<?php require 'template/top-template.php'; ?>
<?php
$countAllUploadedDocuments = "SELECT COUNT(*) as all_documents from tbl_uploaded_document where status != 'Document pulled'";
$stmt = $pdo->prepare($countAllUploadedDocuments);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$allDocuCount = $result['all_documents'];

$countConfirmDisconfirmDocument = "SELECT COUNT(*) as complete_documents from tbl_uploaded_document where status like '%Document confirm by%' or status like '%Completed at%'";
$stmt = $pdo->prepare($countConfirmDisconfirmDocument);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$completedDocuCount = $result['complete_documents'];

$countOffices = "SELECT COUNT(*) as no_offices from tbl_login_account where role = 'handler' and status = 'active'";
$stmt = $pdo->prepare($countOffices);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$no_offices = $result['no_offices'];


$countExternal = "SELECT COUNT(*) as no_external from tbl_login_account where role = 'guest' and status = 'active'";
$stmt = $pdo->prepare($countExternal);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$no_external = $result['no_external'];

$doctypeQuery = "SELECT * FROM tbl_document_type";

$statement = $pdo->prepare($doctypeQuery);
$statement->execute();
$doctypes = $statement->fetchAll(PDO::FETCH_ASSOC);

$trackDocument = "SELECT * from tbl_uploaded_document where status != 'pulled' and status != 'pending' ORDER BY updated_at DESC";
$stmt = $pdo->prepare($trackDocument);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


$get_user_count = "
        SELECT COUNT(*)
        FROM tbl_login_account
        JOIN tbl_userinformation ON tbl_login_account.id = tbl_userinformation.id
        WHERE tbl_login_account.status = 'pending'
    ";
$stmt = $pdo->prepare($get_user_count);
$stmt->execute();

$count = $stmt->fetchColumn(); // Fetching the count directly




?>


<!-- Cards -->
<div class="flex items-center justify-center flex-wrap gap-16 mt-18">
    <!-- Card 1 -->
    <div class="bg-neutral-50 flex flex-col rounded-xl basis-[246px]">
        <div class="flex gap-6 items-center p-3">
            <i class="fa-solid fa-user text-3xl text-green-300"></i>
            <div>
                <h1 class="font-bold text-xs text-gray-500 uppercase">Guest Accounts</h1>
                <p class="uppercase font-bold text-xs"><span class="text-2xl"><?php echo $no_external; ?></span> User/s</p>
            </div>
        </div>
        <a href="./guest.php"
            class="flex items-center justify-center gap-1 text-xs font-bold text-green-950 bg-green-100 rounded-b-xl p-3 select-none">
            View Accounts
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>
    <!-- Card 2 -->
    <div class="bg-neutral-50 flex flex-col rounded-xl basis-[246px]">
        <div class="flex gap-6 items-center p-3">
            <i class="fa-solid fa-users text-4xl text-green-300"></i>
            <div>
                <h1 class="font-bold text-xs text-gray-500 uppercase">Document Handlers</h1>
                <p class="uppercase font-bold text-xs"><span class="text-2xl"><?php echo $no_offices; ?></span> User/s</p>
            </div>
        </div>
        <a href="./offices.php"
            class="flex items-center justify-center gap-1 text-xs font-bold text-green-950 bg-green-100 rounded-b-xl p-3 select-none">
            View Accounts
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>
    <!-- Card 3 -->
    <div class="bg-neutral-50 flex flex-col rounded-xl basis-[246px]">
        <div class="flex gap-6 items-center p-3">
            <i class="fa-solid fa-file text-3xl text-green-300"></i>
            <div>
                <h1 class="font-bold text-xs text-gray-500 uppercase">Incoming Registrations</h1>
                <p class="uppercase font-bold text-xs"><span class="text-2xl"><?php echo $count; ?></span> Item/s</p>
            </div>
        </div>
        <a href="./pending-account.php"
            class="flex items-center justify-center gap-1 text-xs font-bold text-green-950 bg-green-100 rounded-b-xl p-3 select-none">
            View Registrations
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>
</div>
</main>
</body>

</html>
