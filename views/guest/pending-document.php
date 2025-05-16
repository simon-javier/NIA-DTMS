<?php require 'template/top-template.php'; ?>
<?php
try {
    //code...
    $sender_id = $_SESSION['userid'];

    $trackDocuQuery = "SELECT * from tbl_uploaded_document where status = 'pending'  and status != 'pulled' and sender_id = :id order by uploaded_at desc";

    $stmt = $pdo->prepare($trackDocuQuery);
    $stmt->bindParam(':id', $sender_id);
    $stmt->execute();
    $docu_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\Throwable $th) {
    //throw $th;
    echo $th->getMessage();
    exit;
}
?>

<div class="self-center bg-neutral-50 mt-5 p-10 w-[95%] rounded-md shadow-xl">
    <table id="mainTable" class="hover stripe">
        <div class="p-2 bg-neutral-50 shadow-sm absolute w-60
                        right-[74px] z-100 top-[168px] rounded-sm hidden dropdown-list">
            <ul class="dropdown-menu dropdown-menu-end flex flex-col gap-1" aria-labelledby="userDropdown">
                <li><a class="dropdown-item flex items-center gap-1" href="pulled-document.php"><i
                            class='bx bx-show'></i> Pulled Documents</a></li>
                <li><a class="dropdown-item flex items-center gap-1" href="incomplete-document.php"><i
                            class='bx bx-show'></i>Incomplete Documents</a></li>
            </ul>
        </div>
        <thead class="text-green-900 border-b-1 border-b-gray-300 font-bold rounded-full">
            <tr>
                <th>Document Type</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Action Required</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($docu_details as $row) { ?>
                <tr>
                    <td>
                        <?php echo $row['document_type']; ?>
                    </td>
                    <td>
                        <?php echo $row['subject']; ?>
                    </td>
                    <td>
                        <?php echo $row['description']; ?>
                    </td>
                    <td>
                        <?php echo $row['required_action']; ?>
                    </td>
                    <td class="relative">
                        <button class="px-4 py-0.5 rounded-sm cursor-pointer 
                        text-green-700 shadow-xs-1 hover:text-green-900
                        dropdown-btn text-3xl" data-drop-id="<?php echo $row['id'] ?>">
                            <i class='bx bx-dots-horizontal-rounded'></i>
                        </button>
                        <div class="p-2 bg-neutral-50 shadow-sm absolute w-50 
                        right-[54px] z-100 top-[40px] rounded-sm hidden dropdown-list"
                            id="dropdownList<?php echo $row['id'] ?>">
                            <ul class="dropdown-menu dropdown-menu-end flex flex-col gap-1" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item flex items-center gap-1"
                                        href="edit-document.php?id=<?php echo $row['id']; ?>"><i
                                            class='bx bx-pencil'></i>Edit Document</a></li>
                                <li>
                                    <button class="cursor-pointer flex items-center gap-1 pull-btn"
                                        data-id="<?php echo $row['id'] ?>">
                                        <i class='bx bx-git-pull-request'></i> Pull Document
                                    </button>

                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                    </td>
                </tr>
        </tbody>
    </table>
</div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        document.querySelector('#mainTable').addEventListener('click', (e) => {
            if (e.target && e.target.classList.contains('pull-btn')) {
                confirmPullRequest(e);
            }
        })

        function confirmPullRequest(event) {
            const button = event.target;
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


        $("#upload_docu_button").click(function(e) {

            if ($("#upload_docu_form")[0].checkValidity()) {
                e.preventDefault();


            }
        });
    })
</script>
