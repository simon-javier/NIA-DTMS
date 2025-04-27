<?php require 'template/top-template.php'; ?>

<?php
$user_id = $_SESSION['userid'];
try {
    //code...
    $get_user_data = "
            SELECT *
            FROM tbl_login_account
            JOIN tbl_userinformation ON tbl_login_account.id = tbl_userinformation.id
            WHERE tbl_login_account.status = 'active' AND tbl_login_account.role != 'guest' AND tbl_login_account.id != :id
        ";
    $stmt = $pdo->prepare($get_user_data);
    $stmt->bindParam(':id', $user_id);
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
                <th>Position</th>
                <th>Office</th>
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
                        <?php echo $row['position'] ?>
                    </td>
                    <td>
                        <?php echo $row['office']; ?>
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
