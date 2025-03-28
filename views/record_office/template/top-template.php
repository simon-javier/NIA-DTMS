


<?php 
    session_start();
    $user_id = $_SESSION['userid'];
    $office_name = $_SESSION['office'];
    require '../../connection.php';
    if(!isset($_SESSION['userid'])){
        header("Location: ../../index.php");
        exit;
    }

    $userid = $_SESSION['userid'];
    $findUserID = "SELECT conversation_id from tbl_conversation where user_id = :userid";
    $stmt = $pdo->prepare($findUserID);
    $stmt->bindParam(':userid', $userid);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    //counting the receive documents
    $docu_query = "SELECT tbl_office_document.status as docu_status, tbl_office_document.*, tbl_uploaded_document.*  
    FROM tbl_office_document 
    JOIN tbl_uploaded_document ON tbl_office_document.docu_id = tbl_uploaded_document.id 
    WHERE (tbl_office_document.status = 'active' OR tbl_office_document.status = 'completed') 
    AND tbl_office_document.office_name = :office_name ORDER BY tbl_uploaded_document.updated_at DESC";

$stmt = $pdo->prepare($docu_query);
$stmt->bindParam(':office_name', $office_name);
$stmt->execute();
$docu_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Counting the number of rows
$receive_documents_count = $stmt->rowCount();



//counting the ongoing
$docu_query = "SELECT tbl_handler_outgoing.*, tbl_uploaded_document.*  
                FROM tbl_handler_outgoing 
                JOIN tbl_uploaded_document ON tbl_handler_outgoing.docu_id = tbl_uploaded_document.id 
                WHERE tbl_handler_outgoing.office_name = :office and tbl_uploaded_document.completed != 'pulled'
                ORDER BY receive_at DESC";

$stmt = $pdo->prepare($docu_query);
$stmt->bindParam(':office', $office_name);
$stmt->execute();
$docu_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Counting the number of rows
$ongoing_count = $stmt->rowCount();


    


    $current_time = date("M j, Y g:i A");

    $notifCountQuery = "SELECT COUNT(*) from tbl_notification where user_id = :user_id and status = 'unread'";
    $stmt = $pdo->prepare($notifCountQuery);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $notificationCount = $stmt->fetchColumn();

    $notificationQuery = "SELECT * from tbl_notification where user_id = :user_id and status = 'unread' ORDER BY timestamp DESC";
    $stmt = $pdo->prepare($notificationQuery);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $userProfileQuery = "SELECT user_profile from tbl_userinformation where id = :id";
    $stmt = $pdo->prepare($userProfileQuery);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $userProfile = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT COUNT(*) AS total_count FROM tbl_uploaded_document WHERE status = 'pending' AND status != 'pulled'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $totalCount = $result['total_count'];

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

        // Count of pending documents
$sql = "SELECT COUNT(*) as count FROM tbl_uploaded_document WHERE status = 'pending' AND status != 'pulled'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result_pending = $stmt->fetch(PDO::FETCH_ASSOC);
$count_pending = $result_pending['count'];

// Count of documents not yet received by user
$docu_query = "SELECT COUNT(*) as count
                FROM tbl_handler_incoming 
                JOIN tbl_uploaded_document ON tbl_handler_incoming.docu_id = tbl_uploaded_document.id 
                WHERE tbl_handler_incoming.user_id = :user_id 
                AND tbl_handler_incoming.status = 'notyetreceive'
                AND tbl_uploaded_document.completed != 'pulled' ";
                
$stmt = $pdo->prepare($docu_query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$result_not_yet_received = $stmt->fetch(PDO::FETCH_ASSOC);
$count_not_yet_received = $result_not_yet_received['count'];

// Add the counts together
$totalNewDocument = $count_pending + $count_not_yet_received;



 

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
    <script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.2.1.slim.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/stackpath/bootstrap.min.js"></script>

    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/cdnjs/bootstrap-select.min.css">

    <script src="<?php echo $env_basePath; ?>assets/cdnjs/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="sidebar.css">
 
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
                <a href="create_document.php" class="navigation">
                <i class='bx bx-map'></i>
                    <span class="nav-item">Create Tracking</span>
                </a>
                <span class="tooltip">Create Tracking</span>
            </li>
            <li>
                <a href="newly-created-docs.php" class="navigation">
                <i class='bx bx-mail-send' ></i>
                    <span class="nav-item">New Documents</span>
                    <?php if($totalNewDocument > 0){ ?>
                        <span class="badge bg-success rounded-pill"><?php echo $totalNewDocument; ?></span>
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
                    <?php if($receive_documents_count > 0){ ?>
                        <span class="badge bg-success rounded-pill mr-3" style="color: white;"><?php echo $receive_documents_count; ?></span>
                        <?php } ?>
                </a>
                <span class="tooltip">Received Documents</span>
            </li>
            <li>
                <a href="outgoing-documents.php" class="navigation">
                <i class='bx bxs-file-import' ></i>
                    <span class="nav-item">Ongoing Documents</span>
                    <?php if($ongoing_count > 0){ ?>
                        <span class="badge bg-success rounded-pill mr-3" style="color: white;"><?php echo $ongoing_count; ?></span>
                        <?php } ?>
                </a>
                <span class="tooltip">Ongoing Documents</span>
            </li>

            
            

            <li style="display: none;">
                <a href="create-tracking.php" class="navigation">
                <i class='bx bx-mail-send' ></i>
                    <span class="nav-item">Transfer to Internal Office</span>
                    <!-- <span class="badge bg-success rounded-pill">14</span> -->
                </a>
                <span class="tooltip">Transfer to Internal Office</span>
            </li>

            <li style="display: none;">
                <a href="accept-decline.php" class="navigation">
                <i class='bx bx-mail-send' ></i>
                    <span class="nav-item">Document Details</span>
                    <!-- <span class="badge bg-success rounded-pill">14</span> -->
                </a>
                <span class="tooltip">Document Details</span>
            </li>
            <!-- <li>
                <a href="document-tracking.php" class="navigation">
                <i class='bx bx-map'></i>
                    <span class="nav-item">Document Tracking</span>
                </a>
                <span class="tooltip">Document Tracking</span>
            </li> -->

            

            <li>
                <a href="document-tracking.php" class="navigation">
                <i class='bx bx-map'></i>
                    <span class="nav-item">Document Tracking</span>
                </a>
                <span class="tooltip">Document Tracking</span>
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
                    <a href="pulled-document.php" class="navigation">
                    <i class='fa fa-arrow-right'></i>
                        <span class="nav-item">Pulled Documents</span>
                    </a>
                    <span class="tooltip">Pulled Documents</span>
                </li>
                <li>
                    <a href="complete-document.php" class="navigation">
                    <i class='fa fa-arrow-right'></i>
                        <span class="nav-item">Complete Documents</span>
                    </a>
                    <span class="tooltip">Complete Documents</span>
                </li>

                <script>
                    function toggleDropdown() {
                        var dropdown = document.querySelector('.custom-dropdown');
                        dropdown.style.display = (dropdown.style.display === 'none') ? 'block' : 'none';
                    }
                </script>

                <li>
                    <a href="incomplete-document.php" class="navigation">
                    <i class='fa fa-arrow-right'></i>
                        <span class="nav-item">Incomplete Documents</span>
                    </a>
                    <span class="tooltip">Incomplete Documents</span>
                </li>
            </div>


            <li>
                <a href="communication.php" class="navigation">
                <i class='bx bx-map'></i>
                    <span class="nav-item">Communication</span>
                </a>
                <span class="tooltip">Communication</span>
            </li>
            <li>
                <a href="scan-qr-code.php" class="navigation">
                <i class='bx bxs-inbox'></i>
                    <span class="nav-item">Scan QR Code</span>
                </a>
                <span class="tooltip">Scan QR Code</span>
            </li>




        
            <!-- <li>
                <a href="document-tracking.php" class="navigation">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Document Tracking</span>
                </a>
                <span class="tooltip">Document Tracking</span>
            </li> -->
            <!-- <?php if($result){ ?>
                <li>
                    <a href="communication.php?convoid=<?php echo $result['conversation_id']; ?>" class="navigation">
                    <i class='bx bx-chat'></i>
                        <span class="nav-item">Communication</span>
                    </a>
                    <span class="tooltip">Communication</span>
                </li>
            <?php }else{ ?>
                <li>
                    <a href="#" onclick="createConversation();" class="navigation">
                    <i class='bx bx-chat'></i>
                        <span class="nav-item">Communication</span>
                    </a>
                    <span class="tooltip">Communication</span>
                </li>
            <?php } ?> -->
            

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
    <button type="button" class="btn btn-primary" id="openModalBtn" data-id="<?php echo $user_id; ?>" onclick="openNotification(event)">
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

                <div class="dropdown">
                <img src="<?php echo $env_basePath; ?>assets/user-profile/<?php echo $userProfile['user_profile']; ?>" alt="User Default Image" class="dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="height: 50px; width: 50px;">
                    <ul class="dropdown-menu" aria-labelledby="userDropdown" style="left: auto !important; right: 0;">
                    <!-- <p class="" style="margin-left: 10px;"><?php 
                        // if(isset($_SESSION['fullname'])){
                        //     echo $_SESSION['fullname'];
                        // }
                    ?></p> -->
                        <li><a class="dropdown-item" href="<?php echo $env_basePath ?>views/settings/update-profile.php">Settings</a></li>
                        <li><a class="dropdown-item" href="#" onclick="confirmLogout()">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="main-content">
    <!-- end of top-template.php -->

    