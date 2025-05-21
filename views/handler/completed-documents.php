<?php require 'template/top-template.php'; ?>

<?php
$user_id = $_SESSION['userid'];
$office_session = $_SESSION['office'];
try {
    //code...
    $docu_query = "SELECT * FROM tbl_uploaded_document where sender = :office and completed = 'complete'";
    $stmt = $pdo->prepare($docu_query);
    $stmt->bindParam(':user_id', $user_id);
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
                <p class="" onclick="window.location.reload()" style="cursor: pointer"><i class='bx bx-reset'
                        style="font-size: 30px;"></i></p>
            </div>
        </div>
    </div>
    <table id="mainTable" class="hover" style="width:100%">
        <thead>
            <tr>
                <th>QR Code</th>
                <th>Doc Code</th>
                <th>Document Type</th>
                <th>Document Source</th>
                <th>Receiving Unit</th>
                <th>Status</th>
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
                        <?php echo $detail['receiver'] ?>
                    </td>
                    <td>
                        <?php echo $detail['status'] ?>
                    </td>
                    <td>
                        <a href="<?php echo $env_basePath; ?>views/track-document.php?code=<?php echo $detail['document_code']; ?>"
                            class="bg-black text-white px-2.5 py-2 rounded-lg hover:bg-black/80"><i
                                class='bx bx-show'></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>

    </table>
</div>



<?php require 'template/bottom-template.php'; ?>
