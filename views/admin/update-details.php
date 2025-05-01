<?php require 'template/top-template.php'; ?>

<?php
require '../../connection.php';
$id = $_GET['id'];
try {
    //code...
    $get_user_data = "
           select * from tbl_userinformation where id = '$id';
        ";
    $stmt = $pdo->prepare($get_user_data);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $type = $result['role'];

    if ($type != 'guest') {
        $href = 'offices.php';
    } else {
        $href = 'guest.php';
    }

    $officesQuery = "SELECT * FROM tbl_offices";
    $stmt = $pdo->prepare($officesQuery);
    $stmt->execute();
    $list_offices = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\PDOException $th) {
    echo "Error: " . $th->getMessage();
}
?>

<div class="border-b border-gray-900/10 p-12 rounded-md bg-neutral-50 w-[95%] self-center mt-10">
    <div class="flex justify-between">
        <p>
            <span class="badge
                <?php
                $className = '';
                switch ($result['status']) {
                    case 'active':
                        $className = " bg-green-600 text-neutral-50 p-1 text-xs font-bold rounded-md";
                        break;
                    case 'archived':
                        $className = "bg-blue-500 text-neutral-50 p-1 text-xs font-bold rounded-md";
                        break;
                    case 'pending':
                        $className = "bg-yellow-500 text-neutral-50 p-1 text-xs font-bold rounded-md";
                        break;
                    default:
                        $className = "bg-red-600 text-neutral-50 p-1 text-xs font-bold rounded-md";
                        break;
                }
                echo
                $className; ?>"
                style="text-transform: uppercase;">
                <?php echo $result['status']; ?>
            </span>
        </p>
    </div>

    <form id='update_information'>
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <input type="hidden" value="<?php echo $id ?>" name="id" readonly>
            <div class="sm:col-span-3">
                <label for="input1" class="block text-sm/6 font-medium text-neutral-900">First Name</label>
                <div class="mt-2">
                    <input type="text" name="firstname" id="input1" autocomplete="given-name"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-neutral-900 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" value="<?php echo $result['firstname']; ?>"
                        placeholder="N/A" required>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="last-name" class="block text-sm/6 font-medium text-neutral-900">Last Name</label>
                <div class="mt-2">
                    <input type="text" name="lastname" id="last-name" autocomplete="family-name"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" value="<?php echo $result['lastname']; ?>"
                        placeholder="N/A" required>
                </div>
            </div>

            <div class="sm:col-span-4">
                <label for="email" class="block text-sm/6 font-medium text-neutral-900">Email Address</label>
                <div class="mt-2">
                    <input type="email" name="email" id="email" autocomplete="email"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-neutral-900 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600"
                        value="<?php echo $result['email']; ?>" placeholder="N/A" required>
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="contactNo" class="block text-sm/6 font-medium text-neutral-900">Contact Number</label>
                <div class="mt-2">
                    <input type="text" name="contact" id="contactNo" autocomplete="contact-number"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-neutral-900 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" value="<?php echo $result['contact']; ?>"
                        placeholder="N/A" required>
                </div>
            </div>

            <div class="sm:col-span-full">
                <label for="position" class="block text-sm/6 font-medium text-neutral-900">Position</label>
                <div class="mt-2">
                    <input type="text" name="position" id="position" autocomplete="position"
                        class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-neutral-900 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600" value="<?php echo $result['position']; ?>"
                        placeholder="N/A">
                </div>
            </div>


            <?php if ($type == "handler") { ?>
                <div class="sm:col-span-full">
                    <label for="office" class="block text-sm/6 font-medium text-neutral-900">Office</label>
                    <div class="mt-2 grid grid-cols-1">
                        <select name="office" id="office"
                            class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-neutral-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 sm:text-sm/6">
                            <?php foreach ($list_offices as $office): ?>
                                <option value="<?php echo $office['office_name']; ?>" <?php echo ($office['office_name'] == $result['office']) ? 'selected' : ''; ?>>
                                    <?php echo $office['office_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                            viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            <?php } ?>

            <input type="hidden" id="account_type" name="account_type" value="<?php echo $type; ?>">
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
