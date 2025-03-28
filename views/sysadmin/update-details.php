<?php require 'template/top-template.php'; ?>

<?php 
    require '../../connection.php';
    $id = $_GET['id'];
    try {
        //code...
        $get_user_data = "
           select * from tbl_userinformation where id = '$id';
        ";
        $stmt = $pdo->prepare($get_user_data);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $type = $result['role'];

        if($type != 'external'){
            $href = 'offices.php';
        }else{
            $href = 'external.php';
        }
        // print_r($result);
    } catch (\PDOException $th) {
        echo "Error: " . $th->getMessage();
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
        p, h1, h2, h3, h4, h5, h6{
            margin: 0;
        }

        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        *{
            font-family: 'Poppins', 'Arial' !important;
        }
        .top-bar{
            background-color: var(--primary-color);
            padding: 20px;
            color: var(--white-color);
        }
        .content{
            padding: 20px;
            box-shadow: var(--box-shadow);
        }

    </style>
<!-- </head>
<body> -->
    <div class="container mt-3">
        <!-- <div class="top-bar d-flex justify-content-start align-items-start">

            <a href="offices.php" class="btn btn-danger d-flex align-items-center" style="gap: 10px"><i class='bx bx-arrow-back' style="font-size: 18px;"></i> Back</a>
        </div> -->
        <div class="content">
        <div class="mb-3 d-flex justify-content-start align-items-start">
            <!-- <h2>User Details</h2> -->
            <a href="<?php echo $href ?>" class="btn btn-danger d-flex align-items-center" style="gap: 10px"><i class='bx bx-arrow-back' style="font-size: 18px;"></i> Back</a>
        </div>
        <form id="update_information">
            <input type="hidden" value="<?php echo $id ?>" name="id" readonly>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="input1">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="input1" value="<?php echo $result['firstname']; ?>" placeholder="First Name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="input1">Last Name</label>
                    <input type="text" class="form-control" name="lastname" value="<?php echo $result['lastname']; ?>" id="input1" placeholder="Last Name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="input1">Contact Number</label>
                    <input type="text" class="form-control" name="contact" id="input1" value="<?php echo $result['contact']; ?>" placeholder="N/A" required>
                </div>
                
            </div>
            <div class="col-md-6">
            <div class="form-group">
                    <label for="input2">Position</label>
                    <input type="text" class="form-control" name="position" value="<?php echo $result['position']; ?>" id="input2" placeholder="N/A" required>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="input4">Email address</label>
                    <input type="text" class="form-control" name="email" value="<?php echo $result['email']; ?>" id="input4" placeholder="N/A" required>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="input3">Office</label>
                    <input type="text" class="form-control" name="office" value="<?php echo $result['office']; ?>" id="input3" placeholder="N/A" required>
                </div>
            </div>
            
        </div>
        <div class="d-flex justify-content-end align-items-end">
            <button type="submit" id="update_information_button" class="btn btn-primary">Update</button>
        </div>
        </form>
        
        </div>
    </div>
    <?php require 'template/bottom-template.php'; ?>


    <script>
    $("#update_information_button").click(function(e){

        if($("#update_information")[0].checkValidity()){
            e.preventDefault();

            $('.loader-container').fadeIn();
            $.ajax({
                url: "../../controller/crud-users-controller.php",
                type: "POST",
                data: $("#update_information").serialize()+"&action=update_information",
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