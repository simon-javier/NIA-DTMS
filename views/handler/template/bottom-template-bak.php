 <!-- start of bottom-template.php -->
 </div>
   
    
   </body>
   
   
   
   <script src="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.2.1.slim.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/popper.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/sweetalert2.all.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.6.4.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/datatable/dataTables.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/datatable/jquery.dataTables.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/cdnjs/moment.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/datatable/dataTables.dateTime.min.js"></script>
    <script>
     $(document).ready(function() {
        // Initialize DataTable with your table ID
        $('#example').DataTable();

        // Set placeholder text for DataTables search input
        $('.dataTables_filter input').attr('placeholder', '🔎 Search all');

    });
    let minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
DataTable.ext.search.push(function (settings, data, dataIndex) {
    let min = minDate.val();
    let max = maxDate.val();
    let date = new Date(data[0]);
 
    if (
        (min === null && max === null) ||
        (min === null && date <= max) ||
        (min <= date && max === null) ||
        (min <= date && date <= max)
    ) {
        return true;
    }
    return false;
});
 
// Create date inputs
minDate = new DateTime('#min', {
    format: 'MMMM Do YYYY'
});
maxDate = new DateTime('#max', {
    format: 'MMMM Do YYYY'
});
 
// DataTables initialisation
let table = new DataTable('#example');
 
// Refilter the table
document.querySelectorAll('#min, #max').forEach((el) => {
    el.addEventListener('change', () => table.draw());
});
   </script>




<script>
     $(document).ready(function() {
        // Initialize DataTable with your table ID
        $('#example1').DataTable();

        // Set placeholder text for DataTables search input
        $('.dataTables_filter input').attr('placeholder', '🔎 Search all');

    });
    let minDate1, maxDate1;
 
// Custom filtering function which will search data in column four between two values
DataTable.ext.search.push(function (settings, data, dataIndex) {
    let min1 = minDate1.val();
    let max1 = maxDate1.val();
    let date1 = new Date(data[0]);
 
    if (
        (min1 === null && max1 === null) ||
        (min1 === null && date1 <= max1) ||
        (min1 <= date1 && max1 === null) ||
        (min1 <= date1 && date1 <= max1)
    ) {
        return true;
    }
    return false;
});
 
// Create date inputs
minDate1 = new DateTime('#min1', {
    format: 'MMMM Do YYYY'
});
maxDate1 = new DateTime('#max1', {
    format: 'MMMM Do YYYY'
});
 
// DataTables initialisation
let table1 = new DataTable('#example1');
 
// Refilter the table
document.querySelectorAll('#min1, #max1').forEach((el) => {
    el.addEventListener('change', () => table1.draw());
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
            //    console.log(linkHref);
               if(linkHref == 'external.php' || linkHref == 'offices.php'){
                    dropdown.style.display = 'block';
               }
               
           }
       });
   });
   </script>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to check screen size and update the "active" class
        function updateSidebarClass() {
            var sidebar = document.querySelector('.sidebar');
            var navbar = document.querySelector('.navbar');
            
            if (window.innerWidth > 768) {
                sidebar.classList.add('active');
                navbar.classList.add('active');
            } else {
                sidebar.classList.remove('active');
                navbar.classList.remove('active');
            }
        }

        // Initial check on page load
        updateSidebarClass();

        // Check and update on window resize
        window.addEventListener('resize', updateSidebarClass);
    });
</script> -->
<script>
    function openNotification(event) {
        var userId = event.target.getAttribute("data-id");
        $('.loader-container').fadeIn();
        var formData = new FormData();
        formData.append("action", "mark_as_read");
        formData.append("userid", userId);

        $.ajax({
                url: "../../controller/notification-controller.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success:function(response){

                    setTimeout(function() {

                    $('.loader-container').fadeOut();
                    }, 500);
                
                    if(response.status === "failed"){
                        Swal.fire({
                            title: 'Something went wrong!',
                            text: response.message,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }else if(response.status === "error"){
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                    }
                    else if(response.status === "success"){
                        var modal = document.getElementById("notificationModal");
                            modal.style.display = "block";
                            var closeBtn = document.getElementById("closeModalBtn");
                            closeBtn.addEventListener("click", function() {
                                window.location.reload();
                            });
                            
                        }
                    
                   
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    var errorMessage = 'An error occurred while processing your request.';
                    if (xhr.statusText) {
                        errorMessage += ' ' + xhr.statusText;
                    }
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage + '<br><br>' + JSON.stringify(xhr, null, 2), // Include the entire error object for debugging
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Check if the user clicked the "OK" button
                        if (result.isConfirmed) {
                            // Reload the page
                            location.reload();
                        }
                    });
                }
            });
   
};
</script>

   
   </html>