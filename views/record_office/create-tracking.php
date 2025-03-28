


<?php require 'template/top-template.php'; ?>

<?php 
    require '../../connection.php';
    $id = $_GET['id'];
    $sql = "SELECT * from tbl_uploaded_document where id = :id ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);


    
    $internalOffice = "SELECT * FROM tbl_userinformation where role = 'handler' and office != 'Administrative Section Records'";
    $statement = $pdo->prepare($internalOffice);
    $statement->execute();
    $internaloffice = $statement->fetchAll(PDO::FETCH_ASSOC);


    if($results['from_office']){
        

        $officesQuery = "SELECT DISTINCT tbl_offices.office_name FROM tbl_offices 
            JOIN tbl_userinformation ON tbl_offices.office_name = tbl_userinformation.office where tbl_offices.office_name != 'Administrative Section Records' and tbl_offices.office_name != :office_name and tbl_userinformation.status != 'archived'";

        $statement = $pdo->prepare($officesQuery);
        $statement->bindParam(':office_name', $results['from_office']);
        $statement->execute();
        $offices = $statement->fetchAll(PDO::FETCH_ASSOC);
        

    }else{
        $officesQuery = "SELECT DISTINCT tbl_offices.office_name FROM tbl_offices 
        JOIN tbl_userinformation ON tbl_offices.office_name = tbl_userinformation.office where tbl_offices.office_name != 'Administrative Section Records' and tbl_userinformation.status != 'archived'";

    $statement = $pdo->prepare($officesQuery);
    $statement->execute();
    $offices = $statement->fetchAll(PDO::FETCH_ASSOC);
        

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

    .form-control{
        border: 2px solid #009933;
        border-radius: 10px;
    }
   
    .filter-option{
        border: 2px solid var(--primary-color);
        border-radius: 10px;
    }
</style>


<div class="table-container">
    <a href="newly-created-docs.php" class="btn btn-danger mb-5">Back</a>
    <form id="transfer_create_tracking">
    <div class="row">
        <div class="file col-md-12 mb-3">
            <div class="content d-flex align-item-center justify-content-between">
                <div class="d-flex align-item-center">
                    <i class='bx bx-file' style="font-size: 50px;"></i>
                    <h3>Document Information</h3>
                </div>
                
                
            </div>
            <div class="row mt-5">
                <div class="col-md-6 mb-3">
                    <strong><p>Attachments:</p></strong><p><?php echo $results['pdf_filename']; ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong><p>Document Type:</p></strong><p><?php echo $results['document_type']; ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong><p>Name of sender:</p></strong><p><?php echo $results['sender']; ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong><p>Subject:</p></strong><p><?php echo $results['subject']; ?></p>
                </div>
                <div class="col-md-6 mb-3">
                    <strong><p>Description:</p></strong>
                    <textarea name="description" id="description" class="form-control" cols="30" rows="5" readonly><?php echo $results['description']; ?></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <strong><p>Action required:</p></strong><p><?php echo $results['required_action']; ?></p>
                </div>
            </div>
            <!-- <div class="d-flex justify-content-end align-item-end">
                    <a href="<?php echo $env_basePath ?>assets/uploaded-pdf/<?php echo $results['pdf_filename']; ?>" id="downloadLink" download class="btn btn-dark">
                        Download
                    </a>
            </div> -->
        </div>
        <div class="col-md-12">
        <div class="form-group">
                <label for="action_requested">Action Requested:</label>
                <input type="text" class="form-control" id="action_requested" name="action_requested" placeholder="Action Requested" >
            </div>
            </div>
        <div class="col-md-12">
             <div class="form-group">
                <label for="receiver_office">Send To:</label>
                <select name="receiver_office" id="receiver_office" class="form-control selectpicker" data-live-search="true" style="border: 2px solid green;" required>
                    <option value="" selected>Select</option>
                        <?php foreach($offices as $office){ ?>
                            <option value="<?php echo $office['office_name']; ?>">
                            <?php echo $office['office_name']; ?></option>
                        <?php } ?>
                    </select>
          
            </div>
        </div>
       
       
    </div>
    </form>
    <div class="d-flex justify-content-end align-item-end">
        <button class="btn btn-danger mr-3" data-id="<?php echo $id; ?>" onclick="declineDocument(event)">Decline Document</button>
                <button class="btn btn-primary" data-id="<?php echo $id; ?>" onclick="confirmTransfer(event)">Send Document</button>
            </div>
</div>





<?php require 'template/bottom-template.php'; ?>



<script>
    function declineDocument(event) {
        const button = event.currentTarget;
        const dataId = button.getAttribute('data-id');
        Swal.fire({
            title: 'Confirm',
            text: 'Are you sure you want to decline this?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, decline it!'
        }).then((result) => {
            if (result.isConfirmed) {
                
            

            $('.loader-container').fadeIn();
            var formData = new FormData();
            formData.append("action", "decline_document");
            formData.append("id", dataId);

            $.ajax({
                url: "../../controller/transfer-document-controller.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
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
                                window.location.href = "newly-created-docs.php";

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
    }
    function confirmTransfer(event) {
       
        const selectedOffice = document.getElementById('receiver_office').value;
        const actionRequested = document.getElementById('action_requested').value;

        if (!selectedOffice) {
            // Show a message if the selected office is empty or null
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select an office before transferring!',
            });
            return;
        } 
        if (!actionRequested) {
            // Show a message if the selected office is empty or null
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter action requested before transferring!',
            });
            return;
        } 
        const button = event.currentTarget;
        const dataId = button.getAttribute('data-id');
        Swal.fire({
            title: 'Confirm',
            text: 'Are you sure you want to send?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, send it!'
        }).then((result) => {
            if (result.isConfirmed) {
                if($("#transfer_create_tracking")[0].checkValidity()){
            

            $('.loader-container').fadeIn();
            var formData = new FormData($("#transfer_create_tracking")[0]);
            formData.append("action", "transfer_document_withqr_code");
            formData.append("id", dataId);

            $.ajax({
                url: "../../controller/transfer-document-controller.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
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
                                window.location.href = "print_qr_code.php?docu_code=" + response.docu_code;

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
            }
        });
       
    }
</script>



