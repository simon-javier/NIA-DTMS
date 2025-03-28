<?php 
    session_start();
    if(!(isset($_SESSION['reg-code-expiration']) && $_SESSION['reg-code-expiration'])){
        header("Location: registration-page.php");
        exit();
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Tracking System</title>
    <link rel="stylesheet" href="../assets/jsdelivr/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="../assets/cloudflare/all.min.css">
    <link rel="stylesheet" href="../assets/css/login.css">
    <style>
        .form {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>

</head>
<body>
    <?php require '../assets/loader/loader.php'; ?>

        <div class="login-container position-relative">
            <img src="../assets/img/login-background.jpg" alt="Login Background" class="img-fluid">
            <div class="login-form row p-5 d-md-flex justify-content-center align-items-center position-absolute w-100"> 
                    <div class="form col-lg-4 col-12">
                        <form action="" id="reg_verification" class="p-5" autocomplete="off">
                            <h1 class="text-center">OTP Verification</h1>
                            <p class="text-center" style="color:red" id="error-message"></p>
                            <div class="form-group">
                                <label for="username">Verification Code</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                                    </div>
                                    <input type="text" aria-label="Verification code" name="code" id="code" placeholder="Verification code" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-center" style="gap: 1.5rem !important">
                                <button type="submit" id="reg_verify_button" name="reg_verify_button" class="btn btn-primary w-100">Verify</button>
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="" id="reg_resend_code">Resend Code</a>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    
  

        <script src="../assets/jquery/jquery-3.2.1.slim.min.js"></script>
    <script src="../assets/jsdelivr/popper.min.js"></script>
    <script src="../assets/jsdelivr/bootstrap.min.js"></script>
    <script src="../assets/jsdelivr/sweetalert2.all.min.js"></script>
    <script src="../assets/jquery/jquery-3.6.4.min.js"></script>






<script>
    $("#reg_verify_button").click(function(e){
        if($("#reg_verification")[0].checkValidity()){
            e.preventDefault();
            $('.loader-container').fadeIn();
            $.ajax({
                url: "../controller/login-reg-forgot-controller.php",
                type: "POST",
                data: $("#reg_verification").serialize()+"&action=reg_verify_code",
                success:function(response){
                    setTimeout(function() {
                    $('.loader-container').fadeOut();
                    }, 500);
                    if(response.status === "failed"){
                        Swal.fire({
                            title: 'Failed!',
                            text: response.message,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
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
                    }else if(response.status === "success"){
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                        // Check if the user clicked the "OK" button
                        if (result.isConfirmed) {
                            // Reload the page
                            window.location.href = '../index.php';
                        }
                        });
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





    <?php require '../assets/failed-success-modal.php'; ?>
</body>
</html>