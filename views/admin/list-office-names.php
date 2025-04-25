<?php require 'template/top-template.php'; ?>
<?php
// require '../../connection.php';

$doctypeQuery = "SELECT * FROM tbl_offices";
$statement = $pdo->prepare($doctypeQuery);
$statement->execute();
$offices = $statement->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="p-10 bg-neutral-50 m-5 rounded-md shadow-xl">
    <table id="mainTable" class="hover stripe">
        <thead class="text-green-900 border-b-1 border-b-gray-300  font-bold rounded-full">
            <tr>
                <th>Office Name</th>
                <th>Office Code</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($offices as $row) { ?>
                <tr>

                    <td>
                        <?php echo $row['office_name'] ?>
                    </td>
                    <td>
                        <?php echo $row['office_code'] ?>
                    </td>
                    <td style="text-align: right;">
                        <button data-id="<?php echo $row['id'] ?>" data-office="<?php echo $row['office_name'] ?>"
                            data-code="<?php echo $row['office_code'] ?>" class="px-4 py-0.5 rounded-sm cursor-pointer 
                                text-green-700 shadow-xs-1 hover:text-green-900 edit-button">Edit</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</main>

<div class="fixed w-full min-h-full hidden animate-fade-in" id="newDocModal">
    <div class="h-full w-full absolute bg-black z-10 opacity-20 doc-modal"></div>
    <div
        class="flex flex-col gap-2 relative m-auto top-50 p-5 bg-neutral-50 z-100 rounded-xl shadow-xl max-w-[456px] doc-modal">
        <div class="flex justify-between border-b-1 border-b-neutral-200 py-3">
            <h1 class="font-bold text-lg ">New Office</h1>
            <button type="button" class="self-center cursor-pointer p-1 close-btn">
                <div class="w-3 bg-black py-[1px] relative rotate-45 select-none close-btn"></div>
                <div class="w-3 bg-black py-[1px] relative bottom-[2px] -rotate-45 select-none close-btn"></div>
            </button>
        </div>
        <form class="flex flex-col gap-2" id="addNewOffice">
            <label for="office_name">Office Name:</label>
            <input type="text" class="p-2 border-neutral-300 border-1 rounded-md 
            focus-visible:outline-green-500 focus-visible:outline-1.5" id="documentType" name="office_name"
                placeholder="Enter office name" required>
            <label for="office_code">Office Code:</label>
            <input type="text" class="p-2 border-neutral-300 border-1 rounded-md 
            focus-visible:outline-green-500 focus-visible:outline-1.5" id="officeCode" name="office_code"
                placeholder="Enter office code" required>
            <button type="submit" class="bg-green-500 rounded-md py-2 px-5
                self-end text-green-50 cursor-pointer hover:bg-green-600" id="addNewOfficebtn">Add</button>
        </form>
    </div>
</div>

<div class="fixed w-full min-h-full hidden animate-fade-in" id="editDocModal">
    <div class="h-full w-full absolute bg-black z-10 opacity-20 doc-modal"></div>
    <div
        class="flex flex-col gap-2 relative m-auto top-50 p-5 bg-neutral-50 z-100 rounded-xl shadow-xl max-w-[456px] doc-modal">
        <div class="flex justify-between border-b-1 border-b-neutral-200 py-3">
            <h1 class="font-bold text-lg ">Edit Office</h1>
            <button type="button" class="self-center cursor-pointer p-1 close-btn">
                <div class="w-3 bg-black py-[1px] relative rotate-45 select-none close-btn"></div>
                <div class="w-3 bg-black py-[1px] relative bottom-[2px] -rotate-45 select-none close-btn"></div>
            </button>
        </div>
        <form class="flex flex-col gap-2" id="editofficeinfo">
            <label for="edit_office_name">Office Name:</label>
            <input type="text" class="p-2 border-neutral-300 border-1 rounded-md 
            focus-visible:outline-green-500 focus-visible:outline-1.5" id="editOfficeName" name="edit_office_name"
                placeholder="Enter office name" required>
            <label for="edit_office_code">Office Code:</label>
            <input type="text" class="p-2 border-neutral-300 border-1 rounded-md 
            focus-visible:outline-green-500 focus-visible:outline-1.5" id="editOfficeCode" name="edit_office_code"
                placeholder="Enter office code" required>
            <button type="submit" class="bg-green-500 rounded-md py-2 px-5
                self-end text-green-50 cursor-pointer hover:bg-green-600" id="editofficeinfobtn">Save Changes</button>
        </form>
    </div>
</div>
