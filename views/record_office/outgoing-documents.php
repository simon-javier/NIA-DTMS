<?php require 'template/top-template.php'; ?>

<?php

$user_id = $_SESSION['userid'];
$office = $_SESSION['office'];
try {
    //code...
    $docu_query = "SELECT tbl_handler_outgoing.*, tbl_uploaded_document.*  FROM tbl_handler_outgoing JOIN tbl_uploaded_document ON tbl_handler_outgoing.docu_id = tbl_uploaded_document.id where tbl_handler_outgoing.office_name = :office and tbl_uploaded_document.completed != 'pulled' ORDER BY receive_at DESC";
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
<div class="self-center bg-neutral-50 mt-5 p-10 w-[95%] rounded-md shadow-xl">
    <div class="flex justify-end mb-5">
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
                <p class="" onclick="refreshPage()" style="cursor: pointer"><i class='bx bx-reset'
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
                <tr>
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
                        <a href="<?php echo $env_basePath; ?>views/track-document.php?code=<?php echo $detail['document_code']; ?>"
                            class="bg-black text-white px-2.5 py-2 rounded-lg hover:bg-black/80">
                            <i class='bx bx-show'></i></a>
                        <?php if ($detail['sender_id'] == $user_id && $detail['cur_office'] == 'No current office.'): ?>
                            <a href="edit-document.php?id=<?php echo $detail['id']; ?>"
                                class="bg-black text-white px-2.5 py-2 rounded-lg hover:bg-black/80"><i
                                    class='bx bx-pencil'></i></a>
                            <button class="bg-black text-white px-2.5 py-2 rounded-lg hover:bg-black/80"
                                data-id="<?php echo $detail['id']; ?>" onclick="confirmPullRequest(event)"><i
                                    class='bx bx-git-pull-request'></i></button>
                        <?php endif; ?>
                    <?php } ?>
                    </td>
                </tr>
        </tbody>
    </table>
</div>
</main>

<script>
    function refreshPage() {
        window.location.reload();
    }

    document.addEventListener("DOMContentLoaded", () => {
        $(document).ready(function() {
            // Initialize DataTable with your table ID
            $('#mainTable').DataTable();

            // Set placeholder text for DataTables search input
            $('#dt-search-0').attr('placeholder', '🔎 Search all');
        });

        let minDate, maxDate;

        // Custom filtering function which will search data in column 1 between two values
        DataTable.ext.search.push(function(settings, data, dataIndex) {
            let min = minDate.val();
            let max = maxDate.val();
            let date = new Date(data[0]);

            if (
                (min === null && max === null) ||
                (min === null && date <= max) ||
                (min <= date && max === null) ||
                (min <= date && date <= max)
            ) {
                return true;
            }
            return false;
        });

        // Create date inputs
        minDate = new DateTime('#min', {
            format: 'YYYY-MM-DD'
        });
        maxDate = new DateTime('#max', {
            format: 'YYYY-MM-DD'
        });

        // DataTables initialisation
        let table = new DataTable('#mainTable');

        // Refilter the table
        document.querySelectorAll('#min, #max').forEach((el) => {
            el.addEventListener('change', () => table.draw());
        });
    })
</script>

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
                var formData = new FormData($("")[0]);
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
