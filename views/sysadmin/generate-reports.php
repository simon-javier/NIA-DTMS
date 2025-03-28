<?php require 'template/top-template.php'; ?>
<?php

    $doctypeQuery = "SELECT * FROM tbl_document_type";
    $statement = $pdo->prepare($doctypeQuery);
    $statement->execute();
    $doctypes = $statement->fetchAll(PDO::FETCH_ASSOC);
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
    .main-content{
        position: relative;
        background-color: white;
        top: 0;
        max-height: 90vh;
        overflow-y: scroll;
        left: 90px;
        transition: var(--transition);
        width: calc(100% - 90px);
        padding: 1rem;

    }
    .form-control{
        border: 2px solid #009933;
        border-radius: 10px;
    }
</style>


<div class="container">
    <div class="table-container">
        <form id="generate_reports_form" action="export-pdf-template.php" method="get" autocomplete="off" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
            <div class="form-group">
                <label for="doc_type">Document Type:</label>
                <select name="doc_type" class="form-control"  id="doc_type">
                    <option value="Select" selected>Select</option>
                    <?php 
                    foreach ($doctypes as $doctype) {?>
                    
                        <option value="<?php echo $doctype['document_type'];?>"><?php echo $doctype['document_type'];?></option>
                    <?php
                    }
                    
                    ?>
                </select>
            </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sender">Date From:</label>
                    <input type="date" class="form-control" placeholder="Date From" id="from" name="from">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                <label for="receiver">Date To:</label>
                <input type="date" class="form-control" placeholder="Date To" id="dateto" name="dateto">
            </div>
            </div>

        </div>
        <div class="d-flex justify-content-end align-items-end" style="gap: 20px">
                <button type="reset" class="btn btn-danger">Clear</button>
                <button type="submit" class="btn btn-primary">Generate</button>
            </div>
        </form>
    </div>
</div>


<?php require 'template/bottom-template.php'; ?>

<script>

    var fromDateInput = document.getElementById('from');
    var toDateInput = document.getElementById('dateto');


    fromDateInput.addEventListener('input', handleDateChange);
    toDateInput.addEventListener('input', handleDateChange);

    function handleDateChange() {
        var currentDate = new Date();

        var fromDate = new Date(fromDateInput.value);
        var toDate = new Date(toDateInput.value);

        if (toDate < fromDate) {
            toDateInput.value = fromDateInput.value;
        }


        if (toDate > currentDate) {
            toDateInput.valueAsDate = currentDate;
        }
        if (fromDate > currentDate) {
            fromDateInput.valueAsDate = currentDate;
        }
    }
</script>