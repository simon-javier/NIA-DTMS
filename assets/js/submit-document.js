document.addEventListener('DOMContentLoaded', () => {
    var timeoutId;

    $(document).ready(function() {
        $('#docu_code').on('input', function() {

            clearTimeout(timeoutId);


            var docuCode = $(this).val();


            timeoutId = setTimeout(function() {

                $.ajax({
                    url: '../../controller/qr-code-controller.php',
                    method: 'POST',
                    data: {
                        docu_code: docuCode
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Update the QR code image source
                        if (response.status == 'success') {
                            $("#file_name").val(response.qrCodeData);
                            $('#qrCodeImage').attr('src', '<?php echo $env_basePath; ?>assets/qr-codes/' + response.qrCodeData);
                        } else {
                            Swal.fire({
                                title: 'Failed!',
                                text: 'Document code already exists.',
                                icon: 'warning',
                                confirmButtonText: 'OK'
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
            }, 1000); //(1 second)
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.getElementById('file');

        fileInput.addEventListener('change', function() {
            var selectedFile = this.files[0];

            // Check if a file is selected
            if (selectedFile) {
                // Check file type
                var allowedTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'image/jpeg', 'image/png'];
                if (!allowedTypes.includes(selectedFile.type)) {
                    showError('Please select a valid file type (PDF, DOCX, Excel, JPEG, PNG, etc.).');
                    resetFileInput();
                    return;
                }

                // Check file size (in bytes)
                var maxSize = 3 * 1024 * 1024; // 3 MB
                if (selectedFile.size > maxSize) {
                    showError('File size should be less than 3 MB.');
                    resetFileInput();
                    return;
                }
                showError("");
            }
        });

        function showError(message) {
            $("#attachmentError").text(message);
        }

        function resetFileInput() {
            fileInput.value = '';
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var textarea = document.getElementById('description');
        var charCount = document.getElementById('charCount');

        textarea.addEventListener('input', function() {
            var maxLength = 250;
            var currentLength = textarea.value.length;

            if (currentLength > maxLength) {
                textarea.value = textarea.value.substring(0, maxLength);
                currentLength = maxLength;
            }

            charCount.textContent = currentLength + '/' + maxLength;
        });
    });

    $("#upload_docu_button").click(function(e) {

        if ($("#upload_docu_form")[0].checkValidity()) {
            e.preventDefault();

            $('.loader-container').fadeIn();
            var formData = new FormData($("#upload_docu_form")[0]);
            formData.append("action", "upload_document_external");
            formData.append("data_source", "guest");

            $.ajax({
                url: "../../controller/upload-docu-controller.php",
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
                                location.reload();

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
});
