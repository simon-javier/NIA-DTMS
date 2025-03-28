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



<!-- <div class="container">
    <form autocomplete="off">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter your name">
            </div>
            <div class="form-group col-md-6">
                <label for="office">Office</label>
                <input type="text" class="form-control" id="office" placeholder="Enter your office">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="from">From</label>
                <input type="text" class="form-control" id="from" placeholder="Enter sender's name">
            </div>
            <div class="form-group col-md-6">
                <label for="contactNumber">Contact Number</label>
                <input type="tel" class="form-control" id="contactNumber" placeholder="Enter contact number">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email address">
            </div>
            <div class="form-group col-md-6">
                <label for="documentCode">Document Code</label>
                <input type="text" class="form-control" id="documentCode" placeholder="Enter document code">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="documentType">Document Type</label>
                <input type="text" class="form-control" id="documentType" placeholder="Enter document type">
            </div>
            <div class="form-group col-md-6">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" placeholder="Enter description">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" id="subject" placeholder="Enter subject">
            </div>
        </div>
        <button type="submit" class="btn btn-primary" style="float: right;">Submit</button>
    </form>
</div> -->

<!-- <div class="container mt-5">

</div> -->
<div class="container">
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

</div>


<?php require 'template/bottom-template.php'; ?>