<?php 
    session_start();
    if(isset($_SESSION['userid'])){
        if($_SESSION['office'] == "Administrative Section Records"){
            header('Location: views/record_office/newly-created-docs.php');
        }else{
            if($_SESSION['role'] == 'guest'){
                header('Location: views/guest/submit-document.php');
            }
            if($_SESSION['role'] == 'sysadmin'){
                header('Location: views/sysadmin/dashboard.php');
            }
            if($_SESSION['role'] == 'admin'){
                header('Location: views/admin/dashboard.php');
            }
            if($_SESSION['role'] == 'handler'){
                header('Location: views/handler/incoming-documents.php');
            }
        }
        
        exit();
    }

    
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Tracking System</title>
    <link rel="stylesheet" href="assets/jsdelivr/bootstrap.min.css">
    <link rel="stylesheet" href="assets/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/cloudflare/all.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <style>
        .form {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>

</head>
<body>
    <?php require 'assets/loader/loader.php'; ?>

        <div class="login-container position-relative">
            <img src="assets/img/login-background.jpg" alt="Login Background" class="img-fluid">
            <div class="login-form row p-5 d-md-flex justify-content-center align-items-center position-absolute w-100"> 
                    <div class="logo col-lg-8 d-none p-5 d-md-flex justify-content-center align-items-center flex-md-column">
                        <img src="assets/img/logo.png" alt="Logo" class="img-fluid mb-3">
                        <h1 class="text-center">DOCUMENT TRACKING SYSTEM</h1>
                        <p class="text-center">NATIONAL IRRIGATION ADMINISTRATION REGION IV-A (CALABARZON) PILA, LAGUNA</p>
                    </div>

                    <div class="form col-lg-4 col-12">
                        <form action="" id="form-login" class="p-5" autocomplete="off">
                            <h1 class="text-center">Login</h1>
                            <p class="text-center" style="color:red" id="error-message"></p>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" aria-label="Username" name="username" id="username" placeholder="Username" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    </div>
                                    <input type="password" aria-label="Password" name="password" id="password" placeholder="Password" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-end">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" id="customCheck1_label" for="customCheck1">Show Password</label>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-center" style="gap: 1.5rem !important">
                                <button type="submit" id="login_button" name="login_button" class="btn btn-primary w-100">Login</button>
                                <a href="views/registration-page.php" class="btn btn-success w-100">Sign Up</a>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="views/forgot-password.php" >Forgot Password?</a>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                <a href="qr-code-scanner.php" class="btn btn-danger">Scan Document</a>
                            </div>
                          

                           
                        </form>
                    </div>
            </div>
        </div>
    
  
    <script src="assets/jquery/jquery-3.2.1.slim.min.js"></script>
    <script src="assets/jsdelivr/popper.min.js"></script>
    <script src="assets/jsdelivr/bootstrap.min.js"></script>
    <script src="assets/jsdelivr/sweetalert2.all.min.js"></script>
    <script src="assets/jquery/jquery-3.6.4.min.js"></script>






<script>
    $("#login_button").click(function(e){
        if($("#form-login")[0].checkValidity()){
            e.preventDefault();
            $('.loader-container').fadeIn();
            $.ajax({
                url: "controller/login-reg-forgot-controller.php",
                type: "POST",
                data: $("#form-login").serialize()+"&action=login-check",
                success:function(response){
                    setTimeout(function() {
                    $('.loader-container').fadeOut();
                    }, 500);
                    if(response.status === "failed"){
                        if(response.message == "Username not exists"){
                            $("#username").val("");
                            $("#password").val("");
                        }else if(response.message == "Incorrect password"){
                            $("#password").val("");
                        }
                        $("#error-message").text(response.message);
                    }else if(response.status === "error"){
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                        // Check if the user clicked the "OK" button
                        if (result.isConfirmed) {
                            // Reload the page
                            location.reload();
                        }
                    });
                    }
                    if(response.status === "success"){
                        if(response.office == "Administrative Section Records"){
                            window.location.href = 'views/record_office/newly-created-docs.php';
                        }else{
                            if(response.role == "guest"){
                            window.location.href = 'views/guest/submit-document.php';
                            }
                            else if(response.role == "sysadmin"){
                                window.location.href = 'views/sysadmin/dashboard.php';
                            }
                            else if(response.role == "admin"){
                                window.location.href = 'views/admin/dashboard.php';
                            }
                            else if(response.role == "handler"){
                                window.location.href = 'views/handler/incoming-documents.php';
                            }
                            else if(response.role == "internal"){
                                window.location.href = 'views/internal/incoming-document.php';
                            }
                            else{
                                Swal.fire({
                                title: 'Error!',
                                text: "Unkwon account type.",
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                            // Check if the user clicked the "OK" button
                            if (result.isConfirmed) {
                                // Reload the page
                                window.location.href = 'logout.php';

                            }
                        });
                            }
                            
                        }
                      
                    }
                   
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    var errorMessage = 'An error occurred while processing your request.';
                    if (xhr.statusText) {
                        errorMessage += ' ' + xhr.statusText;
                    }
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage + '<br><br>' + JSON.stringify(xhr, null, 2), // Include the entire error object for debugging
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Check if the user clicked the "OK" button
                        if (result.isConfirmed) {
                            // Reload the page
                            location.reload();
                        }
                    });
                }
            });
        }
    });
</script>


<script>
    var showHidePassCheckbox = document.getElementById('customCheck1');
    var passwordInput = document.getElementById('password');
    var customCheck1_label = document.getElementById('customCheck1_label');
    customCheck1_label
    showHidePassCheckbox.addEventListener('change', function() {
      if (showHidePassCheckbox.checked) {
        passwordInput.type = "text";

        customCheck1_label.textContent = "Hide Password";
      } else {
        passwordInput.type = "password";

        customCheck1_label.textContent = "Show Password";
      }
    });

</script>




    <?php require 'assets/failed-success-modal.php'; ?>
</body>
</html>