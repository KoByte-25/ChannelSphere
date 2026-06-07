<?php
session_start();

require_once '../includes/DB.php';

$cusUN = isset($_SESSION['cusUN']) ? $_SESSION['cusUN'] : null;

$pdo = getPdo();

$oid = isset($_POST["oid"]) ? $_POST["oid"] : "";
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

  <!-- Local Leaflet CSS -->
    <link rel="stylesheet" href="../dist/leaflet.css">

    <style>
      #map {
        width: 100%;
        height: 500px;
      }
      
      @media (max-width: 900px) {
        #map {
          height: 300px;
        }
      }
    </style>
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

          <form class="d-none d-md-flex ms-3 flex-grow-1" role="search">
            <input class="form-control search-input" type="search" placeholder="Search users, orders, reports" aria-label="Search">
          </form>

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
              <span class="page-icon"><i class="bi bi-map" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">အော်ဒါ နံပါတ်</p>
                <h1 class="h3 mb-1"><?php echo $oid; ?> </h1>
                <p class="text-muted mb-0">ရောက်ရှိနေသော နေရာ</p>
              </div>
            </div>
            
          </div>

          <?php
          $selectPosition = "SELECT * from truck, delivery where truck.truck_no=delivery.truck_no and delivery.orderId = :oid";
          $stmtP = $pdo->prepare($selectPosition);
          $stmtP->execute([':oid' => $oid]);
          $resultP = $stmtP->fetch();
          $truckNo = $resultP['truck_no'];
          $lon = $resultP['longitude'];
          $lat = $resultP['latitude'];
          $message = "အော်ဒါ နံပါတ် >> " . $oid . " <br> ထရပ် နံပါတ် >> " . $truckNo;
          ?>
          <section class="panel blank-panel">
            <div id="map"></div>
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

  <!-- Local Leaflet JS -->
    <script src="../dist/leaflet.js"></script>

    <script>
          // orderId from PHP (same as you used for the SELECT)
      const oid = <?php echo json_encode($oid); ?>;

      // Initial position from DB (PHP)
      let latitude  = <?php echo $lat; ?>;
      let longitude = <?php echo $lon; ?>;

      // Initialize Leaflet map (lat, lon)
      const map = L.map('map').setView([latitude, longitude], 15);

      const popupMessage = <?php echo json_encode($message); ?>;

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '&copy; OpenStreetMap contributors'
      }).addTo(map);

      // Create a single marker we will move
      let truckMarker = L.marker([latitude, longitude]).addTo(map)
          .bindPopup(popupMessage)
          .openPopup();

      // Function to fetch latest lat/lon from your DB via PHP
      async function fetchLatestPosition() {
          try {
              const response = await fetch('./get_truck_position_by_order_id.php?oid=' + encodeURIComponent(oid));
              const data = await response.json();

              if (data.error) {
                  console.log('Error:', data.error);
                  return;
              }

              const newLat = parseFloat(data.lat);
              const newLon = parseFloat(data.lon);

              if (isNaN(newLat) || isNaN(newLon)) {
                  return;
              }

              // Update marker position
              truckMarker.setLatLng([newLat, newLon]);

              // Optionally recenter map on truck:
              // map.setView([newLat, newLon]);
          } catch (e) {
              console.error('Failed to fetch position', e);
          }
      }

      // Call the function repeatedly every 5 seconds (5000 ms)
      setInterval(fetchLatestPosition, 1000);
    </script>

  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/main.js"></script>
</body>
</html>
