<?php require 'template/top-template-bak.php'; ?>
<?php
require '../../connection.php';

$doctypeQuery = "SELECT * FROM tbl_document_type";
$statement = $pdo->prepare($doctypeQuery);
$statement->execute();
$doctypes = $statement->fetchAll(PDO::FETCH_ASSOC);

$id = $_GET['id'];


$sql = "SELECT * from tbl_uploaded_document where id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
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
    }

    ::-webkit-scrollbar-thumb {
        background-color: #009933;
        border-radius: 6px;
    }

    .qr-code-container {
        display: flex;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .qr-code {
        height: 200px;
    }

    .table-container {
        padding: 2.5rem;
        background-color: #fff;
        box-shadow: var(--box-shadow);
    }

    .form-control {
        border: 2px solid #009933;
        border-radius: 10px;
    }
</style>
<div class="table-container">
    <a href="pending-document.php" class="btn btn-danger mb-5">Back</a>

    <form id="update_docu" autocomplete="off" enctype="multipart/form-data">


        <div class="form-group">
            <label for="documentType">Subject:</label>
            <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" name="subject"
                value="<?php echo $result['subject']; ?>">
        </div>

        <div class="form-group">
            <label for="doc_type">Document Type:</label>
            <select name="doc_type" class="form-control" id="doc_type">
                <?php foreach ($doctypes as $doctype) { ?>
                    <option value="<?php echo $doctype['document_type']; ?>" <?php echo ($result['document_type'] == $doctype['document_type']) ? 'selected' : ''; ?>>
                        <?php echo $doctype['document_type']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter document description" name="description"><?php echo $result['description']; ?></textarea>
            <div class="d-flex justify-content-end">
                <p id="charCount">0/250</p>
            </div>
        </div>
        <div class="form-group">
            <label for="document_date">Document Date:</label>
            <input type="date" class="form-control" id="document_date" name="document_date" placeholder="Document date"
                value="<?php echo $result['document_date']; ?>">
        </div>
        <div class="form-group">
            <label for="required_action">Action Required:</label>
            <input class="form-control" list="action_required_list" id="required_action" name="required_action" rows="3"
                placeholder="Action required" value="<?php echo $result['required_action']; ?>" name="description">
        </div>

        <div class="form-group">
            <label for="file">Send Attachments:</label>
            <input type="file" class="form-control" id="file" name="file">
            <p id="attachmentError" style="color: red;"></p>
        </div>
        <div class="d-flex justify-content-end align-items-end" style="gap: 20px">
            <button type="submit" id="update_docu_btn" data-id="<?php echo $id; ?>"
                class="btn btn-primary">Update</button>
            <!-- <button type="reset" class="btn btn-danger">Clear</button> -->
        </div>

    </form>
</div>

<datalist id="action_required_list">
    <option value="For appropirate action">
    <option value="For comments/recommendation">
    <option value="For initial/signature">
    <option value="For information/reference/file">
    <option value="Please follow-up and report action taken">
    <option value="Please see me">
    <option value="For inspection">
    <option value="For compliance">

</datalist>


<?php require 'template/bottom-template.php'; ?>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.getElementById('file');

        fileInput.addEventListener('change', function() {
            var selectedFile = this.files[0];

            // Check if a file is selected
            if (selectedFile) {
                // Check file type
                var allowedTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'image/jpeg', 'image/png'];
                if (!allowedTypes.includes(selectedFile.type)) {
                    showError('Please select a valid file type (PDF, DOCX, Excel, JPEG, PNG, etc.).');
                    resetFileInput();
                    return;
                }

                // Check file size (in bytes)
                var maxSize = 3 * 1024 * 1024; // 3 MB
                if (selectedFile.size > maxSize) {
                    showError('File size should be less than 3 MB.');
                    resetFileInput();
                    return;
                }
                showError("");
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var textarea = document.getElementById('description');
        var charCount = document.getElementById('charCount');

        textarea.addEventListener('input', function() {
            var maxLength = 250;
            var currentLength = textarea.value.length;

            if (currentLength > maxLength) {
                textarea.value = textarea.value.substring(0, maxLength);
                currentLength = maxLength;
            }

            charCount.textContent = currentLength + '/' + maxLength;
        });
    });
</script>

<script>
    $("#update_docu_btn").click(function(e) {
        var dataId = $(this).data('id');
        if ($("#update_docu")[0].checkValidity()) {
            e.preventDefault();

            $('.loader-container').fadeIn();
            var formData = new FormData($("#update_docu")[0]);
            formData.append("action", "update_document");
            formData.append("id", dataId);

            $.ajax({
                url: "../../controller/upload-docu-controller.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    setTimeout(function() {

                        $('.loader-container').fadeOut();
                    }, 500);

                    if (response.status === "failed") {
                        Swal.fire({
                            title: 'Something went wrong!',
                            text: response.message,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    } else if (response.status === "error") {
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
                    } else if (response.status === "success") {
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
