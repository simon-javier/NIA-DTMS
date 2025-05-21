<?php require 'template/top-template.php'; ?>

<?php
$user_id = $_SESSION['userid'];
$office_session = $_SESSION['office'];
try {
    //code...
    $docu_query = "SELECT * FROM tbl_uploaded_document where from_office = :office and completed = 'pulled'";
    $stmt = $pdo->prepare($docu_query);
    $stmt->bindParam(':office', $office_session);
    $stmt->execute();
    $docu_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\Throwable $th) {
    //throw $th;
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
                <p class="" onclick="window.location.reload();" style="cursor: pointer"><i class='bx bx-reset'
                        style="font-size: 30px;"></i></p>
            </div>
        </div>
    </div>
    <table id="mainTable" class="hover stripe">
        <thead class="text-green-900 border-b-1 border-b-gray-300  font-bold rounded-full">
            <tr>
                <th>Pulled Date</th>
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
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>



<?php require 'template/bottom-template.php'; ?>
