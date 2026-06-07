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

if(isset($_POST["deleteBtn"]))
  {
    $oid = isset($_POST["oid"]) ? $_POST["oid"] : "";
    $deleteQuery = "DELETE from orders where orderId = :oid";
    $stmtD = $pdo->prepare($deleteQuery);
    $stmtD->execute(['oid' => $oid]);

    header("Location: ./orders.php?delMsg=အောင်မြင်စွာ အော်ဒါ ဖျက်လိုက်ပါပြီ။");
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
        <a class="brand-mark" href="index.html" aria-label="adminHMD dashboard">
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
        <a class="nav-link" href="./addOrder.php">
          <span class="nav-icon"><i class="bi bi-cart-plus" aria-hidden="true"></i></span>
          <span class="nav-text">ပစ္စည်း မှာမည်</span>
        </a>
        <a class="nav-link active" href="./orders.php">
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
              <span class="page-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">မှာထားသော</p>
                <h1 class="h3 mb-1">အော်ဒါများ</h1>
                <p class="text-muted mb-0"><?php echo $cusUN; ?> မှာထားသော အော်ဒါများမှာ</p>
              </div>
            </div>
            
          </div>

          <section class="panel">
            <div class="panel-header">
              <div>
                <h2 class="h5 mb-4 section-title"> 
                <a href="./orders.php" class="btn btn-warning"> နေ့တိုင်း</a>  
                <form action="" method="post">
                  <button class="btn btn-success" type="submit" name="todayBtn">ဒီနေ့</button>
                </form>
                </h2>
                <br>
                <h2 class="h5 mb-1 section-title">
                  <span>နေ့ရက်အလိုက်</span>
                  <form action="" method="post">                    
                    <input type="date" name="orderDate">
                    <button class="btn btn-info mt-1" type="submit" name="searchByDate">ရှာမည်</button>                     
                  </form>
                </h2>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table align-middle mb-0" id="ordersTable" data-searchable-table>
                <thead>
                  <tr>
                    <th>အော်ဒါ နံပါတ်</th>
                    <th>အမျိုးအစား</th>
                    <th>အရေအတွက်</th>
                    <th> ငွေပမာဏ </th>
                    <th>မှာသည့် ရက်စွဲ</th>
                    <th>ပို့ဆောင်မှု အခြေအနေ</th>
                    <th class="text-end">လုပ်ဆောင်ချက်</th>
                  </tr>
                </thead>

                <?php
                  $result = null;

                  $selectQuery = "SELECT * from orders where cusId = :cid and delivery_status != 'DELIVERED' ORDER BY order_date DESC";
                  $stmtQ = $pdo->prepare($selectQuery);
                  $stmtQ->execute([ 'cid' => $cusId]);
                  $result = $stmtQ->fetchAll();

                  if(isset($_POST["searchByDate"]))
                    {
                      $orderDate = isset($_POST["orderDate"]) ? $_POST["orderDate"] : "";

                      $selectQuery1 = "SELECT * from orders where cusId = :cid and order_date = :d and delivery_status != 'DELIVERED' ORDER BY order_time DESC";
                      $stmtQ1 = $pdo->prepare($selectQuery1);
                      $stmtQ1->execute([ 'cid' => $cusId, 'd' => $orderDate]);
                      $result = $stmtQ1->fetchAll();
                    }
                  
                  if(isset($_POST["todayBtn"]))
                    {
                      $orderDate = date("Y-m-d");

                      $selectQuery1 = "SELECT * from orders where cusId = :cid and order_date = :d and delivery_status != 'DELIVERED' ORDER BY order_time DESC";
                      $stmtQ1 = $pdo->prepare($selectQuery1);
                      $stmtQ1->execute([ 'cid' => $cusId, 'd' => $orderDate]);
                      $result = $stmtQ1->fetchAll();
                    }

                  foreach($result as $r)
                    {
                ?>

                <tbody>
                  <tr>
                    <td class="fw-semibold"><?php echo $r["orderId"]; ?></td>
                    <td><?php echo $r["com_name"] . ' ' . checkLabel($r["material_type"]); ?></td>
                    <td><?php echo $r["qty"]; ?></td>
                    <td>
                      <?php
                        $amt = 1;
                        $selectAmt = "SELECT per_unit_value from company where com_name = :cn and com_type = :ct";
                        $stmtAmt = $pdo->prepare($selectAmt);
                        $stmtAmt->execute([
                          'cn' => $r["com_name"],
                          'ct' => $r["material_type"]
                        ]);
                        $resultAmt = $stmtAmt->fetch();
                        $amt = $resultAmt["per_unit_value"];
                      
                        echo $r["qty"] * $amt;
                      ?>
                    </td>
                    <td><?php echo $r["order_date"] . "<br>" . $r["order_time"]; ?></td>
                    <td>                       
                      <?php 
                        if($r["delivery_status"] == "NOT_START_DELIVERY")
                          {
                      ?>
                        <span class="badge text-bg-warning"> ကားပေါ် မတင်ရသေးပါ </span>
                      <?php
                          }
                        elseif($r["delivery_status"] == "ON_DELIVERY")
                          {
                      ?>
                        <span class="badge text-bg-info"> စတင် ပို့ဆောင်နေပါပြီ</span>
                      <?php
                          }
                      ?>     
                    </td>
                    <td class="text-end">
                      <?php
                        if($r["delivery_status"] == "ON_DELIVERY")
                          {
                      ?>
                      <form action="./Maps.php" method="post">
                        <input type="hidden" name="oid" value="<?php echo $r["orderId"]; ?>">
                        <button class="btn btn-success btn-sm" type="submit">တည်နေရာ ကြည့်ရန်</button>
                      </form>
                      <?php
                          }
                        elseif($r["delivery_status"] == "NOT_START_DELIVERY")
                          {
                      ?>
                      <form action="" method="post">
                        <input type="hidden" name="oid" value="<?php echo $r["orderId"]; ?>">
                        <button class="btn btn-danger btn-sm" type="submit" name="deleteBtn">အော်ဒါ ပယ်ဖျက်မည်</button>
                      </form>
                      <?php
                          }
                      ?>
                    </td>
                  </tr>
                </tbody>

                <?php
                    }
                ?>

              </table>
            </div>
            <p class="text-success text-center pt-4"><?php echo isset($_GET["delMsg"]) ? $_GET["delMsg"] : "" ?></p>
          </section>
        </div>

      </main>

      <footer class="admin-footer">
        <div class="container-fluid px-3 px-lg-4">
          <span>Copyright 2026 adminHMD. <br> Developed by <a target="_blank" class="fw-bold text-success" href="https://github.com/HasanMahmudDev">Md. Hasan Mahmud</a> • Distributed by <a target="_blank" class="fw-bold text-success" href="https://themewagon.com">ThemeWagon</a> </span>
          <span>Professional dashboard template.</span>
          <span>Responsive table examples.</span>
        </div>
      </footer>
    </div>
  </div>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>
</body>
</html>
