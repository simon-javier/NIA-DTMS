<?php require 'template/top-template.php'; ?>

<?php 
$user_id = $_SESSION['userid'];
$office_session = $_SESSION['office'];
    try {
        //code...
        $docu_query = "SELECT * FROM tbl_uploaded_document where from_office = :office and completed = 'pulled'";
        $stmt = $pdo->prepare($docu_query);
        $stmt->bindParam(':office', $office_session);
        $stmt->execute();
        $docu_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (\Throwable $th) {
        //throw $th;
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

<!-- <div class="container">
    <form autocomplete="off">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="name">Document Type</label>
                <input type="text" class="form-control" id="name" placeholder="Enter your name">
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="office">Date From</label>
                <input type="date" class="form-control" id="office" placeholder="Enter your office">
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="from">Date To</label>
                <input type="date" class="form-control" id="from" placeholder="Enter sender's name">
            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="float: right;">Submit</button>
    </form>
</div> -->


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
                <th>Subject</th>
                <th>Description</th>
                <th>Document Type</th>
            </tr>
        </thead>
        <tbody>
        
        <?php foreach($docu_details as $detail){ ?>
            <tr>

                <td><?php echo $detail['updated_at'] ?></td>
                <td><?php echo $detail['subject'] ?></td>
                <td><?php echo $detail['description'] ?></td>
                <td><?php echo $detail['document_type'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Date</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Document Type</th>
            </tr>
        </tfoot>
    </table>
</div>



<?php require 'template/bottom-template.php'; ?>