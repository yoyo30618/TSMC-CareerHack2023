﻿<!DOCTYPE html>
<html lang="zh-TW">
  <?php
    session_start();//開啟session
    if(isset($_COOKIE["TSMC_Islogin"])==false) {      
			echo"<script  language=\"JavaScript\">alert('請先登入');location.href=\"login.php\";</script>";
    }
    include_once ("conn_mysql.php");
    if(isset($_POST['AddInfo'])){
      $sql_query_AddInfo="INSERT INTO `person`(`Name`, `Cname`,`Department`, `Job`,  `License`) VALUES ('".$_POST['AddName']."','".$_POST['AddCname']."','".$_POST['AddDepartment']."','".$_POST['AddJob']."','".$_POST['AddLicense']."')";
      $AddInfo_result=mysqli_query($db_link,$sql_query_AddInfo) or die("查詢失敗");//查詢帳密
    }
    $sql_query_CheckInfo="SELECT * FROM `person` WHERE 1";
    $CheckInfo_result=mysqli_query($db_link,$sql_query_CheckInfo) or die("查詢失敗");//查詢帳密
    while($row=mysqli_fetch_array($CheckInfo_result)){
      if(isset($_POST['UpdateInfo'.$row['_ID']])){

        $sql_query_UpdateInfo="UPDATE `person` SET `Name`='".$_POST['UpdateName'.$row['_ID']]."',`Cname`='".$_POST['UpdateCname'.$row['_ID']]."',`Department`='".$_POST['UpdateDepartment'.$row['_ID']]."',`Job`='".$_POST['UpdateJob'.$row['_ID']]."',`License`='".$_POST['UpdateLicense'.$row['_ID']]."' WHERE  `_ID`='".$row['_ID']."'
        ";
        $UpdateInfo_result=mysqli_query($db_link,$sql_query_UpdateInfo) or die("查詢失敗");//查詢帳密
        break;
      }
      else if(isset($_POST['DelInfo'.$row['_ID']])){
        $sql_query_DelInfo="DELETE FROM `person` WHERE `_ID`='".$row['_ID']."'";
        $DelInfo_result=mysqli_query($db_link,$sql_query_DelInfo) or die("查詢失敗");//查詢帳密
        break;
      }

    }
		
  ?>
 <head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>TSMC-停車場管理系統</title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
  
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/fontawesome.min.css" />
  <link rel="stylesheet" href="css/flaticon.css" />
  <link rel="stylesheet" href="css/selectize.css" />
  <link rel="stylesheet" href="css/owl.carousel.min.css" />
  <link rel="stylesheet" href="css/owl.theme.default.min.css" />
  <link rel="stylesheet" href="css/animate.min.css" />
  <link rel="stylesheet" href="css/venobox.css" />
  <link rel="stylesheet" href="style.css" />
  <script src="js/vendor/modernizr-custom.js"></script>
  </head>
 <body>
  <div class="wrapper-content">
   <div class="wrapper">
    <header class="header">
     <div class="header-top-area">
      <div class="container">
       <div class="row">
        <div class="col-md-12">
         <div class="header-top">
          <div class="tag-text">
           <span>台灣積體電路製造股份有限公司 TSMC</span>
          </div>
          <div class="certified-text">
           <span> (臺灣證券交易所代碼：2330，美國NYSE代碼：TSM)</span>
          </div>
          <div class="social-area">
           <ul class="social-list list-style">
            <li>
              <a href="https://www.facebook.com/TSMCRecruiterExpress/" target="_blank">
                <i class="fab fa-facebook-f"></i>
              </a>
            </li>
            <li>
              <a href="https://twitter.com/TWSemicon" target="_blank">
                <i class="fab fa-twitter"></i>
              </a>
            </li>
           </ul>
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
     <div class="header-bottom">
      <div class="container">
       <div class="row">
        <div class="header-info">
         <nav class="navbar navbar-expand-lg navbar-dark">
          <a href="index.php"><img src="img/logo/logo.png" alt="logo" /></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
           <ul class="navbar-nav">
            <li class="nav-item active"><a class="nav-link" href="index.php">首頁</a></li>
            <li class="nav-item"><a class="nav-link" href="parkingstatus.php">停車場狀態</a></li>
            <li class="nav-item"><a class="nav-link" href="findcar.php">尋找愛車</a></li>
            <li class="nav-item"><a class="nav-link" href="vip.php">預約VIP位</a></li>
            <?php 
              if (isset($_COOKIE['TSMC_Islogin'])&&$_COOKIE['TSMC_Islogin']=="1"){
                echo "<li class='nav-item'><a class='nav-link' href='info.php'>資料查詢</a></li>";
                if(isset($_COOKIE['TSMC_Status'])&&$_COOKIE['TSMC_Status']=="管理員"){
                  echo "<li class='nav-item'><a class='nav-link' href='NowTimeStatus.php'>實況</a></li>";
                  echo "<li class='nav-item'><a class='nav-link' href='admin.php'>後臺</a></li>";
                  echo "<li class='nav-item'><a class='nav-link' href='SpaceManage.php'>車位管理</a></li>";
                  echo "<li class='nav-item'><a class='nav-link' href='blackwhitelist.php'>黑白名單</a></li>";   
                }     
                echo "<li class='nav-item'>";
                  echo "<div class='login-btn'>";
                    echo "<a class='btn' href='logout.php'>登出</a>";
                    echo "</div>";
                echo "</li>";
              }
              else{           
                echo "<li class='nav-item'>";
                  echo "<div class='login-btn'>";
                    echo "<a class='btn' href='login.php'>登入</a>";
                    echo "</div>";
                echo "</li>";
              }
            ?>
           </ul>
          </div>
         </nav>
        </div>
       </div>
      </div>
     </div>
    </header>    
    <!-- 上方背景橫幅開始-->
    <section class="breadcrumb-area">
     <div class="breadcrumb-content text-center">
      <h1>模擬管理</h1>
      <nav aria-label="breadcrumb">
       <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
        <li class="breadcrumb-item active" aria-current="page">模擬管理</li>
       </ol>
      </nav>
     </div>
    </section>
    <!-- 上方背景橫幅結束-->
    <!-- 查詢開始 -->
    <section class="intro-area">
      <div class="container" align="middle">
        <form action="CheckCarEnter.php" method="POST" enctype="multipart/form-data">
          <legend>模擬車輛入場</legend>
          <table>
            <tr>
              <td>車牌號碼(英文+數字)(供無照片時使用)</td>
              <td><input type="text" name="LicenseEnterCode" id="LicenseInput1"></td>
              <td>&nbsp;&nbsp;or&nbsp;&nbsp;<input type="file" name="LicenseEnterPhoto" accept="image/*"/></td>
            </tr>
            <tr>
              <td></td>
              <td><input type="submit" name="CheckCarEnter" value="模擬入場"  style="width: 100%;" class="login_btn"/></td>
              <td></td>
            </tr>
          </table>
        </form>      
        <br>  
        <form action="CheckCarParked.php" method="POST" enctype="multipart/form-data">
          <legend>模擬車輛停妥</legend>
          <table>
            <tr>
              <td>車牌號碼(英文+數字)(供無照片時使用)</td>
              <td><input type="text" name="LicenseParkedCode" id="LicenseInput2"></td>
              <td>&nbsp;&nbsp;or&nbsp;&nbsp;<input type="file" name="LicenseParkedPhoto" data-target="file-uploader" accept="image/*"/></td>
            </tr>
            <tr>
              <td>車位編號</td>
              <td colspan="2"><input required type="text" name="SpaceID" id="LicenseInput3"></td>
            </tr>
            <tr>
              <td></td>
              <td><input type="submit" name="CheckCarParked" value="模擬停妥"  style="width: 100%;" class="login_btn"/></td>
              <td></td>
            </tr>
          </table>
        </form>
        <br>
        <form action="CheckCarLeave.php" method="POST" enctype="multipart/form-data">
          <legend>模擬車輛出場</legend>
          <table>
            <tr>
              <td>車牌號碼(英文+數字)(供無照片時使用)</td>
              <td><input type="text" name="LicenseLeaveCode" id="LicenseInput4"></td>
              <td>&nbsp;&nbsp;or&nbsp;&nbsp;<input  name="LicenseLeavePhoto"  type="file" data-target="file-uploader" accept="image/*"/></td>
            </tr>
            <tr>
              <td></td>
              <td><input type="submit" name="CheckCarLeave" value="模擬出場"  style="width: 100%;" class="login_btn"/></td>
              <td></td>
            </tr>
          </table>
        </form>  
      </div>
      <br>

    </section>
    <!-- 查詢結束 -->
    
    <script>
      document.getElementById("LicenseInput1").onkeyup = function() {
        this.value = this.value.replace(/[^A-Z0-9]/g, "").substr(0, 7);//限定大寫英文+數字與7碼
      };
      document.getElementById("LicenseInput2").onkeyup = function() {
        this.value = this.value.replace(/[^A-Z0-9]/g, "").substr(0, 7);//限定大寫英文+數字與7碼
      };
      document.getElementById("LicenseInput3").onkeyup = function() {
        this.value = this.value.replace(/[^A-Z0-9]/g, "").substr(0, 7);//限定大寫英文+數字與7碼
      };
      document.getElementById("LicenseInput4").onkeyup = function() {
        this.value = this.value.replace(/[^A-Z0-9]/g, "").substr(0, 7);//限定大寫英文+數字與7碼
      };
      document.getElementById("LicenseInput5").onkeyup = function() {
        this.value = this.value.replace(/[^A-Z0-9]/g, "").substr(0, 7);//限定大寫英文+數字與7碼
      };
    </script>
    <!-- 停車場連結開始 -->
    <div class="client-log-area section-padding">
     <div class="container">
      <div class="row">
       <div class="col-md-12">
        <div class="client-logo-slider owl-carousel owl-theme">
         <div class="client-logo-single">
          <a href="vip.php"><img src="img/clients/1.jpg" alt="Logo" /></a>
         </div>
         <div class="client-logo-single">
          <a href="vip.php"><img src="img/clients/2.jpg" alt="Logo" /></a>
         </div>
         <div class="client-logo-single">
          <a href="vip.php"><img src="img/clients/3.jpg" alt="Logo" /></a>
         </div>
         <div class="client-logo-single">
          <a href="vip.php"><img src="img/clients/4.jpg" alt="Logo" /></a>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
    <!-- 停車場連結結束 -->
    <!-- 底部開始 -->
    <footer class="footer-area">
     <div class="footer-top">
      <div class="container">
       <div class="row">
        <div class="col-md-6 col-lg-2">
         <div class="footer-info">
         </div>
        </div>
        <div class="col-md-6 col-lg-3">
         <div class="footer-info">
          <div class="footer-logo">
           <a href="index.php"><img src="img/logo/logo.png" alt="Logo" /></a>
          </div>
          <p>此為2023 TSMC IT CareerHack中為了台積電所設計的專屬智慧停車管理系統。<br>
             環境模擬於台積電的四處停車場，搭配影像辨識車牌，盼能妥善的運用車位庫存，使開車員工到達辦公場所快速、有效率地的滿足其停車需求，並同時節省警勤巡檢人力。</p>
         </div>
        </div>
        <div class="col-md-6 col-lg-3">
         <div class="footer-info">
         </div>
        </div>
        <div class="col-md-6 col-lg-4">
         <div class="footer-info">
          <h4>快速連結</h4>
          <ul class="link-list list-style">
            <li class="nav-item active"><a class="nav-link" href="index.php">首頁</a></li>
            <li class="nav-item"><a class="nav-link" href="parkingstatus.php">停車場狀態</a></li>
            <li class="nav-item"><a class="nav-link" href="findcar.php">尋找愛車</a></li>
            <li class="nav-item"><a class="nav-link" href="vip.php">預約VIP位</a></li>
            <?php 
              if (isset($_COOKIE['TSMC_Islogin'])&&$_COOKIE['TSMC_Islogin']=="1"){
                echo "<li class='nav-item'><a class='nav-link' href='info.php'>資料查詢</a></li>";
                if(isset($_COOKIE['TSMC_Status'])&&$_COOKIE['TSMC_Status']=="管理員"){
                  echo "<li class='nav-item'><a class='nav-link' href='NowTimeStatus.php'>實況</a></li>";
                  echo "<li class='nav-item'><a class='nav-link' href='admin.php'>後臺</a></li>";
                  echo "<li class='nav-item'><a class='nav-link' href='blackwhitelist.php'>黑白名單</a></li>";   
                }     
                echo "<li class='nav-item'>";
                  echo "<a class='nav-link' href='logout.php'>登出</a>";
                echo "</li>";
              }
              else{           
                echo "<li class='nav-item'>";
                  echo "<a class='nav-link' href='login.php'>登入</a>";
                echo "</li>";
              }
            ?>
          </ul>
        </div>
       </div>
      </div>
     </div>
     <div class="footer-bottom">
      <div class="container">
       <div class="row">
        <div class="col-md-12">
         <div class="footer-bottom-content">
          <p>Copyright &copy; 台灣積體電路製造股份有限公司 著作權所有</p>
         </div>
        </div>
       </div>
      </div>
     </div>
     <!-- Start Back To Top Area -->
     <div class="back-to-top">
      <span>Back To Top</span>
     </div>
     <!-- End Back To Top Area -->
    </footer>
    <!-- 底部結束 -->
   </div>
  </div>
  <!-- 指標圓球開始 -->
  <div class="custom-cursor">
   <div id="cursor">
    <div id="cursor-ball"></div>
   </div>
  </div>
  <!-- 指標圓球結束 -->
  <!-- JS -->
  <script src="js/jquery-3.1.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/selectize.js"></script>
  <script src="js/icheck.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.appear.js"></script>
  <script src="js/jquery.easing.1.3.min.js"></script>
  <script src="js/venobox.min.js"></script>
  <script src="js/jquery.countTo.js"></script>
  <script src="js/wow.min.js"></script>
  <script src="js/loadMoreResults.js"></script>
  <script src="js/TweenMax.js"></script>
  <script src="js/main.js"></script> 
 </body>
</html>