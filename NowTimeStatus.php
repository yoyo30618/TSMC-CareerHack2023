<!DOCTYPE html>
<html lang="zh-TW">
  <meta http-equiv="refresh" content="1"/>
  <?php
    session_start();//開啟session
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
    /*查詢每一格各自狀態*/
    $Sql_query_parkstatusA="SELECT * FROM `parkstatusa`";
    $ParkstatusA_result=mysqli_query($db_link,$Sql_query_parkstatusA) or die("查詢失敗");//查詢帳密
    $ParkASpaceStatus=array();
    while($row=mysqli_fetch_array($ParkstatusA_result)){
      if($row['IsUsed']==0)//位置不可用
        $ParkASpaceStatus[$row['SpaceID']]=2;
      else
      $ParkASpaceStatus[$row['SpaceID']]=$row['IsParked'];
    }
    $Sql_query_parkstatusB="SELECT * FROM `parkstatusb`";
    $ParkstatusB_result=mysqli_query($db_link,$Sql_query_parkstatusB) or die("查詢失敗");//查詢帳密
    $ParkBSpaceStatus=array();
    while($row=mysqli_fetch_array($ParkstatusB_result)){
      if($row['IsUsed']==0)//位置不可用
        $ParkBSpaceStatus[$row['SpaceID']]=2;
      else
      $ParkBSpaceStatus[$row['SpaceID']]=$row['IsParked'];
    }
    $Sql_query_parkstatusC="SELECT * FROM `parkstatusc`";
    $ParkstatusC_result=mysqli_query($db_link,$Sql_query_parkstatusC) or die("查詢失敗");//查詢帳密
    $ParkCSpaceStatus=array();
    while($row=mysqli_fetch_array($ParkstatusC_result)){
      if($row['IsUsed']==0)//位置不可用
        $ParkCSpaceStatus[$row['SpaceID']]=2;
      else
      $ParkCSpaceStatus[$row['SpaceID']]=$row['IsParked'];
    }
    $Sql_query_parkstatusD="SELECT * FROM `parkstatusd`";
    $ParkstatusD_result=mysqli_query($db_link,$Sql_query_parkstatusD) or die("查詢失敗");//查詢帳密
    $ParkDSpaceStatus=array();
    while($row=mysqli_fetch_array($ParkstatusD_result)){
      if($row['IsUsed']==0)//位置不可用
        $ParkDSpaceStatus[$row['SpaceID']]=2;
      else
      $ParkDSpaceStatus[$row['SpaceID']]=$row['IsParked'];
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
                echo "<li class='nav-item'><a class='nav-link' href='info.php'>個資查詢</a></li>";
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
      <h1>實時停車狀態顯示</h1>
      <nav aria-label="breadcrumb">
       <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">首頁</a></li>
        <li class="breadcrumb-item active" aria-current="page">實時停車狀態顯示</li>
       </ol>
      </nav>
     </div>
    </section>
    <!-- 上方背景橫幅結束-->
    <?php
      $NowEnterTime= array();
      $NowEnterLicense= array();
      $NowEnterPath= array();
      $NowLeaveTime= array();
      $NowLeaveLicense= array();
      $NowLeavePath= array();
      $sql_query_NowEnter="SELECT * FROM `parkingrecord` ORDER BY `parkingrecord`.`EnterTime` DESC";
      $NowEnter_result=mysqli_query($db_link,$sql_query_NowEnter) or die("查詢失敗");
      $t=0;
      while($row=mysqli_fetch_array($NowEnter_result)){
        $NowEnterTime[$t]=$row['EnterTime'];
        $NowEnterLicense[$t]=$row['License'];
        $NowEnterPath[$t]=$row['EnterPhotoPath'];
        $t++;
      }
      for(;$t<5;$t++){
        $NowEnterTime[$t]="無資料";
        $NowEnterLicense[$t]="無資料";
        $NowEnterPath[$t]="無資料";
      }

      $sql_query_NowLeave="SELECT * FROM `parkingrecord` ORDER BY `parkingrecord`.`LeaveTime` DESC";
      $NowLeave_result=mysqli_query($db_link,$sql_query_NowLeave) or die("查詢失敗");
      $t=0;
      while($row=mysqli_fetch_array($NowLeave_result)){
        $NowLeaveTime[$t]=$row['LeaveTime'];
        $NowLeaveLicense[$t]=$row['License'];
        $NowLeavePath[$t]=$row['LeavePhotoPath'];
        $t++;
      }
      for(;$t<5;$t++){
        $NowLeaveTime[$t]="無資料";
        $NowLeaveLicense[$t]="無資料";
        $NowLeavePath[$t]="無資料";
      }
		?>
    <!-- 實時車況開始 -->
    <form method="post" action="SpaceChg.php">
      <section class="service-provide-area">
        <div class="container">
          <div class="row">
            <table width="100%" style="border: 1px solid red;">
              <thead>
                <tr>
                <th colspan="3" style="border: 1px solid red;text-align:center;">車輛入場</th>
                <th colspan="3" style="border: 1px solid red;text-align:center;">車輛出場</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  for($i=0;$i<5;$i++){
                    echo "<tr>";
                    echo "<td style='border: 1px solid red;text-align:center;text-align:center'>".$NowEnterLicense[$i]."</td>";
                    echo "<td style='border: 1px solid red;text-align:center;text-align:center'>".$NowEnterTime[$i]."</td>";
                    if($NowEnterPath[$i]=="手動輸入車牌無照片")
                      echo "<td style='border: 1px solid red;text-align:center;text-align:center'>手動輸入車牌無照片</td>";
                    else
                    echo "<td style='border: 1px solid red;text-align:center;text-align:center'><img src='EnterImage/".$NowEnterPath[$i]."' width='300' heigh='200'></td>";
                    echo "<td style='border: 1px solid red;text-align:center;text-align:center'>".$NowLeaveLicense[$i]."</td>";
                    echo "<td style='border: 1px solid red;text-align:center;text-align:center'>".$NowLeaveTime[$i]."</td>";
                    if($NowLeavePath[$i]=="手動輸入車牌無照片")
                      echo "<td style='border: 1px solid red;text-align:center;text-align:center'>手動輸入車牌無照片</td>";
                    else
                      echo "<td style='border: 1px solid red;text-align:center;text-align:center'><img src='LeaveImage/".$NowLeavePath[$i]."' width='300' heigh='200' alt='尚無圖片'></td>";
                    echo "<tr>";
                    echo "</tr>";
                  }
                ?>
              </tbody>
            </table>


          </div>
        </div>
      </section>
    </form>
    <!-- 實時車況結束 -->    

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
<<<<<<< HEAD
                echo "<li class='nav-item'><a class='nav-link' href='info.php'>資料查詢</a></li>";
                if(isset($_COOKIE['TSMC_Status'])&&$_COOKIE['TSMC_Status']=="管理員"){
                  echo "<li class='nav-item'><a class='nav-link' href='NowTimeStatus.php'>實況</a></li>";
                  echo "<li class='nav-item'><a class='nav-link' href='admin.php'>模擬</a></li>";
=======
                echo "<li class='nav-item'><a class='nav-link' href='info.php'>個資查詢</a></li>";
                if(isset($_COOKIE['TSMC_Status'])&&$_COOKIE['TSMC_Status']=="管理員"){
                  echo "<li class='nav-item'><a class='nav-link' href='NowTimeStatus.php'>實況</a></li>";
                  echo "<li class='nav-item'><a class='nav-link' href='admin.php'>後臺</a></li>";
>>>>>>> dc6086cca414cb56879b1d723b4a5480f6308fe4
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