<?php 
    session_start();

    require '../../connection.php';
    if(!isset($_SESSION['userid'])){
        $href = $env_basePath . "index.php";
    }
    $user_id = $_SESSION['userid'];

    
    if($_SESSION['office'] == 'Administrative Section Records'){
        $href = $env_basePath . "views/record_office/newly-created-docs.php";
    }else{
        if($_SESSION['role'] == 'admin'){
            $href = $env_basePath . "views/admin/dashboard.php";
        }
        elseif($_SESSION['role'] == 'sysadmin'){
            $href = $env_basePath . "views/sysadmin/dashboard.php";
        }
        elseif($_SESSION['role'] == 'handler'){
            $href = $env_basePath . "views/handler/incoming-documents.php";
        }
        elseif($_SESSION['role'] == 'guest'){
            $href = $env_basePath . "views/guest/submit-document.php";
        }
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Tracking System</title>
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/cloudflare/all.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/boxicons/boxicons.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" href="sidebar.css">

</head>
<body>
<?php require '../../assets/loader/loader.php'; ?>
    <div class="sidebar active">
        <div class="top">
        <h3 class="mb-4">Settings</h3>
        </div>
        <ul>
            
            <li>
                <a href="<?php echo $href; ?>" class="navigation">
                <i class='bx bx-home-alt'></i>
                    <span class="nav-item">Home</span>
                </a>

            </li>
            <li>
                <a href="update-profile.php" class="navigation">
                <i class="bx bx-edit"></i>
                    <span class="nav-item">Update Profile</span>
                </a>

            </li>
            <li>
                <a href="change-password.php" class="navigation">
                <i class="bx bx-lock"></i>
                    <span class="nav-item">Change Password</span>
                </a>

            </li>
        </ul>
    </div>

    <div class="main-content" style=" height: 100vh;">
        <h2>Change Password</h2>
        <div class="container mt-5">
            <form id="update_password" autocomplete="off" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="oldpassword">Old Password</label>
                            <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Old password" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="password1">New Password</label>
                            <input type="password" class="form-control" id="password1" name="newpassword" placeholder="New password" oninput="validatePasswords()" required>
                            <ul class="mt-2" style="color:red" id="error-password1" style="list-style: none;"></ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="password2">Confirm Password</label>
                            <input type="password" class="form-control" id="password2" name="conpassword" placeholder="Confirm password" oninput="validatePasswords()" required>
                            <p class="mt-2" style="color:red" id="error-password2"></p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end align-item-end">
                    <button type="submit" id="update_password_button" disabled data-id="<?php echo $user_id; ?>" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
               
 
    </div>
            
       
   
</body>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.2.1.slim.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/popper.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/sweetalert2.all.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.6.4.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/datatable/jquery.dataTables.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to check screen size and update the "active" class
        function updateSidebarClass() {
            var sidebar = document.querySelector('.sidebar');
            var top = document.querySelector('.top');
            if (window.innerWidth > 768) {
                sidebar.classList.add('active');
                top.style.display = "block";
            } else {
                sidebar.classList.remove('active');
                top.style.display = "none";
            }
        }

        // Initial check on page load
        updateSidebarClass();

        // Check and update on window resize
        window.addEventListener('resize', updateSidebarClass);
    });



    function validatePasswords() {
            var password1 = document.getElementById('password1');
            var password2 = document.getElementById('password2');
            var errorPassword1 = document.getElementById('error-password1');
            var errorPassword2 = document.getElementById('error-password2');
            var registerButton = document.getElementById('update_password_button');

            var requirements = [];

            // Validate minimum length
            if (password1.value.length < 8) {
            requirements.push("Password must be at least 8 characters long");
            registerButton.disabled = true;
            }

            // Validate uppercase letter
            if (!/[A-Z]/.test(password1.value)) {
            requirements.push("Password must include at least one uppercase letter");
            registerButton.disabled = true;
            }

            // Validate lowercase letter
            if (!/[a-z]/.test(password1.value)) {
            requirements.push("Password must include at least one lowercase letter");
            registerButton.disabled = true;
            }

            // Validate number
            if (!/\d/.test(password1.value)) {
            requirements.push("Password must include at least one number");
            registerButton.disabled = true;
            }

            // Validate special character
            if (!/[@$!%*?&]/.test(password1.value)) {
            requirements.push("Password must include at least one special character (@, $, !, %, *, ?, &)");
            registerButton.disabled = true;
            }

            // Display error messages
            if (requirements.length > 0) {
            errorPassword1.innerHTML = "";
            requirements.forEach(function (requirement) {
                var li = document.createElement('li');
                li.textContent = requirement;
                errorPassword1.appendChild(li);
                registerButton.disabled = true;
            });
            } else {
                errorPassword1.innerHTML = "";
                registerButton.disabled = false;
            }

            // Check if passwords match
            if(password1.value){
                if (password1.value === password2.value) {
                    errorPassword2.textContent = "";
                    checkpassword = false;
                    registerButton.disabled = false;
                } else {
                    errorPassword2.textContent = "Passwords do not match";
                    checkpassword = true;
                    registerButton.disabled = true;
                }
            }

         
        }
</script>

<script>
    $("#update_password_button").click(function(e){

        if($("#update_password")[0].checkValidity()){
            e.preventDefault();

            $('.loader-container').fadeIn();
            var formData = new FormData($("#update_password")[0]);
            formData.append("action", "settings_update_password");
            $.ajax({
                url: "../../controller/crud-users-controller.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                cache: false, // important for sending FormData

                success:function(response){

                    setTimeout(function() {

                    $('.loader-container').fadeOut();
                    }, 500);
                
                    if(response.status === "failed"){
                        Swal.fire({
                            title: 'Something went wrong!',
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
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                    }
                    else if(response.status === "success"){
                        Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                            }).then((result) => {
                            if (result.isConfirmed) {
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


</html>