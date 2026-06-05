<?php
session_start();

require_once '../includes/DB.php';
require_once '../includes/count.php';

$comUN = isset($_SESSION['comUN']) ? $_SESSION['comUN'] : null;

$pdo = getPdo();

$labels = [
          "ရေသန့် ဖြန့်ချီရေး" => "ရေသန့် ၁ ဘူး",
          "ဟာလဝါ ဖြန့်ဖြူးရောင်းချရေး" => "ဟာလဝါ ၁ ဘူး"
          ];

if(isset($_POST["editBtn"]))
  {
    $amount = isset($_POST["amount"]) ? trim($_POST["amount"]) : "";
    $addr = isset($_POST["addr"]) ? trim($_POST["addr"]) : "";
    $mail = isset($_POST["mail"]) ? trim($_POST["mail"]) : "";
    $phNo = isset($_POST["phNo"]) ? trim($_POST["phNo"]) : "";

    $updateCompanyInfo = "UPDATE company set addr = :ad, ph_no = :pn, mail = :m, per_unit_value = :puv WHERE com_username = :username";
    $stmtU = $pdo->prepare($updateCompanyInfo);
    $stmtU->execute([
      'ad' => $addr,      
      'pn' => $phNo,
      'm' => $mail,
      'puv' => $amount,
      'username' => $comUN
      ]);
    
    header("Location: ./profile.php?edMsg=ပရိုဖိုင် ပြင်ဆင်ခြင်း အောင်မြင်ပါသည်။");
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
        <a class="nav-link active" href="./profile.php">
          <span class="nav-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
          <span class="nav-text">ပရိုဖိုင်</span>
        </a>
        <a class="nav-link" href="./trucks.php">
          <span class="nav-icon"><i class="bi bi-truck" aria-hidden="true"></i></span>
          <span class="nav-text">ကုမ္ပဏီရှိ ထရပ်ကားများ</span>
        </a>
        <a class="nav-link" href="./addTruck.php">
          <span class="nav-icon" style="justify-content: center;"><img src="../assets/images/svg/truck_plus.png" width="45" height="30" alt="truck_plus_icon" ></span>
          <span class="nav-text">ထရပ်ကား ထပ်ထည့်မည်</span>
        </a>
        <a class="nav-link" href="./orders.php" aria-current="page">
          <span class="nav-icon"><i class="bi bi-cart" aria-hidden="true"></i></span>
          <span class="nav-text">မပို့ရသေးသော အော်ဒါများ<sup class="text-warning"><?php echo countOrders($comUN)>0 ? countOrders($comUN) : ""; ?></sup></span>
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
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">ကုမ္ပဏီ အကောင့်</p>
                <h1 class="h3 mb-1">ပရိုဖိုင်</h1>
              </div>
            </div>
            
          </div>
          <p class="text-success text-center"><?php echo isset($_GET["edMsg"]) ? $_GET["edMsg"] : ""; ?></p>
          <section class="row g-3">
            <div class="col-12 col-xl-4">
              <div class="panel h-100 text-center profile-card">
                <div class="profile-cover btn-primary"></div>
                <img class="avatar-img avatar-xl profile-photo" src="../assets/images/avatar/OIP.jpg" alt="user profile">
                <h2 class="h5 mt-3 mb-1">
                  <?php
                    if($comUN)
                      {
                        echo $comUN;
                      }
                  ?>
                </h2>
                <div class="d-flex justify-content-center gap-2"><span class="badge text-bg-success">Active အသုံးပြုသူ</span></div>
                <div class="info-list mt-4 text-start">
                <?php                  
                  $selectComInfo = "SELECT * FROM company WHERE com_username = :username";
                  $stmt = $pdo->prepare($selectComInfo);
                  $stmt->execute(['username' => $comUN]);
                  $result = $stmt->fetchAll();

                  foreach($result as $row)
                  {                    
                ?>
                  <div>
                    <span>ကုမ္ပဏီ နာမည် </span>
                    <strong><?php echo $row['com_name']; ?></strong>
                  </div>
                  <div>
                    <span>ကုမ္ပဏီ အမျိုးအစား</span>
                    <strong><?php echo $row['com_type']; ?></strong>
                  </div>
                  <div>
                    <span>နေရပ်လိပ်စာ</span>
                    <strong><?php echo $row['addr']; ?></strong>
                  </div>
                  <div>
                    <span>ဖုန်းနံပါတ်</span>
                    <strong><?php echo $row['ph_no']; ?></strong>
                  </div>
                  <div>
                    <span>အီးမေးလ်</span>
                    <strong><?php echo $row['mail']; ?></strong>
                  </div>
                   <div>
                    <span>
                      <?php echo $labels[$row["com_type"]] . " စျေးနှုန်း" ?>
                    </span>
                    <strong><?php echo $row['per_unit_value']; ?> MMK</strong>
                  </div>
                <?php
                  }
                ?>
                </div>
              </div>
            </div>

            <div class="col-12 col-xl-8">
              <form class="panel needs-validation" novalidate action="" method="post">
                <div class="panel-header"><div><h2 class="h5 mb-1 section-title"><i class="bi bi-person-gear" aria-hidden="true"></i><span>ပရိုဖိုင် စက်တင်</span></h2><p class="text-muted mb-0">ဤနေရာတွင် ကုမ္ပဏီ ပရိုဖိုင် အချက်အလက်များ ပြင်ဆင်နိုင်ပါသည်</p></div></div>
                  <div class="row g-3">
                  <?php                  
                    foreach($result as $row)
                    {                    
                  ?>                  
                  <div class="col-md-6">
                    <label class="form-label" for="addr">နေရပ်လိပ်စာ</label>
                    <input class="form-control" id="addr" name="addr" type="text" value="<?php echo $row["addr"]; ?>" required>                    
                  </div> 
                  <div class="col-md-6">
                    <label class="form-label" for="phNo">ဖုန်းနံပါတ်</label>
                    <input class="form-control" id="phNo" name="phNo" type="text" value="<?php echo $row["ph_no"]; ?>" required>                    
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="mail">အီးမေးလ်</label>
                    <input class="form-control" id="mail" name="mail" type="email" value="<?php echo $row["mail"]; ?>" required>                    
                  </div>                      
                  <div class="col-md-6">
                    <label class="form-label" for="amount"><?php echo $labels[$row["com_type"]] . " စျေးနှုန်း" ?></label>
                    <input class="form-control" id="amount" name="amount" type="number" value="<?php echo $row["per_unit_value"]; ?>" required>                    
                  </div>
                  <?php
                    }
                  ?>
                  </div>
                <div class="d-flex justify-content-end mt-4"><button class="btn btn-primary" type="submit" name="editBtn"><i class="bi bi-check2-circle" aria-hidden="true"></i> ပြင်မည်</button></div>
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

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>
</body>
</html>
