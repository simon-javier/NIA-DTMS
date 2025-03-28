<?php require 'template/top-template-bak.php'; ?>
<?php
$countAllUploadedDocuments = "SELECT COUNT(*) as all_documents from tbl_uploaded_document where status != 'Document pulled'";
$stmt = $pdo->prepare($countAllUploadedDocuments);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$allDocuCount = $result['all_documents'];

$countConfirmDisconfirmDocument = "SELECT COUNT(*) as complete_documents from tbl_uploaded_document where status like '%Document confirm by%' or status like '%Completed at%'";
$stmt = $pdo->prepare($countConfirmDisconfirmDocument);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$completedDocuCount = $result['complete_documents'];

$countOffices = "SELECT COUNT(*) as no_offices from tbl_login_account where role = 'handler' and status = 'active'";
$stmt = $pdo->prepare($countOffices);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$no_offices = $result['no_offices'];


$countExternal = "SELECT COUNT(*) as no_external from tbl_login_account where role = 'guest' and status = 'active'";
$stmt = $pdo->prepare($countExternal);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$no_external = $result['no_external'];

$doctypeQuery = "SELECT * FROM tbl_document_type";

$statement = $pdo->prepare($doctypeQuery);
$statement->execute();
$doctypes = $statement->fetchAll(PDO::FETCH_ASSOC);

$trackDocument = "SELECT * from tbl_uploaded_document where status != 'pulled' and status != 'pending' ORDER BY updated_at DESC";
$stmt = $pdo->prepare($trackDocument);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


$get_user_count = "
        SELECT COUNT(*)
        FROM tbl_login_account
        JOIN tbl_userinformation ON tbl_login_account.id = tbl_userinformation.id
        WHERE tbl_login_account.status = 'pending'
    ";
$stmt = $pdo->prepare($get_user_count);
$stmt->execute();

$count = $stmt->fetchColumn(); // Fetching the count directly




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

    .table-container {
        padding: 2.5rem;
        background-color: #fff;
        box-shadow: var(--box-shadow);
    }

    .main-content {
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

    .form-control {
        border: 2px solid #009933;
        border-radius: 10px;
    }
</style>

<div class="row my-3">


    <div class="col-md-4">
        <a href="guest.php" style="text-decoration: none; color: black">
            <div class="card text-center card-info">
                <div class="card-block">
                    <h4 class="card-title mt-3">No. of guest accounts</h4>
                    <h2><i class="fa fa-user fa-2x"></i></h2>
                </div>
                <div class="row p-2 ">
                    <div class="col-12">
                        <div class="card card-block text-success rounded-0 ">
                            <h3><?php echo $no_external; ?></h3>
                            <span class="small text-uppercase">users</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>

    </div>
    <div class="col-md-4">
        <a href="offices.php" style="text-decoration: none; color: black">
            <div class="card text-center card-info">
                <div class="card-block">
                    <h4 class="card-title mt-3">No. of document handler account</h4>
                    <h2><i class="fa fa-users fa-2x"></i></h2>
                </div>
                <div class="row p-2 ">
                    <div class="col-12">
                        <div class="card card-block text-success rounded-0 ">
                            <h3><?php echo $no_offices; ?></h3>
                            <span class="small text-uppercase">users</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="pending-account.php" style="text-decoration: none; color: black">
            <div class="card text-center card-info">
                <div class="card-block">
                    <h4 class="card-title mt-3">Incoming Registration</h4>
                    <h2><i class="fa fa-file fa-2x"></i></h2>
                </div>
                <div class="row p-2 ">
                    <div class="col-12">
                        <div class="card card-block text-success rounded-0 ">
                            <h3><?php echo $count; ?></h3>
                            <span class="small text-uppercase">items</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
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
