<?php require 'template/top-template.php'; ?>

<?php

$user_id = $_SESSION['userid'];
$office = $_SESSION['office'];
try {
    //code...
    $docu_query = "SELECT tbl_handler_outgoing.receive_at as docu_date, tbl_handler_outgoing.*, tbl_uploaded_document.*  FROM tbl_handler_outgoing JOIN tbl_uploaded_document ON tbl_handler_outgoing.docu_id = tbl_uploaded_document.id where tbl_handler_outgoing.office_name = :office and tbl_uploaded_document.completed != 'pulled' ORDER BY receive_at DESC";
    $stmt = $pdo->prepare($docu_query);
    $stmt->bindParam(':office', $office);
    $stmt->execute();
    $docu_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\Throwable $th) {
    //throw $th;
    echo $th;
    exit;
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
                <p class="" onclick="refreshPage()" style="cursor: pointer"><i class='bx bx-reset'
                        style="font-size: 30px;"></i></p>
            </div>
        </div>
    </div>
    <table id="mainTable" class="hover stripe">
        <thead class="text-green-900 border-b-1 border-b-gray-300 font-bold rounded-full">
            <tr>
                <th>QR Code</th>
                <th>Doc Code</th>
                <th>Document Type</th>
                <th>Document Source</th>
                <th>Sender</th>
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
                        <?php echo $detail['sender'] ?>
                    </td>

                    <td class="text-right">
                        <a href="<?php echo $env_basePath; ?>views/track-document.php?code=<?php echo $detail['document_code']; ?>"
                            class="bg-black text-white px-2.5 py-2 rounded-lg hover:bg-black/80">
                            <i class='bx bx-show'></i></a>
                        <?php if ($detail['sender_id'] == $user_id && $detail['cur_office'] == 'No current office.'): ?>
                            <a href="edit-document.php?id=<?php echo $detail['id']; ?>"
                                class="bg-black text-white px-2.5 py-2 rounded-lg hover:bg-black/80"><i
                                    class='bx bx-pencil'></i></a>
                            <button class="bg-black text-white px-2.5 py-2 rounded-lg hover:bg-black/80"
                                data-id="<?php echo $detail['id']; ?>" onclick="confirmPullRequest(event)"><i
                                    class='bx bx-git-pull-request'></i></button>
                        <?php endif; ?>
                    <?php } ?>
                    </td>
                </tr>
        </tbody>
    </table>
</div>



<?php require 'template/bottom-template.php'; ?>
