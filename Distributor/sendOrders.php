<?php
session_start();

require_once '../includes/DB.php';
require_once '../includes/count.php';

$comUN = isset($_SESSION['comUN']) ? $_SESSION['comUN'] : null;

$truckNo = isset($_GET["tno"]) ? $_GET["tno"] : "";
$pdo = getPdo();

$comName = "";
$comType = "";
$comId = -1; 

$selectComInfo = "SELECT * from company where com_username = :un";
$stmtSCI = $pdo->prepare($selectComInfo);
$stmtSCI->execute(['un' => $comUN]);
$resultSCI = $stmtSCI->fetch();
$comId = $resultSCI['comId'];
$comName = $resultSCI['com_name'];
$comType = $resultSCI['com_type'];

if(isset($_POST["deliverOrder"]))
  {
    $updateQuery = "UPDATE truck set truck_status = 'DELIVERING' where truck_no = :tn";
    $stmtUQ = $pdo->prepare($updateQuery);
    $stmtUQ->execute(['tn' => $truckNo]);

    header("Location: ./orders.php");
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
        <a class="nav-link" href="./addTruck.php">
          <span class="nav-icon" style="justify-content: center;"><img src="../assets/images/svg/truck_plus.png" width="45" height="30" alt="truck_plus_icon" ></span>
          <span class="nav-text">ထရပ်ကား ထပ်ထည့်မည်</span>
        </a>
        <a class="nav-link active" href="./orders.php" aria-current="page">
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

          <div class="page-heading" style="border-bottom: 1px solid var(--admin-success);">
            <div class="page-heading-copy">
              <div>
                <p class="eyebrow mb-1"></p>
                <h3 class="mb-1 text-info">ရွေးချယ်လိုက်သော ထရပ်ကား၏ အချက်အလက်များ</h3>
                <p class="text-muted m-4">
                  <?php
                    $selectC = "SELECT * from truck where truck_no = :tn";
                    $stmtC = $pdo->prepare($selectC);
                    $stmtC->execute(['tn' => $truckNo]);
                    $resultC = $stmtC->fetch();
                  ?>
                  <table>
                    <tr>
                      <td>ထရပ် နံပါတ်</td>
                      <td class="text-info px-4"><?php echo $resultC["truck_no"] ?></td>
                    </tr>
                    <tr>
                      <td>တင်နိုင်သေးသော ပမာဏ</td>
                      <?php
                        if($resultC["available"]==0)
                          {
                      ?>
                      <td class="text-danger px-4"><?php echo $resultC["available"] . ' ' . checkUnit($comType);?></td>
                      <?php
                          }                      
                        else
                          {
                      ?>
                      <td class="text-info px-4"><?php echo $resultC["available"] . ' ' . checkUnit($comType);?></td>
                      <?php
                          }                          
                      ?>
                    </tr>
                    <tr>
                      <td>သွားမည့်လမ်းကြောင်း</td>
                      <td class="text-info px-4">&quot; ကင်မလင်းကျွန်း - ရွှေဝတ်မှုန် - မြက်တို &quot;</td>
                    </tr>
                  </table>                   
                </p>
              </div>
            </div>            
          </div>
          
          <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1"></p>
                <h1 class="h3 mb-1"><?php echo $comName . ' ' . $comType; ?></h1>
                <p class="text-muted mb-0">ကားပေါ်မတင်ရသေးသော အော်ဒါများ</p>
              </div>
            </div>            
          </div>

          
          <section class="panel"> 
            <?php
              if(isset($_GET["msgType"]))
                {
                  if($_GET["msgType"]=="success")
                    {
            ?>
            <p class="text-success"><?php echo isset($_GET["msg"]) ? $_GET["msg"] : ""; ?> </p>
            <?php
                    }
                  elseif($_GET["msgType"]=="full_warning")
                    {
            ?>
            <p class="text-danger"><?php echo isset($_GET["msg"]) ? $_GET["msg"] : ""; ?> </p>
            <?php
                    }
                    elseif($_GET["msgType"]=="warning")
                      {
            ?>
            <p class="text-warning"><?php echo isset($_GET["msg"]) ? $_GET["msg"] : ""; ?> </p>
            <?php
                      }
                }
            ?>
            <div class="panel-header">
              <div>                
                <h2 class="h5 mb-4 section-title"> 
                <form action="" method="post">
                  <button class="btn btn-success" type="submit" name="deliverOrder">အော်ဒါ လိုက်ပို့မယ်</button>
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
                    <th>ပို့ရမည့်လိပ်စာ</th>
                    <th class="text-end">လုပ်ဆောင်ချက်</th>
                  </tr>
                </thead>

                <?php           
                  $selectQuery = "SELECT * from orders where com_name = :cn and material_type = :mt and delivery_status = 'NOT_START_DELIVERY' ORDER BY order_date";
                  $stmtQ = $pdo->prepare($selectQuery);
                  $stmtQ->execute([ 
                    'cn' => $comName,
                    'mt' => $comType
                    ]);
                  $result = $stmtQ->fetchAll();   

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
                        $selectCusAddr = "SELECT addr from customer, orders where customer.cusId=orders.cusId and orderId= :oid";
                        $stmtCA = $pdo->prepare($selectCusAddr);
                        $stmtCA->execute(['oid' => $r["orderId"]]);
                        $resultCA = $stmtCA->fetch();
                        
                        echo $resultCA["addr"];
                        ?>
                    </td> 
                    <td class="text-end">
                      <form action="./putOrder.php" method="post">
                        <input type="hidden" name="tno" value="<?php echo $truckNo; ?>">
                        <input type="hidden" name="oid" value="<?php echo $r["orderId"] ?>">
                        <button class="btn btn-warning" type="submit">ကားပေါ်တင်မည်</button>
                      </form>
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
