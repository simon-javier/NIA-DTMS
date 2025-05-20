<?php
require '../../connection.php';

$doctypeQuery = "SELECT * FROM tbl_document_type";
$statement = $pdo->prepare($doctypeQuery);
$statement->execute();
$doctypes = $statement->fetchAll(PDO::FETCH_ASSOC);

$internalOffice = "SELECT * FROM tbl_userinformation where role = 'handler' and status != 'archived' and office != 'Administrative Section Records'";
$statement = $pdo->prepare($internalOffice);
$statement->execute();
$internaloffice = $statement->fetchAll(PDO::FETCH_ASSOC);



$officesQuery = "SELECT DISTINCT tbl_offices.office_name FROM tbl_offices 
                 JOIN tbl_userinformation ON tbl_offices.office_name = tbl_userinformation.office where tbl_offices.office_name != 'Administrative Section Records' and tbl_userinformation.status != 'archived'";

$statement = $pdo->prepare($officesQuery);
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
                <label for="from_external" class="block text-sm/6 font-medium text-neutral-900">From</label>
                <div class="mt-2 internal-section">
                    <input type="hidden" name="from_internal" id="from_internal"
                        value="<?php echo $_SESSION['fullname'] ?>">
                    <input type="hidden" name="sender_id" id="sender_id" value="<?php echo $_SESSION['userid'] ?>">
                </div>
                <div class="sm:flex sm:gap-3">
                    <input id="from_external" name="from_external" rows="3" placeholder="e.g., Simon Javier"
                        class="block w-11/12 rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 disabled:border-gray-200 disabled:bg-gray-100 disabled:text-gray-500 disabled:shadow-none"
                        disabled>
                    <div class="mt-2 sm:mt-0 flex gap-1 items-center">
                        <input class="accent-green-600 hover:accent-green-700" type="checkbox" onclick="checkExternal()"
                            name="isexternal" id="isexternal">
                        <input type="hidden" name="source" id="source" value="internal">
                        <label class="form-check-label" for="isexternal">Is external?</label>
                    </div>
                </div>
            </div>

            <div class="sm:col-span-full">
                <label for="receiver_office" class="block text-sm/6 font-medium text-neutral-900">Send To:</label>
                <div class="mt-2 grid grid-cols-1">
                    <select id="receiver_office" name="receiver_office"
                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-neutral-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 sm:text-sm/6"
                        data-live-search="true">
                        <option value="" selected>Select Office</option>
                        <?php foreach ($offices as $office) { ?>
                            <option value="<?php echo $office['office_name']; ?>">
                                <?php echo $office['office_name']; ?>
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

            <div class="sm:col-span-full">
                <label for="file" class="block text-sm/6 font-medium text-neutral-900">Send Attachments</label>
                <div class="mt-2">
                    <input type="file" id="file" name="file" rows="3"
                        class="w-full text-gray-400 text-sm bg-neutral-50 file:cursor-pointer cursor-pointer file:outline-0 file:py-2 file:px-4 file:mr-4 file:bg-black hover:file:bg-gray-900 file:text-white rounded"
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
<script>
    function checkExternal() {
        // Get the checkbox element
        var checkbox = document.getElementById("isexternal");
        var input = document.getElementById("source");
        var from_internal = document.getElementById("internal-section");
        var from_external = document.getElementById("from_external");
        var from_label = document.getElementById("from_label");


        // Check if the checkbox is checked
        if (checkbox.checked) {
            // The checkbox is checked, set a variable or perform an action for external
            input.value = "guest";
            from_external.disabled = false;
        } else {
            // The checkbox is not checked, set a variable or perform an action for internal
            input.value = "internal";
            from_external.disabled = true;
        }
    }
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById("from_internal").addEventListener("change", function() {
            var selectedOption = this.options[this.selectedIndex];
            var internalId = selectedOption.getAttribute("data-id");
            document.getElementById("sender_id").value = internalId;
        });

        var timeoutId;

        $(document).ready(function() {
            $('#docu_code').on('input', function() {

                clearTimeout(timeoutId);


                var docuCode = $(this).val();


                timeoutId = setTimeout(function() {

                    $.ajax({
                        url: '../../controller/qr-code-controller.php',
                        method: 'POST',
                        data: {
                            docu_code: docuCode
                        },
                        dataType: 'json',
                        success: function(response) {
                            // Update the QR code image source
                            if (response.status == 'success') {
                                $("#file_name").val(response.qrCodeData);
                                $('#qrCodeImage').attr('src', '<?php echo $env_basePath; ?>assets/qr-codes/' + response.qrCodeData);
                            } else {
                                Swal.fire({
                                    title: 'Failed!',
                                    text: 'Document code already exists.',
                                    icon: 'warning',
                                    confirmButtonText: 'OK'
                                });
                            }

                        },
                        error: function(xhr, status, error) {
                            // Handle the error here
                            var errorMessage = 'An error occurred while processing your request.';
                            if (xhr.statusText) {
                                errorMessage += ' ' + xhr.statusText;
                            }
                            Swal.fire({
                                title: 'Error!',
                                text: errorMessage + '<br><br>' + JSON.stringify(xhr, null, 2), // Include the entire error object for debugging
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                // Check if the user clicked the "OK" button
                                if (result.isConfirmed) {
                                    // Reload the page
                                    location.reload();
                                }
                            });
                        }
                    });
                }, 1000); //(1 second)
            });
        });


        var fileInput = document.getElementById('file');

        fileInput.addEventListener('change', function() {
            var selectedFile = this.files[0];

            // Check if a file is selected
            if (selectedFile) {
                // Check file type
                var allowedTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'image/jpeg', 'image/png'];
                if (!allowedTypes.includes(selectedFile.type)) {
                    showError('Please select a valid file type (PDF, DOCX, Excel, JPEG, PNG, etc.).');
                    resetFileInput();
                    return;
                }

                // Check file size (in bytes)
                var maxSize = 3 * 1024 * 1024; // 3 MB
                if (selectedFile.size > maxSize) {
                    showError('File size should be less than 3 MB.');
                    resetFileInput();
                    return;
                }
                showError("");
            }
        });

        function showError(message) {
            $("#attachmentError").text(message);
        }

        function resetFileInput() {
            fileInput.value = '';
        }

        var textarea = document.getElementById('description');
        var charCount = document.getElementById('charCount');

        textarea.addEventListener('input', function() {
            var maxLength = 250;
            var currentLength = textarea.value.length;

            if (currentLength > maxLength) {
                textarea.value = textarea.value.substring(0, maxLength);
                currentLength = maxLength;
            }

            charCount.textContent = currentLength + '/' + maxLength;
        });

        $("#upload_docu_button").click(function(e) {

            if ($("#upload_docu_form")[0].checkValidity()) {
                e.preventDefault();

                $('.loader-container').fadeIn();
                var formData = new FormData($("#upload_docu_form")[0]);
                formData.append("action", "upload_document");

                $.ajax({
                    url: "../../controller/upload-docu-controller.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                        setTimeout(function() {

                            $('.loader-container').fadeOut();
                        }, 500);

                        if (response.status === "failed") {
                            Swal.fire({
                                title: 'Something went wrong!',
                                text: response.message,
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        } else if (response.status === "error") {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else if (response.status === "success") {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "print_qr_code.php?docu_code=" + response.docu_code;

                                }
                            });
                        }


                    },
                    error: function(xhr, status, error) {
                        // Handle the error here
                        var errorMessage = 'An error occurred while processing your request.';
                        if (xhr.statusText) {
                            errorMessage += ' ' + xhr.statusText;
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage + '<br><br>' + JSON.stringify(xhr, null, 2), // Include the entire error object for debugging
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            // Check if the user clicked the "OK" button
                            if (result.isConfirmed) {
                                // Reload the page
                                location.reload();
                            }
                        });
                    }
                });
            }
        });
    })
</script>
