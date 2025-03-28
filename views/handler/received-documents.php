<?php require 'template/top-template.php'; ?>

<?php 
    $office_name = $_SESSION['office'];
    try {
        //code...
        $docu_query = "SELECT tbl_office_document.status as docu_status, tbl_office_document.*, tbl_uploaded_document.*, tbl_uploaded_document.updated_at as docu_date
        FROM tbl_office_document 
        JOIN tbl_uploaded_document ON tbl_office_document.docu_id = tbl_uploaded_document.id 
        WHERE (tbl_office_document.status = 'active' OR tbl_office_document.status = 'completed') 
        AND tbl_office_document.office_name = :office_name ORDER BY tbl_uploaded_document.updated_at DESC";

        $stmt = $pdo->prepare($docu_query);
        $stmt->bindParam(':office_name', $office_name);
        $stmt->execute();
        $docu_details = $stmt->fetchAll(PDO::FETCH_ASSOC);


    } catch (\Throwable $th) {
        //throw $th;
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
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid var(--primary-color) !important;
        border-radius: 10px;
        padding: 5px;
        background-color: transparent;
        color: inherit;
        margin-left: 3px;
        
    }
    .dataTables_wrapper .dataTables_filter input:active {
        border: 1px solid var(--primary-color) !important;
        border-radius: 10px;
        padding: 5px;
    }
    #example_wrapper{
        overflow-x: scroll;
    }
    .form-control{
        border: 2px solid #009933;
        border-radius: 10px;
    }

</style>



<div class="table-container">
    <p class="mb-4" style="color: red;">Documents currently handle by this office.</p>
    <style>
         @media (min-width: 992px) {
            .w-lg-25 {
                width: 10% !important;
            }
        }
    </style>
<div class="d-flex mb-3 justify-content-end align-items-end">
    <p class="mb-2 mr-3">Filter by date</p>
    <input type="text" class="form-control mr-3 w-lg-25 w-100" id="min" name="min" placeholder="Start date">
    <input type="text" class="form-control w-lg-25 w-100" id="max" name="max" placeholder="End date">
    <p class="ml-2" onclick="refreshPage()" style="cursor: pointer"><i class='bx bx-reset' style="font-size: 30px;"></i></p>
</div>
<script>
    function refreshPage(){
        window.location.reload();
    }
</script>
<table id="example" class="hover" style="width:100%">
        <thead>
            <tr>
                <th>Date</th>
                <th>QR Code</th>
                <th>Doc Code</th>
                <th>Document Type</th>
                <th>Document Source</th>
                <th>Sender</th>
         
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        
        <?php foreach ($docu_details as $detail) { ?>
        <tr style="<?php
            $updatedTimestamp = strtotime($detail['updated_at']);
            $currentTimestamp = time();
            $threeDaysInSeconds = 3 * 24 * 60 * 60; // 3 days in seconds
            $fiveDaysInSeconds = 5 * 24 * 60 * 60;  // 5 days in seconds

            if ($detail['docu_status'] != 'completed' && $currentTimestamp - $updatedTimestamp > $fiveDaysInSeconds) {
                echo 'background-color: #FFC0C0;';  // Set background color for more than 5 days
            } elseif ($detail['docu_status'] != 'completed' && $currentTimestamp - $updatedTimestamp > $threeDaysInSeconds) {
                echo 'background-color: #FFEC94;';  // Set background color for more than 3 days
            }
            ?>">
                        <td><?php echo $detail['docu_date'] ?></td>
            <td><img src="<?php echo $env_basePath; ?>assets/qr-codes/<?php echo $detail['qr_filename']; ?>" alt="QR Code" style="height: 80px"></td>
            <td><?php echo $detail['document_code'] ?></td>
            <td><?php echo $detail['document_type'] ?></td>
            <td><?php echo $detail['data_source'] ?></td>
            <td><?php echo $detail['sender'] ?></td>
            <td>
                <?php if ($detail['docu_status'] == 'completed') { ?>
                    <a href="track-document.php?code=<?php echo $detail['document_code']; ?>" class="btn btn-dark"><i class='bx bx-show'></i></a>
                <?php } else { ?>
                    <a href="transfer-complete.php?id=<?php echo $detail['id']; ?>" class="btn btn-dark"><i class='fa fa-exchange'></i></a>
                    <button class="btn btn-primary" data-id="<?php echo $detail['id']; ?>" onclick="confirmComplete(event)"><i class="fa fa-check" aria-hidden="true"></i></button>
                <?php } ?>
              
            </td>
        </tr>
    <?php } ?>

        </tbody>
        <tfoot>
            <tr>
            <th>Date</th>
                <th>QR Code</th>
                <th>Doc Code</th>
                <th>Document Type</th>
                <th>Document Source</th>
                <th>Sender</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>



<?php require 'template/bottom-template.php'; ?>

<script>
function confirmComplete(event) {
    // Get the data-id attribute value
    const dataId = event.currentTarget.getAttribute("data-id");

    // Show SweetAlert with an input field
    Swal.fire({
        title: 'Mark as completed',
        input: 'text',
        inputLabel: "Please type 'COMPLETED' to proceed.",
        icon: "info",
        inputPlaceholder: 'Type here...',
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        inputValidator: (value) => {
            // Validate that the user typed "COMPLETED"
            if (value !== 'COMPLETED') {
                return 'Invalid input. Please type "COMPLETED" to proceed.';
            }
        }
    }).then((result) => {
        // If the user clicked "Submit" and the input is correct, proceed with your logic
        if (result.isConfirmed) {
           
            $('.loader-container').fadeIn();
            var formData = new FormData();
            formData.append("action", "complete_document");
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
                                window.location.href = "received-documents.php";

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
</script>