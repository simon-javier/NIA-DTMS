<?php
require '../../connection.php';

$doctypeQuery = "SELECT * FROM tbl_document_type";
$statement = $pdo->prepare($doctypeQuery);
$statement->execute();
$doctypes = $statement->fetchAll(PDO::FETCH_ASSOC);

$internalOffice = "SELECT * FROM tbl_userinformation where role = 'internal'";
$statement = $pdo->prepare($internalOffice);
$statement->execute();
$offices = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require 'template/top-template.php'; ?>

<div class="border-b border-gray-900/10 p-12 rounded-md bg-neutral-50 w-[95%] self-center my-10">
    <form id='upload_docu_form' autocomplete="off" enctype="multipart/form-data">
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-full">
                <label for="subject" class="block text-sm/6 font-medium text-neutral-900">Subject</label>
                <div class="mt-2">
                    <input type="text" name="subject" id="subject"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600"
                        placeholder="e.g., Request for Transcript of Records" required>
                </div>
            </div>

            <div class="sm:col-span-full">
                <label for="doc_type" class="block text-sm/6 font-medium text-neutral-900">Document Type</label>
                <div class="mt-2 grid grid-cols-1">
                    <select id="doc_type" name="doc_type"
                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-neutral-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 sm:text-sm/6">
                        <?php foreach ($doctypes as $doctype) { ?>
                            <option value="<?php echo $doctype['document_type']; ?>">
                                <?php echo $doctype['document_type']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd"
                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            <div class="col-span-full">
                <label for="description" class="block text-sm/6 font-medium text-neutral-900">Description</label>
                <div class="mt-2">
                    <textarea name="description" id="description" rows="3" placeholder="Brief summary of the document"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 sm:text-sm/6"></textarea>
                    <div class="flex justify-end text-xs text-neutral-500 mt-1">
                        <p id="charCount">0/250</p>
                    </div>
                </div>
            </div>

            <div class="sm:col-span-full">
                <label for="document_date" class="block text-sm/6 font-medium text-neutral-900">Document Date</label>
                <div class="mt-2">
                    <input type="date" name="document_date" id="document_date"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5 
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" required>
                </div>
            </div>

            <div class="sm:col-span-full">
                <label for="required_action" class="block text-sm/6 font-medium text-neutral-900">Action
                    Required</label>
                <div class="mt-2">
                    <input list="action_required_list" id="required_action" name="required_action" rows="3"
                        placeholder="e.g., For approval, For review, For signature"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" required>
                </div>
            </div>

            <div class="sm:col-span-full">
                <label for="file" class="block text-sm/6 font-medium text-neutral-900">Send Attachments</label>
                <div class="mt-2">
                    <input type="file" id="file" name="file" rows="3"
                        class="w-full text-gray-400 text-sm bg-neutral-50 file:cursor-pointer cursor-pointer file:outline-0 file:py-2 file:px-4 file:mr-4 file:bg-green-900 hover:file:bg-green-950 file:text-white rounded"
                        required>
                    <p id="attachmentError" style="color: red;"></p>
                </div>
            </div>

        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="reset"
                class="cursor-pointer text-sm/6 font-semibold text-gray-900 hover:text-gray-900/80">Clear</button>
            <button type="submit" id="upload_docu_button"
                class="cursor-pointer rounded-md disabled:bg-gray-500 disabled:cursor-default bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Submit</button>
        </div>
    </form>
</div>

<datalist id="action_required_list">
    <option value="For appropirate action">
    <option value="For comments/recommendation">
    <option value="For initial/signature">
    <option value="For information/reference/file">
    <option value="Please follow-up and report action taken">
    <option value="Please see me">
    <option value="For inspection">
    <option value="For compliance">

</datalist>
</main>

<script src="../../assets/js/submit-document.js"></script>
