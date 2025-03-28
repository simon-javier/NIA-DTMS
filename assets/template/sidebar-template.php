<?php 
    session_start();
    require '../../connection.php';



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Tracking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                <a href="#" class="navigation">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Submit Document</span>
                    <span class="badge bg-success rounded-pill">14</span>
                </a>
                <span class="tooltip">Submit Document</span>
            </li>
            <li>
                <a href="#" class="navigation">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Document Tracking</span>
                </a>
                <span class="tooltip">Document Tracking</span>
            </li>
            <li>
                <a href="#" class="navigation">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Communication</span>
                </a>
                <span class="tooltip">Communication</span>
            </li>

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
                    <p class="d-none d-md-block">Full Name</p>
                </div>
                <div class="dropdown">
                    <img src="<?php echo $env_basePath; ?>assets/img/user-default.jpg" alt="User Default Image" class="dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#" onclick="confirmLogout()">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="main-content">
    <!-- end of top-template.php -->

    <!-- start of bottom-template.php -->
    </div>
   
    
</body>



<script src="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.bundle.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.2.1.slim.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jsdelivr/popper.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jsdelivr/sweetalert2.all.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.6.4.min.js"></script>
<script>
       let btn = document.querySelector('#btn');
       let sidebar = document.querySelector('.sidebar');
       let navbar = document.querySelector('.navbar');
   
       btn.onclick = function () {
           sidebar.classList.toggle('active');
           navbar.classList.toggle('active');
       };
   </script>
<script>
function confirmLogout() {
    Swal.fire({
        title: 'Are you sure you want to logout?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, logout!'
    }).then((result) => {
        if (result.isConfirmed) {
            // User clicked "Yes, logout!" - Redirect to logout.php
            window.location.href = '../../logout.php';
        }
    });
}
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the current page's filename
    var currentPage = window.location.pathname.split('/').pop();

    // Get all navigation links
    var navigationLinks = document.querySelectorAll('.navigation');

    // Get the title element
    var titleElement = document.querySelector('.title');

    // Loop through each link and add the 'active' class if the href matches the current page
    navigationLinks.forEach(function(link) {
        var linkHref = link.getAttribute('href').split('/').pop();
        if (linkHref === currentPage) {
            link.classList.add('active');
            // Update the title with the nav-item value
            titleElement.textContent = link.querySelector('.nav-item').textContent;
        }
    });
});
</script>

<script>
$(document).ready(function () {
    $('#btn').click(function () {
        // Trigger an AJAX request to update the session on the server
        
    });
});
</script>

</html>