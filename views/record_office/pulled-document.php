


<?php require 'template/top-template.php'; ?>

<?php 

    $office =  $_SESSION['office'];

    try {


        $trackDocuQuery = "SELECT * from tbl_uploaded_document where from_office = :office and completed = 'pulled' order by updated_at desc";
    
        $stmt = $pdo->prepare($trackDocuQuery);
        $stmt->bindParam(':office', $office);
        $stmt->execute();
        $docu_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        //throw $th;
        echo $th->getMessage();
        exit;
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
</style>



<div class="table-container">

<table id="example" class="hover" style="width:100%">
        <thead>
            <tr>
                <th>Pulled Date</th>
                <th>Sender</th>
                <th>Document Type</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Action Required</th>
           
         
            </tr>
        </thead>
        <tbody>
            <?php foreach($docu_details as $row){ ?>
                <tr style="background-color: #fff;">
                    <td><?php echo $row['updated_at']; ?></td>
                    <td><?php echo $row['sender']; ?></td>
                    <td><?php echo $row['document_type']; ?></td>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['required_action']; ?></td>
                   
                </tr>
            <?php } ?>


            


        </tbody>
        <tfoot>
            <tr>
            <th>Pulled Date</th>
            <th>Sender</th>
                <th>Document Type</th>
                
                <th>Subject</th>
                <th>Description</th>
                <th>Action Required</th>

          
            </tr>
        </tfoot>
    </table>
</div>


<?php require 'template/bottom-template.php'; ?>

<script>
    function confirmPullRequest(event) {
        const button = event.currentTarget;
        const dataId = button.getAttribute('data-id');


        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to pull this document?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, pull it!'
        }).then((result) => {

            if (result.isConfirmed) {
            $('.loader-container').fadeIn();
            var formData = new FormData($("#upload_docu_form")[0]);
            formData.append("action", "pull_documents");
            formData.append("id", dataId);

            $.ajax({
                url: "../../controller/upload-docu-controller.php",
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
    }
</script>


<script>
    $("#upload_docu_button").click(function(e){

        if($("#upload_docu_form")[0].checkValidity()){
            e.preventDefault();

            
        }
    });
</script>