<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session
	if(isset($_POST['vipsubmit']))//如果是由post進入
	{
		if($_POST['SpaceID']!="尚未選擇"){
			$StartTime = $_POST['StartTime'];
			$EndTime = $_POST['EndTime'];
			$License = $_POST['License'];
			$SpaceID = $_POST['SpaceID'];
			if(strtotime($StartTime)>strtotime($EndTime)){
				echo"<script  language=\"JavaScript\">alert('結束時間不得小於開始時間');location.href=\"vip.php\";</script>";
			}
			else{
				include_once ("conn_mysql.php");
				//檢查時段重疊
				$dt = new DateTime($StartTime);
				$formatted_StartTime = $dt->format("Y-m-d H:i:s");
				$dt = new DateTime($EndTime);
				$formatted_EndTime = $dt->format("Y-m-d H:i:s");
				$sql_query_checktime="SELECT * FROM `vip` WHERE (`StartTime`<'".$formatted_StartTime."' AND `EndTime`>'".$formatted_StartTime."' AND `SpaceID`='".$SpaceID."') OR (`StartTime`<'".$formatted_EndTime."' AND `EndTime`>'".$formatted_EndTime."' AND `SpaceID`='".$SpaceID."')";
				// echo $sql_query_checktime;
				$checktime_result=mysqli_query($db_link,$sql_query_checktime) or die("查詢失敗");//查詢帳密
				$Fd=0;
				while($row=mysqli_fetch_array($checktime_result)){
					$Fd=1;
					break;
				}
				if($Fd==1){
					echo"<script  language=\"JavaScript\">alert('有時段已經被別人預約，請重設時段');location.href=\"vip.php\";</script>";
				}
				else{
					$sql_query_booktime="INSERT INTO `vip`(`License`, `StartTime`, `EndTime`, `SpaceID`, `IsUsed`) VALUES ('".$License."','".$StartTime."','".$EndTime."','".$SpaceID."','1')";
					$booktime_result=mysqli_query($db_link,$sql_query_booktime) or die("查詢失敗");
					echo"<script  language=\"JavaScript\">alert('車位".$SpaceID."，時段".$StartTime."~".$EndTime."預約成功！');location.href=\"vip.php\";</script>";
				}
			}
		}
		else{
			echo"<script  language=\"JavaScript\">alert('請先選擇欲預約車位');location.href=\"vip.php\";</script>";
		}
	}
	else//不當路徑進入
		echo"<script  language=\"JavaScript\">alert('請由正確路徑進入');location.href=\"vip.php\";</script>";
		
?>