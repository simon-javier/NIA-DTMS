


<?php 
    if (isset($_SESSION['successmodal']) || isset($_SESSION['failedmodal'])) {
    ?>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.2.1.slim.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/popper.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/bootstrap.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jsdelivr/sweetalert2.all.min.js"></script>
    <script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function() {
            <?php 
                if(isset($_SESSION['successmodal'])){
            ?>
            Swal.fire({
                title: 'Success!',
                text: '<?php echo $_SESSION['successmodal'] ?>',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            <?php }
            elseif(isset($_SESSION['failedmodal'])){
                ?> 
                Swal.fire({
                title: 'Failed!',
                text: '<?php echo $_SESSION['failedmodal'] ?>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            <?php
            }
            ?>
        });
    </script>

    <?php
        unset($_SESSION['successmodal']);
        unset($_SESSION['failedmodal']);
    }
    ?>