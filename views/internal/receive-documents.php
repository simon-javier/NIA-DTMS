<?php require 'template/top-template.php'; ?>

<?php 



    $documentQuery = "SELECT tbl_office_incoming.*, tbl_uploaded_document.*, tbl_office_incoming.status AS incoming_status
    FROM tbl_office_incoming
    JOIN tbl_uploaded_document ON tbl_office_incoming.docu_id = tbl_uploaded_document.id
    WHERE tbl_office_incoming.office_id = :office_id and tbl_office_incoming.status != 'pending'";
    $stmt = $pdo->prepare($documentQuery);
    $stmt->bindParam(':office_id', $office_id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    


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
                <th>Sender</th>
                <th>Document Source</th>
                <!-- <th>Status</th> -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($result as $row) { ?>
                <tr <?php echo strpos($row['incoming_status'], 'Received by') !== false ? 'style="font-weight: bold;"' : ''; ?>>
                <td><img src="<?php echo $env_basePath; ?>assets/qr-codes/<?php echo $row['qr_filename']; ?>" alt="QR Code" style="height: 80px"></td>
                    <td><?php echo $row['document_code']; ?></td>
                    <td><?php echo $row['document_type']; ?></td>
                    <td><?php echo $row['sender']; ?></td>
                    <td><?php echo $row['data_source']; ?></td>
                    <!-- <td>
                        <?php echo $row['incoming_status']; ?>
                    </td> -->
                    <td><a href="document-details.php?id=<?php echo $row['id']; ?>" class="btn btn-dark"><i class='bx bx-show'></i></a></td>
                </tr>
            <?php } ?>

        </tbody>
        <tfoot>
            <tr>
                <th>QR Code</th>
                <th>Doc Code</th>
                <th>Document Type</th>
                <th>Sender</th>
                <th>Document Source</th>
                <!-- <th>Status</th> -->
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>


<?php require 'template/bottom-template.php'; ?>