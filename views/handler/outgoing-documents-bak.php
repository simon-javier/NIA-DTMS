<?php require 'template/top-template-bak.php'; ?>

<?php

$user_id = $_SESSION['userid'];
$office = $_SESSION['office'];
try {
    //code...
    $docu_query = "SELECT tbl_handler_outgoing.receive_at as docu_date, tbl_handler_outgoing.*, tbl_uploaded_document.*  FROM tbl_handler_outgoing JOIN tbl_uploaded_document ON tbl_handler_outgoing.docu_id = tbl_uploaded_document.id where tbl_handler_outgoing.office_name = :office and tbl_uploaded_document.completed != 'pulled' ORDER BY receive_at DESC";
    $stmt = $pdo->prepare($docu_query);
    $stmt->bindParam(':office', $office);
    $stmt->execute();
    $docu_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\Throwable $th) {
    //throw $th;
    echo $th;
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

    .table-container {
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

    #example_wrapper {
        overflow-x: scroll;
    }

    .form-control {
        border: 2px solid #009933;
        border-radius: 10px;
    }

    @media (min-width: 992px) {
        .w-lg-25 {
            width: 10% !important;
        }
    }
</style>

<!-- <div class="container">
    <form autocomplete="off">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="name">Document Type</label>
                <input type="text" class="form-control" id="name" placeholder="Enter your name">
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="office">Date From</label>
                <input type="date" class="form-control" id="office" placeholder="Enter your office">
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="from">Date To</label>
                <input type="date" class="form-control" id="from" placeholder="Enter sender's name">
            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="float: right;">Submit</button>
    </form>
</div> -->


<div class="table-container">
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
        <p class="ml-2" onclick="refreshPage()" style="cursor: pointer"><i class='bx bx-reset'
                style="font-size: 30px;"></i></p>
    </div>
    <script>
        function refreshPage() {
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

                <th style="text-align: end;">Action</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($docu_details as $detail) { ?>
                <tr>
                    <td>
                        <?php echo $detail['docu_date'] ?>
                    </td>
                    <td><img src="<?php echo $env_basePath; ?>assets/qr-codes/<?php echo $detail['qr_filename']; ?>"
                            alt="QR Code" style="height: 80px"></td>
                    <td>
                        <?php echo $detail['document_code'] ?>
                    </td>
                    <td>
                        <?php echo $detail['document_type'] ?>
                    </td>
                    <td>
                        <?php echo $detail['data_source'] ?>
                    </td>
                    <td>
                        <?php echo $detail['sender'] ?>
                    </td>


                    <td style="text-align: end;">
                        <a href="<?php echo $env_basePath; ?>views/track-document.php?code=<?php echo $detail['document_code']; ?>"
                            class="btn btn-dark"><i class='bx bx-show'></i></a>
                        <?php if ($detail['sender_id'] == $user_id && $detail['cur_office'] == 'No current office.'): ?>
                            <a href="edit-document.php?id=<?php echo $detail['id']; ?>" class="btn btn-danger"><i
                                    class='bx bx-pencil'></i></a>
                            <button class="btn btn-dark" data-id="<?php echo $detail['id']; ?>"
                                onclick="confirmPullRequest(event)"><i class='bx bx-git-pull-request'></i></button>
                        <?php endif; ?>
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

                <th style="text-align: end;">Action</th>
            </tr>
        </tfoot>
    </table>
</div>



<?php require 'template/bottom-template-bak.php'; ?>

<script>
    function confirmPullRequest(event) {
        const button = event.currentTarget;
        const dataId = button.getAttribute('data-id');


        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to pull this document?' + dataId,
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
    }
</script>
