<?php
session_start();
$user_id = $_SESSION['userid'];
require '../../connection.php';

if (!isset($_SESSION['userid'])) {
    header("Location: ../../index.php");
    exit;
}
if ($_SESSION['role'] != 'admin') {
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
                <a href="./dashboard.php" class="navigation select-none flex gap-3 bg-green-600 p-3 w-11/12
                            rounded-md sidebar-item">
                    <i class="bx bxs-grid-alt text-2xl text-green-200 sidebar-icon"></i>
                    Dashboard
                </a>
            </div>
            <div class="flex justify-center">
                <a href="./cdts-document.php" class="navigation select-none flex gap-3 p-3 w-11/12 rounded-md hover:bg-neutral-200
                            cursor-pointer sidebar-item">
                    <i class="bx bx-file text-2xl text-gray-500 sidebar-icon"></i>
                    CDTS Document
                </a>
            </div>
            <div class="flex justify-center">
                <a href="./list-office-names.php" class="navigation select-none flex gap-3 p-3 w-11/12 rounded-md hover:bg-neutral-200
                            cursor-pointer sidebar-item">
                    <i class="bx bx-file text-2xl text-gray-500 sidebar-icon"></i>
                    Offices
                </a>
            </div>
            <div class="flex flex-col items-center">
                <div class="select-none flex gap-3 p-3 w-11/12 rounded-md hover:bg-neutral-200
                            cursor-pointer" id="userManagement">
                    <i class="bx bxs-user text-2xl text-gray-500 sidebar-icon"></i>
                    User Management
                    <i class='ml-3 bx bx-chevron-down text-2xl chevron'></i>
                </div>
                <div class="submenu hidden">
                    <ul class="flex flex-col gap-2">
                        <li class="select-none p-3 rounded-md hover:bg-neutral-200 sidebar-item">
                            <a href="./pending-account.php" class="navigation flex items-center gap-3">
                                <i class="bx bx-right-arrow-alt sidebar-icon text-2xl text-gray-500"></i>
                                Incoming Registration
                                <?php if ($count > 0): ?>
                                    <div class="rounded-full w-5 h-5 p-1 
                                        bg-green-600 text-green-100 flex justify-center
                                        items-center text-xs font-bold">
                                        <p class="">
                                            <?php echo $count; ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </a>

                        </li>
                        <li class="select-none p-3 rounded-md hover:bg-neutral-200 sidebar-item">
                            <a href="./offices.php" class="navigation flex items-center gap-3">
                                <i class="bx bx-right-arrow-alt sidebar-icon text-2xl text-gray-500"></i>
                                Document Handler
                            </a>

                        </li>
                        <li class="select-none p-3 rounded-md hover:bg-neutral-200 sidebar-item">
                            <a href="./guest.php" class="navigation flex items-center gap-3">
                                <i class="bx bx-right-arrow-alt sidebar-icon text-2xl text-gray-500"></i>
                                Guest

                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex justify-center">
                <a class="navigation select-none flex gap-3 p-3 w-11/12 rounded-md hover:bg-neutral-200
                            cursor-pointer sidebar-item">
                    <i class="bx bx-file text-2xl text-gray-500 sidebar-icon"></i>
                    Office Performance
                </a>
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
                                    <h2 class="text-sm font-bold">New User Registration Request</h2>
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
