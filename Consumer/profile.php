<?php
session_start();

require_once '../includes/DB.php';

$cusUN = isset($_SESSION['cusUN']) ? $_SESSION['cusUN'] : null;

$pdo = getPdo();

if(isset($_POST["editBtn"]))
  {
    $fullName = isset($_POST["fullName"]) ? trim($_POST["fullName"]) : "";
    $addr = isset($_POST["addr"]) ? trim($_POST["addr"]) : "";
    $mail = isset($_POST["mail"]) ? trim($_POST["mail"]) : "";
    $phNo = isset($_POST["phNo"]) ? trim($_POST["phNo"]) : "";

    $updateUserInfo = "UPDATE customer set full_name = :fn, addr = :ad, mail = :m, ph_no = :pn WHERE username = :username";
    $stmtU = $pdo->prepare($updateUserInfo);
    $stmtU->execute([
      'fn' => $fullName,
      'ad' => $addr,
      'm' => $mail,
      'pn' => $phNo,
      'username' => $cusUN
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
                if($cusUN)
                  {
                    echo "ကြိုဆိုပါတယ်၊ " . $cusUN;
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
        <a class="nav-link" href="./addOrder.php">
          <span class="nav-icon"><i class="bi bi-cart-plus" aria-hidden="true"></i></span>
          <span class="nav-text">ပစ္စည်း မှာမည်</span>
        </a>
        <a class="nav-link" href="./orders.php">
          <span class="nav-icon"><i class="bi bi-cart-dash" aria-hidden="true"></i></span>
          <span class="nav-text">မှာထားသော အော်ဒါများ</span>
        </a>
        <a class="nav-link" href="./delivered_orders.php" aria-current="page">
          <span class="nav-icon"><i class="bi bi-cart-check" aria-hidden="true"></i></span>
          <span class="nav-text">ရောက်ပြီးသော အော်ဒါများ</span>
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
                <p class="eyebrow mb-1">အကောင့်</p>
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
                    if($cusUN)
                      {
                        echo $cusUN;
                      }
                  ?>
                </h2>
                <div class="d-flex justify-content-center gap-2"><span class="badge text-bg-success">Active အသုံးပြုသူ</span></div>
                <div class="info-list mt-4 text-start">
                <?php                  
                  
                  $selectUserInfo = "SELECT * FROM customer WHERE username = :username";
                  $stmt = $pdo->prepare($selectUserInfo);
                  $stmt->execute(['username' => $cusUN]);
                  $result = $stmt->fetchAll();

                  foreach($result as $row)
                  {                    
                ?>
                  <div>
                    <span>နာမည် အပြည့်အစုံ </span>
                    <strong><?php echo $row['full_name']; ?></strong>
                  </div>
                  <div>
                    <span>နေရပ်လိပ်စာ</span>
                    <strong><?php echo $row['addr']; ?></strong>
                  </div>
                  <div>
                    <span>အီးမေးလ်</span>
                    <strong><?php echo $row['mail']; ?></strong>
                  </div>
                  <div>
                    <span>ဖုန်းနံပါတ်</span>
                    <strong><?php echo $row['ph_no']; ?></strong>
                  </div>
                <?php
                  }
                ?>
                </div>
              </div>
            </div>
            
            <div class="col-12 col-xl-8">
              <form class="panel needs-validation" novalidate action="" method="post">
                <div class="panel-header">
                  <div>
                    <h2 class="h5 mb-1 section-title">
                      <i class="bi bi-person-gear" aria-hidden="true"></i>
                      <span>ပရိုဖိုင် စက်တင်</span>
                    </h2>
                    <p class="text-muted mb-0">ဤနေရာတွင် ပရိုဖိုင် အချက်အလက်များ ပြင်ဆင်နိုင်ပါသည်</p>
                  </div>
                </div>
                <div class="row g-3">
                  <?php                  
                    foreach($result as $row)
                    {                    
                  ?>
                  <div class="col-md-6">
                    <label class="form-label" for="profileName">နာမည်အပြည့်အစုံ</label>
                    <input class="form-control" id="profileName" name="fullName" type="text" value="<?php echo $row["full_name"]; ?>" required>                    
                  </div>
                  <div class="col-md-6">
                    <label class="form-label" for="addr">နေရပ်လိပ်စာ</label>
                    <input class="form-control" id="addr" name="addr" type="text" value="<?php echo $row["addr"]; ?>" required>                    
                  </div> 
                  <div class="col-md-6">
                    <label class="form-label" for="mail">အီးမေးလ်</label>
                    <input class="form-control" id="mail" name="mail" type="email" value="<?php echo $row["mail"]; ?>" required>                    
                  </div> 
                  <div class="col-md-6">
                    <label class="form-label" for="phNo">ဖုန်းနံပါတ်</label>
                    <input class="form-control" id="phNo" name="phNo" type="text" value="<?php echo $row["ph_no"]; ?>" required>                    
                  </div>   
                  <?php
                    }
                  ?>
                </div>
                <div class="d-flex justify-content-end mt-4"><button class="btn btn-primary" type="submit" name="editBtn"><i class="bi bi-check2-circle" aria-hidden="true"></i>ပြင်မည်</button></div>
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
