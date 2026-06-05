<?php
session_start();

require_once '../includes/DB.php';

$cusUN = isset($_SESSION['cusUN']) ? $_SESSION['cusUN'] : null;

$pdo = getPdo();

$cusId = -1;

$selectCusId = "SELECT cusId from customer where username = :username";
$stmtCId = $pdo->prepare($selectCusId);
$stmtCId->execute(['username' => $cusUN]);
$resultCId = $stmtCId->fetchAll();

foreach($resultCId as $rcid)
{
  $cusId = $rcid["cusId"];
}
//echo $cusId;

if(isset($_POST["order"]))
  {
    $orderId = "";
    while(true)
      {
        $id = generateCode();
        $odid = "#".$id;
        $selectOId = "SELECT orderId from orders where orderId = :oid";
        $stmtOId = $pdo->prepare($selectOId);
        $stmtOId->execute(['oid' => $odid]);
        $resultOId = $stmtOId->fetch();
        if ($resultOId === false) 
          {
            $orderId = $odid;
            break;
          }
      }
    
    $comName = isset($_POST["comName"]) ? $_POST["comName"] : "";
    $materialType = isset($_POST["materialType"]) ? $_POST["materialType"] : "";
    $qty = isset($_POST["qty"]) ? $_POST["qty"] : "";

    $DELIVERY_STATUS = "NOT_START_DELIVERY";

    $insertOrder = "INSERT into orders (orderId, cusId, com_name, material_type, qty, delivery_status) 
                                values (:oid, :cid, :cn, :mt, :q, :ds)";
    $stmtO = $pdo->prepare($insertOrder);
    $stmtO->execute([
      'oid' => $orderId,
      'cid' => $cusId,
      'cn' => $comName,
      'mt' => $materialType,
      'q' => $qty,
      'ds' => $DELIVERY_STATUS
    ]);
    
    header("Location: ./addOrder.php?successMsg=အောင်မြင်စွာ အော်ဒါတင်လိုက်ပါပြီ။");
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
        <a class="nav-link" href="./profile.php">
          <span class="nav-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
          <span class="nav-text">ပရိုဖိုင်</span>
        </a>
        <a class="nav-link active" href="./addOrder.php">
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
              <span class="page-icon"><i class="bi bi-cart" aria-hidden="true"></i></span>
              <div style="justify-content: center;">
                <p class="eyebrow mb-1">ဤစာမျက်နှာတွင် မှာယူချင်တဲ့ ပစ္စည်း များကို ရွေးချယ်ပြီး မှာယူနိုင်ပါပြီ</p>
              </div>
            </div>
            
          </div>

          <section class="row g-3">
            <div class="col-12 col-xl-4">
              <form class="panel needs-validation" novalidate action="" method="post">
                <div class="panel-header"><h2 class="h5 mb-1 section-title"><i class="bi bi-box-fill" aria-hidden="true"></i><span>မှာယူနိုင်သော ပစ္စည်းများ</span></h2></div>
                <div class="row g-3">
                  <div class="col-md-6">
                    <select class="form-control" name="matType" required>
                      <option value="ရေသန့် ဖြန့်ချီရေး">ရေသန့်</option>
                      <option value="ဟာလဝါ ဖြန့်ဖြူးရောင်းချရေး">ဟာလဝါ</option>
                    </select>
                  </div>
                <div class="d-flex justify-content-end mt-4"><button class="btn btn-primary" type="submit" name="chooseMT"><i class="bi bi-cart-plus" aria-hidden="true"></i> မှာမည်</button></div>
              </form>
            </div>  
            <br><p class="text-success text-center"><?php echo isset($_GET["successMsg"]) ?  $_GET["successMsg"] : ""; ?></p>
            <?php
              if(isset($_POST["chooseMT"]))
                {                       
                  
            ?>

            <div class="col-12 col-xl-8">
              <form class="panel needs-validation" novalidate action="" method="post">
                <div class="panel-header">
                  <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-box" aria-hidden="true"></i><span><?php echo checkLabel($_POST["matType"]); ?> မှာယူရန်</span></h2>
                    <p class="text-muted mb-0">အောက်က ဖောင် ကိုဖြည့်ပေးပါ </p>
                  </div>
                </div>
                
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label" for="comName">ကုမ္ပဏီ နာမည် ရွေးချယ်ပါ</label>                    
                    <select name="comName" id="comName" class="form-control">
                    <?php 
                      $selectCN = "SELECT com_name from company where com_type = :comType";
                      $stmtCN = $pdo->prepare($selectCN);
                      $stmtCN->execute(['comType' => $_POST["matType"]]);
                      $resultCN = $stmtCN->fetchAll(); 
                      
                      foreach($resultCN as $rcn)
                        {
                    ?>  
                      <option value="<?php echo $rcn['com_name']; ?>"><?php echo $rcn['com_name']; ?></option>
                    <?php
                        }
                    ?>
                    </select>
                  </div>
                  
                  <input type="hidden" name="materialType" value="<?php echo $_POST["matType"]; ?>">

                  <div class="col-md-6">
                    <label class="form-label" for="quantity">အရေအတွက်</label>    
                    <input type="number" class="form-control" id="quantity" name="qty" value="1" min="1">                
                  </div>
                
                  <div class="d-flex justify-content-end mt-4"><button class="btn btn-primary" type="submit" name="order"><i class="bi bi-cart-plus" aria-hidden="true"></i><?php echo checkLabel($_POST["matType"]); ?> မှာမည်</button></div>
              </form>
            </div>
            <?php
                }
            ?>

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
