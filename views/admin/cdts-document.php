<?php require 'template/top-template.php'; ?>
<?php
// require '../../connection.php';

$doctypeQuery = "SELECT * FROM tbl_document_type";
$statement = $pdo->prepare($doctypeQuery);
$statement->execute();
$doctypes = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="p-10 bg-neutral-50 m-5 rounded-md shadow-xl">
    <table id="mainTable" class="hover stripe">
        <thead class="text-green-700 border-b-1 border-b-gray-300  font-bold rounded-full">
            <tr>
                <th class="">Document Type</th>
                <th class="" style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($doctypes as $row) { ?>
                <tr>

                    <td><?php echo $row['document_type'] ?></td>
                    <td class="text-right">
                        <button data-id="<?php echo $row['id'] ?>"
                            data-document="<?php echo $row['document_type'] ?>"
                            class="px-4 py-0.5 rounded-sm cursor-pointer 
                                bg-green-100 text-green-700 shadow-xs
                                border-1 border-green-200 text-sm">
                            Edit
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</main>
</body>

</html>
