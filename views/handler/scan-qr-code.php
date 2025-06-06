<?php require 'template/top-template.php'; ?>
<?php require '../../connection.php'; ?>

<div
    class="border-b border-gray-900/10 p-12 rounded-md bg-neutral-50 w-[95%] self-center my-10 grid place-content-center">
    <div class="flex flex-col justify-center items-center gap-3">
        <video class="border-5 rounded-xl border-green-500 video" id="preview"></video>
        <button class="bg-black py-2 cursor-pointer rounded-md text-neutral-50 w-full hover:bg-black/90"
            onclick="scanQRCode()">Scan QR
            Code</button>
        <form id="find_code" class="w-full mt-3">
            <div class="flex items-center justify-center gap-3">
                <input type="text"
                    class="block w-full rounded-md bg-neutral-50 px-3 py-1.5
                    text-base text-neutral-900 outline-1 -outline-offset-1
                    outline-gray-300 placeholder:text-gray-400 sm:text-sm/6 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600"
                    name="code" placeholder="Input document tracking code" required>
                <button type="submit" id="find_code_button"
                    class="bg-blue-600 py-2 rounded-md text-neutral-50 w-30 cursor-pointer hover:bg-blue-500">Find
                    Code</button>
            </div>
        </form>
    </div>
</div>





<?php require 'template/bottom-template.php'; ?>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<script>
    let scanner;

    function startScanner() {
        scanner = new Instascan.Scanner({
            video: document.getElementById('preview')
        });

        scanner.addListener('scan', function(content) {
            // Callback when a QR code is scanned
            try {
                const url = new URL(content);
                const code = url.searchParams.get('code');
                $.ajax({
                    url: "../../controller/upload-docu-controller.php",
                    type: "POST",
                    data: $("#find_code").serialize() + "&action=find_code&code=" + code,
                    success: function(response) {
                        setTimeout(function() {
                            $('.loader-container').fadeOut();

                        }, 500);

                        if (response.status === "failed") {
                            Swal.fire({
                                title: 'Failed!',
                                text: response.message,
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        } else if (response.status === "error") {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });

                        } else if (response.status === "success") {

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
                                        success: function(response) {

                                            setTimeout(function() {

                                                $('.loader-container').fadeOut();
                                            }, 500);

                                            if (response.status === "failed") {
                                                Swal.fire({
                                                    title: 'Something went wrong!',
                                                    text: response.message,
                                                    icon: 'warning',
                                                    confirmButtonText: 'OK'
                                                });
                                            } else if (response.status === "error") {
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
                                            } else if (response.status === "success") {
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
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
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

        // Initialize the scanner after getting camera access
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                const rearCamera = cameras.find(camera => camera.name.toLowerCase().includes('back'));
                scanner.start(rearCamera || cameras[0]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function(error) {
            Swal.fire({
                title: 'Error',
                text: 'Failed to access cameras',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }

    // Stop the scanner when navigating away
    window.addEventListener('beforeunload', function() {
        if (scanner) {
            scanner.stop();
        }
    });

    // Start the scanner when the page is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
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
<script>
    $("#find_code_button").click(function(e) {
        if ($("#find_code")[0].checkValidity()) {
            e.preventDefault();
            $('.loader-container').fadeIn();
            $.ajax({
                url: "../../controller/upload-docu-controller.php",
                type: "POST",
                data: $("#find_code").serialize() + "&action=find_code",
                success: function(response) {
                    setTimeout(function() {
                        $('.loader-container').fadeOut();

                    }, 500);

                    if (response.status === "failed") {
                        Swal.fire({
                            title: 'Failed!',
                            text: response.message,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    } else if (response.status === "error") {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });

                    } else if (response.status === "success") {

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
                                    success: function(response) {

                                        setTimeout(function() {

                                            $('.loader-container').fadeOut();
                                        }, 500);

                                        if (response.status === "failed") {
                                            Swal.fire({
                                                title: 'Something went wrong!',
                                                text: response.message,
                                                icon: 'warning',
                                                confirmButtonText: 'OK'
                                            });
                                        } else if (response.status === "error") {
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
                                        } else if (response.status === "success") {
                                            Swal.fire({
                                                title: 'Success!',
                                                text: response.message,
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "incoming-documents.php";

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
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
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
