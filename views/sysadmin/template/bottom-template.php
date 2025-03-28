 <!-- start of bottom-template.php -->
 </div>
   </body>
   
   
   
   <script src="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.2.1.slim.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/popper.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/sweetalert2.all.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.6.4.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/datatable/jquery.dataTables.min.js"></script>
    <script>
$(document).ready(function() {
        // Initialize DataTable with your table ID
        $('#example').DataTable();

        // Set placeholder text for DataTables search input
        $('.dataTables_filter input').attr('placeholder', 'Search all');
    });
   </script>
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
       var dropdown = document.querySelector('.custom-dropdown');
        
       // Loop through each link and add the 'active' class if the href matches the current page
       navigationLinks.forEach(function(link) {
           var linkHref = link.getAttribute('href').split('/').pop();
           if (linkHref === currentPage) {
               link.classList.add('active');
               // Update the title with the nav-item value
               titleElement.textContent = link.querySelector('.nav-item').textContent;
               if(linkHref == 'external.php' || linkHref == 'offices.php' || linkHref == 'add-new-users.php' || linkHref == 'user-details.php' || linkHref == 'update-details.php'){
                    dropdown.style.display = 'block';
               }

               
               
           }
       });
   });
   </script>


   
   </html>