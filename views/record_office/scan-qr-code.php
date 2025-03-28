<?php require 'template/top-template.php'; ?>
<?php require '../../connection.php'; ?>
<style>
        :root {
    --primary-color: #069734;
    --lighter-primary-color: #07b940;
    --white-color: #FFFFFF;
    --black-color: #181818;
    --bold: 600;
    --transition: all 0.5s ease;
    --box-shadow: 0 0.1rem 0.8rem rgba(0, 0, 0, 0.2);
    }
    ::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #009933; 
        border-radius: 6px;
    }
    .table-container{
        padding: 2.5rem;
        background-color: #fff;
        box-shadow: var(--box-shadow);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 85vh;
    }

    .form-control{
        border: 2px solid #009933;
        border-radius: 10px;
    }

    .filter-option{
        border: 2px solid var(--primary-color);
        border-radius: 10px;
    }
    .video{
        height: 100%;
        width: 100%;
    }
</style>


<div class="table-container">
    <div class="video-container">

        <video class="video" id="preview"></video>
        <button class="btn btn-primary mb-3 w-100" onclick="scanQRCode()">Scan QR Code</button>
        <form id="find_code" class="w-100">
        <div class="d-flex flex-column justify-content-center align-item-center">
            <input type="text" class="form-control mb-3" name="code" placeholder="Input document tracking code" required>
            <button type="submit" id="find_code_button" class="btn btn-primary">Find Code</button>
        </div>
        </form>

 
    </div>
</div>



<script>
        let scanner;

        function startScanner() {
            scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

            scanner.addListener('scan', function (content) {
                // Callback when a QR code is scanned
                try {
                    const url = new URL(content);
                    const code = url.searchParams.get('code');
                    $.ajax({
                    url: "../../controller/upload-docu-controller.php",
                    type: "POST",
                    data: $("#find_code").serialize()+"&action=find_code&code="+code,
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
                            });
                        }else if(response.status === "error"){
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            
                        }
                        else if(response.status === "success"){
        
                            Swal.fire({
                        title: 'QR Code Matched!',
                        text: `Code: ${response.code}`,
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Receive',
                        cancelButtonText: 'View',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('.loader-container').fadeIn();
                            var formData = new FormData();
                            formData.append("action", "receive_document_qrcode");
                            formData.append("code", response.code);
                            $.ajax({
                                url: "../../controller/transfer-document-controller.php",
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
                                        Swal.fire({
                                        title: 'Success!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                            }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "received-documents.php";

                                            }
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
                        } 
                        else if (result.dismiss === Swal.DismissReason.cancel) {
                            window.location.href = "track-document.php?code=" + response.code;

                        }
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
                } catch (error) {
                    // Handle parsing error with SweetAlert
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

        // Stop the scanner when navigating away
        window.addEventListener('beforeunload', function () {
            if (scanner) {
                scanner.stop();
            }
        });

        // Start the scanner when the page is fully loaded
        document.addEventListener('DOMContentLoaded', function () {
            startScanner();
        });

        function scanQRCode() {
            if (scanner) {
                // Stop the scanner and restart it
                scanner.stop();
                startScanner();
            }
        }
    </script>


<?php require 'template/bottom-template.php'; ?>

<script>
        $("#find_code_button").click(function(e){
            if($("#find_code")[0].checkValidity()){
                e.preventDefault();
                $('.loader-container').fadeIn();
                $.ajax({
                    url: "../../controller/upload-docu-controller.php",
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
                            });
                        }else if(response.status === "error"){
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            
                        }
                        else if(response.status === "success"){
        
                            Swal.fire({
                        title: 'QR Code Matched!',
                        text: `Code: ${response.code}`,
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Receive',
                        cancelButtonText: 'View',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('.loader-container').fadeIn();
                            var formData = new FormData();
                            formData.append("action", "receive_document_qrcode");
                            formData.append("code", response.code);
                            $.ajax({
                                url: "../../controller/transfer-document-controller.php",
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
                                        Swal.fire({
                                        title: 'Success!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                            }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "received-documents.php";

                                            }
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
                        } 
                        else if (result.dismiss === Swal.DismissReason.cancel) {
                            window.location.href = "track-document.php?code=" + response.code;

                        }
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
            }
        });
    </script>