document.addEventListener('DOMContentLoaded', () => {
    function confirmPullRequest(event) {
        const button = event.currentTarget;
        const dataId = button.getAttribute('data-id');


        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to pull this document?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, pull it!'
        }).then((result) => {

            if (result.isConfirmed) {
                $('.loader-container').fadeIn();
                var formData = new FormData($("#upload_docu_form")[0]);
                formData.append("action", "pull_documents");
                formData.append("id", dataId);

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
    }


    $("#upload_docu_button").click(function(e) {

        if ($("#upload_docu_form")[0].checkValidity()) {
            e.preventDefault();


        }
    });
})
