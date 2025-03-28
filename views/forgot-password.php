<?php 
    session_start();
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
        ::-webkit-scrollbar {
            width: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background-color: #009933; 
            border-radius: 6px;
        }
    </style>

</head>
<body>

    <?php require '../assets/loader/loader.php'; ?>

        <div class="login-container position-relative">
            <img src="../assets/img/login-background.jpg" alt="Login Background" class="img-fluid">
            <div class="login-form row p-5 d-md-flex justify-content-center align-items-center position-absolute w-100"> 
                    <div class="logo col-lg-8 d-none p-5 d-md-flex justify-content-center align-items-center flex-md-column">
                        <img src="../assets/img/logo.png" alt="Logo" class="img-fluid mb-3">
                        <h1 class="text-center">DOCUMENT TRACKING SYSTEM</h1>
                        <p class="text-center">NATIONAL IRRIGATION ADMINISTRATION REGION IV-A (CALABARZON) PILA, LAGUNA</p>
                    </div>

                    <div class="form col-lg-4 col-12" style="background-color: white;">
                    <h2 class="text-center mt-5">Forgot Password</h2>
                            <?php if(!(isset($_SESSION['verification_code']))) 
                            {
                            ?>
                                <form action="" id="check_email" class="p-5" autocomplete="off">
                            
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                            </div>
                                            <input type="email" aria-label="Email address" name="email" id="email" placeholder="Email address" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group d-flex justify-content-center" style="gap: 1.5rem !important">
                                        <button type="submit" id="send_code" name="send_code" class="btn btn-primary w-100">Send Code</button>
                                    </div>
                                </form>
                            <?php
                            }else{
                                ?>
                                 <form action="" id="verify_code" class="p-5" autocomplete="off">
                            
                                    <div class="form-group">
                                        <label for="email">Verification Code</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="text" aria-label="Verification code" name="code" id="code" placeholder="Verification Code" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group d-flex justify-content-center flex-column" style="gap: 0.5rem !important">
                                        <button type="submit" id="verify_code_button" name="verify_code_button" class="btn btn-primary w-100">Verify</button>
                                        <a id="resend_code_button" name="resend_code_button" class="btn btn-danger w-100" style="color: white">Get New Code</a>
                                    </div>
                                </form>
                                <?php
                            }
                            ?>
                            
                            
                           


                            <div class="d-flex justify-content-center mb-5">
                                <a href="../logout.php" >Back to login page</a>
                            </div>
                          

                           
                        
                    </div>
            </div>
        </div>
    
  

    <script src="../assets/jquery/jquery-3.2.1.slim.min.js"></script>
    <script src="../assets/jsdelivr/popper.min.js"></script>
    <script src="../assets/jsdelivr/bootstrap.min.js"></script>
    <script src="../assets/jsdelivr/sweetalert2.all.min.js"></script>
    <script src="../assets/jquery/jquery-3.6.4.min.js"></script>






<script>
    $("#send_code").click(function(e){
        if($("#check_email")[0].checkValidity()){
            e.preventDefault();
            $('.loader-container').fadeIn();
            $.ajax({
                url: "../controller/login-reg-forgot-controller.php",
                type: "POST",
                data: $("#check_email").serialize()+"&action=check-email",
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
                        });
                        
                    }
                    else{
     
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            // Check if the user clicked the "OK" button
                            if (result.isConfirmed) {
                                // Reload the page
                                location.reload();
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


<script>
    $("#verify_code_button").click(function(e){
        if($("#verify_code")[0].checkValidity()){
            e.preventDefault();
            $('.loader-container').fadeIn();
            $.ajax({
                url: "../controller/login-reg-forgot-controller.php",
                type: "POST",
                data: $("#verify_code").serialize()+"&action=verify-code",
                success:function(response){
                    setTimeout(function() {
                    $('.loader-container').fadeOut();
                    
                    }, 500);
                    if(response.status === "error"){
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
                    }else if(response.status === "failed"){
                        Swal.fire({
                            title: 'Failed!',
                            text: response.message,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            // Check if the user clicked the "OK" button
                            if (result.isConfirmed) {
                                // Reload the page
                                location.reload();
                            }
                        });
                    }
                    else{
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            // Check if the user clicked the "OK" button
                            if (result.isConfirmed) {
                                // Reload the page
                                window.location.href = 'change-new-password.php';
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

<script>
    $("#resend_code_button").click(function(e){
        e.preventDefault();
        $('.loader-container').fadeIn();
        $.ajax({
            url: "../controller/login-reg-forgot-controller.php",
            type: "POST",
            data: "action=get-new-code",
            success:function(response){
                setTimeout(function() {
                $('.loader-container').fadeOut();
                
                }, 500);
                if(response.status === "error"){
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
                }else if(response.status === "failed"){
                    Swal.fire({
                        title: 'Failed!',
                        text: response.message,
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Check if the user clicked the "OK" button
                        if (result.isConfirmed) {
                            // Reload the page
                            location.reload();
                        }
                    });
                }
                else{
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
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
        
    });
</script>






    <?php require '../assets/failed-success-modal.php'; ?>
</body>
</html>