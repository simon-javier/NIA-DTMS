<?php require 'template/top-template.php'; ?>

<?php

$user_id = $_SESSION['userid'];
$officename = $_SESSION['office'];
try {
    //code...
    $docu_query = "SELECT tbl_handler_incoming.receive_at as date_receive, tbl_handler_incoming.*, tbl_uploaded_document.*  FROM tbl_handler_incoming JOIN tbl_uploaded_document ON tbl_handler_incoming.docu_id = tbl_uploaded_document.id where tbl_handler_incoming.user_id = :user_id and tbl_handler_incoming.status != 'notyetreceive' ORDER BY receive_at DESC";
    $stmt = $pdo->prepare($docu_query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $docu_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (\Throwable $th) {
    //throw $th;
    echo $th;
    exit;
}



?>

<div class="self-center bg-neutral-50 mt-5 p-10 w-[95%] rounded-md shadow-xl">
    <div class="flex gap-3 justify-end mb-5 items-center">
        <p>Filter by date</p>
        <div class="flex gap-2 items-center">
            <input type="text"
                class="block w-40 rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 disabled:border-gray-200 disabled:bg-gray-100 disabled:text-gray-500 disabled:shadow-none"
                id="min" name="min" placeholder="Start date">
            <input type="text"
                class="block w-40 rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 disabled:border-gray-200 disabled:bg-gray-100 disabled:text-gray-500 disabled:shadow-none"
                id="max" name="max" placeholder="End date">
            <p class="" onclick="refreshPage()" style="cursor: pointer"><i class='bx bx-reset'
                    style="font-size: 30px;"></i></p>
        </div>
    </div>
    <table id="mainTable" class="hover stripe">
        <thead class="text-green-900 border-b-1 border-b-gray-300 font-bold rounded-full">
            <tr>
                <th>Date</th>
                <th>QR Code</th>
                <th>Doc Code</th>
                <th>Document Type</th>
                <th>Document Source</th>
                <th>Sender</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $detail) { ?>
                <tr style="<?php
                            $receiveTimestamp = strtotime($detail['date_receive']);
                            $currentTimestamp = time();
                            $threeDaysInSeconds = 3 * 24 * 60 * 60; // 3 days in seconds
                            $fiveDaysInSeconds = 5 * 24 * 60 * 60;  // 5 days in seconds

                            if ($currentTimestamp - $receiveTimestamp > $fiveDaysInSeconds) {
                                echo 'background-color: #FFC0C0;';  // Set background color for more than 5 days
                            } elseif ($currentTimestamp - $receiveTimestamp > $threeDaysInSeconds) {
                                echo 'background-color: #FFEC94;';  // Set background color for more than 3 days
                            }
                            ?>">
                    <td>
                        <?php echo $detail['receive_at'] ?>
                    </td>
                    <td><img src="<?php echo $env_basePath; ?>assets/qr-codes/<?php echo $detail['qr_filename']; ?>"
                            alt="QR Code" style="height: 80px"></td>
                    <td>
                        <?php echo $detail['document_code'] ?>
                    </td>
                    <td>
                        <?php echo $detail['document_type'] ?>
                    </td>
                    <td>
                        <?php echo $detail['data_source'] ?>
                    </td>
                    <td>
                        <?php echo $detail['sender'] ?>
                    </td>

                    <td class="text-right">
                        <a href="receive-the-docu.php?id=<?php echo $detail['id']; ?>"
                            class="px-4 py-0.5 rounded-sm cursor-pointer text-green-700 shadow-xs-1 hover:text-green-900">
                            Show
                        </a>
                    <?php } ?>
                    </td>
                </tr>
        </tbody>
    </table>
</div>
</main>

<script>
    function refreshPage() {
        window.location.reload();
    }

    document.addEventListener("DOMContentLoaded", () => {
        $(document).ready(function() {
            // Initialize DataTable with your table ID
            $('#mainTable').DataTable();

            // Set placeholder text for DataTables search input
            $('#dt-search-0').attr('placeholder', '🔎 Search all');
        });

        let minDate, maxDate;

        // Custom filtering function which will search data in column 1 between two values
        DataTable.ext.search.push(function(settings, data, dataIndex) {
            let min = minDate.val();
            let max = maxDate.val();
            let date = new Date(data[0]);

            if (
                (min === null && max === null) ||
                (min === null && date <= max) ||
                (min <= date && max === null) ||
                (min <= date && date <= max)
            ) {
                return true;
            }
            return false;
        });

        // Create date inputs
        minDate = new DateTime('#min', {
            format: 'YYYY-MM-DD'
        });
        maxDate = new DateTime('#max', {
            format: 'YYYY-MM-DD'
        });

        // DataTables initialisation
        let table = new DataTable('#mainTable');

        // Refilter the table
        document.querySelectorAll('#min, #max').forEach((el) => {
            el.addEventListener('change', () => table.draw());
        });
    })
</script>
