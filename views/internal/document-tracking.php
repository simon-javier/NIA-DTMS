


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
</style>



<div class="table-container">
<table id="example" class="hover" style="width:100%">
        <thead>
            <tr>
                <th>QR Code</th>
                <th>Doc Code</th>
                <th>Document Type</th>
                <th>Document Source</th>
                <th>Receiving Unit</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Sample qr code 1</td>
                <td>3212545</td>
                <td>letter</td>
                <td>Internal</td>
                <td>asdasdwe</td>
                <td>Pending</td>
                <td>View</td>
            </tr>
            <tr>
                <td>Sample qr code 2</td>
                <td>3245124</td>
                <td>letter</td>
                <td>Internal</td>
                <td>asdasdwe</td>
                <td>Pending</td>
                <td>View</td>
            </tr>
            <tr>
                <td>Sample qr code 3</td>
                <td>3242135</td>
                <td>letter</td>
                <td>Internal</td>
                <td>asdasdwe</td>
                <td>Pending</td>
                <td>View</td>
            </tr>
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


<?php require 'template/bottom-template.php'; ?>