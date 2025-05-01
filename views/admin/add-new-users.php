<?php require 'template/top-template.php'; ?>

<?php
require '../../connection.php';

$type = $_GET['type'];
if ($type == 'handler') {
    $href = 'offices.php';
} else {
    $href = 'guest.php';
}

$sql = "SELECT * from tbl_offices";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$offices = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="border-b border-gray-900/10 p-12 rounded-md bg-neutral-50 w-[95%] self-center mt-10">
    <form id='user_form' autocomplete="off">
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-full">
                <label for="username" class="block text-sm/6 font-medium text-neutral-900">Username</label>
                <div class="mt-2">
                    <input type="text" name="username" id="username" autocomplete="given-name"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" placeholder="Enter your username" required>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="firstName" class="block text-sm/6 font-medium text-neutral-900">First Name</label>
                <div class="flex flex-col mt-2">
                    <input type="text" name="firstName" id="firstName" autocomplete="given-name"
                        oninput="checkForNumbers('firstName', 'error-firstname')"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                        outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" placeholder="e.g., Juan"
                        required>
                    <p class="mt-2 text-red-600 text-xs hidden" id="error-firstname"></p>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="lastName" class="block text-sm/6 font-medium text-neutral-900">Last Name</label>
                <div class="mt-2 flex flex-col">
                    <input type="text" name="lastName" id="lastName" autocomplete="family-name"
                        oninput="checkForNumbers('lastName', 'error-lastname')"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" placeholder="e.g., Dela Cruz"
                        required>
                    <p class="mt-2 text-red-600 text-xs hidden" id="error-lastname"></p>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="email" class="block text-sm/6 font-medium text-neutral-900">Email Address</label>
                <div class="mt-2">
                    <input type="email" name="email" id="email" autocomplete="email" oninput="validateEmails()"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" placeholder="e.g., juan.delacruz@email.com" required>
                    <p class="mt-2 text-red-600 text-xs hidden" id="error-email"></p>
                </div>
            </div>
            <div class="sm:col-span-3">
                <label for="email" class="block text-sm/6 font-medium text-neutral-900">Confirm Email Address</label>
                <div class="mt-2">
                    <input type="email" name="conemail" id="conemail" autocomplete="email" oninput="validateEmails()"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600"
                        placeholder="e.g., juan.delacruz@email.com" required>
                    <p class="mt-2 text-red-600 text-xs hidden" id="error-conemail"></p>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="contact" class="block text-sm/6 font-medium text-neutral-900">Contact Number</label>
                <div class="mt-2">
                    <input type="number" name="contact" id="contact" autocomplete="contact-number"
                        oninput="validateContactNumber()"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600"
                        placeholder="e.g., 09123456789" required>
                    <p class="mt-2 text-red-600 text-xs hidden" style="color:red" id="error-number"></p>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="position" class="block text-sm/6 font-medium text-neutral-900">Position</label>
                <div class="mt-2">
                    <input type="text" name="position" id="position" autocomplete="position"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" placeholder="N/A">
                </div>
            </div>


            <div class="sm:col-span-full">
                <label for="office" class="block text-sm/6 font-medium text-neutral-900">Office</label>
                <div class="mt-2 grid grid-cols-1">
                    <select id="office" name="office" autocomplete="office-name"
                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-neutral-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 sm:text-sm/6">
                        <?php foreach ($offices as $office) { ?>
                            <option value="<?php echo $office['office_name'] ?>">
                                <?php echo $office['office_name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                    <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                        viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd"
                            d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                            clip-rule="evenodd" />
                    </svg>
                    <input type="hidden" name="office_code" id="office_code">
                </div>
            </div>

            <input type="hidden" class="form-control" id="role" value="<?php echo $type; ?>" name="role" required
                readonly>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="<?php echo $href ?>"
                class="cursor-pointer text-sm/6 font-semibold text-gray-900 hover:text-gray-900/80">Cancel</a>
            <button type="submit" id="add_user_btn" disabled
                class="cursor-pointer rounded-md disabled:bg-gray-500 disabled:cursor-default bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Add
                User</button>
        </div>
    </form>
</div>
</main>


<script>
    let checknum = true;
    let checkcontact = true;
    let checkemail = true;


    function checkForNumbers(inputId, errorId) {
        let input = document.getElementById(inputId);
        let error = document.getElementById(errorId);

        if (/^\D*$/.test(input.value)) {

            error.classList.add("hidden");
            error.textContent = "";
            checknum = false;
        } else {
            error.classList.remove("hidden");
            error.textContent = "Should not contain numbers";
            checknum = true;
        }
        enableRegisterButton();
    }

    function validateContactNumber() {
        let input = document.getElementById('contact');
        let error = document.getElementById('error-number');


        if (/^0\d{10}$/.test(input.value)) {
            error.classList.add("hidden");
            error.textContent = "";
            checkcontact = false;
        } else {

            error.classList.remove("hidden");
            error.textContent = "Invalid contact number";
            checkcontact = true;
        }
        enableRegisterButton();
    }

    function validateEmails() {
        let email = document.getElementById('email');
        let conemail = document.getElementById('conemail');
        let errorEmail = document.getElementById('error-email');
        let errorConemail = document.getElementById('error-conemail');


        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (emailPattern.test(email.value)) {
            errorEmail.textContent = "";
            errorEmail.classList.add("hidden");
        } else {
            errorEmail.textContent = "Invalid email address";
            errorEmail.classList.remove("hidden");
        }

        if (conemail.value) {
            if (email.value === conemail.value) {
                errorConemail.textContent = "";
                errorConemail.classList.add("hidden");
                checkemail = false;
            } else {
                errorConemail.textContent = "Email addresses do not match";
                errorConemail.classList.remove("hidden");
                checkemail = true;
            }
        }
        enableRegisterButton();

    }


    function enableRegisterButton() {
        // Enable or disable the button based on the presence of errors
        let registerButton = document.getElementById('add_user_btn');
        registerButton.disabled = checknum || checkcontact || checkemail;
    }
</script>

<script>
    let type = "<?php echo $type; ?>";


    function toggleFields() {
        let positionField = document.getElementById("position");
        let officeField = document.getElementById("office");

        if (type === "guest") {
            positionField.parentNode.parentNode.classList.add("hidden");
            officeField.parentNode.parentNode.classList.add("hidden");

            // Remove the 'required' attribute
            positionField.removeAttribute("required");
            officeField.removeAttribute("required");
        } else {
            positionField.parentNode.parentNode.classList.remove("hidden");
            officeField.parentNode.parentNode.classList.remove("hidden");

            // Add the 'required' attribute
            positionField.setAttribute("required", "required");
            officeField.setAttribute("required", "required");
        }
    }


    toggleFields();
</script>

<script>
    // Function to get the office_code of the selected office
    function getOfficeCode(selectedOffice) {
        // Assuming $offices is a PHP array containing 'office_name' and 'office_code'
        let offices = <?php echo json_encode($offices); ?>;
        debugger;

        // Find the selected office in the offices array
        let selectedOfficeObject = offices.find(function(office) {
            return office.office_name === selectedOffice;
        });

        // Return the office_code if found, otherwise an empty string
        return selectedOfficeObject ? selectedOfficeObject.office_code : '';
    }

    // Function to update the office_code based on the selected office
    function updateOfficeCode() {
        let selectedOffice = document.getElementById('office').value;
        let officeCodeInput = document.getElementById('office_code');

        // Get the office_code based on the selected office
        let officeCode = getOfficeCode(selectedOffice);

        // Set the value of the office_code input
        officeCodeInput.value = officeCode;
    }

    // Initial call to set the initial state
    updateOfficeCode();

    // Add an event listener to the office dropdown
    document.getElementById('office').addEventListener('change', updateOfficeCode);
</script>
