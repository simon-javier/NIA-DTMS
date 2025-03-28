<?php 
    require '../../connection.php';


    

?>


<?php require 'template/top-template.php'; ?>
<?php 
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
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);



} catch (\Throwable $th) {
    //throw $th;
    echo $th;
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
    .form-control{
        border: 2px solid #009933;
        border-radius: 10px;
    }
</style>


<div class="table-container">
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
            <th>Document Code</th>
                <th>Document Type</th>
                <th>Sender</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Action required</th>
      

                <th style="text-align: end;">Action</th>
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
        <td><?php echo date('Y-m-d', strtotime($detail['uploaded_at'])); ?></td>
        <td><?php echo $detail['document_code'] ?></td>
        <td><?php echo $detail['document_type'] ?></td>
        <td><?php echo $detail['sender'] ?></td>
        <td><?php echo $detail['subject'] ?></td>
        <td><?php echo $detail['description'] ?></td>
        <td><?php echo $detail['required_action'] ?></td>


        <td style="text-align: end;">
            <a href="accept-decline.php?id=<?php echo $detail['id']; ?>" class="btn btn-dark"><i class='bx bx-show'></i></a>
        </td>
    </tr>
<?php } ?>

        </tbody>
        <tfoot>
            <tr>
            <th>Date</th>
            <th>Document Code</th>
                <th>Document Type</th>
                <th>Sender</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Action required</th>

                <th style="text-align: end;">Action</th>
            </tr>
        </tfoot>
    </table>
</div>


<?php require 'template/bottom-template.php'; ?>