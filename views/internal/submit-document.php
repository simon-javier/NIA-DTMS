<?php 
    require '../../connection.php';

    $doctypeQuery = "SELECT * FROM tbl_document_type";
    $statement = $pdo->prepare($doctypeQuery);
    $statement->execute();

    // Fetch all rows as an associative array
    $doctypes = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require 'template/top-template.php'; ?>
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
    }

    ::-webkit-scrollbar-thumb {
        background-color: #009933; 
        border-radius: 6px;
    }
    .qr-code-container{
        display: flex;
        justify-content: center;
        margin-bottom: 1rem;
    }
    .qr-code{
        height: 200px;
    }

</style>
        <form>
            <div class="qr-code-container">
                <img src="<?php echo $env_basePath; ?>assets/img/qr-code-default.jpg" alt="QR Code" class="qr-code img-fluid" id="qrCodeImage">
                <input type="text" class="form-control" id="file_name" name="file_name" hidden readonly>
            </div>
            <div class="form-group">
                <label for="documentType">Document Code:</label>
                <input type="text" class="form-control" id="docu_code" placeholder="Document code" name="docu_code" required>
            </div>
            <div class="form-group">
                <label for="documentType">Subject:</label>
                <input type="text" class="form-control" id="subject" placeholder="Subject" name="subject">
            </div>

            <div class="form-group">
                <label for="doc_type">Document Type:</label>
                <select name="doc_type" class="form-control"  id="doc_type">
                    <?php 
                    foreach ($doctypes as $doctype) {?>
                    
                        <option value="<?php echo $doctype['document_type'];?>"><?php echo $doctype['document_type'];?></option>
                    <?php
                    }
                    
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" rows="3" placeholder="Enter document description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="receivingUnit">Receiving Unit:</label>
                <input type="text" class="form-control" id="receivingUnit" placeholder="Enter receiving unit" name="receivingUnit">
            </div>
            <div class="form-group">
                <label for="file">Send Attachments:</label>
                <input type="file" class="form-control" id="file" name="file">
                <p id="attachmentError" style="color: red;"></p>
            </div>
            <div class="d-flex justify-content-end align-items-end" style="gap: 20px">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Clear</button>
            </div>

        </form>



<?php require 'template/bottom-template.php'; ?>
<script>
var timeoutId; 

$(document).ready(function () {
    $('#docu_code').on('input', function () {

        clearTimeout(timeoutId);


        var docuCode = $(this).val();


        timeoutId = setTimeout(function () {

            $.ajax({
                url: '../../controller/qr-code-controller.php',
                method: 'POST',
                data: {docu_code: docuCode},
                dataType: 'json',
                success: function (response) {
                    // Update the QR code image source
                    if(response.status == 'success'){
                        $("#file_name").val(response.qrCodeData);
                        $('#qrCodeImage').attr('src', '<?php echo $env_basePath; ?>assets/qr-codes/' + response.qrCodeData);
                    }else{
                        Swal.fire({
                            title: 'Failed!',
                            text: 'Document code already exists.',
                            icon: 'warning',
                            confirmButtonText: 'OK'
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
        }, 1000); //(1 second)
    });
});

</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var fileInput = document.getElementById('file');

        fileInput.addEventListener('change', function () {
            var selectedFile = this.files[0];

            // Check if a file is selected
            if (selectedFile) {
                // Check file type
                if (selectedFile.type !== 'application/pdf') {
                    showError('Please select a PDF file.');
                    resetFileInput();
                    return;
                }

                // Check file size (in bytes)
                var maxSize = 2 * 1024 * 1024; // 2 MB
                if (selectedFile.size > maxSize) {
                    showError('File size should be less than 2 MB.');
                    resetFileInput();
                    return;
                }
            }
        });

        function showError(message) {
            $("#attachmentError").text(message);
        }

        function resetFileInput() {
            fileInput.value = '';
        }
    });
</script>
