


<?php 
    session_start();
  
    require '../../connection.php';
    if(!isset($_SESSION['userid'])){
        header("Location: ../../index.php");
        exit;
    }
    $office_id = $_SESSION['userid'];

    $countPedningQuery = "SELECT COUNT(*) AS pending_count FROM tbl_office_incoming where office_id = :office_id AND status = 'pending'";
    $stmt = $pdo->prepare($countPedningQuery);
    $stmt->bindParam(':office_id', $office_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $countPendingDocument  = $result['pending_count'];

    $countReceiveQuery = "SELECT COUNT(*) AS pending_count FROM tbl_office_incoming where office_id = :office_id AND status LIKE '%Received by%'";
    $stmt = $pdo->prepare($countReceiveQuery);
    $stmt->bindParam(':office_id', $office_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $countReceivedDocument  = $result['pending_count'];

    $current_time = date("M j, Y g:i A");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Tracking System</title>

    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/cloudflare/all.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/boxicons/boxicons.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/datatable/jquery.dataTables.min.css">
    <link rel="stylesheet" href="sidebar.css">
    
</head>
<body>
    <div class="sidebar active">
        <div class="top">
            <div class="logo">
                <img src="<?php echo $env_basePath; ?>assets/img/logo.png" alt="User Default Image">
                <span>NIA Document Tracking and Management System</span>
            </div>
        </div>
        <ul>
            <li>
                <a href="incoming-document.php" class="navigation">
                <i class='bx bxs-dashboard' style='color:#282929'></i>
                    <span class="nav-item">Incoming Document</span>
                    <?php if($countPendingDocument > 0) {?>
                        <span class="badge bg-danger rounded-pill mr-3"><?php echo $countPendingDocument; ?></span>
                    <?php } ?>
                
                </a>
                <span class="tooltip">Incoming Document</span>
            </li>
            <li>
                <a href="receive-documents.php" class="navigation">
                <i class='bx bxs-dashboard' style='color:#282929'></i>
                    <span class="nav-item">Received Documents</span>
                    <?php if($countReceivedDocument > 0) {?>
                        <span class="badge bg-danger rounded-pill mr-3"><?php echo $countReceivedDocument; ?></span>
                    <?php } ?>
                
                </a>
                <span class="tooltip">Received Documents</span>
            </li>
            <!-- <li>
                <a href="submit-document.php" class="navigation">
                <i class='bx bxs-dashboard' style='color:#282929'></i>
                    <span class="nav-item">Submit Document</span>
                    <span class="badge bg-success rounded-pill">14</span>
                </a>
                <span class="tooltip">Submit Document</span>
            </li> -->
            <!-- <li>
                <a href="document-tracking.php" class="navigation">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Document Tracking</span>
                </a>
                <span class="tooltip">Document Tracking</span>
            </li> -->
            <!-- <li>
                <a href="document-tracking.php" class="navigation">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Document Tracking</span>
                </a>
                <span class="tooltip">Document Tracking</span>
            </li> -->
            
            <!-- <li>
                <a href="communication.php" class="navigation">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Communication</span>
                </a>
                <span class="tooltip">Communication</span>
            </li> -->

        </ul>
    </div>

    <nav class="navbar active navbar-expand-lg">
        <div class="container-fluid">
            <div class="menu">
                <i class="bx bx-menu" id="btn" ></i>
                <h4 class="title d-none d-md-block">Navbar</h4>
            </div>
            <div class="actions">
                <div class="fullname">
                    <p class="d-none d-md-block"><?php echo $current_time; ?></p>
                </div>
                <div class="dropdown">
                    <img src="<?php echo $env_basePath; ?>assets/img/user-default.jpg" alt="User Default Image" class="dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <ul class="dropdown-menu" aria-labelledby="userDropdown" style="left: auto !important; right: 0;">
                    <!-- <p class="" style="margin-left: 10px;"><?php 
                        // if(isset($_SESSION['fullname'])){
                        //     echo $_SESSION['fullname'];
                        // }
                    ?></p> -->
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#" onclick="confirmLogout()">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="main-content">
    <!-- end of top-template.php -->