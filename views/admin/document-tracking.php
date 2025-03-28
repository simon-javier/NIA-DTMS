<?php require 'template/top-template.php'; ?>
<?php
    try {
        //code...
        $trackDocument = "SELECT * from tbl_uploaded_document";
        $stmt = $pdo->prepare($trackDocument);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

<div class="container mt-5">
<div class="table-container">
<table id="example" class="hover" style="width:100%">
        <thead>
            <tr>
                <th>QR Code</th>
                <th>Doc Code</th>
                <th>Document Type</th>
                <th>Document Source</th>
                <th>Sender</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $row) { ?>
                <tr>
                <td><img src="<?php echo $env_basePath; ?>assets/qr-codes/<?php echo $row['qr_filename']; ?>" alt="QR Code" style="height: 80px"></td>
                    <td><?php echo $row['document_code'] ?></td>
                    <td><?php echo $row['document_type'] ?></td>
                    <td><?php echo $row['data_source'] ?></td>
                    <td><?php echo $row['sender'] ?> - <?php echo $row['sender_office'] ?></td>
                    <td><?php echo $row['status'] ?></td>
                    <td><a href="<?php echo $env_basePath; ?>views/track-document.php?code=<?php echo $row['document_code']; ?>" class="btn btn-dark"><i class='bx bx-show'></i></a></td>
                </tr>
            <?php } ?>

        </tbody>
        <tfoot>
            <tr>
                <th>QR Code</th>
                <th>Doc Code</th>
                <th>Document Type</th>
                <th>Document Source</th>
                <th>Receiving Unit</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>
</div>


<?php require 'template/bottom-template.php'; ?>