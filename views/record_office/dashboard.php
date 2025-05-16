<?php require 'template/top-template.php'; ?>
<?php
require '../../connection.php';
$sql = "SELECT COUNT(*) as count FROM tbl_uploaded_document WHERE data_source = 'guest' AND status = 'pending' AND status != 'pulled'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$count = $result['count'];

$trackDocument = "SELECT COUNT(*) as count FROM tbl_uploaded_document WHERE status != 'pulled'";
$stmt = $pdo->prepare($trackDocument);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$count1 = $result['count'];


?>

<!-- Cards -->
<div class="flex items-center justify-center flex-wrap gap-16 mt-18">
    <!-- Card 1 -->
    <div class="bg-neutral-50 flex flex-col rounded-xl basis-[246px]">
        <div class="flex gap-6 items-center p-3">
            <i class="bx bx-mail-send text-3xl text-green-300"></i>
            <div>
                <h1 class="font-bold text-xs text-gray-500 uppercase">New Documents</h1>
                <p class="uppercase font-bold text-xs"><span class="text-2xl">
                        <?php echo $count; ?>
                    </span> item/s</p>
            </div>
        </div>
        <a href="newly-created-docs.php"
            class="flex items-center justify-center gap-1 text-xs font-bold text-green-950 bg-green-100 rounded-b-xl p-3 select-none">
            View Documents
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>
    <!-- Card 2 -->
    <div class="bg-neutral-50 flex flex-col rounded-xl basis-[246px]">
        <div class="flex gap-6 items-center p-3">
            <i class="fa-solid fa-users text-4xl text-green-300"></i>
            <div>
                <h1 class="font-bold text-xs text-gray-500 uppercase">All Documents</h1>
                <p class="uppercase font-bold text-xs"><span class="text-2xl">
                        <?php echo $count1; ?>
                    </span> item/s</p>
            </div>
        </div>
        <a href="document-tracking.php"
            class="flex items-center justify-center gap-1 text-xs font-bold text-green-950 bg-green-100 rounded-b-xl p-3 select-none">
            View Documents
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>
</div>
</main>
</body>

</html>
