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
    if ($result['status'] == 'pending') {
        $href = 'pending-account.php';
    } else {
        if ($type != 'guest') {
            $href = 'offices.php';
        } else {
            $href = 'guest.php';
        }
    }


    // print_r($result);
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
        <button type="button" onclick="history.back()"
            class="text-sm m-0 py-1 px-3 bg-gray-400 text-neutral-200 rounded-sm font-normal hover:bg-gray-500 flex items-center gap-1"><i
                class='bx bx-arrow-back text-base'></i> Back</button>
    </div>

    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-3">
            <label for="input1" class="block text-sm/6 font-medium text-gray-900">First Name</label>
            <div class="mt-2">
                <input type="text" name="first-name" id="input1" autocomplete="given-name" class="block w-full rounded-md bg-neutral-200 px-3 py-1.5
                    text-base text-gray-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-900 sm:text-sm/6"
                    value="<?php echo $result['firstname']; ?>" placeholder="N/A" readonly>
            </div>
        </div>

        <div class="sm:col-span-3">
            <label for="last-name" class="block text-sm/6 font-medium text-gray-900">Last Name</label>
            <div class="mt-2">
                <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="block w-full rounded-md bg-neutral-200 px-3 py-1.5
                    text-base text-gray-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6" value="<?php echo $result['lastname']; ?>"
                    placeholder="N/A" readonly>
            </div>
        </div>

        <div class="sm:col-span-4">
            <label for="email" class="block text-sm/6 font-medium text-gray-900">Email Address</label>
            <div class="mt-2">
                <input type="email" name="email" id="email" autocomplete="email" class="block w-full rounded-md bg-neutral-200 px-3 py-1.5
                    text-base text-gray-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-900 sm:text-sm/6" value="<?php echo $result['email']; ?>"
                    placeholder="N/A" readonly>
            </div>
        </div>

        <div class="sm:col-span-2">
            <label for="contactNo" class="block text-sm/6 font-medium text-gray-900">Contact Number</label>
            <div class="mt-2">
                <input type="text" name="contactNo" id="contactNo" autocomplete="contact-number" class="block w-full rounded-md bg-neutral-200 px-3 py-1.5
                    text-base text-gray-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-900 sm:text-sm/6" value="<?php echo $result['contact']; ?>"
                    placeholder="N/A" readonly>
            </div>
        </div>

        <div class="sm:col-span-3">
            <label for="position" class="block text-sm/6 font-medium text-gray-900">Position</label>
            <div class="mt-2">
                <input type="text" name="position" id="position" autocomplete="position" class="block w-full rounded-md bg-neutral-200 px-3 py-1.5
                    text-base text-gray-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-900 sm:text-sm/6" value="<?php echo $result['position']; ?>"
                    placeholder="N/A" readonly>
            </div>
        </div>

        <div class="sm:col-span-3">
            <label for="role" class="block text-sm/6 font-medium text-gray-900">Role</label>
            <div class="mt-2">
                <input type="text" name="role" id="role" autocomplete="role" class="block w-full rounded-md bg-neutral-200 px-3 py-1.5
                    text-base text-gray-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-900 sm:text-sm/6" value="<?php echo $result['role']; ?>"
                    placeholder="N/A" readonly>
            </div>
        </div>

        <div class="sm:col-span-full">
            <label for="office" class="block text-sm/6 font-medium text-gray-900">Office</label>
            <div class="mt-2">
                <input type="text" name="office" id="office" autocomplete="office" class="block w-full rounded-md bg-neutral-200 px-3 py-1.5
                    text-base text-gray-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-900 sm:text-sm/6" value="<?php echo $result['office']; ?>"
                    placeholder="N/A" readonly>
            </div>
        </div>

    </div>
</div>
</main>
