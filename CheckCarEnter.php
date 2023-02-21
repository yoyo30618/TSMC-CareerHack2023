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
				$License=exec("sudo /root/anaconda3/envs/torch/bin/python pic2txt.py  EnterImage/".$NowFileName);

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
					'message' => '有人是黑名單但嘗試想進入停車場，車牌為'.$License
				);//宣告一下訊息內容
				//一些關於curl的設定(有點類似網頁版本的CMD?)
				$ch = curl_init();//想像成宣告一個空容器?
				curl_setopt($ch , CURLOPT_URL , "https://notify-api.line.me/api/notify");//宣告要傳遞的網址
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//要傳遞的表頭
				curl_setopt($ch, CURLOPT_POST, true);//POST方式傳遞
				curl_setopt($ch, CURLOPT_POSTFIELDS, $message);//要傳遞的訊息內容
				$result = curl_exec($ch);//把容器拋出去~!
				curl_close($ch);



				echo"<script  language=\"JavaScript\">alert('車輛無權進入，請洽管理室');location.href=\"admin.php\";</script>";
			}
			else{
				if($License==""){
					$License="辨識車牌異常，請洽管理室";
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
						'message' => '有一輛車牌辨識異常的車輛即將入場'
					);//宣告一下訊息內容
					//一些關於curl的設定(有點類似網頁版本的CMD?)
					$ch = curl_init();//想像成宣告一個空容器?
					curl_setopt($ch , CURLOPT_URL , "https://notify-api.line.me/api/notify");//宣告要傳遞的網址
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//要傳遞的表頭
					curl_setopt($ch, CURLOPT_POST, true);//POST方式傳遞
					curl_setopt($ch, CURLOPT_POSTFIELDS, $message);//要傳遞的訊息內容
					$result = curl_exec($ch);//把容器拋出去~!
					curl_close($ch);
				}
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