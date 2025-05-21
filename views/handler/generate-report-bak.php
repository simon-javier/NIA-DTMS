<?php require 'template/top-template-bak.php'; ?>
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

    .table-container {
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

    #example_wrapper {
        overflow-x: scroll;
    }

    .form-control {
        border: 2px solid #009933;
        border-radius: 10px;
    }

    @media (min-width: 992px) {
        .w-lg-25 {
            width: 10% !important;
        }
    }
</style>


<div class="table-container mt-5">
    <h3>Generate Reports</h3>
    <br>
    <form id="generate_reports_form" action="export-pdf-template.php" method="get" autocomplete="off"
        enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="doc_type">Document Type:</label>
                    <select name="doc_type" class="form-control" id="doc_type">
                        <option value="Select" selected>Select</option>
                        <!-- <?php
                                foreach ($doctypes as $doctype) { ?>
                    
                        <option value="<?php echo $doctype['document_type']; ?>"><?php echo $doctype['document_type']; ?></option>
                    <?php
                                }

                    ?> -->
                        <option value="complete">Complete Documents</option>
                        <option value="decline">Incomplete Documents</option>
                        <option value="ongoing">Ongoing Documents</option>
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

<?php require 'template/bottom-template-bak.php'; ?>
