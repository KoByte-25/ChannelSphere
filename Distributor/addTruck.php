<?php
session_start();

require_once '../includes/DB.php';
require_once '../includes/count.php';

$comUN = isset($_SESSION['comUN']) ? $_SESSION['comUN'] : null;

$pdo = getPdo();

$comId = -1;
$selectCId = "SELECT comId from company where com_username = :username";
$stmtS = $pdo->prepare($selectCId);
$stmtS->execute(['username' => $comUN]);
$resultS = $stmtS->fetch();
$comId = $resultS["comId"];

if(isset($_POST["saveBtn"]))
  {
    $truckNo = isset($_POST["truckNo"]) ? trim($_POST["truckNo"]) : "";
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
    //$long = isset($_POST["long"]) ? trim($_POST["long"]) : "";
    //$lat = isset($_POST["lat"]) ? trim($_POST["lat"]) : "";
    $limit = isset($_POST["limit"]) ? trim($_POST["limit"]) : "";
    $route = isset($_POST["route"]) ? trim($_POST["route"]) : "";

    $checkTN = "SELECT truck_no from truck where truck_no = :tno";
    $stmtC = $pdo->prepare($checkTN);
    $stmtC->execute(['tno' => $truckNo]);
    $resultC = $stmtC->fetchAll();

    if(count($resultC) > 0)
      {
        header("Location: ./addTruck.php?errMsg=ဖြည့်လိုက်သော ထရပ်နံပါတ်သည် ရှိပြီးသား ထရပ်နံပါတ်ဖြစ်နေပါသည်။ ပြန်လည် ဖြည့်သွင်းပါ။");
        exit();  
      }
    else
      {
        $insertTruckInfo = "INSERT into truck(truck_no, pwd, comId, longitude, latitude, item_limit, available, route, truck_status)
                                    values (:tno, :p, :cid, :lg, :lt, :il, :av, :r, :ts)";
        $stmtI = $pdo->prepare($insertTruckInfo);
        $stmtI->execute([
          'tno' => $truckNo,      
          'p' => $password,
          'cid' => $comId,
          'lg' => 1.1,
          'lt' => 1.1,
          'il' => $limit,
          'av' => $limit,
          'r' => $route,
          'ts' => 'NOT_DELIVERING'
          ]);
        
        header("Location: ./addTruck.php?sMsg=ထရပ်ကား အသစ်ထည့်ခြင်း အောင်မြင်ပါသည်။");
      }    
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="adminHMD professional admin dashboard template">
  <title>ChannelSphere</title>

  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <a class="brand-mark" href="#" aria-label="adminHMD dashboard">
          <span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
          <span class="brand-copy">
            <span class="brand-title">ChannelSphere</span>
            <span class="brand-subtitle">
              <?php
                if($comUN)
                  {
                    echo "ကြိုဆိုပါတယ်၊ " . $comUN;
                  }
              ?>
            </span>
          </span>
        </a>
      </div>

      <nav class="sidebar-nav">
        <a class="nav-link" href="./profile.php">
          <span class="nav-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
          <span class="nav-text">ပရိုဖိုင်</span>
        </a>
        <a class="nav-link" href="./trucks.php">
          <span class="nav-icon"><i class="bi bi-truck" aria-hidden="true"></i></span>
          <span class="nav-text">ကုမ္ပဏီရှိ ထရပ်ကားများ</span>
        </a>
        <a class="nav-link active" href="./addTruck.php">
          <span class="nav-icon" style="justify-content: center;"><img src="../assets/images/svg/truck_plus.png" width="45" height="30" alt="truck_plus_icon" ></span>
          <span class="nav-text">ထရပ်ကား ထပ်ထည့်မည်</span>
        </a>
        <a class="nav-link" href="./orders.php" aria-current="page">
          <span class="nav-icon"><i class="bi bi-cart" aria-hidden="true"></i></span>
          <span class="nav-text">ကားပေါ်မတင်ရသေးသော <sup class="text-warning"><?php echo countOrders($comUN)>0 ? countOrders($comUN) : ""; ?></sup><br>အော်ဒါများ</span>
        </a>        
        <a class="nav-link" href="./onDelivery.php" aria-current="page">
          <span class="nav-icon"><i class="bi bi-cart-dash" aria-hidden="true"></i></span>
          <span class="nav-text">ပို့နေဆဲ အော်ဒါများ</span>
        </a>   
        <a class="nav-link" href="./delivered_orders.php" aria-current="page">
          <span class="nav-icon"><i class="bi bi-cart-check" aria-hidden="true"></i></span>
          <span class="nav-text">ပို့ပြီးသွားသော အော်ဒါများ</span>
        </a>   
      </nav>
      
      <div class="sidebar-footer">
        <span class="status-dot"></span>
        <span class="sidebar-footer-text">Application အား အသုံးပြုသည့်အတွက် <br> ကျေးဇူးအများကြီးတင်ပါတယ်</span>
      </div>
    </aside>

    <div class="admin-main">
      <nav class="navbar admin-navbar navbar-expand bg-white">
        <div class="container-fluid px-3 px-lg-4">
          <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true" aria-label="Toggle sidebar">
            <span></span>
            <span></span>
            <span></span>
          </button>

          <!-- <form class="d-none d-md-flex ms-3 flex-grow-1" role="search">
            <input class="form-control search-input" type="search" placeholder="Search users, orders, reports" aria-label="Search">
          </form> -->

          <div class="navbar-actions ms-auto">
            <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
              <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button> 
            <div class="dropdown">
              <button class="icon-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="display: inline-flex; align-items: center; justify-content: center;">
                <img src="../assets/images/avatar/OIP.jpg" alt="user" style="height: 35px; width: 50px; border-radius: 5px;">
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="./profile.php">ပရိုဖိုင်</a></li>
                <li><a class="dropdown-item" href="./logout.php">အကောင့်ထွက်မည်</a></li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          <div class="page-heading">
            
            
          </div>
          <p class="text-success text-center"><?php echo isset($_GET["sMsg"]) ? $_GET["sMsg"] : ""; ?></p>
          <section class="row g-3">           
            <div class="col-12 col-xl-12">
              <form class="panel needs-validation" novalidate action="" method="post">
                <div class="panel-header"><div><h2 class="h5 mb-1 section-title"><i class="bi bi-truck" aria-hidden="true"></i><span>ထရပ်ကား ထပ်ထည့်မည်</span></h2><p class="text-muted mb-0">ဤနေရာတွင် ထရပ်ကား အချက်အလက်များ ဖြည့်ပါ</p></div></div>
                  <div class="row g-3">                                  
                    <div class="col-md-6">
                      <label class="form-label" for="truckNo">ထရပ် နံပါတ်</label>
                      <input class="form-control" id="truckNo" name="truckNo" type="text" required>
                      <p class="text-danger"><?php echo isset($_GET["errMsg"]) ? $_GET["errMsg"] : ""; ?></p>                    
                    </div> 
                    <div class="col-md-6">
                      <label class="form-label" for="password">လျှို့ဝှက်နံပါတ်</label>
                      <div class="input-group">
                        <input class="form-control" id="password" name="password" type="password" required>
                        <span class="input-group-text" id="togglePwd"><i class="bi bi-eye-slash" id="toggleIcon"></i></span>                    
                      </div>
                    </div>
                    <input type="hidden" id="long" name="long">
                    <input type="hidden" id="lat" name="lat">
                    <div class="col-md-6">
                      <label class="form-label" for="limit">အများဆုံး တင်နိုင်သော ပမာဏ (Capacity) </label>
                      <input class="form-control" id="limit" name="limit" type="number" required>                    
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="route">ပို့ဆောင်မည့် လမ်းကြောင်း </label>
                      <input class="form-control" id="route" name="route" type="text" required>                    
                    </div>     
                  </div>
                <div class="d-flex justify-content-end mt-4"><button class="btn btn-primary" type="submit" name="saveBtn"><img src="../assets/images/svg/truck_plus.png" width="45" height="30" alt="truck_plus_icon" > ထည့်မည်</button></div>
              </form>
            </div>

          </section>
        </div>
      </main>

      <footer class="admin-footer">
        <div class="container-fluid px-3 px-lg-4">
          <span>Copyright 2026 adminHMD. <br> Developed by <a target="_blank" class="fw-bold text-success" href="https://github.com/HasanMahmudDev">Md. Hasan Mahmud</a> • Distributed by <a target="_blank" class="fw-bold text-success" href="https://themewagon.com">ThemeWagon</a> </span>
          <span>Back-End Developed by - Ko Byte</span>
        </div>
      </footer>
    </div>
  </div>

  <script>
    const longIpt = document.getElementById("long");
    const latIpt = document.getElementById("lat");
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function (position) {
            console.log("Lat:", position.coords.latitude);
            console.log("Lng:", position.coords.longitude);
          },
          
          function (error) {
            console.error(error);
          }
        );
    } else {
        console.log("Geolocation not supported");
    }
                
    const pwdIpt = document.getElementById("password");
    const toggle = document.getElementById("togglePwd");
    const toggleIcon = document.getElementById("toggleIcon")

    toggle.addEventListener('mouseover', function(){
      pwdIpt.type="text";
      toggleIcon.classList.remove("bi-eye-slash");
      toggleIcon.classList.add("bi-eye");
    });

    toggle.addEventListener('mouseout', function(){
      pwdIpt.type="password";
      toggleIcon.classList.remove("bi-eye");
      toggleIcon.classList.add("bi-eye-slash");
    });
  </script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>
</body>
</html>
