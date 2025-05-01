<?php require 'template/top-template.php'; ?>


<?php
try {
    //code...
    $get_user_data = "
            SELECT *
            FROM tbl_login_account
            JOIN tbl_userinformation ON tbl_login_account.id = tbl_userinformation.id
            WHERE tbl_login_account.status = 'active' AND tbl_login_account.role = 'guest'
        ";
    $stmt = $pdo->prepare($get_user_data);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $th) {
    echo "Error: " . $th->getMessage();
}

?>

<div class="self-center bg-neutral-50 mt-5 p-10 w-[95%] rounded-md shadow-xl">
    <table id="mainTable" class="hover stripe">
        <thead class="text-green-900 border-b-1 border-b-gray-300 font-bold rounded-full">
            <tr>
                <th class="w-60">Username</th>
                <th>Role</th>
                <th>Full Name</th>

                <th>Contact number</th>

                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row) { ?>
                <tr>
                    <td>
                        <?php echo $row['username'] ?>
                    </td>
                    <td>
                        <?php echo $row['role'] ?>
                    </td>
                    <td>
                        <?php echo $row['firstname'] ?>
                        <?php echo $row['lastname'] ?>
                    </td>
                    <td>
                        <?php echo $row['contact'] ?>
                    </td>
                    <td>
                        <?php echo $row['email']; ?>
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
                                        href="user-details.php?id=<?php echo $row['id'] ?>"><i class='bx bx-show'></i> View
                                        Details</a></li>
                                <li><a class="dropdown-item flex items-center gap-1"
                                        href="update-details.php?id=<?php echo $row['id'] ?>"><i
                                            class='bx bx-edit-alt'></i>Update
                                        Details</a></li>
                                <li>
                                    <button class="cursor-pointer flex items-center gap-1" onclick="updatePassword(this)"
                                        data-id="<?php echo $row['id'] ?>">
                                        <i class='bx bx-lock'></i> Retrieve Account
                                    </button>

                                </li>
                                <li>
                                    <button class="cursor-pointer flex items-center gap-1" onclick="archiveAccount(this)"
                                        data-id="<?php echo $row['id'] ?>">
                                        <i class='bx bx-archive-in'></i>
                                        Archive Account
                                    </button>

                                </li>
                            </ul>
                        </div>
                    </td>
                <?php } ?>
        </tbody>
    </table>
</div>
</main>

<script>
    function updatePassword(button) {
        var userId = button.dataset.id;
        Swal.fire({
            title: "Retrieve account?",
            text: "This will set the user's password to the default and notify them via email.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, retrieve it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $('.loader-container').fadeIn();
                $.ajax({
                    url: "../../controller/crud-users-controller.php",
                    type: "POST",
                    data: "action=retrieve_account&id=" + userId,
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
                                text: "Account retrieved successfully.",
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
    function archiveAccount(button) {
        var userId = button.dataset.id;
        Swal.fire({
            title: "Archive account?",
            text: "This will lose the access of the user to the system.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, archive it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $('.loader-container').fadeIn();
                $.ajax({
                    url: "../../controller/crud-users-controller.php",
                    type: "POST",
                    data: "action=archive_account&id=" + userId,
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
