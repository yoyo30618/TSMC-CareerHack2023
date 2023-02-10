<?php
	$db_link=@mysqli_connect("35.221.188.178","root","5LreLPpz");
	$db_link=@mysqli_connect("127.0.0.1","root","yoyo0516");
	if(!$db_link)
		die("資料庫連線失敗<br>");
	else{
		mysqli_query($db_link, 'SET NAMES utf8');
		$seldb=@mysqli_select_db($db_link,"careerhack");
		if(!$seldb)
			die("資料庫選擇失敗<br>");
	}
?>
