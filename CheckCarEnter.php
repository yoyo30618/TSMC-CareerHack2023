<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session
	if(isset($_POST['CheckCarEnter']))//如果是由post進入
	{
		if(isset($_POST['LicenseEnterCode'])|| !empty($_FILES['LicenseEnterPhoto']['name'])){
			include_once ("conn_mysql.php");
			if(!empty($_FILES['LicenseEnterPhoto']['name'])){//如果有拿到照片，取得車牌
				$License=exec("python test.py 5");
			}
			else{//否則抓手動輸入的車牌
				$License=$_POST['LicenseEnterCode'];
			}
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
				if($file_size > 2097152) {
				   $errors[]='File size must be excately 2 MB';
				}
				if(empty($errors)==true) {
				   move_uploaded_file($file_tmp,"EnterImage/".$NowFileName);
				   echo "Success";
				}else{
				   print_r($errors);
				}
			}
			/*將檔案存放置伺服器成功*/
			$sql_query_LicenseEnter="INSERT INTO `parkingrecord`(`License`, `EnterTime`, `IsIn`, `EnterPhotoPath`) VALUES ('".$License."','".date( "Y-m-d H:i:s")."','1','".$NowFileName."')";
			$LicenseEnter_result=mysqli_query($db_link,$sql_query_LicenseEnter) or die("查詢失敗");//查詢帳密
			
			echo"<script  language=\"JavaScript\">alert('已成功設定車輛進入');location.href=\"admin.php\";</script>";
		} 
		else{
			echo"<script  language=\"JavaScript\">alert('手動輸入車牌/上傳照片務必則一');location.href=\"admin.php\";</script>";
		}
	}
	else//不當路徑進入
		echo"<script  language=\"JavaScript\">alert('請由正確路徑進入');location.href=\"admin.php\";</script>";
		
?>