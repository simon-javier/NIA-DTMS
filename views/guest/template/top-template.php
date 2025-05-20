<?php
session_start();
$user_id = $_SESSION['userid'];
require '../../connection.php';
if (!isset($_SESSION['userid'])) {
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
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/cloudflare/all.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/datatable/datatables.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/css/boxicons.min.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/css/fontawesome.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/css/brands.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/css/solid.css">
    <link rel="stylesheet" href="<?php echo $env_basePath; ?>assets/css/output.css">

    <script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.2.1.slim.min.js" defer></script>
    <script src="<?php echo $env_basePath; ?>assets/datatable/datatables.min.js" defer></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/popper.min.js" defer></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/sweetalert2.all.min.js" defer></script>
    <script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.6.4.min.js" defer></script>
    <script src="<?php echo $env_basePath; ?>assets/js/script.js" defer></script>
</head>


<body class="bg-gray-200 text-neutral-950 flex min-h-screen">
    <?php require '../../assets/loader/loader.php'; ?>
    <!-- Sidebar -->
    <div class="bg-neutral-50 w-[270px] shrink-0 shadow-lg flex flex-col gap-9 h-screen sticky top-0" id="sidebar">
        <div class="flex flex-col items-center mt-4 gap-3">
            <img src="<?php echo $env_basePath; ?>assets/img/logo.png" class="w-1/2" alt="">
            <h1 class="text-lg font-bold text-center w-10/12" id="sidebarTitle">
                NIA Document Tracking and Management System
            </h1>
        </div>
        <div>
            <div class="flex text-green-50 justify-center">
                <a href="submit-document.php" class="navigation select-none flex gap-3 bg-green-600 p-3 w-11/12
                            rounded-md sidebar-item">
                    <i class="bx bx-mail-send text-2xl text-green-200 sidebar-icon"></i>
                    Submit Document
                </a>
            </div>
            <div class="flex justify-center items-center">
                <a href="pending-document.php" class="navigation select-none flex gap-3 p-3 w-11/12 rounded-md hover:bg-neutral-200
                            cursor-pointer sidebar-item">
                    <i class="bx bx-file text-2xl text-gray-500 sidebar-icon"></i>
                    Pending Document
                    <?php if ($count_pending > 0): ?>
                        <div class="rounded-full w-5 h-5 p-1 
                                        bg-green-600 text-green-100 flex justify-center
                                        items-center text-xs font-bold ml-auto self-center">
                            <p class="">
                                <?php echo $count_pending; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </a>
            </div>
            <div class="flex justify-center">
                <a href="document-tracking.php" class="navigation select-none flex gap-3 p-3 w-11/12 rounded-md hover:bg-neutral-200
                            cursor-pointer sidebar-item">
                    <i class="bx bx-file text-2xl text-gray-500 sidebar-icon"></i>
                    Document Tracking
                </a>
            </div>
            <div class="flex justify-center">
                <?php if ($result) { ?>
                    <a href="communication.php?convoid=<?php echo $result['conversation_id']; ?>" class="navigation select-none flex gap-3 p-3 w-11/12 rounded-md hover:bg-neutral-200
                                cursor-pointer sidebar-item items-center">
                        <i class="bx bx-chat text-2xl text-gray-500 sidebar-icon"></i>
                        Communication
                        <?php if ($message_count > 0): ?>
                            <div class="rounded-full w-5 h-5 p-1 
                                            bg-green-600 text-green-100 flex justify-center
                                            items-center text-xs font-bold ml-auto">
                                <p class="">
                                    <?php echo $message_count; ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </a>
                <?php } else { ?>
                    <a href="#" onclick="createConversation();" class="navigation select-none flex gap-3 p-3 w-11/12 rounded-md hover:bg-neutral-200
                                cursor-pointer sidebar-item items-center">
                        <i class="bx bx-chat text-2xl text-gray-500 sidebar-icon"></i>
                        Communication
                        <?php if ($message_count > 0): ?>
                            <div class="rounded-full w-5 h-5 p-1 
                                            bg-green-600 text-green-100 flex justify-center
                                            items-center text-xs font-bold ml-auto">
                                <p class="">
                                    <?php echo $message_count; ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
    <main class="flex flex-col flex-1">
        <!-- Navigation Bar -->
        <header>
            <nav class="bg-neutral-50 w-full flex justify-end items-center
                gap-6 shadow-sm">
                <p class="font-bold text-gray-500 py-5">
                    <?php echo $current_time; ?>
                </p>
                <button type="button" class="cursor-pointer relative" id="notificationButton"
                    data-id="<?php echo $user_id; ?>">
                    <i class='bx bx-bell text-2xl text-gray-500 hover:text-green-600'></i>
                    <?php if ($notificationCount > 0) { ?>
                        <span
                            class="bg-red-600 p-1 w-2 h-1 inline-block rounded-full absolute left-3 border-neutral-50 border-1"></span>
                    <?php } ?>
                </button>
                <a href="../../views/settings/update-profile.php" class="cursor-pointer">
                    <i class='bx bx-cog text-2xl text-gray-500 hover:text-green-600'></i>
                </a>
                <button type="button" class="cursor-pointer mr-5" id="profileLogo">
                    <img src="<?php echo $env_basePath; ?>assets/user-profile/<?php echo $userProfile['user_profile']; ?>"
                        class="drop-shadow-md size-9
                        object-cover rounded-full hover:drop-shadow-green-600" alt="">
                </button>
            </nav>
            <!-- Profile Logo Modal -->
            <button type="button" class="hidden cursor-pointer absolute right-4 z-20 shadow-2xl text-red-600 items-baseline
                    bg-neutral-50 py-4 px-5 rounded-lg gap-2 top-17 hover:bg-gray-100" id="logoutBtn">
                <i class="fa-solid fa-right-from-bracket"></i>
                <p>Logout</p>
            </button>

            <!-- Notification Modal -->
            <div class="absolute hidden flex-col right-4 top-18 bg-neutral-50 
                max-w-[402px] rounded-xl shadow-2xl z-10" id="notificationModal">
                <div class="py-3 px-4">
                    <h1 class="text-sm">Notifications</h1>
                </div>
                <div class="">
                    <?php if (!empty($notifications)) { ?>
                        <?php foreach ($notifications as $notification) { ?>
                            <div class="flex gap-3 items-center p-3
                                border-y-gray-200 border-y-1 max-w-[368px]">
                                <i class='p-1 bg-gray-200 rounded-md border-gray-300 border-1 bx bxs-envelope'></i>
                                <div>
                                    <h2 class="text-sm font-bold">New Message</h2>
                                    <p class="text-xs text-neutral-500">
                                        <?php echo $notification['content']; ?>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <p class="text-center py-10 px-24">No new notification</p>
                    <?php } ?>
                </div>
                <div class="py-3 px-4 text-center bg-neutral-100 rounded-b-xl">
                    <a href="notifications.php" class="text-sm text-neutral-600">See all notifications</a>
                </div>
            </div>

        </header>
