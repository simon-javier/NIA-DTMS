


<?php require 'template/top-template.php'; ?>
<?php 
    try {
        //code...
        $sender_id = $_SESSION['userid'];

        $trackDocuQuery = "SELECT * from tbl_uploaded_document where status != 'pending' and  status != 'pulled' and  completed != 'decline' and sender_id = :id order by updated_at desc";
    
        $stmt = $pdo->prepare($trackDocuQuery);
        $stmt->bindParam(':id', $sender_id);
        $stmt->execute();
        $docu_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        //throw $th;
        echo $th->getMessage();
        exit;
    }





?>
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
</style>



<div class="table-container">
<table id="example" class="hover" style="width:100%">
        <thead>
            <tr>
                <th>QR Code</th>
                <th>Doc Code</th>
                <th>Document Type</th>
     

                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($docu_details as $row){ ?>
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
                <td><img src="<?php echo $env_basePath; ?>assets/qr-codes/<?php echo $row['qr_filename']; ?>" alt="QR Code" style="height: 80px"></td>
                    <td><?php echo $row['document_code']; ?></td>
                    <td><?php echo $row['document_type']; ?></td>


                    <td><?php echo strlen($row['status']) > 50 ? substr($row['status'], 0, 50) . '...' : $row['status']; ?></td>
                    <td><a href="<?php echo $env_basePath; ?>views/track-document.php?code=<?php echo $row['document_code']; ?>" class="btn btn-dark"><i class='bx bx-show'></i></a></td>
                </tr>
            <?php } ?>


            


        </tbody>
        <tfoot>
            <tr>
                <th>QR Code</th>
                <th>Doc Code</th>
                <th>Document Type</th>

                <th>Status</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>


<?php require 'template/bottom-template.php'; ?>