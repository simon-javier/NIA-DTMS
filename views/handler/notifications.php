<?php 
    session_start();
    $user_id = $_SESSION['userid'];
    require '../../connection.php';
    if(!isset($_SESSION['userid'])){
        header("Location: ../../index.php");
        exit;
    }

    $sql = "SELECT * from tbl_notification where user_id = :user_id ORDER BY timestamp desc";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
   



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/cloudflare/all.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/boxicons/boxicons.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/datatable/jquery.dataTables.min.css">
    <script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.2.1.slim.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/stackpath/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/cdnjs/bootstrap-select.min.css">
    <script src="<?php echo $env_basePath; ?>assets/cdnjs/bootstrap-select.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        
        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', 'Arial';
            scroll-behavior: smooth;
            
        }

        .custom-shadow {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
    
</head>
<body>
<div class="container mt-5 mb-5 custom-shadow">
    <div class="row">

        <div class="col-lg-12 right">
            <div class="box shadow-sm rounded bg-white mb-3">
                <div class="box-title border-bottom p-3">
                    <h3 class="m-0"><a href="dashboard.php" class="btn btn-danger mr-3">Back</a>Notifications</h3>
                </div>
                <?php foreach($result as $row): ?>
                    <div class="box-body p-0">
                    <div class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header">
                        <div class=" mr-3">
                            <div class="text-truncate"><?php echo $row['content']; ?></div>
                            <!-- <div class="small">Income tax sops on the cards, The bias in VC funding, and other top news for you</div> -->
                        </div>
                        <span class="ml-auto mb-auto">
                            <div class="text-right text-muted pt-1">
                                <?php echo date('M j, Y g:iA', strtotime($row['timestamp'])); ?>
                            </div>
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
               
                
            </div>
     
        </div>
    </div>
</div>


 
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.2.1.slim.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/popper.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/sweetalert2.all.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.6.4.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/datatable/jquery.dataTables.min.js"></script>
</body>
</html>