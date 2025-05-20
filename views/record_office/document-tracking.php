<?php
require '../../connection.php';
$trackDocument = "SELECT * from tbl_uploaded_document where status != 'pulled' and status != 'pending' and completed != 'decline' ORDER BY updated_at DESC";
$stmt = $pdo->prepare($trackDocument);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<?php require 'template/top-template.php'; ?>

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
                <th>QR Code</th>
                <th>Doc Code</th>
                <th>Document Type</th>
                <th>Document Source</th>
                <th>Sender</th>
                <th>Current Office</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row) { ?>
                <tr style="<?php
                            if ($row['completed']  == 'no') {
                                $receiveTimestamp = strtotime($row['updated_at']);
                                $currentTimestamp = time();
                                $threeDaysInSeconds = 3 * 24 * 60 * 60; // 3 days in seconds
                                $fiveDaysInSeconds = 5 * 24 * 60 * 60;  // 5 days in seconds

                                if ($currentTimestamp - $receiveTimestamp > $fiveDaysInSeconds) {
                                    echo 'background-color: #FFC0C0;';  // Set background color for more than 5 days
                                } elseif ($currentTimestamp - $receiveTimestamp > $threeDaysInSeconds) {
                                    echo 'background-color: #FFEC94;';  // Set background color for more than 3 days
                                }
                            }

                            ?>">
                    <td>
                        <?php echo date('Y-m-d', strtotime($row['updated_at'])); ?>
                    </td>
                    <td><img src="<?php echo $env_basePath; ?>assets/qr-codes/<?php echo $row['qr_filename']; ?>"
                            alt="QR Code" style="height: 80px"></td>
                    <td>
                        <?php echo $row['document_code'] ?>
                    </td>
                    <td>
                        <?php echo $row['document_type'] ?>
                    </td>
                    <td>
                        <?php echo $row['data_source'] ?>
                    </td>
                    <td>
                        <?php echo $row['sender'] ?>
                    </td>
                    <!-- <td><?php echo strlen($row['status']) > 50 ? substr($row['status'], 0, 50) . '...' : $row['status']; ?></td> -->
                    <!-- <td><?php echo $row['prev_office'] ?></td> -->
                    <td>
                        <?php echo $row['cur_office'] ?>
                    </td>

                    <td><a href="track-document.php?code=<?php echo $row['document_code']; ?>"
                            class="bg-black text-white px-2.5 py-2 rounded-lg hover:bg-black/80"><i
                                class='bx bx-show'></i></a></td>
                </tr>
            <?php } ?>
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
