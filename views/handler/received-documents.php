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

<div class="self-center bg-neutral-50 mt-5 p-10 w-[95%] rounded-md shadow-xl">
    <div class="flex justify-between mb-5">
        <p class="text-red-600">Documents currently handle by this office.</p>
        <div class="flex gap-3 items-center">
            <p>Filter by date</p>
            <div class="flex gap-2 items-center">
                <input type="text"
                    class="block w-40 rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 disabled:border-gray-200 disabled:bg-gray-100 disabled:text-gray-500 disabled:shadow-none"
                    id="min" name="min" placeholder="Start date">
                <input type="text"
                    class="block w-40 rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 disabled:border-gray-200 disabled:bg-gray-100 disabled:text-gray-500 disabled:shadow-none"
                    id="max" name="max" placeholder="End date">
                <p class="" onclick="window.location.reload();" style="cursor: pointer"><i class='bx bx-reset'
                        style="font-size: 30px;"></i></p>
            </div>
        </div>
    </div>
    <table id="mainTable" class="hover stripe">
        <thead class="text-green-900 border-b-1 border-b-gray-300 font-bold rounded-full">
            <tr>
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

                    <td class="text-right">
                        <?php if ($detail['docu_status'] == 'completed') { ?>
                            <a href="track-document.php?code=<?php echo $detail['document_code']; ?>"
                                class="bg-black text-white px-2.5 py-2 rounded-lg hover:bg-black/80">
                                <i class='bx bx-show'></i></a>
                            </a>
                        <?php } else { ?>
                            <div class="flex gap-3 justify-end">
                                <a href="transfer-complete.php?id=<?php echo $detail['id']; ?>"
                                    class="bg-black text-white px-2.5 py-2 rounded-lg hover:bg-black/80">
                                    <i class='fa fa-exchange'></i></a>
                                </a>
                                <button data-id="<?php echo $detail['id']; ?>" onclick="confirmComplete(event)"
                                    class="bg-green-600 text-white px-2.5 py-2 rounded-lg hover:bg-green-700">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </button>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    </td>
                </tr>
        </tbody>
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
