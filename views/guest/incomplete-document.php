<?php require 'template/top-template.php'; ?>
<?php
try {
    //code...
    $sender_id = $_SESSION['userid'];

    $trackDocuQuery = "SELECT * from tbl_uploaded_document where completed = 'decline' and sender_id = :id order by uploaded_at desc";

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
        <thead class="text-green-900 border-b-1 border-b-gray-300 font-bold rounded-full">
            <tr>
                <th>Date</th>
                <th>Document Type</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($docu_details as $row) { ?>
                <tr>
                    <td>
                        <?php echo $row['updated_at']; ?>
                    </td>
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
                        <?php echo $row['status']; ?>
                    </td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</main>
