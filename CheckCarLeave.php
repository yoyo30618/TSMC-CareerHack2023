<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session
	if(isset($_POST['CheckCarLeave']))//如果是由post進入
	{
		if(isset($_POST['LicenseLeaveCode'])|| !empty($_FILES['LicenseLeavePhoto']['name'])){
			include_once ("conn_mysql.php");
			$Isphoto=False;
			if(!empty($_FILES['LicenseLeavePhoto']['name'])){//如果有拿到照片，取得車牌
				/*將檔案存放置伺服器*/
				$NowFileName="";
				if(isset($_FILES['LicenseLeavePhoto'])){
					$errors= array();
					$file_name = $_FILES['LicenseLeavePhoto']['name'];
					$file_size = $_FILES['LicenseLeavePhoto']['size'];
					$file_tmp = $_FILES['LicenseLeavePhoto']['tmp_name'];
					$file_type = $_FILES['LicenseLeavePhoto']['type'];
					$file_ext=strtolower(end(explode('.',$_FILES['LicenseLeavePhoto']['name'])));
					$extensions= array("jpeg","jpg","png");
					$NowFileName=date("Ymd_His").".".$file_ext;
					if(in_array($file_ext,$extensions)=== false){
					$errors[]="extension not allowed, please choose a JPEG or PNG file.";
					}
					if(empty($errors)==true) {
						move_uploaded_file($file_tmp,"LeaveImage/".$NowFileName);
					}else{
						print_r($errors);
					}
				}
				/*將檔案存放置伺服器成功*/
				$License=exec("sudo /root/anaconda3/envs/torch/bin/python pic2txt.py  LeaveImage/".$NowFileName);

				$Isphoto=true;
			}
			else{//否則抓手動輸入的車牌
				$License=$_POST['LicenseLeaveCode'];
			}
			//先找有沒有 入場後無出場的紀錄，代表現在要出這筆
			$sql_query_CheckEnter="SELECT * FROM `parkingrecord` WHERE `License`='".$License."' AND `LeaveTime` IS null ORDER BY `EnterTime` DESC";
			$CheckEnter_result=mysqli_query($db_link,$sql_query_CheckEnter) or die("查詢失敗");//查詢帳密
			$Fd=0;
			$OldParkRec="";
			while($row=mysqli_fetch_array($CheckEnter_result)){
				$Fd=1;
				$LeavingID=$row['_ID'];
				$OldParkRec=$row['SpaceID'];
				break;
			} 
			if($Fd==0){
				echo"<script  language=\"JavaScript\">alert('無該車入場紀錄，請檢查');location.href=\"admin.php\";</script>";
			}
			else{
				/*釋出該車位*/	
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
				
				/*必定離場 離場後檢查是否違規*/
				$sql_query_SetVIPLeave="SELECT * FROM `vip` WHERE `License`='".$License."' AND `IsUsed`='1'";
				$SetVIPLeave_result=mysqli_query($db_link,$sql_query_SetVIPLeave) or die("查詢失敗");//查詢帳密
				while($row=mysqli_fetch_array($SetVIPLeave_result)){
					if(date( "Y-m-d H:i:s")>$row['EndTime']){
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
							'message' => '此人預約VIP車位但超時離場，車牌為'.$License
						);//宣告一下訊息內容
						//一些關於curl的設定(有點類似網頁版本的CMD?)
						$ch = curl_init();//想像成宣告一個空容器?
						curl_setopt($ch , CURLOPT_URL , "https://notify-api.line.me/api/notify");//宣告要傳遞的網址
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//要傳遞的表頭
						curl_setopt($ch, CURLOPT_POST, true);//POST方式傳遞
						curl_setopt($ch, CURLOPT_POSTFIELDS, $message);//要傳遞的訊息內容
						$result = curl_exec($ch);//把容器拋出去~!
						curl_close($ch);






						echo"<script  language=\"JavaScript\">alert('超過預約時間才離場！已自動新增至違規名單處罰三天');location.href=\"admin.php\";</script>";
						$sql_query_InsertNewBlack="INSERT INTO `blacklist`(`License`, `StartTime`, `EndTime`, `Info`) VALUES ('".$License."','".date( "Y-m-d H:i:s")."','".date( "Y-m-d H:i:s",strtotime('+3 day'))."','VIP車位違停超時處罰三天')";
						$InsertNewBlack_result=mysqli_query($db_link,$sql_query_InsertNewBlack) or die("查詢失敗");
					
					}
					break;
				}
		

				
				/*必定離場 離場後檢查是否違規*/
				$sql_query_SetVIPLeave="SELECT * FROM `vip` WHERE `License`='".$License."' AND `IsUsed`='1'";
				$SetVIPLeave_result=mysqli_query($db_link,$sql_query_SetVIPLeave) or die("查詢失敗");//查詢帳密
				while($row=mysqli_fetch_array($SetVIPLeave_result)){
					if(date( "Y-m-d H:i:s")>$row['EndTime']){
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
							'message' => '此人預約VIP車位但超時離場，車牌為'.$License
						);//宣告一下訊息內容
						//一些關於curl的設定(有點類似網頁版本的CMD?)
						$ch = curl_init();//想像成宣告一個空容器?
						curl_setopt($ch , CURLOPT_URL , "https://notify-api.line.me/api/notify");//宣告要傳遞的網址
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//要傳遞的表頭
						curl_setopt($ch, CURLOPT_POST, true);//POST方式傳遞
						curl_setopt($ch, CURLOPT_POSTFIELDS, $message);//要傳遞的訊息內容
						$result = curl_exec($ch);//把容器拋出去~!
						curl_close($ch);






						echo"<script  language=\"JavaScript\">alert('超過預約時間才離場！已自動新增至違規名單處罰三天');location.href=\"admin.php\";</script>";
						$sql_query_InsertNewBlack="INSERT INTO `blacklist`(`License`, `StartTime`, `EndTime`, `Info`) VALUES ('".$License."','".date( "Y-m-d H:i:s")."','".date( "Y-m-d H:i:s",strtotime('+3 day'))."','VIP車位違停超時處罰三天')";
						$InsertNewBlack_result=mysqli_query($db_link,$sql_query_InsertNewBlack) or die("查詢失敗");
					
					}
					break;
				}
				if($License==""){
					$License="辨識車牌異常，請洽管理室";
					$LineToken="";
					$sql_query_CheckLineToken="SELECT * FROM `account`";
					$CheckLineToken_result=mysqli_query($db_link,$sql_query_CheckLineToken) or die("查詢失敗2");//查詢帳密
					while($row=mysqli_fetch_array($CheckLineToken_result)){
						$LineToken=$row['LineToken'];
						break;
					}/*底下為LINE NOTIFY的部分，傳送LINE確認*/
					$headers = array(
						'Content-Type: multipart/form-data',
						'Authorization: Bearer '.$LineToken
					);//宣告一下表頭與要傳送的TOKEN(權杖)，這樣才知道要傳給哪個BOT
					$message = array(
						'message' => '有一輛車牌辨識異常的車輛即將離場'
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
				//找到該筆，確認離場
				if(!$Isphoto)
					$sql_query_LicenseLeave="UPDATE `parkingrecord` SET `LeaveTime`='".date( "Y-m-d H:i:s")."',`IsIn`='0',`LeavePhotoPath`='手動輸入車牌無照片' WHERE `_ID`='".$LeavingID."'";
				else
					$sql_query_LicenseLeave="UPDATE `parkingrecord` SET `LeaveTime`='".date( "Y-m-d H:i:s")."',`IsIn`='0',`LeavePhotoPath`='".$NowFileName."' WHERE `_ID`='".$LeavingID."'";
				$LicenseLeave_result=mysqli_query($db_link,$sql_query_LicenseLeave) or die("查詢失敗");//查詢帳密
				echo"<script  language=\"JavaScript\">alert('已成功設定車輛離場');location.href=\"admin.php\";</script>";
			}
		} 
		else{
			echo"<script  language=\"JavaScript\">alert('手動輸入車牌/上傳照片務必則一');location.href=\"admin.php\";</script>";
		}
	}
	else//不當路徑進入
		echo"<script  language=\"JavaScript\">alert('請由正確路徑進入');location.href=\"admin.php\";</script>";
		
?>