<?php require 'connection.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <link rel="stylesheet" href="assets/jsdelivr/bootstrap.min.css">
    <link rel="stylesheet" href="assets/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/cloudflare/all.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://rawgit.com/schmich/instascan-builds/master/css/instascan.min.css">
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');


        :root {
            --primary-color: #069734;
            --lighter-primary-color: #07b940;
            --white-color: #FFFFFF;
            --black-color: #181818;
            --bold: 600;
            --transition: all 0.5s ease;
            --box-shadow: 0 0.5rem 0.8rem rgba(0, 0, 0, 0.2)
        }



        *{
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', 'Arial';
            scroll-behavior: smooth;
        }

        p, h1, h2, h3, h4, h5, h6{
            margin: 0;
        }
        .container{
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .content{
            border: 2px solid var(--black-color);
 
            width: 50%;
        }
        .video-container{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .video{
            width: 80%;
            height: 80%;
        }

       

        @media (max-width: 768px) {
        
            .content {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<?php require 'assets/loader/loader.php'; ?>
<div class="container">
        <div class="content">
            <div class="title d-flex justify-content-center p-3">
                <h1>QR Code Scanner</h1>
            </div>
            <div class="video-container">
                <video class="video" id="preview"></video>
            </div>
            <div class="button-container d-flex justify-content-center mb-3 mt-3">
            <!-- <div class="row">
                <div class="col-md-12">
                <button id="toggleCameraBtn" class="btn btn-primary w-100" onclick="toggleCamera()">Toggle Camera</button>
                </div>
                </div> -->
            
        </div>
            
            <div class="button-container d-flex justify-content-center mb-3 mt-3">
                
                <div class="row">
                <div class="col-md-12">
                <button id="scannedContent" class="btn btn-primary w-100" onclick="scanQRCode()">Scan QR Code</button>
                </div>
                </div>
                
            </div>
            <div class="button-container d-flex justify-content-center mb-3 mt-3">
                <div class="row">
                    <form action="" id="find_code" style="width: 100%;">
                    <div class="col-md-12 mb-3">
                        <input type="text" id="code" name="code" class="form-control text-center" placeholder="Enter tracking code" required>
                    </div>
                    <div class="col-md-12 mb-3">
                    <button type="submit" id="find_code_btn" class="btn btn-dark w-100" onclick="scanQRCode()">Find Code</button>
                    </form>
                    </div>
                    <div class="col-md-12 mb-3">
                    <a href="index.php" class="btn btn-danger w-100" style="margin-right: 5px;">Back</a>
                    </div>
                </div>
                
            </div>
        </div>

    </div>

    <script src="assets/jquery/jquery-3.2.1.slim.min.js"></script>
    <script src="assets/jsdelivr/popper.min.js"></script>
    <script src="assets/jsdelivr/bootstrap.min.js"></script>
    <script src="assets/jsdelivr/sweetalert2.all.min.js"></script>
    <script src="assets/jquery/jquery-3.6.4.min.js"></script>
    <script>
        let scanner;

        function startScanner() {
            
            scanner = new Instascan.Scanner({ video: document.getElementById('preview'),  mirror: false });

            scanner.addListener('scan', function (content) {
                try {
                    const url = new URL(content);
                    const code = url.searchParams.get('code');

                    Swal.fire({
                        title: 'QR Code Scanned!',
                        text: `Code: ${code}`,
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'View',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "<?php echo $env_basePath ?>views/guest-track.php?code=" + code;
                        }
                    });
                } catch (error) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to parse QR code content',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    const rearCamera = cameras.find(camera => camera.name.toLowerCase().includes('back'));
            scanner.start(rearCamera || cameras[0]);
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function (error) {
                Swal.fire({
                    title: 'Error',
                    text: 'Failed to access cameras',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }

        window.addEventListener('beforeunload', function () {
            if (scanner) {
                scanner.stop();
            }
        });

        // function toggleCamera() {
        //     isUsingRearCamera = !isUsingRearCamera; // Toggle the camera flag
        //     if (scanner) {
        //         scanner.stop(); // Stop the current scanner
        //         startScanner(); // Start the scanner again with the updated camera settings
        //     }
        // }

        document.addEventListener('DOMContentLoaded', function () {
            startScanner();
        });

        function scanQRCode() {
            if (scanner) {
                scanner.stop();
                startScanner();
            }
        }
    </script>
    <script>
    $("#find_code_btn").click(function(e){
        if($("#find_code")[0].checkValidity()){
            e.preventDefault();
            $('.loader-container').fadeIn();
            $.ajax({
                url: "controller/upload-docu-controller.php",
                type: "POST",
                data: $("#find_code").serialize()+"&action=find_code",
                success:function(response){
                    setTimeout(function() {
                    $('.loader-container').fadeOut();
                    }, 500);
                    if(response.status === "failed"){
                        Swal.fire({
                            title: 'Failed!',
                            text: response.message,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                        // Check if the user clicked the "OK" button
                        if (result.isConfirmed) {
                            // Reload the page
                            location.reload();
                        }
                    });
     
                    }else if(response.status === "error"){
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
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
                    if(response.status === "success"){
   
                        window.location.href = 'views/track-document.php?code='+response.code;
                        
                        
                      
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
        }
    });
</script>
</body>
</html>
