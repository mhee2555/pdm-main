<?php
session_start();
date_default_timezone_set("Asia/Bangkok");

// if (isset($_SESSION['userData'])) {
//     header("location:login.php");
//     exit(0);
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pose intelligence</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="assets/dist/img/p.png" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="assets/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/vendor/animsition/css/animsition.min.css">
    <link rel="stylesheet" href="assets/plugins/jquery-confirm-v3.3.4/css/jquery-confirm.css">

    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/login/util.css">
    <link rel="stylesheet" type="text/css" href="assets/login/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <!--===============================================================================================-->
    <style>
        body {
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<body>

    <div class="limiter">
        <div class="container-login100 rootBackround">
            <div class="card fade-in" style="border-radius: 2.25rem!important;">
                <div class="card-body py-5">
                    <div class="wrap-login100 p-b-20">
                        <div class="login100-form validate-form">
                            <span class="login100-form-title titleColor">
                                Pose intelligence
                            </span>

                            <div class="wrap-input100 validate-input m-t-60 m-b-35" data-validate="Enter username">
                                <input class="input100" type="text" name="username" id="username">
                                <span class="focus-input100" data-placeholder="Username"></span>
                            </div>

                            <div class="wrap-input100 validate-input m-b-50" data-validate="Enter password">
                                <input class="input100" type="password" name="pass" id="password">
                                <span class="focus-input100" data-placeholder="Password"></span>
                            </div>

                            <div class="container-login100-form-btn">
                                <button class="login100-form-btn" id="btnLogin">
                                    Login
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card helper" id="helper">
                <div class="card-header text-right">
                    <button id="btnHideHelp">X</button>
                </div>
                <div class="card-body text-center" style="padding-left:0px!important;padding-right:0px!important;">
                    <div class="help-title">
                        <span>เมื่อพบปัญหาในการใช้งาน <br> สามารถติดต่อได้ที่ <span class="help-line">LINE@</span> นี้ค่ะ</span>
                    </div>
                    <div>
                        <img src="assets/dist/img/poseQr.jpg" style="width:50%;" />
                    </div>
                    <div class="help-title">
                        <span>POSE INTELLIGENCE <br> Service Support </span>
                    </div>
                </div>
            </div>

            <div class="iconHelper " id="showHelper" title="Helper" hidden>
                
                <div class="iconHelper d-flex align-items-center justify-content-center">
                    <i class="fa fa-info-circle"></i>
                </div>
            </div>
       

        </div>
    </div>


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


        $("#showHelper").click(function() {
            $('#helper').addClass("helperIn");
            $('#helper').removeClass("helperOut");

            setTimeout(() => {
                $('#showHelper').attr('hidden', true);
            }, 500);
        })

        
        $("#btnHideHelp").click(function() {
            $('#helper').removeClass("helperIn");
            $('#helper').addClass("helperOut");
            setTimeout(() => {
                $('#showHelper').attr('hidden', false);
            }, 500);
        })
    </script>

</body>

</html>