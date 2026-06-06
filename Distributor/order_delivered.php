<?php
session_start();

require_once '../includes/DB.php';
require_once '../includes/count.php';

$truckNo = isset($_SESSION['truckNo']) ? $_SESSION['truckNo'] : null;

$pdo = getPdo();

$selectComInfo = "SELECT * from truck where truck_no = :tn";
$stmtSCI = $pdo->prepare($selectComInfo);
$stmtSCI->execute(['tn' => $truckNo]);
$resultSCI = $stmtSCI->fetch();
$comId = $resultSCI['comId'];

$selectO = "SELECT * from delivery, orders where delivery.orderId=orders.orderId and delivery.truck_no=:tn and orders.delivery_status='ON_DELIVERY';";
$stmtO = $pdo->prepare($selectO);
$stmtO-> execute(['tn' => $truckNo]);
$resultO = $stmtO->fetchAll();

$count = count($resultO);

$selectDO = "SELECT * from delivery, orders where delivery.orderId=orders.orderId and delivery.truck_no=:tn and orders.delivery_status='DELIVERED';";
$stmtDO = $pdo->prepare($selectDO);
$stmtDO-> execute(['tn' => $truckNo]);
$resultDO = $stmtDO->fetchAll();

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
                if($truckNo)
                  {
                    echo "ကြိုဆိုပါတယ်၊ " . $truckNo;
                  }
              ?>
            </span>
          </span>
        </a>
      </div>

      <nav class="sidebar-nav">        
        <a class="nav-link" href="./ordersToSend.php" aria-current="page">
          <span class="nav-icon"><i class="bi bi-cart" aria-hidden="true"></i></span>
          <span class="nav-text">မပို့ရသေးသော အော်ဒါများ<sup class="text-warning"><?php echo $count>0 ? $count : ""; ?></sup></span>
        </a>                
        <a class="nav-link active" href="./order_delivered.php" aria-current="page">
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
          

          <div class="navbar-actions ms-auto">
            <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
              <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button>            
            
            <a href="./logout.php"><button class="btn btn-info btn-sm">အကောင့်ထွက်မည်</button></a>
          </div>
        </div>
      </nav>

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          
          
          <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1"></p>
                <h5 class="text-info mb-1">ထရပ်နံပါတ် <?php echo $truckNo; ?> မှ</h5>
                <p class="text-muted mb-0">ပို့ပြီးသွားသော အော်ဒါများ</p>                
              </div>
            </div>            
          </div>
          
          

          
        <section class="panel">            
            <div class="table-responsive">
              <table class="table align-middle mb-0" id="ordersTable" data-searchable-table>
                <thead>
                  <tr>
                    <th>အော်ဒါ နံပါတ်</th>
                    <th>အမျိုးအစား</th>
                    <th>အရေအတွက်</th>
                    <th> ငွေပမာဏ </th>
                    <th>မှာသည့် ရက်စွဲ</th>
                    <th>ပို့ရမည့်လိပ်စာ</th>
                    <th class="text-end">ပို့ပြီးသည့်ရက်</th>
                  </tr>
                </thead>

                <?php                 
                  foreach($resultDO as $r)
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
                        $selectAmt = "SELECT per_unit_value from company where comId = :ci";
                        $stmtAmt = $pdo->prepare($selectAmt);
                        $stmtAmt->execute(['ci' => $comId]);
                        $resultAmt = $stmtAmt->fetch();
                        $amt = $resultAmt["per_unit_value"];
                      
                        echo $r["qty"] * $amt;
                      ?>
                    </td>
                    <td><?php echo $r["order_date"] . "<br>" . $r["order_time"]; ?></td>
                    <td>
                        <?php
                        $selectCusAddr = "SELECT addr from customer, orders where customer.cusId=orders.cusId and orderId= :oid";
                        $stmtCA = $pdo->prepare($selectCusAddr);
                        $stmtCA->execute(['oid' => $r["orderId"]]);
                        $resultCA = $stmtCA->fetch();
                        
                        echo $resultCA["addr"];
                        ?>
                    </td>
                    <td class="text-end"><?php echo $r["delivered_date"]; ?></td>  
                  </tr>
                </tbody>

                <?php
                    }
                ?>

              </table>
            </div>
            <p class="text-success text-center pt-4"><?php echo isset($_GET[""]) ? $_GET[""] : "" ?></p>
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
