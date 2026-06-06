<?php
session_start();

require_once '../includes/DB.php';
require_once '../includes/count.php';

$comUN = isset($_SESSION['comUN']) ? $_SESSION['comUN'] : null;

$pdo = getPdo();

$comId = -1;
$comName = "";
$comType = "";

$selectComInfo = "SELECT * from company where com_username = :un";
$stmtSCI = $pdo->prepare($selectComInfo);
$stmtSCI->execute(['un' => $comUN]);
$resultSCI = $stmtSCI->fetch();
$comId = $resultSCI['comId'];
$comName = $resultSCI['com_name'];
$comType = $resultSCI['com_type'];

if(isset($_POST["editTI"]))
  {
    $tNo = isset($_POST["tNo"]) ? $_POST["tNo"] : "";
    $pwd = isset($_POST["pwd"]) ? $_POST["pwd"] : "";
    $lmt = isset($_POST["lmt"]) ? $_POST["lmt"] : "";

    $updateQuery = "UPDATE truck set pwd=:p, item_limit=:il where truck_no=:tno";
    $stmtQ = $pdo->prepare($updateQuery);
    $stmtQ->execute([
      'p' => $pwd,
      'il' => $lmt,
      'tno' => $tNo
      ]);
    header("Location: ./trucks.php?msg=အချက်အလက်များ အောင်မြင်စွာ ပြင်ပြီးပါပြီ။");
  }

if(isset($_POST["deleteT"]))
  {
    $tNo = isset($_POST["tNo"]) ? $_POST["tNo"] : "";
    $deleteQuery = "DELETE from truck where truck_no=:tno";
    $stmtD = $pdo->prepare($deleteQuery);
    $stmtD->execute(['tno' => $tNo]);
    header("Location: ./trucks.php?msg=ထရပ်ကား အား အောင်မြင်စွာ ဖျက်ပြီးပါပြီ။");
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
        <a class="nav-link active" href="./trucks.php">
          <span class="nav-icon"><i class="bi bi-truck" aria-hidden="true"></i></span>
          <span class="nav-text">ကုမ္ပဏီရှိ ထရပ်ကားများ</span>
        </a>
        <a class="nav-link" href="./addTruck.php">
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
                <p class="eyebrow mb-1"></p>
                <h1 class="h3 mb-1 text-info"><?php echo $comName . ' ' . $comType; ?> တွင်​ရှိသော</h1>
                <p class="text-muted mb-0">ထရပ်ကားများ</p>
              </div>
            </div>
            
          </div>
          <p class="text-success text-center pt-4"><?php echo isset($_GET["msg"]) ? $_GET["msg"] : "" ?></p>

          <section class="panel">            
            <div class="table-responsive">
              <table class="table align-middle mb-0" id="ordersTable" data-searchable-table>
                <thead>
                  <tr>
                    <th>ထရပ် နံပါတ်</th>
                    <th>လျှို့ဝှက်နံပါတ်</th>
                    <th>အများဆုံး တင်နိုင်သော ပမာဏ <br> (Capacity)</th>
                    <th>တင်နိုင်သေးသော ပမာဏ <br> (Avaible) </th>
                    <th> ပို့ဆောင်မည့် လမ်းကြောင်း </th>
                    <th> ပို့ဆောင်မှု အခြေအနေ</th>
                    <th class="text-end">လုပ်ဆောင်ချက်</th>
                  </tr>
                </thead>

                <?php
                  $result = null;

                  $selectQuery = "SELECT * from truck where comId = :cid";
                  $stmtQ = $pdo->prepare($selectQuery);
                  $stmtQ->execute([ 'cid' => $comId]);
                  $result = $stmtQ->fetchAll();                  

                  foreach($result as $r)
                    {     
                ?>

                <tbody>
                  <tr>
                    <td class="fw-semibold"><?php echo $r["truck_no"]; ?></td>
                    <td><?php echo $r["pwd"]; ?></td>
                    <td><?php echo $r["item_limit"]; ?></td>
                    <td><?php echo $r["available"]; ?></td>
                    <td><?php echo $r["route"]; ?></td>
                    <td><?php echo $r["truck_status"]; ?></td>
                    <td class="text-end">
                      <?php
                      if($r["item_limit"]==$r["available"])
                        {
                      ?>
                      <form action="" method="post">
                        <input type="hidden" name="tno" value="<?php echo $r["truck_no"]; ?>">
                        <button class="btn btn-danger" name="deleteT">ဖျက်မည်</button>
                      </form>   
                      <?php
                        }
                      ?>              
                      <br>
                      <a href="test.php?tno=<?php echo $r["truck_no"]; ?>" class="btn btn-success btn-sm">တည်နေရာ ကြည့်ရန်</a>
                    </td>
                  </tr>
                </tbody>
                <?php
                          }
                  
                ?>

              </table>
            </div>
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

  <script>
    const passwordInput = document.getElementById("pwd");
    const toggle = document.getElementById("togglePwd");
    const toggleIcon = document.getElementById("toggleIcon")

    toggle.addEventListener('mouseover', function(){
      passwordInput.type="text";
      toggleIcon.classList.remove("bi-eye-slash");
      toggleIcon.classList.add("bi-eye");
    });

    toggle.addEventListener('mouseout', function(){
      passwordInput.type="password";
      toggleIcon.classList.remove("bi-eye");
      toggleIcon.classList.add("bi-eye-slash");
    });
  </script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>
</body>
</html>
