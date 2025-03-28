<?php 
    session_start();
    $user_id = $_SESSION['userid'];
    require '../../connection.php';

    if(!isset($_SESSION['userid'])){
        header("Location: ../../index.php");
        exit;
    }
    if($_SESSION['role'] != 'admin'){
        header("Location: ../../index.php");
        exit;
    }
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
    <style>
        .dropdown-menu-left{
            left: 0 !important;
            right: auto !important;
        }
    </style>
     <style>
        .custom-dropdown {
            display: none;
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
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Dashboard</span>
                    <!-- <span class="badge bg-success rounded-pill">14</span> -->
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="cdts-document.php" class="navigation">
                    <i class='bx bx-file'></i>
                    <span class="nav-item">CDTS Document</span>
                </a>
                <span class="tooltip">CDTS Document</span>
            </li>
            <li>
                <a href="list-office-names.php" class="navigation">
                    <i class='bx bx-file'></i>
                    <span class="nav-item">Offices</span>
                </a>
                <span class="tooltip">Offices</span>
            </li>

            <li style="display: none;">
                <a href="office-archived.php" class="navigation">
                    <i class='bx bx-file'></i>
                    <span class="nav-item">Archive List</span>
                </a>
                <span class="tooltip">Archive List</span>
            </li>
            <li style="display: none;">
                <a href="guest-archived.php" class="navigation">
                    <i class='bx bx-file'></i>
                    <span class="nav-item">Archive List</span>
                </a>
                <span class="tooltip">Archive List</span>
            </li>
            <!-- <li>
                <a href="incoming-document.php" class="navigation">
                    <i class='bx bxs-file-blank'></i>
                    <span class="nav-item">Incoming Document</span>
                </a>
                <span class="tooltip">Incoming Document</span>
            </li> -->
            <!-- <li>
                <a href="my-pending-documents.php" class="navigation">
                    <i class='bx bxs-file-blank'></i>
                    <span class="nav-item">My Pending Document</span>
                </a>
                <span class="tooltip">My Pending Document</span>
            </li> -->
            <li onclick="toggleDropdown()">
                <a href="#" class="navigation" >
                    <i class='bx bxs-user' ></i>
                    <span class="nav-item">User Management</span>
                </a>
                <span class="tooltip">User Management</span>
            </li>
            <div class="custom-dropdown" style="margin-left: 10px; display: none;">
                <li>
                    <a href="pending-account.php" class="navigation">
                    <i class='fa fa-arrow-right'></i>
                        <span class="nav-item">Incoming Registration</span>
                        <?php if($count > 0): ?>
                            <span class="badge bg-success rounded-pill"><?php echo $count; ?></span>
                            <?php endif; ?>
                    </a>
                    <span class="tooltip">Incoming Registration</span>
                </li>
                <li>
                    <a href="offices.php" class="navigation">
                    <i class='fa fa-arrow-right'></i>
                        <span class="nav-item">Document Handler</span>
                    </a>
                    <span class="tooltip">Document Handler</span>
                </li>
                <li style="display: none;">
                    <a href="add-new-users.php" class="navigation">
                    <i class='bx bx-dice-1'></i>
                        <span class="nav-item">Add New Users</span>
                    </a>
                    <span class="tooltip">Add New Users</span>
                </li>
                <li style="display: none;">
                    <a href="user-details.php" class="navigation">
                        <i class="bx bxs-grid-alt"></i>
                        <span class="nav-item">User Details</span>
                    </a>
                    <span class="tooltip">User Details</span>
                </li>
                <li style="display: none;">
                    <a href="update-details.php" class="navigation">
                        <i class="bx bxs-grid-alt"></i>
                        <span class="nav-item">Update Details</span>
                    </a>
                    <span class="tooltip">Update Details</span>
                </li>
                <li>
                    <a href="guest.php" class="navigation">
                    <i class='fa fa-arrow-right'></i>
                        <span class="nav-item">Guest</span>
                    </a>
                    <span class="tooltip">Guest</span>
                </li>
            </div>
            <li>
                <a href="office-performance.php" class="navigation">
                    <i class='bx bx-file'></i>
                    <span class="nav-item">Office Performance</span>
                </a>
                <span class="tooltip">Office Performance</span>
            </li>
<!--             
            <li>
                <a href="document-tracking.php" class="navigation">
                <i class='bx bx-radar'></i>
                    <span class="nav-item">Document Tracking</span>
                </a>
                <span class="tooltip">Document Tracking</span>
            </li> -->
            <!-- <li>
                <a href="generate-reports.php" class="navigation">
                <i class='bx bxs-report' ></i>
                    <span class="nav-item">Generate Reports</span>
                </a>
                <span class="tooltip">Generate Reports</span>
            </li> -->
            <!-- <li>
                <a href="communication.php" class="navigation">
                <i class='bx bx-chat'></i>
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
                <h4 class="title d-none d-md-block">NIA DTS</h4>
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
        


                <!-- <div class="fullname">
                    <p class="d-none d-md-block"><?php 
                        // if(isset($_SESSION['fullname'])){
                        //     echo $_SESSION['fullname'];
                        // }
                    ?></p>
                </div> -->
                <div class="dropdown">
                    <img src="<?php echo $env_basePath; ?>assets/user-profile/<?php echo $userProfile['user_profile']; ?>" alt="User Default Image" class="dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="height: 50px; width: 50px;">
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="<?php echo $env_basePath ?>views/settings/update-profile.php">Settings</a></li>
                        <li><a class="dropdown-item" href="#" onclick="confirmLogout()">Logout</a></li>
                    </div>
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