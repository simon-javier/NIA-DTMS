<?php require 'template/top-template.php'; ?>

<?php
try {
    //code...
    $get_user_data = "
            SELECT *
            FROM tbl_login_account
            JOIN tbl_userinformation ON tbl_login_account.id = tbl_userinformation.id
            WHERE tbl_login_account.status = 'pending'
        ";
    $stmt = $pdo->prepare($get_user_data);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $th) {
    echo "Error: " . $th->getMessage();
}

?>

<div class="p-10 bg-neutral-50 m-5 rounded-md shadow-xl">
    <table id="mainTable" class="hover stripe">
        <thead class="text-green-900 border-b-1 border-b-gray-300 font-bold rounded-full">
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Full Name</th>

                <th class="w-50">Contact number</th>

                <th>Email</th>
                <th class="w-3">Action</th>
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
                        <?php echo strlen($row['email']) > 10 ? substr($row['email'], 0, 10) . '...' : $row['email']; ?>
                    </td>
                    <td class="relative">
                        <button class="px-4 py-0.5 rounded-sm cursor-pointer 
                        text-green-700 shadow-xs-1 hover:text-green-900
                        dropdown-btn text-3xl" data-drop-id="<?php echo $row['id'] ?>">
                            <i class='bx bx-dots-horizontal-rounded'></i>
                        </button>
                        <div class="p-2 bg-neutral-50 shadow-sm absolute w-40 
                        right-[24px] z-100 top-[40px] rounded-sm hidden dropdown-list"
                            id="dropdownList<?php echo $row['id'] ?>">
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item flex items-center gap-1"
                                        href="user-details.php?id=<?php echo $row['id'] ?>"><i class='bx bx-show'></i> View
                                        Details</a></li>
                                <li>
                                    <button class="cursor-pointer flex items-center gap-1" onclick="approve(this)"
                                        data-id="<?php echo $row['id'] ?>">
                                        <i class='bx bx-check'></i> Approve
                                    </button>

                                </li>
                                <li>
                                    <button class="cursor-pointer flex items-center gap-1" onclick="decline(this)"
                                        data-id="<?php echo $row['id'] ?>">
                                        <i class='bx bx-x'></i>
                                        Decline
                                    </button>

                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</main>
