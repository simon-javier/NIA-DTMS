<?php require 'template/top-template-bak.php'; ?>
<?php
// require '../../connection.php';

$doctypeQuery = "SELECT * FROM tbl_offices";
$statement = $pdo->prepare($doctypeQuery);
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
        height: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #009933;
        border-radius: 6px;
    }

    .table-container {
        padding: 2.5rem;
        background-color: #fff;
        box-shadow: var(--box-shadow);
        overflow-x: auto;
    }

    .form-control {
        border: 2px solid #009933;
        border-radius: 10px;
    }

    .main-content {
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

    .qr-code-container {
        display: flex;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .qr-code {
        height: 200px;
    }
</style>

<div class="table-container">
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary d-flex align-items-center" data-toggle="modal" data-target="#newDocumentModal">
            <i class='bx bx-plus-circle mr-2' style="font-size: 18px"></i> New Office
        </button>
    </div>
    <table id="example" class="hover" style="width:100%">
        <thead>
            <tr>
                <th>Office Name</th>
                <th>Office Code</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($offices as $row) { ?>
                <tr>

                    <td><?php echo $row['office_name'] ?></td>
                    <td><?php echo $row['office_code'] ?></td>
                    <td style="text-align: right;">
                        <button data-id="<?php echo $row['id'] ?>" data-document="<?php echo $row['office_name'] ?>" data-code="<?php echo $row['office_code'] ?>" class="btn btn-dark edit-button"><i class='bx bx-pencil'></i></button>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
        <tfoot>
            <tr>
                <th>Office Name</th>
                <th>Office Code</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </tfoot>
    </table>
</div>

<div class="modal fade" id="newDocumentModal" tabindex="-1" role="dialog" aria-labelledby="newDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newDocumentModalLabel">New Office</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for submitting a new document type -->
                <form id="addNewOffice" autocomplete="off">
                    <div class="form-group">
                        <label for="documentType">Office Name:</label>
                        <input type="text" class="form-control" id="documentType" name="office_name" placeholder="Enter office name" required>
                    </div>
                    <div class="form-group">
                        <label for="officeCode">Office Code:</label>
                        <input type="text" class="form-control" id="officeCode" name="office_code" placeholder="Enter office code" required>
                    </div>
                    <!-- Add more form fields as needed -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" id="addNewOfficebtn" class="btn btn-primary">Add</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editDocumentModal" tabindex="-1" role="dialog" aria-labelledby="editDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDocumentModalLabel">Edit Document Type</h5>
                <button type="button" id="close_modal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editofficeinfo">
                    <div class="form-group">
                        <label for="editOfficeName">Office Name:</label>
                        <input type="text" class="form-control" id="editOfficeName" name="edit_office_name" required>
                        <input type="hidden" id="office_id" name="office_id" required>
                    </div>
                    <div class="form-group">
                        <label for="editOfficeCode">Office Code:</label>
                        <input type="text" class="form-control" id="editOfficeCode" name="edit_office_code" required>
                    </div>
                    <div class="d-flex justify-content-end"> <button type="submit" id="editofficeinfobtn" class="btn btn-primary">Save Changes</button></div>


                </form>
            </div>
        </div>
    </div>
</div>


<?php require 'template/bottom-template.php'; ?>
<script>
    // Attach a click event to the edit button
    $('.edit-button').click(function() {
        var id = $(this).data('id');
        var documentType = $(this).data('document');
        var officeCode = $(this).data('code');

        $('#editOfficeName').val(documentType);
        $('#office_id').val(id);
        $('#editOfficeCode').val(officeCode);
        $('#editDocumentModal').modal('show');
    });

    $('#close_modal').click(function() {
        $('#editDocumentModal').modal('hide');
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
    $("#editofficeinfobtn").click(function(e) {
        if ($("#editofficeinfo")[0].checkValidity()) {
            e.preventDefault();

            $('.loader-container').fadeIn();
            var formData = new FormData($("#editofficeinfo")[0]);
            formData.append("action", "edit_office");

            $.ajax({
                url: "../../controller/office-name-controller.php",
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


<script>
    $("#addNewOfficebtn").click(function(e) {
        if ($("#addNewOffice")[0].checkValidity()) {
            e.preventDefault();

            $('.loader-container').fadeIn();
            var formData = new FormData($("#addNewOffice")[0]);
            formData.append("action", "add_office");

            $.ajax({
                url: "../../controller/office-name-controller.php",
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
