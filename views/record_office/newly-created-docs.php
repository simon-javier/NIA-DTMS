<?php


?>


<?php require 'template/top-template.php'; ?>
<?php

$sql = "SELECT * from tbl_uploaded_document where status = 'pending' and status != 'pulled' order by uploaded_at desc";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


$user_id = $_SESSION['userid'];
$officename = $_SESSION['office'];
try {
    //code...
    $docu_query = "SELECT tbl_handler_incoming.receive_at as date_receive, tbl_handler_incoming.*, tbl_uploaded_document.*  
    FROM tbl_handler_incoming 
    JOIN tbl_uploaded_document ON tbl_handler_incoming.docu_id = tbl_uploaded_document.id 
    WHERE tbl_handler_incoming.user_id = :user_id 
    AND tbl_handler_incoming.status = 'notyetreceive' 
    AND tbl_uploaded_document.completed != 'pulled' 
    ORDER BY tbl_handler_incoming.receive_at DESC";

    $stmt = $pdo->prepare($docu_query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $results1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <div class="p-2 bg-neutral-50 shadow-sm absolute w-60
                        right-[74px] z-100 top-[168px] rounded-sm hidden dropdown-list">
            <ul class="dropdown-menu dropdown-menu-end flex flex-col gap-1" aria-labelledby="userDropdown">
                <li><a class="dropdown-item flex items-center gap-1" href="pulled-document.php"><i
                            class='bx bx-show'></i> Pulled Documents</a></li>
                <li><a class="dropdown-item flex items-center gap-1" href="incomplete-document.php"><i
                            class='bx bx-show'></i>Incomplete Documents</a></li>
            </ul>
        </div>
        <thead class="text-green-900 border-b-1 border-b-gray-300 font-bold rounded-full">
            <tr>
                <th>Date</th>
                <th>Document Type</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Action Required</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $detail) { ?>
                <tr style="<?php
                            $uploadedTimestamp = strtotime($detail['uploaded_at']);
                            $currentTimestamp = time();
                            $threeDaysInSeconds = 3 * 24 * 60 * 60; // 3 days in seconds
                            $fiveDaysInSeconds = 5 * 24 * 60 * 60;  // 5 days in seconds

                            if ($currentTimestamp - $uploadedTimestamp > $fiveDaysInSeconds) {
                                echo 'background-color: #FFC0C0;';  // Set background color for more than 5 days
                            } elseif ($currentTimestamp - $uploadedTimestamp > $threeDaysInSeconds) {
                                echo 'background-color: #FFEC94;';  // Set background color for more than 3 days
                            }
                            ?>">
                    <td>
                        <?php echo date('Y-m-d', strtotime($detail['uploaded_at'])); ?>
                    </td>
                    <td>
                        <?php echo $detail['document_type'] ?>
                    </td>
                    <td>
                        <?php echo $detail['sender'] ?>
                    </td>
                    <td>
                        <?php echo $detail['subject'] ?>
                    </td>
                    <td>
                        <?php echo $detail['description'] ?>
                    </td>
                    <td>
                        <?php echo $detail['required_action'] ?>
                    </td>
                    <td class="text-right">
                        <a href="accept-decline.php?id=<?php echo $detail['id']; ?>&from=external"
                            class="px-4 py-0.5 rounded-sm cursor-pointer text-green-700 shadow-xs-1 hover:text-green-900">
                            Show
                        </a>
                    <?php } ?>
                    </td>
                </tr>

                <?php foreach ($results1 as $detail) { ?>
                    <tr style="<?php
                                $uploadedTimestamp = strtotime($detail['updated_at']);
                                $currentTimestamp = time();
                                $threeDaysInSeconds = 3 * 24 * 60 * 60; // 3 days in seconds
                                $fiveDaysInSeconds = 5 * 24 * 60 * 60;  // 5 days in seconds

                                if ($currentTimestamp - $uploadedTimestamp > $fiveDaysInSeconds) {
                                    echo 'background-color: #FFC0C0;';  // Set background color for more than 5 days
                                } elseif ($currentTimestamp - $uploadedTimestamp > $threeDaysInSeconds) {
                                    echo 'background-color: #FFEC94;';  // Set background color for more than 3 days
                                }
                                ?>">
                        <td>
                            <?php echo date('Y-m-d', strtotime($detail['uploaded_at'])); ?>
                        </td>
                        <td>
                            <?php echo $detail['document_type'] ?>
                        </td>
                        <td>
                            <?php echo $detail['sender'] ?>
                        </td>
                        <td>
                            <?php echo $detail['subject'] ?>
                        </td>
                        <td>
                            <?php echo $detail['description'] ?>
                        </td>
                        <td>
                            <?php echo $detail['required_action'] ?>
                        </td>
                        <td class="text-right">
                            <a href="accept-decline.php?id=<?php echo $detail['id']; ?>&from=external"
                                class="px-4 py-0.5 rounded-sm cursor-pointer text-green-700 shadow-xs-1 hover:text-green-900">
                                Accept
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
