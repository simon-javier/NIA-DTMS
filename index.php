<?php 
    session_start();
    if(isset($_SESSION['userid'])){
        if($_SESSION['office'] == "Administrative Section Records"){
            header('Location: views/record_office/dashboard.php');
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
                header('Location: views/handler/dashboard.php');
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

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        :root {
            --primary-color: #069734;
            --lighter-primary-color: #07b940;
            --white-color: #FFFFFF;
            --black-color: #181818;
            --bold: 600;
            --transition: all 0.5s ease;
            --box-shadow: 0 0.5rem 0.8rem rgba(0, 0, 0, 0.2)
        }
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', 'Arial';
        }
        .main {
            height: 100vh;
            width: 100%;



            
         
    
        }

        .background {
            height: 100vh;
            width: 100%;
           
        }
        
        .background::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-image: url('assets/img/login-background.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.5; /* Adjust the opacity value for darkening the background image */
            z-index: -1;
        
        }

        .content{
        
            height: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            border-radius: 2rem;
            background-color: white;
        }
        .left{
            border-radius: 2rem 0 0 2rem;
            height: auto;
            padding: 2rem;
        }
        .right{
            border-radius: 10rem 2rem 2rem 10rem;
            height: auto;
            background: linear-gradient(106deg, rgba(77,185,111,1) 0%, rgba(74,195,112,1) 23%, rgba(33,157,72,1) 48%, rgba(6,151,52,1) 100%);
        }
        .form-group{
            width: 80%;
        }
        .logo{
            width: 150px;
            height: 150px;
        }
        .input-group-text {
            cursor: pointer;
        }
        #form-login{
            display: flex;
            justify-content: center;
            align-items: center;
 
            flex-direction: column;
            width: 100%;
        }
        .register-button {
            text-decoration: none;
            border: 2px solid white;
            padding: 10px;
            border-radius: 5px;
            color: white;
            transition: transform 0.3s ease; 
         
        }

        .register-button:hover {
            color: white;
            text-decoration: none;
            transform: scale(1.1); 
        }
        
    </style>
</head>
<body style="background-color: #181818;">
    <?php require 'assets/loader/loader.php'; ?>
    <div class="p-5 main d-flex justify-content-center align-items-center">
        <div class="p-3 background d-flex justify-content-center align-items-center">
        <div class="content col-md-6 col-sm-8">
            <div class="row">
            <div class="left col-md-6 d-flex flex-column justify-content-center align-items-center">
                <img src="assets/img/logo.png" alt="Logo" class="logo img-fluid mb-3 d-none d-md-block">
                <h1>Login</h1>
                <p class="text-center" style="color:red" id="error-message"></p>
                <form action="" id="form-login" autocomplete="off">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" aria-describedby="username" placeholder="Username" required>
                </div>
                <div class="form-group mb-3">
                    <label for="username">Password</label>
                    <div class="input-group flex-nowrap">
                        <input type="password" class="form-control" placeholder="Password" aria-label="Password" id="password" name="password" aria-describedby="addon-wrapping" required>
                        <span class="input-group-text" id="addon-wrapping" onclick="togglePassword()"><i class="fa fa-eye" id="showhide" aria-hidden="true"></i></span>
                    </div>
                </div>
                <a href="views/forgot-password.php">Forget Your Password</a>
                <button type="submit" id="login_button" name="login_button" class="btn btn-success mt-3 mb-3" style="width: 30%;">Login</button>
                <a href="views/registration-page.php" class="d-block d-md-none mb-5">Don't have an account?</a>
                </form>
                <a href="qr-code-scanner.php" class="btn btn-danger d-block d-md-none" >Scan Document</a>
            </div>
            <div class="right col-md-6 flex-column d-none d-md-flex justify-content-center align-items-center" style="color: white">
                <h1 style="font-weight: bold;">Hello,</h1>
                <p style="text-align: center">Register with your personal details to use all of the site features. You can also scan the tracking QR Code by clicking the Scan Document button.</p>
                <div class="d-flex">
                <a href="views/registration-page.php" class="register-button mr-3">Register</a>
                <a href="qr-code-scanner.php" class="register-button">Scan Document</a>
                </div>
                
            </div>
            </div>
        </div>
        </div>
        
    </div>
    



    <script src="assets/jquery/jquery-3.2.1.slim.min.js"></script>
    <script src="assets/jsdelivr/popper.min.js"></script>
    <script src="assets/jsdelivr/bootstrap.min.js"></script>
    <script src="assets/jsdelivr/sweetalert2.all.min.js"></script>
    <script src="assets/jquery/jquery-3.6.4.min.js"></script>


    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("showhide");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>

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
                            window.location.href = 'views/record_office/dashboard.php';
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
                                window.location.href = 'views/handler/dashboard.php';
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
</body>
</html>
