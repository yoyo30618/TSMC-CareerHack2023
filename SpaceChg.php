<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session
	if(isset($_POST['choose'])){
		include_once ("conn_mysql.php");
		$SpaceID=$_POST['choose'];
		$Park=$SpaceID[0];
		$SpaceNum = intval(substr($SpaceID, 1));
		echo $Park;
		echo $SpaceNum;
		
		if($Park=="A")
			$sql_query_ChgStatus="UPDATE parkstatusa SET IsUsed = NOT IsUsed where SpaceID='".$SpaceNum."'";
		if($Park=="B")
			$sql_query_ChgStatus="UPDATE parkstatusb SET IsUsed = NOT IsUsed where SpaceID='".$SpaceNum."'";
		if($Park=="C")
			$sql_query_ChgStatus="UPDATE parkstatusc SET IsUsed = NOT IsUsed where SpaceID='".$SpaceNum."'";
		if($Park=="D")
			$sql_query_ChgStatus="UPDATE parkstatusd SET IsUsed = NOT IsUsed where SpaceID='".$SpaceNum."'";
		
		$ChgStatus_result=mysqli_query($db_link,$sql_query_ChgStatus) or die("查詢失敗");//查詢帳密
		echo"<script  language=\"JavaScript\">location.href=\"SpaceManage.php\";</script>";
	}	
	else{
		echo"<script  language=\"JavaScript\">alert('請由正確路徑進入');location.href=\"SpaceManage.php\";</script>";
	}
?>