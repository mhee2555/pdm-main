<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>เข้าสู่ระบบ</title>
  <?php include_once('assets/import_index/css.php'); ?>
  <link rel="stylesheet" href="assets/plugins/jquery-confirm-v3.3.4/css/jquery-confirm.css">

  <!--===============================================================================================-->
</head>

<body>
  <div class="row" id="form-layout">
    <!-- Form - Layout -->

    <div class="col-sm-8 col-md-6">
      <div class="logo mt-4 ml-5" style="position: fixed;">
        <img src="assets/dist/img/logo/logo.png" class="logo-img" style="width: 350px;">
      </div>
      
      <div class="left-layout">
        <!-- logo -->
        <div class="logo">
          <!-- <img src="assets/dist/img/logo_nhealth.png" class="logo-img"> -->
          <label style="font-size: 70px;color:#224099;">Pose health care</label>
        </div>

        <!-- Text Login -->
        <div class="text-login">
          <label style="color:black">Login Account</label>
        </div>

        <!-- form login -->
        <div class="login-layout">
          <!-- Username -->
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="icon-user"><i class="fas fa-user"></i></span>
            </div>
            <div id="floatContainer1" class="float-container">
              <label for="inputUsername">ชื่อผู้ใช้งาน</label>
              <input type="text" id="username" data-placeholder="" autocomplete="off">
            </div>
          </div>

          <!-- Password -->
          <div class="input-group mt-2">
            <div class="input-group-prepend">
              <span class="input-group-text" id="icon-user"><i class="fas fa-unlock-alt"></i></span>
            </div>

            <div id="floatContainer2" class="float-container">
              <label for="inputPassword">รหัสผ่าน</label>
              <input type="password" id="password" data-placeholder="" autocomplete="off">
            </div>
          </div>

          <!-- <div class=" mt-3 text-right my-3" style="width: 65%;">
            <a href="#" data-toggle="modal" data-target="#modal_chang"><span>เปลี่ยนรหัสผ่าน</span></a>
          </div> -->

          <!-- Button -->
          <div class="my-3 ">
            <button class="btn-login" id="btnLogin">เข้าสู่ระบบ</button>
          </div>

        </div>

        <!-- form login -->
      </div>

    </div>
    <!-- Form - Login -->


    <!-- background - reft -->
    <div class="col-sm-4 col-md-6 img-background"><img src="assets/dist/img/bg_nsupply.png"></div>
    <!-- background - reft -->
  </div>



  <script src="assets/dist/js/input.js"></script>
  <!--===============================================================================================-->
  <script src="assets/login/vendor/jquery/jquery-3.2.1.min.js"></script>
  <!--===============================================================================================-->
  <script src="assets/login/vendor/animsition/js/animsition.min.js"></script>
  <!--===============================================================================================-->
  <script src="assets/login/vendor/bootstrap/js/popper.js"></script>
  <script src="assets/login/vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/plugins/jquery-confirm-v3.3.4/js/jquery-confirm.js"></script>
  <script src="assets/login/login.js"></script>
  <script>
    var isShowError = false;

    document.addEventListener("keydown", function(event) {
      if (event.which == 13) {
        if ($("#username").val() != "" && $("#password").val() != null) {
          if (!isShowError) {
            login();
          }
        } else {
          $("#btnLogin").click();
        }
      }
    })

    function login() {


      $.ajax({
        url: "process/authen.php",
        type: 'POST',
        data: {
          'FUNC_NAME': 'login',
          'username': $("#username").val(),
          'password': $("#password").val(),
        },
        success: function(result) {
          if (result == "success") {
            location.href = "index.php";
          } else {
            $("#username").val("");
            $("#password").val("");
            showDialogError();
          }
        }
      });
    }


    function showDialogError() {
      isShowError = true;
      $.confirm({
        title: 'Failed!',
        content: "Username or Password invalid!",
        type: 'red',
        autoClose: 'close|8000',
        typeAnimated: true,
        draggable: false,
        buttons: {
          close: function() {
            isShowError = false;
          }
        }
      });
    }
  </script>
</body>

</html>