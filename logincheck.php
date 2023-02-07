<?php
	header("Content-Type:text/html;charset=utf-8");//設定編碼
	session_start();//開啟session
	if(isset($_POST['login']))//如果是由post進入
	{
		$Account = $_POST['Account'];
		$Password = $_POST['Password'];
		if(($Account=='')||($Password==''))//空白帳密
			echo"<script  language=\"JavaScript\">alert('使用者名稱或密碼不能為空');location.href=\"login.php\";</script>";
		include_once ("conn_mysql.php");

		$sql_query_login="SELECT * FROM `account` WHERE Account='$Account'";
		$Pwd_result=mysqli_query($db_link,$sql_query_login) or die("查詢失敗");//查詢帳密
		while($row=mysqli_fetch_array($Pwd_result))
		{
			if($row['Password']==$Password)//登入成功
			{
				if($row['IsUsed']==0){
					echo"<script  language=\"JavaScript\">alert('此帳號已被禁止，請洽管理人員解鎖');location.href=\"login.php\";</script>";
					break;
				}
				else{
					$_SESSION['TSMC_Account']=$Account;//登入成功將資訊儲存到session中
					$_SESSION['TSMC_AccountID']=$row['_ID'];//登入成功將資訊儲存到session中
					$_SESSION['TSMC_Islogin']=1;
					if($row['Status']=="職員")//存不同權限
						$_SESSION['TSMC_Status']="職員";
					else if($row['Status']=="管理員")
						$_SESSION['TSMC_Status']="管理員";
					// 若勾選7天內自動登入,則將其儲存到Cookie並設定保留7天
					if (isset($_POST['remember'])) {
						setcookie('TSMC_Account', $Account, time()+7*24*60*60);
						setcookie('TSMC_Code', md5($Account.md5($Password)), time()+7*24*60*60);
					}
					else {
						setcookie('TSMC_Account', $Account);
						setcookie('TSMC_Code', md5($Account.md5($Password)));
					}
					echo"<script  language=\"JavaScript\">alert('登入成功');location.href=\"index.php\";</script>";
					break;
				}
			}
			else//密碼錯誤登入失敗
				echo"<script  language=\"JavaScript\">alert('使用者名稱或密碼錯誤');location.href=\"login.php\";</script>";
		}
		if(!isset($_SESSION['TSMC_Islogin']))//都找不到代表沒帳號
			echo"<script  language=\"JavaScript\">alert('使用者名稱或密碼錯誤');location.href=\"login.php\";</script>";
	}
	else//不當路徑進入
		echo"<script  language=\"JavaScript\">alert('請由正確路徑進入');location.href=\"login.php\";</script>";
		
?>