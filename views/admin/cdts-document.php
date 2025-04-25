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
        <thead class="text-green-900 border-b-1 border-b-gray-300  font-bold rounded-full">
            <tr>
                <th class="">Document Type</th>
                <th class="">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($doctypes as $row) { ?>
            <tr>

                <td class="text-neutral-600">
                    <?php echo $row['document_type'] ?>
                </td>
                <td class="text-right">
                    <button data-id="<?php echo $row['id'] ?>" data-document="<?php echo $row['document_type'] ?>"
                        class="px-4 py-0.5 rounded-sm cursor-pointer 
                                text-green-700 shadow-xs-1 hover:text-green-900 edit-button">
                        Edit
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</main>
<div class="fixed w-full min-h-full hidden animate-fade-in" id="editDocModal">
    <div class="h-full w-full absolute bg-black z-10 opacity-20 doc-modal"></div>
    <div
        class="flex flex-col gap-2 relative m-auto top-50 p-5 bg-neutral-50 z-100 rounded-xl shadow-xl max-w-[456px] doc-modal">
        <div class="flex justify-between border-b-1 border-b-neutral-200 py-3">
            <h1 class="font-bold text-lg ">Edit Document Type</h1>
            <button type="button" class="self-center cursor-pointer p-1 close-btn">
                <div class="w-3 bg-black py-[1px] relative rotate-45 select-none close-btn"></div>
                <div class="w-3 bg-black py-[1px] relative bottom-[2px] -rotate-45 select-none close-btn"></div>
            </button>
        </div>
        <form class="flex flex-col gap-2" id="editDocumentForm">
            <label for="editDocumentType">Document Type:</label>
            <input type="text" class="p-2 border-neutral-300 border-1 rounded-md 
            focus-visible:outline-green-500 focus-visible:outline-1.5" id="editDocumentType" name="edit_document_type"
                placeholder="Enter document type" required>
            <input type="hidden" id="document_id" name="document_id" required>
            <button type="submit" class="bg-green-500 rounded-md py-2 px-5
                self-end text-green-50 cursor-pointer hover:bg-green-600" id="editDocumentFormbtn">Save
                Changes</button>
        </form>
    </div>
</div>
<div class="fixed w-full min-h-full hidden animate-fade-in" id="newDocModal">
    <div class="h-full w-full absolute bg-black z-10 opacity-20 doc-modal"></div>
    <div
        class="flex flex-col gap-2 relative m-auto top-50 p-5 bg-neutral-50 z-100 rounded-xl shadow-xl max-w-[456px] doc-modal">
        <div class="flex justify-between border-b-1 border-b-neutral-200 py-3">
            <h1 class="font-bold text-lg ">New Document</h1>
            <button type="button" class="self-center cursor-pointer p-1 close-btn">
                <div class="w-3 bg-black py-[1px] relative rotate-45 select-none close-btn"></div>
                <div class="w-3 bg-black py-[1px] relative bottom-[2px] -rotate-45 select-none close-btn"></div>
            </button>
        </div>
        <form class="flex flex-col gap-2" id="newDocumentForm">
            <p>Document Type:</p>
            <input type="text" class="p-2 border-neutral-300 border-1 rounded-md 
            focus-visible:outline-green-500 focus-visible:outline-1.5" id="documentType" name="document_type"
                placeholder="Enter document type" required>
            <button type="submit" class="bg-green-500 rounded-md py-2 px-5
                self-end text-green-50 cursor-pointer hover:bg-green-600" id="newDocumentFormbtn">Add</button>
        </form>
    </div>
</div>
</body>

</html>
