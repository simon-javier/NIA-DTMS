<?php 
    session_start();
    if(!(isset($_SESSION['change_password']) && $_SESSION['change_password'])){
        header("Location: forgot-password.php");
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
                <div class="logo col-lg-6 d-none p-5 d-md-flex justify-content-center align-items-center flex-md-column">
                    <img src="../assets/img/logo.png" alt="Logo" class="img-fluid mb-3">
                    <h1 class="text-center">DOCUMENT TRACKING SYSTEM</h1>
                    <p class="text-center">NATIONAL IRRIGATION ADMINISTRATION REGION IV-A (CALABARZON) PILA, LAGUNA</p>
                </div>

                <div class="form col-lg-6 col-12" style="background-color: white;">
                <div class="p-2 sticky-top" style="background-color: white;">
                    <h2 class="text-center mt-5">Create New Password</h2>
                    <p class="text-center" style="color:red; " id="error-message"></p>
                </div>
                
                    <form action="" id="change_password" class="p-5" style="margin-top: -50px;" autocomplete="off">
                        <div class="form-group">
                            <label for="email">New Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                                <input type="password" aria-label="New password" name="newpass" id="newpass" placeholder="New password" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <ul class="password-guide" style="list-style: none;
                            font-size: 12px;
                            color: grey;">
                                <li id="characters">Minimum of 8 Characters</li>
                                <li id="uppercase">Include One Uppercase Letter</li>
                                <li id="lowercase">Include One Lowercase Letter</li>
                                <li id="numbers">Include Numbers (0-9)</li>
                                <li id="specialchar">Include Special Characters (e.g., !, @, #, $, %)</li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <label for="email">Confirm password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                </div>
                                <input type="password" aria-label="Confirm password" name="conpass" id="conpass" placeholder="Confirm password" class="form-control" disabled required>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-center" style="gap: 1.5rem !important">
                            <button type="submit" id="change_password_button" name="change_password_button" class="btn btn-primary w-100" disabled>Change Password</button>
                        </div>
                    </form>
                    
                
                
            


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
        $("#change_password_button").click(function(e){
            if($("#change_password")[0].checkValidity()){
                e.preventDefault();
                $('.loader-container').fadeIn();
                $.ajax({
                    url: "../controller/login-reg-forgot-controller.php",
                    type: "POST",
                    data: $("#change_password").serialize()+"&action=change-password",
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
        $("#newpass").on("input", function() {
            var password = $(this).val();
            $("#characters").css("color", password.length >= 8 ? "green" : "grey");
            $("#uppercase").css("color", /[A-Z]/.test(password) ? "green" : "grey");
            $("#lowercase").css("color", /[a-z]/.test(password) ? "green" : "grey");
            $("#numbers").css("color", /\d/.test(password) ? "green" : "grey");
            $("#specialchar").css("color", /[!@#$%^&*(),.?":{}|<>]/.test(password) ? "green" : "grey");
            if(password.length >= 8 && /[A-Z]/.test(password) && /[a-z]/.test(password) && /\d/.test(password) && /[!@#$%^&*(),.?":{}|<>]/.test(password)){
                $("#conpass").prop("disabled", false);

            }else{
                $("#conpass").prop("disabled", true);


            }
        });

        $("#conpass").on("input", function() {
            var conpass = $(this).val();
            var newpass = $("#newpass").val();
            if(conpass == newpass){
                $("#change_password_button").prop("disabled", false)
            }else{
                $("#change_password_button").prop("disabled", true)
            }
        });
    </script>



</body>
</html>