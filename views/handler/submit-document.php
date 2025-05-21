<?php require 'template/top-template-bak.php'; ?>
<?php
require '../../connection.php';
$office = $_SESSION['office'];
$user_id = $_SESSION['userid'];

$doctypeQuery = "SELECT * FROM tbl_document_type";
$statement = $pdo->prepare($doctypeQuery);
$statement->execute();
$doctypes = $statement->fetchAll(PDO::FETCH_ASSOC);

$internalOffice = "SELECT * FROM tbl_userinformation where role = 'handler' and status != 'archived' and office != :office";
$statement = $pdo->prepare($internalOffice);
$statement->bindParam(':office', $office);
$statement->execute();
$internaloffice = $statement->fetchAll(PDO::FETCH_ASSOC);



$officesQuery = "SELECT DISTINCT tbl_offices.office_name FROM tbl_offices 
                 JOIN tbl_userinformation ON tbl_offices.office_name = tbl_userinformation.office where tbl_offices.office_name != :office and tbl_userinformation.status != 'archived'";

$statement = $pdo->prepare($officesQuery);
$statement->bindParam(':office', $office);
$statement->execute();
$offices = $statement->fetchAll(PDO::FETCH_ASSOC);


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

    .filter-option {
        border: 2px solid var(--primary-color);
        border-radius: 10px;
    }
</style>
<div class="table-container">
    <form accept-charset="UTF-8" id="upload_docu_form" autocomplete="off" enctype="multipart/form-data">
        <!-- <div class="qr-code-container">
                <img src="<?php echo $env_basePath; ?>assets/img/qr-code-default.jpg" alt="QR Code" class="qr-code img-fluid" id="qrCodeImage">
                <input type="text" class="form-control" id="file_name" name="file_name" hidden  readonly>
            </div> -->
        <!-- <div class="form-group">
                <label for="documentType">Document Code:</label>
                <input type="text" class="form-control" id="docu_code" placeholder="Document code" name="docu_code" required>
            </div> -->
        <div class="form-group">
            <label for="documentType">Subject:</label>
            <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" name="subject"
                required>
        </div>

        <div class="form-group">
            <label for="doc_type">Document Type:</label>
            <select name="doc_type" class="form-control" id="doc_type">
                <?php
                foreach ($doctypes as $doctype) { ?>
                    <option value="<?php echo $doctype['document_type']; ?>">
                        <?php echo $doctype['document_type']; ?>
                    </option>
                <?php
                }

                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="3"
                placeholder="Enter document description"></textarea>
            <div class="d-flex justify-content-end">
                <p id="charCount">0/250</p>
            </div>
        </div>
        <div class="form-group">
            <label for="document_date">Document Date:</label>
            <input type="date" class="form-control" id="document_date" name="document_date" placeholder="Document date">
        </div>
        <div class="form-group">
            <label for="required_action">Action Required:</label>
            <input class="form-control" list="action_required_list" id="required_action" name="required_action"
                placeholder="Action required">
        </div>

        <input type="hidden" name="sender_id" id="sender_id" value="<?php echo $user_id; ?>">
        <input type="hidden" placeholder="Sender name" class="form-control" name="from_internal" id="from_internal"
            value="<?php echo $_SESSION['fullname']; ?>">
        <input type="hidden" name="source" id="source" value="internal">


        <div class="form-group">
            <label for="receiver_office">Send To:</label>
            <select name="receiver_office" id="receiver_office" class="form-control selectpicker"
                data-live-search="true" style="border: 2px solid green;" required>
                <option value="" selected>Select</option>
                <?php foreach ($offices as $office) { ?>
                    <option value="<?php echo $office['office_name']; ?>">
                        <?php echo $office['office_name']; ?>
                    </option>
                <?php } ?>
            </select>

        </div>

        <div class="form-group">
            <label for="file">Send Attachments:</label>
            <input type="file" class="form-control" id="file" name="file">
            <p id="attachmentError" style="color: red;"></p>
        </div>
        <div class="d-flex justify-content-end align-items-end" style="gap: 20px">
            <button type="submit" id="upload_docu_button" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-danger">Clear</button>
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
    document.getElementById("from_internal").addEventListener("change", function() {
        var selectedOption = this.options[this.selectedIndex];
        var internalId = selectedOption.getAttribute("data-id");
        document.getElementById("sender_id").value = internalId;
    });

    function checkExternal() {
        // Get the checkbox element
        var checkbox = document.getElementById("isexternal");
        var input = document.getElementById("source");
        var from_internal = document.getElementById("internal-section");
        var from_external = document.getElementById("from_external");

        // Check if the checkbox is checked
        if (checkbox.checked) {
            // The checkbox is checked, set a variable or perform an action for external
            input.value = "guest";
            from_external.style.display = "block";
            from_internal.style.display = "none";
        } else {
            // The checkbox is not checked, set a variable or perform an action for internal
            input.value = "internal";
            from_internal.style.display = "block";
            from_external.style.display = "none";
        }
    }
</script>
<script>
    var timeoutId;

    $(document).ready(function() {
        $('#docu_code').on('input', function() {

            clearTimeout(timeoutId);


            var docuCode = $(this).val();


            timeoutId = setTimeout(function() {

                $.ajax({
                    url: '../../controller/qr-code-controller.php',
                    method: 'POST',
                    data: {
                        docu_code: docuCode
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Update the QR code image source
                        if (response.status == 'success') {
                            $("#file_name").val(response.qrCodeData);
                            $('#qrCodeImage').attr('src', '<?php echo $env_basePath; ?>assets/qr-codes/' + response.qrCodeData);
                        } else {
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
    $("#upload_docu_button").click(function(e) {

        if ($("#upload_docu_form")[0].checkValidity()) {
            e.preventDefault();

            $('.loader-container').fadeIn();
            var formData = new FormData($("#upload_docu_form")[0]);
            formData.append("action", "upload_document");

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
    });
</script>
