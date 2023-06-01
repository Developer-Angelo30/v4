<?php
include_once("./include/session/checkSession.php");
if(isset($_SESSION['email']) && isset($_SESSION['password']) && isset($_SESSION['role']) && isset($_SESSION['department'])) {
    $session = new mySession($_SESSION['email'], $_SESSION['password'], $_SESSION['role'], $_SESSION['department']);
    $session->checkSession();
}

// echo md5("loginAccounts-schedlr");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome-free-6.4.0-web/css/all.css">
    <link rel="stylesheet" href="../assets/css/all.css">
    <link rel="stylesheet" href="../assets/css/login-styles.css">
    <title>Document</title>
</head>
<body>
    <sectio class="wrapper login-section d-flex justify-content-center align-items-center ">
        <div class="box login-box">
            <div class="left position-relative ">
                <span class="yellow position-absolute bottom-0 w-100 h-100 " ></span>
                <span class="orange position-absolute bottom-0 w-100 p-3" >
                    <img src="../assets/images/schedule-icon.JPG" class="position-relative w-100" alt="">
                </span>
                <span class="blue position-absolute bottom-0 w-100 " ></span>
            </div>
            <div class="right position-relative h-100 w-100 ">
                <div class="white orange position-absolute bottom-0 w-100 d-flex h-100 justify-content-center align-items-center">
                    <form id="login-form" class="w-100 p-5" >
                        <div class="text-center">
                            <img src="../assets/images/icon.gif" alt="" class="rounded-circle" >
                            <h4 class="fw-bolder" >ADMINISTATOR</h4><hr>
                        </div>
                        <div class="form-group mt-3">
                            <div class="input-group ">
                                <input type="text" class="login-email input form-control" placeholder="Email Address" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2"> <i class="fa fa-envelope"></i> </span>
                            </div>
                            <small class="error login-email-error text-danger" ></small>
                        </div>
                        <div class="form-group mt-3">
                            <div class="input-group ">
                                <input type="password" id="login-password" class="login-password input form-control" placeholder="Password" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2"> <i onclick="passwordShow('login-password', 'password-icon')" id="password-icon" class=" fa fa-eye"></i> </span>
                            </div>
                            <small class="error login-password-error text-danger" ></small>
                        </div>
                        <div class="form-group text-center mt-3">
                            <button type="button"  id="login-submit" class="login-submit btn btn-primary w-75" ><span> <strong>Login</strong> <i class="fa fa-arrow-right" ></i> </span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </sectio>
    <script src="../assets/js/jquery-3.6.4.js" ></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js" ></script>
    <script src="../assets/fontawesome-free-6.4.0-web/js/all.js"></script>
    <script src="../assets/sweetalert2/dist/sweetalert2.all.js"></script>
    <script src="../assets/js/login-custom.js"></script>
</body>
</html>