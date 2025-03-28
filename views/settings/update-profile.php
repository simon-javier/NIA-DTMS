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
    
    $findProfile = "SELECT * FROM tbl_userinformation where id = :user_id";
    $stmt = $pdo->prepare($findProfile);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
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

    <style>


        
        .user-profile-img{
            height: 200px;
            width: 200px;
            border-radius: 50%;
        }

    </style>
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
            
                <!-- Content -->
                
                <div class="main-content" style=" height: 100vh;">
                    <h2>Update Profile</h2>
                    <div class="container">
                   
                    <form id="update_information" autocomplete="off" enctype="multipart/form-data">
                    <div class="d-flex justify-content-center">
                        <img class="img-fluid user-profile-img" id="img-holder" src="<?php echo $env_basePath; ?>assets/user-profile/<?php echo $result['user_profile']; ?>" alt="User Profile">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="image-file">Image:</label>
                                <input type="file" class="form-control" id="image-file" name="image-file" placeholder="Find image">
                                <p class="mt-2" style="color:red" id="error-profile"></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName">First Name:</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First name" value="<?php echo $result['firstname']; ?>"  required oninput="checkForNumbers('firstName', 'error-firstname')">
                                <p class="mt-2" style="color:red" id="error-firstname"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="lastName">Last Name:</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name" value="<?php echo $result['lastname']; ?>" required oninput="checkForNumbers('lastName', 'error-lastname')">
                            <p class="mt-2" style="color:red" id="error-lastname"></p>
                        </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="contact">Contact no.:</label>
                            <input type="number" value="<?php echo $result['contact']; ?>" class="form-control" id="contact" name="contact" placeholder="Format: 9123456789"  required oninput="validateContactNumber()">
                                                    <p class="mt-2" style="color:red" id="error-number"></p>
                            </div>
                        </div>
                       
                        <div class="col-md-6" style="display: none">
                            <div class="form-group">
                                <label for="office">Office:</label>
                                <input type="hidden" class="form-control" value="<?php echo $result['office']; ?>" id="office" placeholder="Office"  name="office" >
                            </div>
                        </div>
                       
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="position">Position:</label>
                                <input type="text" class="form-control" value="<?php echo $result['position']; ?>" id="position" placeholder="Position" name="position" >
                            </div>
                        </div>
                  
                    </div>
                        <div class="d-flex justify-content-end align-item-end">
                            <button type="submit" id="update_information_button" data-id="<?php echo $user_id; ?>" class="btn btn-primary">Update Profile</button>
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
        var imageFileInput = document.getElementById('image-file');
        var imgHolder = document.getElementById('img-holder');
        var errorProfile = document.getElementById('error-profile');
        
        var checknum = true;
        var checkcontact = true;

      

        imageFileInput.addEventListener('change', function () {
            var file = imageFileInput.files[0];

            if (file) {
                // Check if the selected file is an image
                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        imgHolder.src = e.target.result;
                        errorProfile.innerHTML = '';
                    };

                    reader.readAsDataURL(file);
                } else {
                    errorProfile.innerHTML = 'Please upload a valid image file.';
                    imageFileInput.value = ''; // Clear the file input
                }
            }
        });
    });

        function checkForNumbers(inputId, errorId) {
            var input = document.getElementById(inputId);
            var error = document.getElementById(errorId);
            var registerButton = document.getElementById('update_information_button');

            if (/^\D*$/.test(input.value)) {

            error.style.display = 'none';
            error.textContent = "";
            registerButton.disabled = false;
            } else {

            error.style.display = 'block';
            error.textContent = "Should not contain numbers";
            registerButton.disabled = true;
            }

            enableRegisterButton();
        }

        function validateContactNumber() {
            var input = document.getElementById('contact');
            var error = document.getElementById('error-number');
            var registerButton = document.getElementById('update_information_button');


            if (/^9\d{9}$/.test(input.value)) {

                error.style.display = 'none';
                error.textContent = "";
                registerButton.disabled = false;
            } else {

                error.style.display = 'block';
                error.textContent = "Invalid contact number";
                registerButton.disabled = true;

            }


        }


</script>
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
</script>


<script>
    $("#update_information_button").click(function(e){

        if($("#update_information")[0].checkValidity()){
            e.preventDefault();

            $('.loader-container').fadeIn();
            var formData = new FormData($("#update_information")[0]);
            formData.append("action", "settings_update_info");
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

