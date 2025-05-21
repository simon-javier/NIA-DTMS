<?php require 'template/top-template-bak.php'; ?>
<?php
$office_session = $_SESSION['office'];

require '../../connection.php';
$docu_query = "SELECT COUNT(*) as count FROM tbl_handler_incoming JOIN tbl_uploaded_document ON tbl_handler_incoming.docu_id = tbl_uploaded_document.id WHERE tbl_handler_incoming.user_id = :user_id and tbl_handler_incoming.status != 'notyetreceive'";
$stmt = $pdo->prepare($docu_query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$incoming = $result['count'];



$docu_query = "SELECT COUNT(*) as count FROM tbl_handler_outgoing JOIN tbl_uploaded_document ON tbl_handler_outgoing.docu_id = tbl_uploaded_document.id WHERE tbl_handler_outgoing.office_name = :office";
$stmt = $pdo->prepare($docu_query);
$stmt->bindParam(':office', $office_session);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$outgoing = $result['count'];

$docu_query = "SELECT COUNT(*) as count FROM tbl_office_document 
                JOIN tbl_uploaded_document ON tbl_office_document.docu_id = tbl_uploaded_document.id 
                WHERE (tbl_office_document.status = 'active' OR tbl_office_document.status = 'completed') 
                AND tbl_office_document.office_name = :office_name";

$stmt = $pdo->prepare($docu_query);
$stmt->bindParam(':office_name', $office_session);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$receive = $result['count'];


$docu_query = "SELECT COUNT(*) as count from tbl_uploaded_document where from_office = :office and completed = 'pulled'";
$stmt = $pdo->prepare($docu_query);
$stmt->bindParam(':office', $office_session);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$pulled = $result['count'];

$docu_query = "SELECT COUNT(*) as count from tbl_uploaded_document where from_office = :office and completed = 'complete'";
$stmt = $pdo->prepare($docu_query);
$stmt->bindParam(':office', $office_session);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$complete = $result['count'];

$docu_query = "SELECT COUNT(*) as count from tbl_uploaded_document where from_office = :office and completed = 'decline'";
$stmt = $pdo->prepare($docu_query);
$stmt->bindParam(':office', $office_session);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$incomplete = $result['count'];




?>


<div class="row my-3">


    <div class="col-md-4">
        <a href="incoming-documents.php" style="text-decoration: none; color: black">
            <div class="card text-center card-info">
                <div class="card-block">
                    <h4 class="card-title mt-3">Incoming Documents</h4>
                    <h2><i class="bx bxs-file-export fa-2x"></i></h2>
                </div>
                <div class="row p-2 ">
                    <div class="col-12">
                        <div class="card card-block text-success rounded-0 ">
                            <h3>
                                <?php echo $incoming; ?>
                            </h3>
                            <span class="small text-uppercase">items</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="outgoing-documents.php" style="text-decoration: none; color: black">
            <div class="card text-center card-info">
                <div class="card-block">
                    <h4 class="card-title mt-3">Ongoing Documents</h4>
                    <h2><i class="bx bxs-file-import fa-2x"></i></h2>
                </div>
                <div class="row p-2 ">
                    <div class="col-12">
                        <div class="card card-block text-success rounded-0 ">
                            <h3>
                                <?php echo $outgoing; ?>
                            </h3>
                            <span class="small text-uppercase">items</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="received-documents.php" style="text-decoration: none; color: black">
            <div class="card text-center card-info">
                <div class="card-block">
                    <h4 class="card-title mt-3">Received Documents</h4>
                    <h2><i class="bx bx-file fa-2x"></i></h2>
                </div>
                <div class="row p-2 ">
                    <div class="col-12">
                        <div class="card card-block text-success rounded-0 ">
                            <h3>
                                <?php echo $receive; ?>
                            </h3>
                            <span class="small text-uppercase">items</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row my-3">


    <div class="col-md-4">
        <a href="pulled-documents.php" style="text-decoration: none; color: black">
            <div class="card text-center card-info">
                <div class="card-block">
                    <h4 class="card-title mt-3">Pulled Documents</h4>
                    <h2><i class="bx bxs-file-export fa-2x"></i></h2>
                </div>
                <div class="row p-2 ">
                    <div class="col-12">
                        <div class="card card-block text-success rounded-0 ">
                            <h3>
                                <?php echo $pulled; ?>
                            </h3>
                            <span class="small text-uppercase">items</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="completed-documents.php" style="text-decoration: none; color: black">
            <div class="card text-center card-info">
                <div class="card-block">
                    <h4 class="card-title mt-3">Complete Documents</h4>
                    <h2><i class="bx bxs-file-import fa-2x"></i></h2>
                </div>
                <div class="row p-2 ">
                    <div class="col-12">
                        <div class="card card-block text-success rounded-0 ">
                            <h3>
                                <?php echo $complete; ?>
                            </h3>
                            <span class="small text-uppercase">items</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="incomplete-documents.php" style="text-decoration: none; color: black">
            <div class="card text-center card-info">
                <div class="card-block">
                    <h4 class="card-title mt-3">Incomplete Documents</h4>
                    <h2><i class="bx bx-file fa-2x"></i></h2>
                </div>
                <div class="row p-2 ">
                    <div class="col-12">
                        <div class="card card-block text-success rounded-0 ">
                            <h3>
                                <?php echo $incomplete; ?>
                            </h3>
                            <span class="small text-uppercase">items</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>





<?php require 'template/bottom-template-bak.php'; ?>
