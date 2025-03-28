<?php require 'template/top-template.php'; ?>



<?php
   $type= $_GET['type'];
   if($type == 'internal'){
        $href = 'offices.php';
   } else{
        $href = 'external.php';
   }

?>




<style>
    :root {
    --primary-color: #069734;
    --lighter-primary-color: #07b940;
    --white-color: #FFFFFF;
    --black-color: #181818;
    --bold: 600;
    --transition: all 0.5s ease;
    --box-shadow: 0 0.1rem 0.8rem rgba(0, 0, 0, 0.2);
    }
    ::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #009933; 
        border-radius: 6px;
    }
    .table-container{
        padding: 2.5rem;
        background-color: #fff;
        box-shadow: var(--box-shadow);
    }

    .main-content{
        position: relative;
        background-color: white;
        top: 0;
        max-height: 90vh;
        overflow-y: scroll;
        left: 90px;
        transition: var(--transition);
        width: calc(100% - 90px);
        padding: 1rem;

    }
</style>


<div class="container">

    <div class="table-container">
        <div class="d-flex justify-content-start align-items-start mb-3">
            <a href="<?php echo $href ?>" class="btn btn-danger d-flex align-items-center" style="gap: 10px"><i class='bx bx-arrow-back' style="font-size: 18px;"></i> Back</a>     
        </div>
        <form id="user_form" autocomplete="off">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="firstName">First Name:</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First name"  required oninput="checkForNumbers('firstName', 'error-firstname')">
                    <p class="mt-2" style="color:red" id="error-firstname"></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name"  required oninput="checkForNumbers('lastName', 'error-lastname')">
                <p class="mt-2" style="color:red" id="error-lastname"></p>
            </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="contact">Contact no.:</label>
                <input type="number" class="form-control" id="contact" name="contact" placeholder="Format: 9123456789"  required oninput="validateContactNumber()">
                                        <p class="mt-2" style="color:red" id="error-number"></p>
                </div>
            </div>
            
            <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" class="form-control" placeholder="Email address"  id="email" name="email" required oninput="validateEmails()">
                <p class="mt-2" style="color:red" id="error-email"></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="email">Confirm Email Address:</label>
                <input type="email" class="form-control" placeholder="Email address"  id="conemail" name="conemail" required oninput="validateEmails()">
                <p class="mt-2" style="color:red" id="error-conemail"></p>
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group">
                <label for="position">Position:</label>
                <input type="text" class="form-control" id="position" placeholder="Position"  name="position" required>
            </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="office">Office:</label>
                    <input type="text" class="form-control" id="office" placeholder="Office"  name="office" required>
                </div>
            </div>
            <?php if($type == 'internal'){ ?>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="role">Account Type</label>
                    <select name="role" id="role"  class="form-control">
                        <option value="sysadmin">System Admin</option>
                        <option value="admin">Admin</option>
                        <option value="handler">Document Handler</option>
                    </select>
                </div>
            </div>
            <?php }else{ ?>
                <input type="hidden" class="form-control" id="role" value="<?php echo $type; ?>" name="role" required readonly>
                <?php } ?>

            
        </div>
            <div class="d-flex justify-content-end align-item-end">
                <button type="submit" id="add_user_btn" disabled class="btn btn-primary">Add User</button>
            </div>
        </form>



    </div>
</div>


<?php require 'template/bottom-template.php'; ?>

<script>
    $("#add_user_btn").click(function(e){

        if($("#user_form")[0].checkValidity()){
            e.preventDefault();

            $('.loader-container').fadeIn();
            $.ajax({
                url: "../../controller/crud-users-controller.php",
                type: "POST",
                data: $("#user_form").serialize()+"&action=add_new_user",
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
                        text: "Account added successfully.",
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


<script>

        var checknum = true;
        var checkcontact = true;
        var checkemail = true;


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
            var input = document.getElementById('contact');
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


        function enableRegisterButton() {
            // Enable or disable the button based on the presence of errors
            var registerButton = document.getElementById('add_user_btn');
            registerButton.disabled = checknum || checkcontact || checkemail;
        }
    </script>
