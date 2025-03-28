<?php require 'template/top-template.php'; ?>
<?php 
    $countAllUploadedDocuments = "SELECT COUNT(*) as all_documents from tbl_uploaded_document where status != 'Document pulled'";
    $stmt = $pdo->prepare($countAllUploadedDocuments);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $allDocuCount = $result['all_documents'];

    $countConfirmDisconfirmDocument = "SELECT COUNT(*) as complete_documents from tbl_uploaded_document where status like '%Document confirm by%' or status like '%Document disconfirm by%'";
    $stmt = $pdo->prepare($countConfirmDisconfirmDocument);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $completedDocuCount = $result['complete_documents'];

    $countOffices = "SELECT COUNT(*) as no_offices from tbl_login_account where role = 'internal'";
    $stmt = $pdo->prepare($countOffices);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $no_offices = $result['no_offices'];

    
    $countExternal = "SELECT COUNT(*) as no_external from tbl_login_account where role = 'external'";
    $stmt = $pdo->prepare($countExternal);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $no_external = $result['no_external'];
?>


<style>
    :root {
    --primary-color: #069734;
    --lighter-primary-color: #07b940;
    --white-color: #FFFFFF;
    --black-color: #181818;
    --bold: 600;
    --transition: all 0.5s ease;
    --box-shadow: 0 0.1rem 0.4rem rgba(0, 0, 0, 0.2);
    }
    ::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #009933; 
        border-radius: 6px;
    }
    .card{
        box-shadow: var(--box-shadow);
    }
    .card-title, .card-text{
        color: var(--primary-color);
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $allDocuCount; ?></h5>
                    <p class="card-text">All Documents</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $no_offices ?></h5>
                    <p class="card-text">No. of offices</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $no_external ?></h5>
                    <p class="card-text">No. of external accounts</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $completedDocuCount; ?></h5>
                    <p class="card-text">Complete Documents</p>
                </div>
            </div>
        </div>
    </div>
</div>
        
<?php require 'template/bottom-template.php'; ?>