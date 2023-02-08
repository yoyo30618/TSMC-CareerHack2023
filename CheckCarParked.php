<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session
	if(isset($_POST['CheckCarParked']))//如果是由post進入
	{
		if(isset($_POST['LicenseParkedCode'])|| !empty($_FILES['LicenseParkedPhoto']['name'])){
			include_once ("conn_mysql.php");
			if(!empty($_FILES['LicenseParkedPhoto']['name'])){//如果有拿到照片，取得車牌
				$License=exec("python test.py 5");
			}
			else{//否則抓手動輸入的車牌
				$License=$_POST['LicenseParkedCode'];
			}
			//先找有沒有 入場後無出場的紀錄，代表現在要停
			$sql_query_CheckEnter="SELECT * FROM `parkingrecord` WHERE `License`='".$License."' AND `LeaveTime` IS null ORDER BY `EnterTime` DESC";
			$CheckEnter_result=mysqli_query($db_link,$sql_query_CheckEnter) or die("查詢失敗");//查詢帳密
			$Fd=0;
			$OldParkRec="";
			while($row=mysqli_fetch_array($CheckEnter_result)){
				$Fd=1;
				$ParkingID=$row['_ID'];
				$OldParkRec=$row['SpaceID'];
				break;
			}
			if($Fd==0){
				echo"<script  language=\"JavaScript\">alert('無該車入場紀錄，請檢查');location.href=\"admin.php\";</script>";
			}
			else{//找到該筆，確認停妥
				$SpaceID=$_POST['SpaceID'];
				$Park=$SpaceID[0];
				$SpaceNum = intval(substr($SpaceID, 1));
				if($Park!='A'&&$Park!='B'&&$Park!='C'&&$Park!='D'){
					echo"<script  language=\"JavaScript\">alert('停車格不合法，請檢查');location.href=\"admin.php\";</script>";
				}
				else if(!($SpaceNum>=0 && $SpaceNum<=99)){
					echo"<script  language=\"JavaScript\">alert('停車格不合法，請檢查');location.href=\"admin.php\";</script>";
				}
				else{
					/*如果原先有停別的位置 要釋出*/
					if($OldParkRec!=""){
						$OldPark=$OldParkRec[0];
						$OldSpaceNum = intval(substr($OldParkRec, 1));
						if($OldPark=="A")
							$sql_query_SetOldPark="UPDATE `parkstatusa` SET `IsParked`='0' WHERE `SpaceID`='".$OldSpaceNum."'";
						if($OldPark=="B")
							$sql_query_SetOldPark="UPDATE `parkstatusb` SET `IsParked`='0' WHERE `SpaceID`='".$OldSpaceNum."'";
						if($OldPark=="C")
							$sql_query_SetOldPark="UPDATE `parkstatusc` SET `IsParked`='0' WHERE `SpaceID`='".$OldSpaceNum."'";
						if($OldPark=="D")
							$sql_query_SetOldPark="UPDATE `parkstatusd` SET `IsParked`='0' WHERE `SpaceID`='".$OldSpaceNum."'";
						$SetOldPark_result=mysqli_query($db_link,$sql_query_SetOldPark) or die("查詢失敗");//查詢帳密
					}


					/*將檔案存放置伺服器*/
					$NowFileName="";
					if(isset($_FILES['LicenseParkedPhoto'])){
						$errors= array();
						$file_name = $_FILES['LicenseParkedPhoto']['name'];
						$file_size = $_FILES['LicenseParkedPhoto']['size'];
						$file_tmp = $_FILES['LicenseParkedPhoto']['tmp_name'];
						$file_type = $_FILES['LicenseParkedPhoto']['type'];
						$file_ext=strtolower(end(explode('.',$_FILES['LicenseParkedPhoto']['name'])));
						$extensions= array("jpeg","jpg","png");
						$NowFileName=date("Ymd_His").".".$file_ext;
						if(in_array($file_ext,$extensions)=== false){
							$errors[]="extension not allowed, please choose a JPEG or PNG file.";
						}
						if(empty($errors)==true) {
							move_uploaded_file($file_tmp,"ParkedImage/".$NowFileName);
						}else{
							print_r($errors);
						}
					}
					/*將檔案存放置伺服器成功*/

					/*需先將該停車場內格子設定為不可用*/
					if($Park=="A")
						$sql_query_SetPark="UPDATE `parkstatusa` SET `IsParked`='1' WHERE `SpaceID`='".$SpaceNum."'";
					if($Park=="B")
						$sql_query_SetPark="UPDATE `parkstatusb` SET `IsParked`='1' WHERE `SpaceID`='".$SpaceNum."'";
					if($Park=="C")
						$sql_query_SetPark="UPDATE `parkstatusc` SET `IsParked`='1' WHERE `SpaceID`='".$SpaceNum."'";
					if($Park=="D")
						$sql_query_SetPark="UPDATE `parkstatusd` SET `IsParked`='1' WHERE `SpaceID`='".$SpaceNum."'";
					$SetPark_result=mysqli_query($db_link,$sql_query_SetPark) or die("查詢失敗");//查詢帳密
					$sql_query_LicenseLeave="UPDATE `parkingrecord` SET `SpaceID`='".$SpaceID."',`ParkPhotoPath`='".$NowFileName."' WHERE `_ID`='".$ParkingID."'";
					$LicenseLeave_result=mysqli_query($db_link,$sql_query_LicenseLeave) or die("查詢失敗");//查詢帳密
					echo"<script  language=\"JavaScript\">alert('已成功設定車輛停妥');location.href=\"admin.php\";</script>";	
				}
			}
		} 
		else{
			echo"<script  language=\"JavaScript\">alert('手動輸入車牌/上傳照片務必則一');location.href=\"admin.php\";</script>";
		}
	}
	else//不當路徑進入
		echo"<script  language=\"JavaScript\">alert('請由正確路徑進入');location.href=\"admin.php\";</script>";
		
?>