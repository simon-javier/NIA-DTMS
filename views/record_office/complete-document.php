<?php require 'template/top-template.php'; ?>
<?php
$office =  $_SESSION['office'];

try {


    $trackDocuQuery = "SELECT * from tbl_uploaded_document where from_office = :office and completed = 'complete' order by updated_at desc";

    $stmt = $pdo->prepare($trackDocuQuery);
    $stmt->bindParam(':office', $office);
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
        <thead class="text-green-900 border-b-1 border-b-gray-300  font-bold rounded-full">
            <tr>
                <th>Completed Date</th>
                <th>Sender</th>
                <th>Document Type</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Action Required</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($docu_details as $row) { ?>
                <tr>
                    <td>
                        <?php echo $row['updated_at']; ?>
                    </td>
                    <td>
                        <?php echo $row['sender']; ?>
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
                        <?php echo $row['required_action']; ?>
                    </td>
                <?php } ?>
        </tbody>
    </table>
</div>
</main>
