<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session
	if(isset($_POST['CheckCarEnter']))//如果是由post進入
	{
		if(isset($_POST['LicenseEnterCode'])|| !empty($_FILES['LicenseEnterPhoto']['name'])){
			include_once ("conn_mysql.php");
			$Isphoto=False;
			if(!empty($_FILES['LicenseEnterPhoto']['name'])){//如果有拿到照片，取得車牌
				/*將檔案存放置伺服器*/
				$NowFileName="";
				if(isset($_FILES['LicenseEnterPhoto'])){
					$errors= array();
					$file_name = $_FILES['LicenseEnterPhoto']['name'];
					$file_size = $_FILES['LicenseEnterPhoto']['size'];
					$file_tmp = $_FILES['LicenseEnterPhoto']['tmp_name'];
					$file_type = $_FILES['LicenseEnterPhoto']['type'];
					$file_ext=strtolower(end(explode('.',$_FILES['LicenseEnterPhoto']['name'])));
					$extensions= array("jpeg","jpg","png");
					$NowFileName=date("Ymd_His").".".$file_ext;
					if(in_array($file_ext,$extensions)=== false){
						$errors[]="extension not allowed, please choose a JPEG or PNG file.";
					}
					if(empty($errors)==true) {
						move_uploaded_file($file_tmp,"EnterImage/".$NowFileName);
					}else{
						print_r($errors);
					}
				}
				/*將檔案存放置伺服器成功*/
				$License=exec("python3 test.py 5");
				$Isphoto=True;
			}
			else{//否則抓手動輸入的車牌
				$License=$_POST['LicenseEnterCode'];
			}
			/*檢查車輛是否可以入場*/
			$sql_query_CheckWhite="SELECT * FROM `whitelist` WHERE `StartTime`<'".date("Y-m-d H:i:s")."' AND `EndTime`>'".date("Y-m-d H:i:s")."' AND `License`='".$License."'";
			$CheckWhite_result=mysqli_query($db_link,$sql_query_CheckWhite) or die("查詢失敗1");//查詢帳密
			//如果他有白名單則肯定可以
			$IsWhite=FALSE;
			$IsBlack=FALSE;
			while($row=mysqli_fetch_array($CheckWhite_result)){
				$IsWhite=TRUE;
				break;
			}
			//如果他不是白名單且在黑名單時效內則無法
			if($IsWhite==FALSE){
				$sql_query_CheckBlack="SELECT * FROM `blacklist` WHERE `StartTime`<'".date("Y-m-d H:i:s")."' AND `EndTime`>'".date("Y-m-d H:i:s")."' AND `License`='".$License."'";
				$CheckBlack_result=mysqli_query($db_link,$sql_query_CheckBlack) or die("查詢失敗2");//查詢帳密
				while($row=mysqli_fetch_array($CheckBlack_result)){
					$IsBlack=TRUE;
					break;
				}
			}
			if($IsWhite==FALSE && $IsBlack==TRUE){//無法進入者
				echo"<script  language=\"JavaScript\">alert('車輛無權進入，請洽管理室');location.href=\"admin.php\";</script>";
			}
			else{
				if(!$Isphoto)
					$sql_query_LicenseEnter="INSERT INTO `parkingrecord`(`License`, `EnterTime`, `IsIn`, `EnterPhotoPath`) VALUES ('".$License."','".date( "Y-m-d H:i:s")."','1','手動輸入車牌無照片')";
				else
					$sql_query_LicenseEnter="INSERT INTO `parkingrecord`(`License`, `EnterTime`, `IsIn`, `EnterPhotoPath`) VALUES ('".$License."','".date( "Y-m-d H:i:s")."','1','".$NowFileName."')";
				// echo $sql_query_LicenseEnter;
				$LicenseEnter_result=mysqli_query($db_link,$sql_query_LicenseEnter) or die("查詢失敗3");//查詢帳密
				echo"<script  language=\"JavaScript\">alert('已成功設定車輛進入');location.href=\"admin.php\";</script>";
			} 
		}
		else{
			echo"<script  language=\"JavaScript\">alert('手動輸入車牌/上傳照片務必則一');location.href=\"admin.php\";</script>";
		}
	}
	else//不當路徑進入
		echo"<script  language=\"JavaScript\">alert('請由正確路徑進入');location.href=\"admin.php\";</script>";
		
?>