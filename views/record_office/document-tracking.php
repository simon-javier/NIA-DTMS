<?php 
    require '../../connection.php';
    $trackDocument = "SELECT * from tbl_uploaded_document where status != 'pulled' and status != 'pending' and completed != 'decline' ORDER BY updated_at DESC";
    $stmt = $pdo->prepare($trackDocument);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<?php require 'template/top-template.php'; ?>
<style>
        :root {
    --primary-color: #069734;
    --lighter-primary-color: #07b940;
    --white-color: #FFFFFF;
    --black-color: #181818;
    --bold: 600;
    --transition: all 0.5s ease;
    --box-shadow: 0 0.1rem 0.8rem rgba(0, 0, 0, 0.2);
    }
    ::-webkit-scrollbar {
        width: 4px;
        height: 4px; 
    }

    ::-webkit-scrollbar-thumb {
        background-color: #009933; 
        border-radius: 6px;
    }
    .table-container{
        padding: 2.5rem;
        background-color: #fff;
        box-shadow: var(--box-shadow);
    }
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid var(--primary-color) !important;
        border-radius: 10px;
        padding: 5px;
        background-color: transparent;
        color: inherit;
        margin-left: 3px;
        
    }
    .dataTables_wrapper .dataTables_filter input:active {
        border: 1px solid var(--primary-color) !important;
        border-radius: 10px;
        padding: 5px;
    }
    #example_wrapper{
        overflow-x: scroll;
    }
    .form-control{
        border: 2px solid #009933;
        border-radius: 10px;
    }
</style>


<div class="table-container" style="overflow-x: auto;">
<style>
         @media (min-width: 992px) {
            .w-lg-25 {
                width: 10% !important;
            }
        }
    </style>
<div class="d-flex mb-3 justify-content-end align-items-end">
    <p class="mb-2 mr-3">Filter by date</p>
    <input type="text" class="form-control mr-3 w-lg-25 w-100" id="min" name="min" placeholder="Start date">
    <input type="text" class="form-control w-lg-25 w-100" id="max" name="max" placeholder="End date">
    <p class="ml-2" onclick="refreshPage()" style="cursor: pointer"><i class='bx bx-reset' style="font-size: 30px;"></i></p>
</div>
<script>
    function refreshPage(){
        window.location.reload();
    }
</script>
<table id="example" class="hover" style="width:100%">
        <thead>
            <tr>
            <th>Date</th>
                <th>QR Code</th>
                <th>Doc Code</th>
                <th>Document Type</th>
                <th>Document Source</th>
                <th>Sender</th>
                <!-- <th>Previous Office</th> -->
                <th>Current Office</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $row) { ?>
                <tr style="<?php
                if($row['completed']  == 'no'){
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
                        <td><?php echo date('Y-m-d', strtotime($row['updated_at'])); ?></td>
                <td><img src="<?php echo $env_basePath; ?>assets/qr-codes/<?php echo $row['qr_filename']; ?>" alt="QR Code" style="height: 80px"></td>
                    <td><?php echo $row['document_code'] ?></td>
                    <td><?php echo $row['document_type'] ?></td>
                    <td><?php echo $row['data_source'] ?></td>
                    <td><?php echo $row['sender'] ?></td>
                    <!-- <td><?php echo strlen($row['status']) > 50 ? substr($row['status'], 0, 50) . '...' : $row['status']; ?></td> -->
                    <!-- <td><?php echo $row['prev_office'] ?></td> -->
                    <td><?php echo $row['cur_office'] ?></td>

                    <td><a href="track-document.php?code=<?php echo $row['document_code']; ?>" class="btn btn-dark"><i class='bx bx-show'></i></a></td>
                </tr>
            <?php } ?>

        </tbody>
        <tfoot>
            <tr>
            <th>Date</th>
                <th>QR Code</th>
                <th>Doc Code</th>
                <th>Document Type</th>
                <th>Document Source</th>
                <th>Receiving Unit</th>
                <!-- <th>Previous Office</th> -->
                <th>Current Office</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>


<?php require 'template/bottom-template.php'; ?>