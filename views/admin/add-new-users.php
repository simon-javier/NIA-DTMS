<!-- TODO: validation and renaming -->

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
                <label for="input1" class="block text-sm/6 font-medium text-neutral-900">First Name</label>
                <div class="mt-2">
                    <input type="text" name="firstname" id="input1" autocomplete="given-name"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                        outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" placeholder="e.g., Juan" required>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="last-name" class="block text-sm/6 font-medium text-neutral-900">Last Name</label>
                <div class="mt-2">
                    <input type="text" name="lastname" id="last-name" autocomplete="family-name"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" placeholder="e.g., Dela Cruz" required>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="email" class="block text-sm/6 font-medium text-neutral-900">Email Address</label>
                <div class="mt-2">
                    <input type="email" name="email" id="email" autocomplete="email"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600"
                        placeholder="e.g., juan.delacruz@email.com" required>
                </div>
            </div>
            <div class="sm:col-span-3">
                <label for="email" class="block text-sm/6 font-medium text-neutral-900">Confirm Email Address</label>
                <div class="mt-2">
                    <input type="email" name="conemail" id="conemail" autocomplete="email"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" placeholder="e.g., juan.delacruz@email.com"
                        required>
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="contactNo" class="block text-sm/6 font-medium text-neutral-900">Contact Number</label>
                <div class="mt-2">
                    <input type="text" name="contact" id="contactNo" autocomplete="contact-number"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" placeholder="e.g., 09123456789" required>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="position" class="block text-sm/6 font-medium text-neutral-900">Position</label>
                <div class="mt-2">
                    <input type="text" name="position" id="position" autocomplete="position"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" placeholder="N/A" required>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="role" class="block text-sm/6 font-medium text-neutral-900">Role</label>
                <div class="mt-2">
                    <input type="text" name="role" id="role" autocomplete="role"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" placeholder="N/A" required>
                </div>
            </div>

            <div class="sm:col-span-full">
                <label for="office" class="block text-sm/6 font-medium text-neutral-900">Office</label>
                <div class="mt-2">
                    <input type="text" name="office" id="office" autocomplete="office"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" placeholder="N/A" required>
                </div>
            </div>
            <input type="hidden" id="account_type" name="account_type">
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="<?php echo $href ?>"
                class="cursor-pointer text-sm/6 font-semibold text-gray-900 hover:text-gray-900/80">Cancel</a>
            <button type="submit" id="update_information_button"
                class="cursor-pointer rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Update</button>
        </div>
    </form>
</div>
</main>
