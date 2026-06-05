<?php
session_start();

require_once '../includes/DB.php';

  if(isset($_POST['login']))
    {
      $username = isset($_POST['username']) ? trim($_POST['username']) : '';
      $password = isset($_POST['pwd']) ? trim($_POST['pwd']) : '';

      $pdo = getPdo();
      
      $checkUserName = "SELECT * FROM customer WHERE BINARY username = :username";
      $stmt = $pdo->prepare($checkUserName);
      $stmt->execute(['username' => $username]);
      $result = $stmt->fetchAll();

      if(count($result) > 0)
        {
          $checkPwd = "SELECT * FROM customer WHERE BINARY username = :username AND BINARY pwd = :pwd";
          $stmt = $pdo->prepare($checkPwd);
          $stmt->execute(['username' => $username, 'pwd' => $password]);
          $result = $stmt->fetchAll();
          if(count($result) > 0)
            {
              $_SESSION['cusUN'] = $username;
              header("Location: ./profile.php");
              exit();
            }
          else
            {
              header("Location: ./index.php?logPwdErrMsg=လျှို့ဝှက်နံပါတ် မှားယွင်းနေပါသည်။ <br> ထပ်မံကြိုးစားပါ");
              exit();
            }

        }
      else
        {
          header("Location: ./index.php?logUNErrMsg=အသုံးပြုသူအမည် မှားယွင်းနေပါသည်။ <br> အကောင့်မရှိသေးပါက အကောင့်ဖွင့်ပါ");
          exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="ChannelSphere">
  <title>Login | ChannelSphere</title>

  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="auth-body">
  <button class="icon-button theme-toggle auth-theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
    <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
  </button>
  <main class="auth-page">
    <section class="auth-card">
      <a class="auth-brand" href="./index.php"><span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span><span><strong>ChannelSphere</strong></span></a>
      <div class="auth-visual"><img src="../assets/images/png/dasher-ui-bootstrap-5.jpg" alt="ChannelSphere"></div><!-- ဆိုင်တဲ့ဓာတ်ပုံပြောင်းရန် -->
      <form class="needs-validation" action="" method="post" novalidate>
        <div class="mb-4">
          <p class="eyebrow mb-1">ပစ္စည်း မှာ ဖို့ အကောင့်ဝင်ပါ။</p>
          <h1 class="h3 mb-1">အကောင့်ဝင်ပါ</h1>
        </div>
        <div class="mb-3"><label class="form-label" for="username">အသုံးပြုသူအမည်</label><input class="form-control" id="username" type="text" name="username" required><div class="invalid-feedback">မှန်ကန်သော အသုံးပြုသူအမည်ထည့်ပေးပါ</div><p style="color: red; padding: 3px;"><?php  echo isset($_GET['logUNErrMsg']) ? $_GET['logUNErrMsg'] : '';  ?></p></div>
        <div class="mb-3"><div class="d-flex justify-content-between"><label class="form-label" for="loginPassword">လျှို့ဝှက်နံပါတ်</label><!--<a class="small fw-semibold" href="forgot-password.html">Forgot?</a> --></div><div class="input-group"><input class="form-control" id="loginPassword" type="password" name="pwd" required><span class="input-group-text" id="togglePwd"><i class="bi bi-eye-slash" id="toggleIcon"></i></span></div><div class="invalid-feedback">မှန်ကန်သော လျှို့ဝှက်နံပါတ်ထည့်ပေးပါ</div><p style="color: red; padding: 3px;"><?php  echo isset($_GET['logPwdErrMsg']) ? $_GET['logPwdErrMsg'] : '';  ?></p></div>
        <!-- <div class="form-check mb-4"><input class="form-check-input" type="checkbox" id="rememberMe"><label class="form-check-label" for="rememberMe">Remember me</label></div> -->
        <button class="btn btn-primary w-100" type="submit" name="login"><i class="bi bi-box-arrow-in-right" aria-hidden="true"></i>အကောင့်ဝင်ပါ</button>
      </form>
      
      <div class="auth-footer">အကောင့်မရှိသေးဘူးလား? <a href="./register.php">အကောင့်ဖွင့်ပါ</a></div>
    </section>
  </main>

  <script>
    const pwdIpt = document.getElementById("loginPassword");
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
