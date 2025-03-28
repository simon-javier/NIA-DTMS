<?php 
    session_start();
    require '../connection.php';

    $sql = "SELECT * from tbl_offices";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $offices = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
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
            max-height: 80vh;
            overflow-y: auto
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
                    <div class="logo  d-none p-5 d-md-flex justify-content-center align-items-center flex-md-column">
                        <img src="../assets/img/logo.png" alt="Logo" class="img-fluid mb-3">
                        <h1 class="text-center">DOCUMENT TRACKING SYSTEM</h1>
                        <p class="text-center">NATIONAL IRRIGATION ADMINISTRATION REGION IV-A (CALABARZON) PILA, LAGUNA</p>
                    </div>

                    <div class="form shadow-md col-12 mb-5">
                        <form action="" id="form-registration" class="p-5" autocomplete="off">
                            <div style="background-color: white;">
                                <h1 class="text-center">Register</h1>
                                <p class="text-center" style="color:red" id="error-message"></p>
                            </div>

                            <div class="container-fluid">
                                <form action="" id="registration-from">
                            <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="accountype">Account Type</label>
                                        <select name="accountype" id="accountype" class="form-control" required>
                                            <option value="handler">Document Handler</option>
                                            <option value="guest">Guest</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="firstname">First Name</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name" oninput="checkForNumbers('firstname', 'error-firstname')">
                                        <p class="mt-2" style="color:red" id="error-firstname"></p>
                                    </div>
                                    
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="lastname">Last Name</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name" oninput="checkForNumbers('lastname', 'error-lastname')">
                                        <p class="mt-2" style="color:red" id="error-lastname"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="number">Contact Number</label>
                                        <input type="number" class="form-control" id="number" name="number" placeholder="Format: 9123456789" oninput="validateContactNumber()">
                                        <p class="mt-2" style="color:red" id="error-number"></p>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12" id="positionSection">
                                    <div class="form-group">
                                        <label for="position">Position</label>
                                        <input type="text" class="form-control" id="position" name="position" placeholder="Position" required>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12" id="officeSection">
                                    <div class="form-group">
                                        <label for="office">Office</label>
                                        <select name="office" id="office" class="form-control" required>
                                            <?php foreach($offices as $office){ ?>
                                                <option value="<?php echo $office['office_name']; ?>"><?php echo $office['office_name']; ?></option>
                                            <?php } ?>
                        
                                        </select>
                                        <input type="hidden" name="office_code" id="office_code">

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email address" oninput="validateEmails()" required>
                                        <p class="mt-2" style="color:red" id="error-email"></p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="email">Confirm Email Address</label>
                                        <input type="email" class="form-control" id="conemail" placeholder="Confirm email address" oninput="validateEmails()" required>
                                        
                                        <p class="mt-2" style="color:red" id="error-conemail"></p>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="password1">Password</label>
                                        <input type="password" class="form-control" id="password1" name="password" oninput="validatePasswords()" placeholder="Password" required>
                                        <ul class="mt-2" style="color:red" id="error-password1" style="list-style: none;"></ul>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="password2">Confirm Password</label>
                                        <input type="password" class="form-control" id="password2" name="conpassword" oninput="validatePasswords()" placeholder="Confirm password" required>
                                        <p class="mt-2" style="color:red" id="error-password2"></p>
                                    </div>
                                </div>
                                
                                
                            </div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="submit" class="btn btn-primary" id="registerButton" disabled>Register</button>
                                </div>

                            <div class="d-flex justify-content-center">
                                <a href="../logout.php">Back to login page</a>
                            </div>
                            </form>
                        </div>

                        </form>
                </div>
        </div>
    
  

        <script src="../assets/jquery/jquery-3.2.1.slim.min.js"></script>
    <script src="../assets/jsdelivr/popper.min.js"></script>
    <script src="../assets/jsdelivr/bootstrap.min.js"></script>
    <script src="../assets/jsdelivr/sweetalert2.all.min.js"></script>
    <script src="../assets/jquery/jquery-3.6.4.min.js"></script>
    <script>

        var checknum = true;
        var checkcontact = true;
        var checkemail = true;
        var checkpassword = true;

        function checkForNumbers(inputId, errorId) {
            var input = document.getElementById(inputId);
            var error = document.getElementById(errorId);

            if (/^\D*$/.test(input.value)) {

            error.style.display = 'none';
            error.textContent = "";
            checknum = false;
            } else {

            error.style.display = 'block';
            error.textContent = "Should not contain numbers";
            checknum = true;
            }
            enableRegisterButton();
        }

        function validateContactNumber() {
            var input = document.getElementById('number');
            var error = document.getElementById('error-number');


            if (/^9\d{9}$/.test(input.value)) {

            error.style.display = 'none';
            error.textContent = "";
            checkcontact =false;
            } else {

            error.style.display = 'block';
            error.textContent = "Invalid contact number";
            checkcontact =true;
            }
            enableRegisterButton();
        }
        function validateEmails() {
            var email = document.getElementById('email');
            var conemail = document.getElementById('conemail');
            var errorEmail = document.getElementById('error-email');
            var errorConemail = document.getElementById('error-conemail');


            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (emailPattern.test(email.value)) {
                errorEmail.textContent = "";
                errorEmail.style.display = 'none';
            } else {
                errorEmail.textContent = "Invalid email address";
                errorEmail.style.display = 'block';
            }

            if(conemail.value){
                if (email.value === conemail.value) {
                    errorConemail.textContent = "";
                    errorConemail.style.display = 'none';
                    checkemail = false;
                } else {
                    errorConemail.textContent = "Email addresses do not match";
                    errorConemail.style.display = 'block';
                    checkemail = true;
                }
            }
            enableRegisterButton();

        }
        function validatePasswords() {
            var password1 = document.getElementById('password1');
            var password2 = document.getElementById('password2');
            var errorPassword1 = document.getElementById('error-password1');
            var errorPassword2 = document.getElementById('error-password2');

            var requirements = [];

            // Validate minimum length
            if (password1.value.length < 8) {
            requirements.push("Password must be at least 8 characters long");
            }

            // Validate uppercase letter
            if (!/[A-Z]/.test(password1.value)) {
            requirements.push("Password must include at least one uppercase letter");
            }

            // Validate lowercase letter
            if (!/[a-z]/.test(password1.value)) {
            requirements.push("Password must include at least one lowercase letter");
            }

            // Validate number
            if (!/\d/.test(password1.value)) {
            requirements.push("Password must include at least one number");
            }

            // Validate special character
            if (!/[@$!%*?&]/.test(password1.value)) {
            requirements.push("Password must include at least one special character (@, $, !, %, *, ?, &)");
            }

            // Display error messages
            if (requirements.length > 0) {
            errorPassword1.innerHTML = "";
            requirements.forEach(function (requirement) {
                var li = document.createElement('li');
                li.textContent = requirement;
                errorPassword1.appendChild(li);
            });
            } else {
                errorPassword1.innerHTML = "";
            }

            // Check if passwords match
            if(password1.value){
                if (password1.value === password2.value) {
                    errorPassword2.textContent = "";
                    checkpassword = false;
                } else {
                    errorPassword2.textContent = "Passwords do not match";
                    checkpassword = true;
                }
            }

            enableRegisterButton();
        }

        function enableRegisterButton() {
            // Enable or disable the button based on the presence of errors
            var registerButton = document.getElementById('registerButton');
            registerButton.disabled = checknum || checkcontact || checkemail || checkpassword;
        }
    </script>
    <script>
    $("#registerButton").click(function(e){
        if($("#form-registration")[0].checkValidity()){
            e.preventDefault();
            $('.loader-container').fadeIn();
            $.ajax({
                url: "../controller/login-reg-forgot-controller.php",
                type: "POST",
                data: $("#form-registration").serialize()+"&action=check-credentials",
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
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }else if(response.status === "failed"){
                        if(response.message == "Username already exists."){
                            $("#username").val("");
                        }else if(response.message == "Email address already exists."){
                            
                            $("#email").val("");
                            $("#conemail").val("");
                        }
                        Swal.fire({
                            title: 'Failed!',
                            text: response.message,
                            icon: 'warning',
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
                                window.location.href = 'otp-page.php';
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
    // Function to toggle visibility and required attribute
    function toggleFields() {
        var accountType = document.getElementById('accountype').value;
        var positionSection = document.getElementById('positionSection');
        var officeSection = document.getElementById('officeSection');

        if (accountType === 'guest') {
            positionSection.style.display = 'none';
            officeSection.style.display = 'none';
            document.getElementById('position').removeAttribute('required');
            document.getElementById('office').removeAttribute('required');
        } else {
            positionSection.style.display = 'block';
            officeSection.style.display = 'block';
            document.getElementById('position').setAttribute('required', 'required');
            document.getElementById('office').setAttribute('required', 'required');
        }
    }

    // Initial call to set the initial state
    toggleFields();

    // Add an event listener to accountype dropdown
    document.getElementById('accountype').addEventListener('change', toggleFields);
</script>
<script>
    // Function to get the office_code of the selected office
    function getOfficeCode(selectedOffice) {
        // Assuming $offices is a PHP array containing 'office_name' and 'office_code'
        var offices = <?php echo json_encode($offices); ?>;
        
        // Find the selected office in the offices array
        var selectedOfficeObject = offices.find(function(office) {
            return office.office_name === selectedOffice;
        });

        // Return the office_code if found, otherwise an empty string
        return selectedOfficeObject ? selectedOfficeObject.office_code : '';
    }

    // Function to update the office_code based on the selected office
    function updateOfficeCode() {
        var selectedOffice = document.getElementById('office').value;
        var officeCodeInput = document.getElementById('office_code');

        // Get the office_code based on the selected office
        var officeCode = getOfficeCode(selectedOffice);

        // Set the value of the office_code input
        officeCodeInput.value = officeCode;
    }

    // Initial call to set the initial state
    updateOfficeCode();

    // Add an event listener to the office dropdown
    document.getElementById('office').addEventListener('change', updateOfficeCode);
</script>
    <?php require '../assets/failed-success-modal.php'; ?>
</body>
</html>