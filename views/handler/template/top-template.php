


<?php 
    session_start();
    $user_id = $_SESSION['userid'];
    $officename = $_SESSION['office'];
    require '../../connection.php';

    if(!isset($_SESSION['userid'])){
        header("Location: ../../index.php");
        exit;
    }
    $current_time = date("M j, Y g:i A");

    $notifCountQuery = "SELECT COUNT(*) from tbl_notification where user_id = :user_id and status = 'unread'";
    $stmt = $pdo->prepare($notifCountQuery);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $notificationCount = $stmt->fetchColumn();

    $notificationQuery = "SELECT * from tbl_notification where user_id = :user_id and status = 'unread' ORDER BY timestamp desc";
    $stmt = $pdo->prepare($notificationQuery);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $userProfileQuery = "SELECT user_profile from tbl_userinformation where id = :id";
    $stmt = $pdo->prepare($userProfileQuery);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $userProfile = $stmt->fetch(PDO::FETCH_ASSOC);



    try {
        $user_id = $_SESSION['userid'];
        //code...
        $docu_query = "SELECT tbl_handler_incoming.receive_at as date_receive, tbl_handler_incoming.*, tbl_uploaded_document.*  
                        FROM tbl_handler_incoming 
                        JOIN tbl_uploaded_document ON tbl_handler_incoming.docu_id = tbl_uploaded_document.id 
                        WHERE tbl_handler_incoming.user_id = :user_id and tbl_handler_incoming.status != 'notyetreceive'
                        ORDER BY receive_at DESC";
    
        $stmt = $pdo->prepare($docu_query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $docu_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Count the number of rows
        $num_rows = $stmt->rowCount();
    
        // Now $num_rows contains the count of rows returned by the query
    
    } catch (\Throwable $th) {
        echo $th;
        exit;
    }

    $docu_query = "SELECT COUNT(*) as count
                FROM tbl_handler_incoming 
                JOIN tbl_uploaded_document ON tbl_handler_incoming.docu_id = tbl_uploaded_document.id 
                WHERE tbl_handler_incoming.user_id = :user_id 
                AND tbl_handler_incoming.status = 'notyetreceive'
                AND tbl_uploaded_document.completed != 'pulled'";

    $stmt = $pdo->prepare($docu_query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $countNewDocument = $result['count'];
   


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
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/datatable/dataTables.dataTables.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/datatable/dataTables.dateTime.min.css">
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="https://cdn.rawgit.com/cozmo/jsQR/master/dist/jsQR.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="sidebar.css">
    <style>
        .dropdown-menu-left{
            float: left !important;
        }
    </style>
</head>
<body>
<?php require '../../assets/loader/loader.php'; ?>
    <div class="sidebar active">
        <div class="top">
            <div class="logo">
                <img src="<?php echo $env_basePath; ?>assets/img/logo.png" alt="User Default Image">
                <span>NIA Document Tracking and Management System</span>
            </div>
        </div>
        <ul>
        <li>
                <a href="dashboard.php" class="navigation">
                <i class='bx bxs-grid-alt' ></i>
                    <span class="nav-item">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="submit-document.php" class="navigation">
                <i class='bx bx-mail-send' ></i>
                    <span class="nav-item">Submit Document</span>
                </a>
                <span class="tooltip">Submit Document</span>
            </li>
            <li>
                <a href="newly-created-docs.php" class="navigation">
                <i class='bx bx-mail-send' ></i>
                    <span class="nav-item">New Documents</span>
                    <?php if($countNewDocument > 0){ ?>
                        <span class="badge bg-success rounded-pill"><?php echo $countNewDocument; ?></span>
                        <?php } ?>
                    
                </a>
                <span class="tooltip">New Documents</span>
            </li>
            <li>
                <a href="incoming-documents.php" class="navigation">
                <i class='bx bxs-file-export'></i>
                    <span class="nav-item">Incoming Documents</span>
                    <?php if($num_rows > 0){ ?>
                        <span class="badge bg-success rounded-pill mr-3" style="color: white;"><?php echo $num_rows; ?></span>
                        <?php } ?>
                
                </a>
                <span class="tooltip">Incoming Documents</span>
            </li>
            <li>
                <a href="received-documents.php" class="navigation">
                <i class='bx bx-file'></i>
                    <span class="nav-item">Received Documents</span>
                </a>
                <span class="tooltip">Received Documents</span>
            </li>
            <li>
                <a href="outgoing-documents.php" class="navigation">
                <i class='bx bxs-file-import' ></i>
                    <span class="nav-item">Ongoing Documents</span>
                </a>
                <span class="tooltip">Ongoing Documents</span>
            </li>

            
            <li onclick="toggleDropdown()">
                <a href="#" class="navigation" >
                    <i class='bx bxs-receipt' ></i>
                    <span class="nav-item">Transactions</span>
                </a>
                <span class="tooltip">Transactions</span>
            </li>
            <div class="custom-dropdown" style="margin-left: 10px; display: none;">
                <li>
                    <a href="generate-report.php" class="navigation">
                    <i class='fa fa-arrow-right'></i>
                        <span class="nav-item">Generate Report</span>
                    </a>
                    <span class="tooltip">Generate Report</span>
                </li>
                <li>
                    <a href="pulled-documents.php" class="navigation">
                    <i class='fa fa-arrow-right'></i>
                        <span class="nav-item">Pulled Documents</span>
                    </a>
                    <span class="tooltip">Pulled Documents</span>
                </li>
                <li>
                    <a href="completed-documents.php" class="navigation">
                    <i class='fa fa-arrow-right'></i>
                        <span class="nav-item">Complete Documents</span>
                    </a>
                    <span class="tooltip">Complete Documents</span>
                </li>



                <li>
                    <a href="incomplete-documents.php" class="navigation">
                    <i class='fa fa-arrow-right'></i>
                        <span class="nav-item">Incomplete Documents</span>
                    </a>
                    <span class="tooltip">Incomplete Documents</span>
                </li>
            </div>

            <li style="display: none;">
                <a href="transfer-complete.php" class="navigation">
                <i class='bx bxs-inbox'></i>
                    <span class="nav-item">Take Action</span>
                </a>
                <span class="tooltip">Take Action</span>
            </li>

            <li>
                <a href="scan-qr-code.php" class="navigation">
                <i class='bx bxs-inbox'></i>
                    <span class="nav-item">Scan QR Code</span>
                </a>
                <span class="tooltip">Scan QR Code</span>
            </li>
            <!-- <li>
                <a href="transfered-documents.php" class="navigation">
                    <i class='bx bx-transfer-alt'></i>
                    <span class="nav-item">Transfered Documents</span>
                    <span class="badge bg-success rounded-pill">14</span>
                </a>
                <span class="tooltip">Transfered Documents</span>
            </li>
            <li>
                <a href="completed-documents.php" class="navigation">
                <i class='bx bx-check'></i>
                    <span class="nav-item">Completed Documents</span>
                    <span class="badge bg-success rounded-pill">14</span>
                </a>
                <span class="tooltip">Completed Documents</span>
            </li> -->
            <!-- <li>
                <a href="#" class="navigation" onclick="toggleDropdown()">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">User Management</span>
                </a>
                <span class="tooltip">User Management</span>
            </li> -->
            <!-- <div class="custom-dropdown" style="margin-left: 10px; display: none; transition: display 0.5s ease;">
                <li>
                    <a href="offices.php" class="navigation">
                        <i class="bx bxs-grid-alt"></i>
                        <span class="nav-item">Offices</span>
                    </a>
                    <span class="tooltip">Offices</span>
                </li>
                <li>
                    <a href="external.php" class="navigation">
                        <i class="bx bxs-grid-alt"></i>
                        <span class="nav-item">External</span>
                    </a>
                    <span class="tooltip">External</span>
                </li>
            </div> -->
            
            <!-- <li>
                <a href="document-tracking.php" class="navigation">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Document Tracking</span>
                </a>
                <span class="tooltip">Document Tracking</span>
            </li> -->
            <!-- <li>
                <a href="generate-reports.php" class="navigation">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Generate Reports</span>
                </a>
                <span class="tooltip">Generate Reports</span>
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
                <div class="btn-group">
    <button type="button" class="btn btn-primary" id="openModalBtn" data-id="<?php echo $_SESSION['userid'] ?>" onclick="openNotification(event)">
        <i class='bx bx-bell'></i>
        <?php if ($notificationCount > 0) { ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?php echo $notificationCount; ?>
            </span>
        <?php } ?>
    </button>
</div>
<div class="modal" id="notificationModal" style="color: black">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <?php if (!empty($notifications)) { ?>
                    <?php foreach ($notifications as $notification) { ?>
                        <div class="mb-3 border-bottom">
                            <p><?php echo $notification['content']; ?></p>
                            <small class="text-muted">
                                <?php echo date('F j, Y', strtotime($notification['timestamp'])); ?>
                            </small>
                           
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p class="text-center">No new notification.</p>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <a href="notifications.php">View all notifications</a>
                <button type="button" class="btn btn-secondary" id="closeModalBtn">Close</button>
            </div>
        </div>
    </div>
</div>


                <!-- <div class="fullname">
                    <p class="d-none d-md-block"><?php 
                        // if(isset($_SESSION['fullname'])){
                        //     echo $_SESSION['fullname'];
                        // }
                    ?></p>
                </div> -->
                <div class="dropdown">
                <img src="<?php echo $env_basePath; ?>assets/user-profile/<?php echo $userProfile['user_profile']; ?>" alt="User Default Image" class="dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="height: 50px; width: 50px;">
                    <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="<?php echo $env_basePath ?>views/settings/update-profile.php">Settings</a></li>
                        <li><a class="dropdown-item" href="#" onclick="confirmLogout()">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="main-content">
    <!-- end of top-template.php -->

    <script>
    function toggleDropdown() {
        var dropdown = document.querySelector('.custom-dropdown');
        dropdown.style.display = (dropdown.style.display === 'none') ? 'block' : 'none';
    }
</script>

