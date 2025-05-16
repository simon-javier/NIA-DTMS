


<?php 
    session_start();
    $user_id = $_SESSION['userid'];
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

    $sender_id = $_SESSION['userid'];

    $trackDocuQuery = "SELECT COUNT(*) AS count_pending FROM tbl_uploaded_document WHERE status = 'pending' AND status != 'pulled' AND sender_id = :id";

    $stmt = $pdo->prepare($trackDocuQuery);
    $stmt->bindParam(':id', $sender_id);
    $stmt->execute();
    $docu_count = $stmt->fetch(PDO::FETCH_ASSOC);

    $count_pending = $docu_count['count_pending'];

    $selectConversationID = "SELECT conversation_id FROM tbl_messages WHERE user_id = :user_id";
    $stmt = $pdo->prepare($selectConversationID);
    $stmt->bindParam(':user_id', $sender_id);
    $stmt->execute();
    
    // Check if the query executed successfully
    if ($stmt) {
        // Fetch the result
        $coversation = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Check if conversation exists
        if ($coversation) {
            $conversation_id = $coversation['conversation_id'];
        } else {
            // Handle case where no conversation is found
            $conversation_id = null; // or any default value you want to assign
        }
    } else {
        // Handle error if query execution fails
        echo "Error executing query";
        // You might want to log the error or handle it differently based on your application's requirements
    }
    
    

    $selectCount = "SELECT count(*) as count from tbl_messages where user_id != :user_id and conversation_id = :conversation_id and status = 'unread'";
    $stmt = $pdo->prepare($selectCount);
    $stmt->bindParam(':user_id', $sender_id);
    $stmt->bindParam(':conversation_id', $conversation_id);
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    $message_count = $count['count'];


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
                <a href="submit-document.php" class="navigation">
                <i class='bx bx-mail-send' ></i>
                    <span class="nav-item">Submit Document</span>
                    <!-- <span class="badge bg-success rounded-pill">14</span> -->
                </a>
                <span class="tooltip">Submit Document</span>
            </li>
            <li>
                <a href="pending-document.php" class="navigation">
                <i class='bx bx-map'></i>
                    <span class="nav-item">Pending Document</span>
                    <?php if($count_pending > 0): ?>
                    <span class="badge bg-success rounded-pill"><?php echo $count_pending; ?></span>
                    <?php endif; ?>
                </a>
                <span class="tooltip">Pending Document</span>
            </li>
            <li>
                <a href="document-tracking.php" class="navigation">
                <i class='bx bx-map'></i>
                    <span class="nav-item">Document Tracking</span>
                </a>
                <span class="tooltip">Document Tracking</span>
            </li>
            <li style="display: none;">
                <a href="pulled-document.php" class="navigation">
                <i class='bx bx-map'></i>
                    <span class="nav-item">Pulled Documents</span>
                </a>
                <span class="tooltip">Pulled Documents</span>
            </li>
            <li style="display: none;">
                <a href="incomplete-document.php" class="navigation">
                <i class='bx bx-map'></i>
                    <span class="nav-item">Incomplete Documents</span>
                </a>
                <span class="tooltip">Incomplete Documents</span>
            </li>
            <!-- <li>
                <a href="document-tracking.php" class="navigation">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Document Tracking</span>
                </a>
                <span class="tooltip">Document Tracking</span>
            </li> -->
            <?php if($result){ ?>
                <li>
                    <a href="communication.php?convoid=<?php echo $result['conversation_id']; ?>" class="navigation">
                    <i class='bx bx-chat'></i>
                        <span class="nav-item">Communication</span>
                        <?php if($message_count > 0): ?>
                            <span class="badge bg-success rounded-pill"><?php echo $message_count; ?></span>
                        <?php endif; ?>
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
            <?php } ?>
            

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

    