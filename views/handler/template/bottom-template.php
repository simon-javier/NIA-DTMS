<!-- start of bottom-template.php -->
</main>

<script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.2.1.slim.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.6.4.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/cdnjs/moment.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/datatable/datatables.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jsdelivr/popper.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jsdelivr/sweetalert2.all.min.js"></script>
<script src="https://cdn.rawgit.com/cozmo/jsQR/master/dist/jsQR.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="<?php echo $env_basePath; ?>assets/js/script.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable with your table ID
        $('#mainTable').DataTable();

        // Set placeholder text for DataTables search input
        $('#dt-search-0').attr('placeholder', '🔎 Search all');

    });
    let minDate, maxDate;

    // Custom filtering function which will search data in column four between two values
    DataTable.ext.search.push(function(settings, data, dataIndex) {
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
    let table = new DataTable('#mainTable');

    // Refilter the table
    document.querySelectorAll('#min, #max').forEach((el) => {
        el.addEventListener('change', () => table.draw());
    });
</script>




<script>
    $(document).ready(function() {
        // Initialize DataTable with your table ID
        $('#mainTable').DataTable();

        // Set placeholder text for DataTables search input
        $('#dt-search-0').attr('placeholder', '🔎 Search all');

    });
    let minDate1, maxDate1;

    // Custom filtering function which will search data in column four between two values
    DataTable.ext.search.push(function(settings, data, dataIndex) {
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
    let table1 = new DataTable('#mainTable');

    // Refilter the table
    document.querySelectorAll('#min1, #max1').forEach((el) => {
        el.addEventListener('change', () => table1.draw());
    });
</script>
