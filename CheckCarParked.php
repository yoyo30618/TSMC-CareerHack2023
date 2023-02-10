<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session
	if(isset($_POST['CheckCarParked']))//如果是由post進入
	{
		if(isset($_POST['LicenseParkedCode'])|| !empty($_FILES['LicenseParkedPhoto']['name'])){
			include_once ("conn_mysql.php");
			$Isphoto=False;
			if(!empty($_FILES['LicenseParkedPhoto']['name'])){//如果有拿到照片，取得車牌
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
				$License=exec("sudo /root/anaconda3/envs/torch/bin/python pic2txt.py  ParkedImage/".$NowFileName);
				$Isphoto=true;
			}
			else{//否則抓手動輸入的車牌
				$License=$_POST['LicenseParkedCode'];
			}
			//先找有沒有 入場後無出場的紀錄，代表現在要停的那筆ID
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
					$IsVIPPark=false;
					if($Park=="A"){
						$sql_query_CheckVIPPark="SELECT * FROM `parkstatusa` WHERE `SpaceID`='".$SpaceID."'";
						$CheckVIPPark_result=mysqli_query($db_link,$sql_query_CheckVIPPark) or die("查詢失敗");
						while($row=mysqli_fetch_array($CheckVIPPark_result)){
							if($row['IsVIP']==1)
								$IsVIPPark=true;
							break;
						}
					}
					if($IsVIPPark){//如果停放到VIP區了 但並沒有預約 通知並處罰
						$sql_query_CheckViolation="SELECT * FROM `vip` WHERE `SpaceID`='".$OldParkRec."' AND `License`='".$License."' AND `StartTime`<'".date( "Y-m-d H:i:s")."' AND `EndTime`>'".date( "Y-m-d H:i:s")."'";	
						echo $sql_query_CheckViolation;
						$IsOKVIP=false;
						$CheckViolation_result=mysqli_query($db_link,$sql_query_CheckViolation) or die("查詢失敗");
						$NowInVIP=-1;
						while($row=mysqli_fetch_array($CheckViolation_result)){
							$IsOKVIP=true;
							$NowInVIP=$row['_ID'];
							break;
						}
						if(!$IsOKVIP){//不合法的VIP 他停到不該停的位置了 他沒預約但停在VIP
							//顯示不合法
							/*發送測試訊息*/
							$LineToken="";
							$sql_query_CheckLineToken="SELECT * FROM `account`";
							$CheckLineToken_result=mysqli_query($db_link,$sql_query_CheckLineToken) or die("查詢失敗2");//查詢帳密
							while($row=mysqli_fetch_array($CheckLineToken_result)){
								$LineToken=$row['LineToken'];
								break;
							}
							/*底下為LINE NOTIFY的部分，傳送LINE確認*/
							$headers = array(
								'Content-Type: multipart/form-data',
								'Authorization: Bearer '.$LineToken
							);//宣告一下表頭與要傳送的TOKEN(權杖)，這樣才知道要傳給哪個BOT
							$message = array(
								'message' => '此車輛並沒有預約此VIP車位，車牌為'.$License
							);//宣告一下訊息內容
							//一些關於curl的設定(有點類似網頁版本的CMD?)
							$ch = curl_init();//想像成宣告一個空容器?
							curl_setopt($ch , CURLOPT_URL , "https://notify-api.line.me/api/notify");//宣告要傳遞的網址
							curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//要傳遞的表頭
							curl_setopt($ch, CURLOPT_POST, true);//POST方式傳遞
							curl_setopt($ch, CURLOPT_POSTFIELDS, $message);//要傳遞的訊息內容
							$result = curl_exec($ch);//把容器拋出去~!
							curl_close($ch);
							echo"<script  language=\"JavaScript\">alert('此車輛並沒有預約此VIP車位！已自動新增至違規名單處罰三天');</script>";	
							$sql_query_InsertNewBlack="INSERT INTO `blacklist`(`License`, `StartTime`, `EndTime`, `Info`) VALUES ('".$License."','".date( "Y-m-d H:i:s")."','".date( "Y-m-d H:i:s",strtotime('+3 day'))."','違停VIP車位處罰三天')";
							$InsertNewBlack_result=mysqli_query($db_link,$sql_query_InsertNewBlack) or die("查詢失敗");
						}
						else{
							$sql_query_UpdateVIP="UPDATE `vip` SET `IsUsed`='1' WHERE `_ID`='".$NowInVIP."'";
							$UpdateVIP_result=mysqli_query($db_link,$sql_query_UpdateVIP) or die("查詢失敗");
						}
					}
					/*需先將該停車場內格子設定為不可用*/
					if($Park=="A")
						$sql_query_SetPark="UPDATE `parkstatusa` SET `IsParked`='1' WHERE `SpaceID`='".$SpaceNum."'";
					if($Park=="B")
						$sql_query_SetPark="UPDATE `parkstatusb` SET `IsParked`='1' WHERE `SpaceID`='".$SpaceNum."'";
					if($Park=="C")
						$sql_query_SetPark="UPDATE `parkstatusc` SET `IsParked`='1' WHERE `SpaceID`='".$SpaceNum."'";
					if($Park=="D")
						$sql_query_SetPark="UPDATE `parkstatusd` SET `IsParked`='1' WHERE `SpaceID`='".$SpaceNum."'";
					$SetPark_result=mysqli_query($db_link,$sql_query_SetPark) or die("查詢失敗");
					if(!$Isphoto)
						$sql_query_LicenseLeave="UPDATE `parkingrecord` SET `SpaceID`='".$SpaceID."',`ParkPhotoPath`='手動輸入車牌無照片' WHERE `_ID`='".$ParkingID."'";
					else
						$sql_query_LicenseLeave="UPDATE `parkingrecord` SET `SpaceID`='".$SpaceID."',`ParkPhotoPath`='".$NowFileName."' WHERE `_ID`='".$ParkingID."'";
					$LicenseLeave_result=mysqli_query($db_link,$sql_query_LicenseLeave) or die("查詢失敗");//查詢帳密
					echo"<script  language=\"JavaScript\">alert('已成功設定車輛');location.href=\"admin.php\";</script>";	
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