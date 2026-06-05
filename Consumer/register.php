<?php
session_start();

require_once '../includes/DB.php';

  if(isset($_POST['register']))
    {
      $username = isset($_POST['username']) ? trim($_POST['username']) : '';
      $password = isset($_POST['pwd']) ? trim($_POST['pwd']) : '';
      $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
      $address = isset($_POST['address']) ? trim($_POST['address']) : '';
      $email = isset($_POST['email']) ? trim($_POST['email']) : '';
      $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

      $pdo = getPdo();
      
      $checkUserQuery = "SELECT * FROM customer WHERE username = :username";
      $stmt = $pdo->prepare($checkUserQuery);
      $stmt->execute(['username' => $username]);
      $result = $stmt->fetchAll();

      if(count($result) > 0)
        {
          // User already exists
          header("Location: ./register.php?regErrMsg=အသုံးပြုသူအမည် ရှိပြီးသားဖြစ်ပါသည်။ အခြားအသုံးပြုသူအမည်ကို အသုံးပြုပါ။");
          exit();
        }
      else
        {

          $checkEmail = "SELECT * FROM customer WHERE mail = :mail";
          $stmt = $pdo->prepare($checkEmail);
          $stmt->execute(['mail' => $email]);
          $result = $stmt->fetchAll();
          if(count($result) > 0)
            {
              header("Location: ./register.php?regMErrMsg=ထည့်လိုက်သော အီးမေးလ်ကို အသုံးပြုထားတဲ့ အကောင့် ရှိပြီးသားဖြစ်ပါသည်။ အခြား အီးမေးလ်ကို အသုံးပြုပါ။");
              exit();
            }
          else 
            {
              // User does not exist, proceed with registration
              //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
              $insertUserQuery = "INSERT INTO customer (username, pwd, full_name, addr, mail, ph_no) 
                                  VALUES (:username, :pwd, :full_name, :addr, :mail, :ph_no)";
              $stmt = $pdo->prepare($insertUserQuery);
              $stmt->execute([
                  'username' => $username,
                  'pwd' => $password,
                  'full_name' => $fullname,
                  'addr' => $address,
                  'mail' => $email,
                  'ph_no' => $phone
              ]);

              $_SESSION['cusUN'] = $username;
              header("Location: ./profile.php");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="adminHMD authentication page">
  <title>Register | ChannelSphere</title>

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
      <div class="auth-visual"><img src="../assets/images/png/dasher-ui-bootstrap-5.jpg" alt="ChannelSphere dashboard interface"></div><!-- ဆိုင်တဲ့ဓာတ်ပုံပြောင်းရန် -->
      <form class="needs-validation" action="" method="POST" novalidate>
        <div class="mb-4">
          <p class="eyebrow mb-1">ပစ္စည်း မှာဖို့ အကောင့်ဖွင့်ရန် လိုအပ်ပါသည်။</p>
          <h1 class="h3 mb-1">အကောင့်ဖွင့်ပါ</h1>
        </div>
        <div class="mb-3"><label class="form-label" for="registerName">အသုံးပြုသူအမည်</label><input class="form-control" id="registerName" type="text" name="username" required><div class="invalid-feedback">မှန်ကန်သော အသုံးပြုသူအမည်ထည့်ပေးပါ</div><p style="color: red; padding: 3px;" id="username-error"><?php  echo isset($_GET['regErrMsg']) ? $_GET['regErrMsg'] : '';  ?></p></div>
        <div class="mb-3"><label class="form-label" for="registerPassword">လျှို့ဝှက်နံပါတ်</label><div class="input-group"><input class="form-control" id="registerPassword" type="password" name="pwd" required><span class="input-group-text" id="togglePwd"><i class="bi bi-eye-slash" id="toggleIcon"></i></span></div><div class="invalid-feedback">မှန်ကန်သော လျှို့ဝှက်နံပါတ်ထည့်ပေးပါ</div><p style="color: red; padding: 3px; font-size: 12px;" id="pwd-error"></p></div>
        <div class="mb-3"><label class="form-label" for="registerFN">နာမည်အပြည့်အစုံ</label><input class="form-control" id="registerFN" type="text" name="fullname" required><div class="invalid-feedback">မှန်ကန်သော နာမည်အပြည့်အစုံထည့်ပေးပါ</div></div>
        <div class="mb-3"><label class="form-label" for="registerAddr">နေရပ်လိပ်စာ</label><input class="form-control" id="registerAddr" type="text" name="address" required><div class="invalid-feedback">မှန်ကန်သော နေရပ်လိပ်စာထည့်ပေးပါ</div></div>
        <div class="mb-3"><label class="form-label" for="registerEmail">အီးမေးလ်</label><input class="form-control" id="registerEmail" type="email" name="email" required><div class="invalid-feedback">မှန်ကန်သော အီးမေးလ်ထည့်ပေးပါ</div><p style="color: red; padding: 3px;"><?php  echo isset($_GET['regMErrMsg']) ? $_GET['regMErrMsg'] : '';  ?></p></div>
        <div class="mb-3"><label class="form-label" for="registerPhone">ဖုန်းနံပါတ်</label><input class="form-control" id="registerPhone" type="text" name="phone" required><div class="invalid-feedback">မှန်ကန်သည့် ဖုန်းနံပါတ်ထည့်ပေးပါ</div></div>

        <!-- <div class="form-check mb-4"><input class="form-check-input" type="checkbox" id="terms" required><label class="form-check-label" for="terms">I agree to the terms</label><div class="invalid-feedback">You must agree before continuing.</div></div> -->
        <button class="btn btn-primary w-100" type="submit" name="register" id="register"><i class="bi bi-person-plus" aria-hidden="true"></i> အကောင့်ဖွင့်မည်</button>
      </form>
      
      <div class="auth-footer">အကောင့်ဖွင့်ပြီးသားလား? <a href="./index.php">အကောင့်ဝင်ပါ</a></div>
    </section>
  </main>

  <script>
    const input  = document.getElementById('registerName');
    const error  = document.getElementById('username-error');
    const register  = document.getElementById('register');

    input.addEventListener('input', function () {
        if (this.value.includes(' ')) {
            error.textContent = 'အသုံးပြုသူအမည်တွင် space ထည့်လို့မရပါ';
            register.disabled = true;
        } else {
            error.textContent = '';
            register.disabled = false;
        }
    });

    const passwordInput = document.getElementById('registerPassword');
    const passwordError = document.getElementById('pwd-error');

    const passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;

    passwordInput.addEventListener('input', function () {
      const value = this.value;

      if (!passwordRegex.test(value)) {        
        passwordError.textContent = 'လျှို့ဝှက်နံပါတ်သည် စာလုံး အနည်းဆုံး ၈ လုံး၊ စာလုံးကြီး အနည်းဆုံး ၁ လုံး , အထူး စာလုံး အနည်းဆုံး ၁ လုံး၊ ဂဏန်း အနည်းဆုံး ၁ လုံး လိုအပ်ပါသည်။';
        register.disabled = true;
      } else {        
        passwordError.textContent = '';
        register.disabled = false;
      }
    });

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
