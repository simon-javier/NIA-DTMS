<?php require 'template/top-template.php'; ?>

<?php
try {
    //code...
    $get_user_data = "
            SELECT *
            FROM tbl_login_account
            JOIN tbl_userinformation ON tbl_login_account.id = tbl_userinformation.id
            WHERE tbl_login_account.status = 'archived' AND tbl_login_account.role = 'guest'
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

                <th class="w-10">Contact number</th>

                <th>Email</th>
                <th class="w-60">Action</th>
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
                    <td class="text-right">
                        <button data-id="<?php echo $row['id'] ?>" data-document="<?php echo $row['document_type'] ?>"
                            onclick="unarchiveAccount(this)" class="px-4 py-0.5 rounded-sm cursor-pointer 
                                text-blue-400 shadow-xs-1 hover:text-blue-900 edit-button flex items-center gap-1">
                            <i class='bx bx-archive-out'></i> Unarchive
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</main>
