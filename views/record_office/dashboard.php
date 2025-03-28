<?php require 'template/top-template.php'; ?>
<?php 
    require '../../connection.php';
    $sql = "SELECT COUNT(*) as count FROM tbl_uploaded_document WHERE data_source = 'guest' AND status = 'pending' AND status != 'pulled'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    $trackDocument = "SELECT COUNT(*) as count FROM tbl_uploaded_document WHERE status != 'pulled'";
    $stmt = $pdo->prepare($trackDocument);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $count1 = $result['count'];


?>


    <div class="row my-3">
        
    
        <div class="col-md-6">
        <a href="newly-created-docs.php" style="text-decoration: none; color: black">
            <div class="card text-center card-info">
                <div class="card-block">
                    <h4 class="card-title mt-3">New Documents</h4>
                    <h2><i class="bx bx-mail-send fa-2x"></i></h2>
                </div>
                <div class="row p-2 ">
                    <div class="col-12">
                        <div class="card card-block text-info rounded-0 ">
                            <h3><?php echo $count; ?></h3>
                            <span class="small text-uppercase">items</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        </div>
        <div class="col-md-6">
        <a href="document-tracking.php" style="text-decoration: none; color: black">
            <div class="card text-center card-info">
                <div class="card-block">
                    <h4 class="card-title mt-3">All Documents</h4>
                    <h2><i class="bx bx-mail-send fa-2x"></i></h2>
                </div>
                <div class="row p-2 ">
                    <div class="col-12">
                        <div class="card card-block text-info rounded-0 ">
                            <h3><?php echo $count1; ?></h3>
                            <span class="small text-uppercase">items</span>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>
    </div>




<?php require 'template/bottom-template.php'; ?>