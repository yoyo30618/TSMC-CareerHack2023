﻿<!DOCTYPE html>
<html lang="zh-TW">
  <?php
    session_start();//開啟session
    if(isset($_COOKIE["TSMC_Islogin"])==false) {      
			echo"<script  language=\"JavaScript\">alert('請先登入');location.href=\"login.php\";</script>";
    }
    include_once ("conn_mysql.php");
    /*計算空車位*/
    $Sql_query_parkstatusA="SELECT COUNT(*) AS res FROM `parkstatusa` WHERE `Isparked`=0";
    $ParkstatusA_result=mysqli_query($db_link,$Sql_query_parkstatusA) or die("查詢失敗");//查詢帳密
    while($row=mysqli_fetch_array($ParkstatusA_result)){
      $ParkASpace=$row['res'];
    }
    $Sql_query_parkstatusB="SELECT COUNT(*) AS res FROM `parkstatusb` WHERE `Isparked`=0";
    $ParkstatusB_result=mysqli_query($db_link,$Sql_query_parkstatusB) or die("查詢失敗");//查詢帳密
    while($row=mysqli_fetch_array($ParkstatusB_result)){
      $ParkBSpace=$row['res'];
    }
    $Sql_query_parkstatusC="SELECT COUNT(*) AS res FROM `parkstatusc` WHERE `Isparked`=0";
    $ParkstatusC_result=mysqli_query($db_link,$Sql_query_parkstatusC) or die("查詢失敗");//查詢帳密
    while($row=mysqli_fetch_array($ParkstatusC_result)){
      $ParkCSpace=$row['res'];
    }
    $Sql_query_parkstatusD="SELECT COUNT(*) AS res FROM `parkstatusd` WHERE `Isparked`=0";
    $ParkstatusD_result=mysqli_query($db_link,$Sql_query_parkstatusD) or die("查詢失敗");//查詢帳密
    while($row=mysqli_fetch_array($ParkstatusD_result)){
      $ParkDSpace=$row['res'];
    }
    $ParkALLSpace=$ParkASpace+$ParkBSpace+$ParkCSpace+$ParkDSpace;
    /*計算VIP車位*/
    $Sql_query_VIPstatusA="SELECT COUNT(*) AS res FROM `parkstatusa` WHERE `Isparked`=0 AND `IsVIP`=1";
    $VIPstatusA_result=mysqli_query($db_link,$Sql_query_VIPstatusA) or die("查詢失敗");//查詢帳密
    while($row=mysqli_fetch_array($VIPstatusA_result)){
      $VIPA=$row['res'];
    }
    $Sql_query_VIPstatusB="SELECT COUNT(*) AS res FROM `parkstatusb` WHERE `Isparked`=0 AND `IsVIP`=1";
    $VIPstatusB_result=mysqli_query($db_link,$Sql_query_VIPstatusB) or die("查詢失敗");//查詢帳密
    while($row=mysqli_fetch_array($VIPstatusB_result)){
      $VIPB=$row['res'];
    }
    $Sql_query_VIPstatusC="SELECT COUNT(*) AS res FROM `parkstatusc` WHERE `Isparked`=0 AND `IsVIP`=1";
    $VIPstatusC_result=mysqli_query($db_link,$Sql_query_VIPstatusC) or die("查詢失敗");//查詢帳密
    while($row=mysqli_fetch_array($VIPstatusC_result)){
      $VIPC=$row['res'];
    }
    $Sql_query_VIPstatusD="SELECT COUNT(*) AS res FROM `parkstatusd` WHERE `Isparked`=0 AND `IsVIP`=1";
    $VIPstatusD_result=mysqli_query($db_link,$Sql_query_VIPstatusD) or die("查詢失敗");//查詢帳密
    while($row=mysqli_fetch_array($VIPstatusD_result)){
      $VIPD=$row['res'];
    }
    $ALLVIP=$VIPA+$VIPB+$VIPC+$VIPD;
    /*計算成功預約紀錄*/
    $Sql_query_RecordCount="SELECT COUNT(*) AS res FROM `parkingrecord`";
    $RecordCount_result=mysqli_query($db_link,$Sql_query_RecordCount) or die("查詢失敗");//查詢帳密
    while($row=mysqli_fetch_array($RecordCount_result)){
      $RecordCount=$row['res'];
    }
    /*檢查白名單刪除*/
    $sql_query_delwhite="SELECT * FROM `whitelist` WHERE 1";
    $delwhite_result=mysqli_query($db_link,$sql_query_delwhite) or die("查詢失敗");
    while($row=mysqli_fetch_array($delwhite_result)){
      if(isset($_POST['delwhite'.$row['_ID']])){
        $sql_query_del="DELETE FROM `whitelist` WHERE `_ID`='".$row['_ID']."'";
        $del_result=mysqli_query($db_link,$sql_query_del) or die("查詢失敗");
        break;
      }
    }
    /*檢查黑名單刪除*/
    $sql_query_delblack="SELECT * FROM `blacklist` WHERE 1";
    $delblack_result=mysqli_query($db_link,$sql_query_delblack) or die("查詢失敗");
    while($row=mysqli_fetch_array($delblack_result)){
      if(isset($_POST['delblack'.$row['_ID']])){
        $sql_query_del="DELETE FROM `blacklist` WHERE `_ID`='".$row['_ID']."'";
        $del_result=mysqli_query($db_link,$sql_query_del) or die("查詢失敗");
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
      <h1>黑白名單</h1>
      <nav aria-label="breadcrumb">
       <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
        <li class="breadcrumb-item active" aria-current="page">黑白名單</li>
       </ol>
      </nav>
     </div>
    </section>
    <!-- 上方背景橫幅結束-->    
    <!-- 白名單設定開始 -->
    <br>
    <section class="service-provide-area">
     <div class="container">
      <div class="row">
        <table width="100%" style="border: 1px solid red;">
          <thead>
          <tr>
              <th colspan="20" style="border: 1px solid red;text-align:center;">
                <form action="setlist.php" method="POST" style="width:100%;">
                  <legend>白名單設定(白名單權力>黑名單)</legend>
                  <table style='width:100%;text-align:center;align:center;'>
                    <tr>
                      <td style="width: 50%;">白名單(僅大寫英文+數字)</td>
                      <td style="width: 50%;"><input required type="text" name="License"  id="LicenseInput1"/></td>
                    </tr>              
                    <tr>
                      <td style="width: 50%;">起始時間：</td>
                      <td style="width: 50%;"><input required type="datetime-local" name="StartTime"/></td>
                    </tr>
                    <tr>
                      <td style="width: 50%;">結束時間：</td>
                      <td style="width: 50%;"><input required type="datetime-local" name="EndTime"/></td>
                    </tr>
                    <tr>
                      <td style="width: 50%;">紀錄事由：</td>
                      <td style="width: 50%;"><input required type="text" name="Info"/></td>
                    </tr>
                    <tr>
                      <td colspan="2"><input type="submit" name="whitelist" value="設定白名單"  style="width: 50%;" class="login_btn"/></td>
                    </tr>
                  </table>
                </form>
              </th>
            </tr>
            <tr>
              <th colspan="20" style="border: 1px solid red;text-align:center;">
                <form action="setlist.php" method="POST" style="width:100%;">
                  <legend>黑名單設定(白名單權力>黑名單)</legend>
                  <table style='width:100%;text-align:center;align:center;'>
                    <tr>
                      <td style="width: 50%;">黑名單(僅大寫英文+數字)</td>
                      <td style="width: 50%;"><input required type="text" name="License"  id="LicenseInput2"/></td>
                    </tr>              
                    <tr>
                      <td style="width: 50%;">起始時間：</td>
                      <td style="width: 50%;"><input required type="datetime-local" name="StartTime"/></td>
                    </tr>
                    <tr>
                      <td style="width: 50%;">結束時間：</td>
                      <td style="width: 50%;"><input required type="datetime-local" name="EndTime"/></td>
                    </tr>
                    <tr>
                      <td style="width: 50%;">紀錄事由：</td>
                      <td style="width: 50%;"><input required type="text" name="Info"/></td>
                    </tr>
                    <tr>
                      <td colspan="2"><input type="submit" name="blacklist" value="設定黑名單"  style="width: 50%;" class="login_btn"/></td>
                    </tr>
                  </table>
                </form>
              </th>
            </tr>
          </thead>
          <tbody>
          <form action="blackwhitelist.php" method="POST" style="width:100%;">
            <tr>
              <td colspan='5' style='text-align:center;color:green;'>已設定之白名單</td>
            </tr>
            <tr style='color:green;'> 
              <td style='text-align:center;'>車牌</td>
              <td style='text-align:center;'>起始時間</td>
              <td style='text-align:center;'>結束時間</td>
              <td style='text-align:center;'>紀錄事由</td>
              <td style='text-align:center;'>狀態</td>
            </tr>
              <?php
                $sql_query_whitelist="SELECT * FROM `whitelist` WHERE 1";
                $whitelist_result=mysqli_query($db_link,$sql_query_whitelist) or die("查詢失敗");//查詢帳密
                while($row=mysqli_fetch_array($whitelist_result)){
                  echo "<tr style='color:green;'>";
                  echo "<td style='text-align:center;'>".$row['License']."</td>";
                  echo "<td style='text-align:center;'>".$row['StartTime']."</td>";
                  echo "<td style='text-align:center;'>".$row['EndTime']."</td>";
                  echo "<td style='text-align:center;'>".$row['Info']."</td>";
                  echo "<td style='text-align:center;'><input type='submit' name='delwhite".$row['_ID']."' value='取消白名單'/></td>";
                  echo "</tr>";
                }
              ?>
            <tr style='color:red;'>
              <td colspan='5' style='text-align:center;'>已設定之黑名單</td>
            </tr>
            <tr style='color:red;'>
              <td style='text-align:center;'>車牌</td>
              <td style='text-align:center;'>起始時間</td>
              <td style='text-align:center;'>結束時間</td>
              <td style='text-align:center;'>紀錄事由</td>
              <td style='text-align:center;'>狀態</td>
            </tr>
              <?php
                $sql_query_blacklist="SELECT * FROM `blacklist` WHERE 1";
                $blacklist_result=mysqli_query($db_link,$sql_query_blacklist) or die("查詢失敗");//查詢帳密
                while($row=mysqli_fetch_array($blacklist_result)){
                  echo "<tr style='color:red;'>";
                  echo "<td style='text-align:center;'>".$row['License']."</td>";
                  echo "<td style='text-align:center;'>".$row['StartTime']."</td>";
                  echo "<td style='text-align:center;'>".$row['EndTime']."</td>";
                  echo "<td style='text-align:center;'>".$row['Info']."</td>";
                  echo "<td style='text-align:center;'><input type='submit' name='delblack".$row['_ID']."' value='取消黑名單'/></td>";
                  echo "</tr>";
                }
              ?>
            </form>
          </tbody>
        </table>
      </div>
     </div>
    </section>
    <!-- 白名單設定結束 -->
    <script>
      document.getElementById("LicenseInput1").onkeyup = function() {
        this.value = this.value.replace(/[^A-Z0-9]/g, "").substr(0, 7);//限定大寫英文+數字與7碼
      };
      document.getElementById("LicenseInput2").onkeyup = function() {
        this.value = this.value.replace(/[^A-Z0-9]/g, "").substr(0, 7);//限定大寫英文+數字與7碼
      };
    </script>
    <!-- 預約表單結束 -->
    <!-- 各停車場目前使用狀態開始 -->
    <br>
    <section class="service-provide-area">
     <div class="container">
      <div class="row">
       <div class="col-md-12">
        <div class="section-title">
         <h2>各停車場目前使用狀態</h2>
         <div class="section-line">
          <span></span>
         </div>
        </div>
       </div>
      </div>
      <div class="row">
       <div class="col-md-12">
        <div class="service-provide-block">
         <div class="service-provide-single">
          <img src="img/projects/1.jpg" alt="img" />
          <h4><a>A停車場</a></h4>
          <p>台積電F12P1-張忠謀大樓</p>
          <div class="counter-content-single">
            <h4>停車場可用空位</h4>
            <h2>  
              <?php
                echo "<span class='timer' data-from='0' data-to='$ParkASpace' data-speed='5000' data-refresh-interval='50'></span>";
              ?>
            </h2>
          </div>
         </div> 
         <div class="service-provide-single">
          <img src="img/projects/2.jpg" alt="img" />
          <h4><a>B停車場</a></h4>
          <p>台積電五廠</p>
          <div class="counter-content-single">
            <h4>停車場可用空位</h4>
            <h2>  
              <?php
                echo "<span class='timer' data-from='0' data-to='$ParkBSpace' data-speed='5000' data-refresh-interval='50'></span>";
              ?>
            </h2>
          </div>
         </div>
         <div class="service-provide-single">
          <img src="img/projects/3.jpg" alt="img" />
          <h4><a>C停車場</a></h4>
          <p>台積電十二廠P6</p>
          <div class="counter-content-single">
            <h4>停車場可用空位</h4>
            <h2>  
              <?php
                echo "<span class='timer' data-from='0' data-to='$ParkCSpace' data-speed='5000' data-refresh-interval='50'></span>";
              ?>
            </h2>
          </div>
         </div>
         <div class="service-provide-single">
          <img src="img/projects/4.jpg" alt="img" />
          <h4><a>D停車場</a></h4>
          <p>台積電十二廠P4,5</p>
          <div class="counter-content-single">
            <h4>停車場可用空位</h4>
            <h2>  
              <?php
                echo "<span class='timer' data-from='0' data-to='$ParkDSpace' data-speed='5000' data-refresh-interval='50'></span>";
              ?>
            </h2>
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </section>
    <!-- 各停車場目前使用狀態結束 -->

    <!-- 台積電簡介開始 -->
    <section class="analysis-area section-padding">
     <div class="container">
      <div class="row">
       <div class="col-md-12 col-lg-12 col-xl-6">
        <div class="analysis-mask-block">
         <img src="img/services/shape.png" alt="img" />
         <div class="analysis-mask">
          <div class="analysis-mask-image">
           <img src="img/services/4.jpg" alt="img" />
          </div>
         </div>
        </div>
       </div>
       <div class="col-md-12 col-lg-12 col-xl-6">
        <div class="analysis-content">
         <h2>台積電集團</h2>
         <p>
           　　台灣積體電路製造(Taiwan Semiconductor Manufacturing Co., Ltd.)，簡稱台積電或TSMC，與旗下公司合稱時則稱作台積電集團<br>
           　　是臺灣一家從事晶圓代工的公司，為全球規模最大的半導體製造廠，可量產的邏輯IC為全球最先進的製程，總部位於新竹科學園區，主要廠房則分布於臺灣的新竹、臺中、臺南等科學園區<br>
           　　2021年8月，台積電在美國《財富》雜誌評選「全球最大500家公司」排行榜中，依營收規模名列全球第251名。2019年8月，台積電在PwC發表的「全球頂尖100家公司」排行榜中，依公司市場價值名列全球第37名
         </p>
         <div class="about-count">
          <div class="counter-content-single">
           <h2><span class="timer" data-from="0" data-to="<?php echo $ParkALLSpace;?>" data-speed="5000" data-refresh-interval="50"></span></h2>
           <h4>停車場可用空位</h4>
          </div>
          <div class="counter-content-single">
           <h2><span class="timer" data-from="0" data-to="<?php echo $ALLVIP;?>" data-speed="5000" data-refresh-interval="50"></span></h2>
           <h4>VIP車位可預約空位</h4>
          </div>
          <div class="counter-content-single">
           <h2><span class="timer" data-from="0" data-to="<?php echo $RecordCount;?>" data-speed="5000" data-refresh-interval="50"></span></h2>
           <h4>已完成停車紀錄</h4>
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </section>
    <!-- 台積電簡介結束 -->
    <!-- 停車場位址開始 -->
    <section class="project-area">
     <div class="container-fluid">
      <div class="row">
       <div class="col-md-12">
        <div class="section-title">
         <h2>您的愛車可至以下四座停車場停放</h2>
        </div>
       </div>
      </div>
      <div class="row grid">
       <div class="col-md-6 col-lg-3">
        <div class="grid-item mouse-move">
         <a href="vip.php"><img src="img/projects/1.jpg" alt="Project" /></a>
         <div class="grid-hover">
          <h3>A停車場</h3>
          <span>台積電F12P1-張忠謀大樓</span>
         </div>
         <div class="grid-hover-link">
          <a href="vip.php"><span class="flaticon-unlink"></span></a>
          <a class="venobox vbox-item" data-gall="myGallery" data-title="A停車場" href="img/projects/1.jpg"><span class="flaticon-thin-expand-arrows"></span></a>
         </div>
        </div>
       </div>
       <div class="col-md-6 col-lg-3">
        <div class="grid-item mouse-move">
         <a href="vip.php"><img src="img/projects/2.jpg" alt="Project" /></a>
         <div class="grid-hover">
          <h3>B停車場</h3>
          <span>台積電五廠</span>
         </div>
         <div class="grid-hover-link">
          <a href="vip.php"><span class="flaticon-unlink"></span></a>
          <a class="venobox vbox-item" data-gall="myGallery" data-title="B停車場" href="img/projects/2.jpg"><span class="flaticon-thin-expand-arrows"></span></a>
         </div>
        </div>
       </div>
       <div class="col-md-6 col-lg-3">
        <div class="grid-item mouse-move">
         <a href="vip.php"><img src="img/projects/3.jpg" alt="Project" /></a>
         <div class="grid-hover">
          <h3>C停車場</h3>
          <span>台積電十二廠P6</span>
         </div>
         <div class="grid-hover-link">
          <a href="vip.php"><span class="flaticon-unlink"></span></a>
          <a class="venobox vbox-item" data-gall="myGallery" data-title="C停車場" href="img/projects/3.jpg"><span class="flaticon-thin-expand-arrows"></span></a>
         </div>
        </div>
       </div>
       <div class="col-md-6 col-lg-3">
        <div class="grid-item mouse-move">
         <a href="vip.php"><img src="img/projects/4.jpg" alt="Project" /></a>
         <div class="grid-hover">
          <h3>D停車場</h3>
          <span>台積電十二廠P4,5</span>
         </div>
         <div class="grid-hover-link">
          <a href="vip.php"><span class="flaticon-unlink"></span></a>
          <a class="venobox vbox-item" data-gall="myGallery" data-title="D停車場" href="img/projects/4.jpg"><span class="flaticon-thin-expand-arrows"></span></a>
         </div>
        </div>
       </div>

      </div>
     </div>
    </section>
    <!-- 停車場位址結束 -->
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