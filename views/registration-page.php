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

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', 'Arial';
        }

        .main,
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
            background-image: url('../assets/img/login-background.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.5; /* Adjust the opacity value for darkening the background image */
            z-index: -1;
        
        }

        /* .background{
            background-image: url('assets/img/logo.png'); 
            background-size: cover; 
            background-position: center; 
            position: relative;

            
        } */
        .logo {
            width: 150px;
            height: 150px;
        }

        .content {
            width: 80%;
            height: 70vh;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            border-radius: 2rem;
            background-color: white;
            padding: 3rem;
            overflow-y: scroll;
        }
    </style>
</head>

<body style="background-color: #181818;">
    <?php require '../assets/loader/loader.php'; ?>
    <div class="main d-flex justify-content-center align-items-center">
        <div class="background d-flex justify-content-center align-items-center">
            <div class="content">

                <div class="d-flex flex-column justify-content-center align-items-center mt-3" style="width: 100%;">
                    <img src="../assets/img/logo.png" alt="Logo" class="logo img-fluid mb-3 d-none d-md-block">
                    <h2>Registration Form</h2>
                    <p class="text-center" style="color:red" id="error-message"></p>
                </div>
                <form action="" class="p-3" id="form-registration" autocomplete="off">
                    <div class="row">


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="accountype">Account Type</label>
                                <select name="accountype" onchange="toggleFields()" id="accountype" class="form-control" required>
                                    <option value="handler">Document Handler</option>
                                    <option value="guest">Guest</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name" oninput="checkForNumbers('firstname', 'error-firstname')">
                                <p class="mt-2" style="color:red" id="error-firstname"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name" oninput="checkForNumbers('lastname', 'error-lastname')">
                                <p class="mt-2" style="color:red" id="error-lastname"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="number">Contact Number</label>
                                <input type="number" class="form-control" id="number" name="number" placeholder="Format: 09123456789" oninput="validateContactNumber()">
                                <p class="mt-2" style="color:red" id="error-number"></p>
                            </div>
                        </div>
                        <div class="col-md-4" id="positionSection">
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" id="position" name="position" placeholder="Position" required>
                            </div>
                        </div>
                        <div class="col-md-4" id="officeSection">
                            <div class="form-group">
                                <label for="office">Office</label>
                                <select name="office" id="office" class="form-control" required>
                                    <?php foreach ($offices as $office) { ?>
                                        <option value="<?php echo $office['office_name']; ?>"><?php echo $office['office_name']; ?></option>
                                    <?php } ?>

                                </select>
                                <input type="hidden" name="office_code" id="office_code">
               

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email address" oninput="validateEmails()" required>
                                <p class="mt-2" style="color:red" id="error-email"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Confirm Email Address</label>
                                <input type="email" class="form-control" id="conemail" placeholder="Confirm email address" oninput="validateEmails()" required>

                                <p class="mt-2" style="color:red" id="error-conemail"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            <label for="password1">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password1" name="password" oninput="validatePasswords()" placeholder="Password" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <ul class="mt-2" style="color:red" id="error-password1" style="list-style: none;"></ul>
                        </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            <label for="password2">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password2" name="conpassword" oninput="validatePasswords()" placeholder="Confirm password" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <p class="mt-2" style="color:red" id="error-password2"></p>
                        </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <button type="submit" class="btn btn-success" id="registerButton" disabled>Register</button>
                    </div>
                    <div class="d-flex justify-content-center mt-3 mb-3">
                        <a href="../logout.php">Back to login page</a>
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

<!-- 
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
    </script> -->
    <script>
    document.getElementById("toggleConfirmPassword").addEventListener("click", function() {
        const confirmPasswordInput = document.getElementById("password2");
        const icon = document.querySelector("#toggleConfirmPassword i");

        if (confirmPasswordInput.type === "password") {
            confirmPasswordInput.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            confirmPasswordInput.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    });
</script>
    <script>
    document.getElementById("togglePassword").addEventListener("click", function() {
        const passwordInput = document.getElementById("password1");
        const icon = document.querySelector("#togglePassword i");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    });
</script>

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


    if (/^0\d{10}$/.test(input.value)) {

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


// Add an event listener to accountype dropdown
// document.getElementById('accountype').addEventListener('change', toggleFields);
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


</body>

</html>