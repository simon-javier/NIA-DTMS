<?php require 'template/top-template.php'; ?>
<?php
$office_session = $_SESSION['office'];

require '../../connection.php';
$docu_query = "SELECT COUNT(*) as count FROM tbl_handler_incoming JOIN tbl_uploaded_document ON tbl_handler_incoming.docu_id = tbl_uploaded_document.id WHERE tbl_handler_incoming.user_id = :user_id and tbl_handler_incoming.status != 'notyetreceive'";
$stmt = $pdo->prepare($docu_query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$incoming = $result['count'];



$docu_query = "SELECT COUNT(*) as count FROM tbl_handler_outgoing JOIN tbl_uploaded_document ON tbl_handler_outgoing.docu_id = tbl_uploaded_document.id WHERE tbl_handler_outgoing.office_name = :office";
$stmt = $pdo->prepare($docu_query);
$stmt->bindParam(':office', $office_session);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$outgoing = $result['count'];

$docu_query = "SELECT COUNT(*) as count FROM tbl_office_document 
                JOIN tbl_uploaded_document ON tbl_office_document.docu_id = tbl_uploaded_document.id 
                WHERE (tbl_office_document.status = 'active' OR tbl_office_document.status = 'completed') 
                AND tbl_office_document.office_name = :office_name";

$stmt = $pdo->prepare($docu_query);
$stmt->bindParam(':office_name', $office_session);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$receive = $result['count'];


$docu_query = "SELECT COUNT(*) as count from tbl_uploaded_document where from_office = :office and completed = 'pulled'";
$stmt = $pdo->prepare($docu_query);
$stmt->bindParam(':office', $office_session);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$pulled = $result['count'];

$docu_query = "SELECT COUNT(*) as count from tbl_uploaded_document where from_office = :office and completed = 'complete'";
$stmt = $pdo->prepare($docu_query);
$stmt->bindParam(':office', $office_session);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$complete = $result['count'];

$docu_query = "SELECT COUNT(*) as count from tbl_uploaded_document where from_office = :office and completed = 'decline'";
$stmt = $pdo->prepare($docu_query);
$stmt->bindParam(':office', $office_session);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$incomplete = $result['count'];




?>
<!-- Cards -->
<div class="flex items-center justify-center flex-wrap gap-16 mt-18 max-w-[900px] self-center">
    <!-- Card 1 -->
    <div class="bg-neutral-50 flex flex-col rounded-xl basis-[246px]">
        <div class="flex gap-6 items-center p-3">
            <i class="bx bxs-file-export fa-2x text-3xl text-green-300"></i>
            <div>
                <h1 class="font-bold text-xs text-gray-500 uppercase">Incoming Documents</h1>
                <p class="uppercase font-bold text-xs"><span class="text-2xl">
                        <?php echo $incoming; ?>
                    </span> item/s</p>
            </div>
        </div>
        <a href="incoming-documents.php"
            class="flex items-center justify-center gap-1 text-xs font-bold text-green-950 bg-green-100 rounded-b-xl p-3 select-none">
            View Documents
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>
    <!-- Card 2 -->
    <div class="bg-neutral-50 flex flex-col rounded-xl basis-[246px]">
        <div class="flex gap-6 items-center p-3">
            <i class="bx bxs-file-import fa-2x text-4xl text-green-300"></i>
            <div>
                <h1 class="font-bold text-xs text-gray-500 uppercase">Ongoing Documents</h1>
                <p class="uppercase font-bold text-xs"><span class="text-2xl">
                        <?php echo $outgoing; ?>
                    </span> item/s</p>
            </div>
        </div>
        <a href="outgoing-documents.php"
            class="flex items-center justify-center gap-1 text-xs font-bold text-green-950 bg-green-100 rounded-b-xl p-3 select-none">
            View Documents
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>
    <!-- Card 3 -->
    <div class="bg-neutral-50 flex flex-col rounded-xl basis-[246px]">
        <div class="flex gap-6 items-center p-3">
            <i class="bx bx-file fa-2x text-4xl text-green-300"></i>
            <div>
                <h1 class="font-bold text-xs text-gray-500 uppercase">Received Documents</h1>
                <p class="uppercase font-bold text-xs"><span class="text-2xl">
                        <?php echo $receive; ?>
                    </span> item/s</p>
            </div>
        </div>
        <a href="received-documents.php"
            class="flex items-center justify-center gap-1 text-xs font-bold text-green-950 bg-green-100 rounded-b-xl p-3 select-none">
            View Documents
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>
    <!-- Card 4 -->
    <div class="bg-neutral-50 flex flex-col rounded-xl basis-[246px]">
        <div class="flex gap-6 items-center p-3">
            <i class="bx bxs-file-export fa-2x text-4xl text-green-300"></i>
            <div>
                <h1 class="font-bold text-xs text-gray-500 uppercase">Pulled Documents</h1>
                <p class="uppercase font-bold text-xs"><span class="text-2xl">
                        <?php echo $pulled; ?>
                    </span> item/s</p>
            </div>
        </div>
        <a href="pulled-documents.php"
            class="flex items-center justify-center gap-1 text-xs font-bold text-green-950 bg-green-100 rounded-b-xl p-3 select-none">
            View Documents
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>
    <!-- Card 5 -->
    <div class="bg-neutral-50 flex flex-col rounded-xl basis-[246px]">
        <div class="flex gap-6 items-center p-3">
            <i class="bx bxs-file-import fa-2x text-4xl text-green-300"></i>
            <div>
                <h1 class="font-bold text-xs text-gray-500 uppercase">Complete Documents</h1>
                <p class="uppercase font-bold text-xs"><span class="text-2xl">
                        <?php echo $complete; ?>
                    </span> item/s</p>
            </div>
        </div>
        <a href="completed-documents.php"
            class="flex items-center justify-center gap-1 text-xs font-bold text-green-950 bg-green-100 rounded-b-xl p-3 select-none">
            View Documents
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>
    <!-- Card 6 -->
    <div class="bg-neutral-50 flex flex-col rounded-xl basis-[246px]">
        <div class="flex gap-6 items-center p-3">
            <i class="bx bx-file fa-2x text-4xl text-green-300"></i>
            <div>
                <h1 class="font-bold text-xs text-gray-500 uppercase">Incomplete Documents</h1>
                <p class="uppercase font-bold text-xs"><span class="text-2xl">
                        <?php echo $incomplete; ?>
                    </span> item/s</p>
            </div>
        </div>
        <a href="incomplete-documents.php"
            class="flex items-center justify-center gap-1 text-xs font-bold text-green-950 bg-green-100 rounded-b-xl p-3 select-none">
            View Documents
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>
</div>
</main>
<?php require 'template/bottom-template.php'; ?>
