<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session
	$License=$_POST['License'];
	$StartTime=$_POST['StartTime'];
	$EndTime=$_POST['EndTime'];
	$Info=$_POST['Info'];
	if(strtotime($StartTime)>strtotime($EndTime)){
		echo"<script  language=\"JavaScript\">alert('結束時間不得小於開始時間');location.href=\"blackwhitelist.php\";</script>";
	}
	else{
		include_once ("conn_mysql.php");
		if(isset($_POST['blacklist']))//如果是由post進入
		{
			$sql_query_setblack="INSERT INTO `blacklist`(`License`, `StartTime`, `EndTime`, `Info`) VALUES ('".$License."','".$StartTime."','".$EndTime."','".$Info."')";
			$setblack_result=mysqli_query($db_link,$sql_query_setblack) or die("查詢失敗");//查詢帳密
			echo"<script  language=\"JavaScript\">alert('黑名單設定完成');location.href=\"blackwhitelist.php\";</script>";
		}	
		else if(isset($_POST['whitelist']))//如果是由post進入
		{
			$sql_query_setwhite="INSERT INTO `whitelist`(`License`, `StartTime`, `EndTime`, `Info`) VALUES ('".$License."','".$StartTime."','".$EndTime."','".$Info."')";
			$setwhite_result=mysqli_query($db_link,$sql_query_setwhite) or die("查詢失敗");//查詢帳密
			echo"<script  language=\"JavaScript\">alert('白名單設定完成');location.href=\"blackwhitelist.php\";</script>";
		}
		else//不當路徑進入
			echo"<script  language=\"JavaScript\">alert('請由正確路徑進入');location.href=\"blackwhitelist.php\";</script>";
	}
?>