const sidebarTitle = document.querySelector("#sidebarTitle");
const pages = document.querySelectorAll(".sidebar-item");

let currentlyActiveItem = null; // Variable to store the currently active item

// Find the initially active item (if any) on page load
// This assumes one item might start with the active classes.
// Adjust the selector if your active state is marked differently initially.
currentlyActiveItem = document.querySelector(".sidebar-item.bg-green-600");
const currentPage = window.location.pathname.split('/').pop();


document.addEventListener("DOMContentLoaded", () => {
    pages.forEach((item) => {
        if (item.classList.contains(currentlyActiveItem)) {
            return;
        }

        let linkHref = "";

        if (item.tagName === "LI") {
            linkHref = item.querySelector('a').getAttribute("href");
        } else {
            linkHref = item.getAttribute("href");
        }

        if (linkHref !== null && (linkHref.startsWith(`./${currentPage}`) || linkHref.startsWith(currentPage))) {
            setActiveState(item);
        } else {
            setInactiveState(item);
        }
    });
})


function setActiveState(item) {
    if (!item) return; // Guard clause if item is null

    const itemIcon = item.querySelector("i"); // Find icon only when needed
    const itemParent = item.parentElement;
    // Add active classes
    item.classList.add("bg-green-600");
    item.classList.remove("hover:bg-neutral-200");

    if (itemIcon) { // Check if itemIcon exists
        itemIcon.classList.add("text-green-200");
        itemIcon.classList.remove("text-gray-500");
    }

    if (itemParent.tagName === "UL") {
        item.classList.add("text-green-50");
    } else {
        itemParent.classList.add("text-green-50");

    }

}

function setInactiveState(item) {
    if (!item) return; // Guard clause if item is null

    const itemIcon = item.querySelector("i"); // Find icon only when needed
    const itemParent = item.parentElement;

    // Remove active classes and restore inactive ones
    item.classList.remove("bg-green-600");
    item.classList.add("hover:bg-neutral-200");
    itemParent.classList.remove("text-green-50");

    if (itemIcon) { // Check if itemIcon exists
        itemIcon.classList.remove("text-green-200");
        itemIcon.classList.add("text-gray-500");
    }

    if (itemParent.tagName === "UL") {
        item.classList.remove("text-green-50");
    }
}

function handleItemClick() {
    const clickedItem = this;

    // If the clicked item is already active, do nothing
    if (clickedItem === currentlyActiveItem) {
        return;
    }

    // Deactivate the previously active item (if one exists)
    if (currentlyActiveItem) {
        setInactiveState(currentlyActiveItem);
    }

    // Activate the newly clicked item
    setActiveState(clickedItem);

    // Update the reference to the currently active item
    currentlyActiveItem = clickedItem;
}

const userManagementMenu = document.querySelector("#userManagement");
let submenu;
let chevron;
if (userManagementMenu) {
    submenu = userManagementMenu.parentElement.querySelector(".hidden");
    chevron = userManagementMenu.querySelector(".chevron");

    userManagementMenu.addEventListener("click", () => {

        chevron.classList.toggle("bx-chevron-down");
        chevron.classList.toggle("bx-chevron-up");
        submenu.classList.toggle('hidden');
    })
}


const notificationBtn = document.querySelector("#notificationButton");
const notificationModal = document.querySelector("#notificationModal");
notificationBtn.addEventListener("click", (event) => {
    const userId = event.target.closest("[data-id]").getAttribute("data-id");
    $('.loader-container').fadeIn();
    let formData = new FormData();
    formData.append("action", "mark_as_read");
    formData.append("userid", userId);

    $.ajax({
        url: "../../controller/notification-controller.php",
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
                notificationModal.classList.toggle("hidden")
                notificationModal.classList.toggle("flex")
                if (notificationModal.classList.contains("hidden")) {
                    window.location.reload();
                }

            }


        },
        error: function(xhr, status, error) {
            // Handle the error here
            let errorMessage = 'An error occurred while processing your request.';
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

})

const profileLogo = document.querySelector("#profileLogo");
const logoutBtn = document.querySelector("#logoutBtn");
profileLogo.addEventListener("click", () => {
    logoutBtn.classList.toggle("hidden");
    logoutBtn.classList.toggle("flex");
})

logoutBtn.addEventListener("click", () => {
    Swal.fire({
        titleText: "Logout",
        html: `
            <p class="text-sm text-neutral-500">Are you sure you want to logout?</p>
        `,
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'Logout'
    }).then((result) => {
        if (result.isConfirmed) {
            // User clicked "Yes, logout!" - Redirect to logout.php
            window.location.href = '../../logout.php';
        }
    });
})

let btnText = "";
let btnClassName = "";
switch (currentPage) {
    case "list-office-names.php":
        btnText = "<i class='bx bx-plus-circle text-lg'></i>New Office";
        btnClassName = "new-document-btn"
        break;
    case "cdts-document.php":
        btnText = "<i class='bx bx-plus-circle text-lg'></i>New Document";
        btnClassName = "new-document-btn"
        break;
    case "pending-account.php":
        btnText = "<i class='bx bx-archive-in'></i>Archived Accounts";
        btnClassName = "dec-reg-btn";
        break;
    case "guest-archived.php":
        btnText = "<i class='bx bx-arrow-back text-base'></i> Back";
        btnClassName = "dec-reg-btn backBtn";
        break;
    case "offices.php":
        btnText = "<i class='bx bx-plus-circle text-lg'></i>New User";
        btnClassName = "new-document-btn newUserBtn";
        break;
    case "guest.php":
        btnText = "<i class='bx bx-plus-circle text-lg'></i>New User";
        btnClassName = "new-document-btn newGuestUserBtn";
        break;
    case "pending-document.php":
        btnText = "<i class='fa-solid fa-file'></i>Document List";
        btnClassName = "docViewBtn";
        break;
    case "pulled-document.php":
        btnText = "<i class='bx bx-arrow-back text-base'></i>Back";
        btnClassName = "dec-reg-btn backBtn";
        break;
    case "incomplete-document.php":
        btnText = "<i class='bx bx-arrow-back text-base'></i>Back";
        btnClassName = "dec-reg-btn backBtn";
        break;
    case "document-tracking.php":
        btnText = "<i class='bx bx-arrow-back text-base'></i>Back";
        btnClassName = "btnHidden";
        break;
    case "newly-created-docs.php":
        btnText = "<i class='bx bx-arrow-back text-base'></i>Back";
        btnClassName = "btnHidden";
        break;
    case "incoming-documents.php":
        btnText = "<i class='bx bx-arrow-back text-base'></i>Back";
        btnClassName = "btnHidden";
        break;
    case "received-documents.php":
        btnText = "<i class='bx bx-arrow-back text-base'></i>Back";
        btnClassName = "btnHidden";
        break;
    case "outgoing-documents.php":
        btnText = "<i class='bx bx-arrow-back text-base'></i>Back";
        btnClassName = "btnHidden";
        break;
    case "complete-document.php":
        btnText = "<i class='bx bx-arrow-back text-base'></i>Back";
        btnClassName = "btnHidden";
        break;
}

const mainTable = new DataTable('#mainTable', {
    responsive: true,
    columnDefs: [{
        orderable: false,
        responsivePriority: 2,
        targets: -1,
    }],
    layout: {
        top0End: {
            buttons: [
                {
                    className: btnClassName,
                    text: btnText,
                }]
        },
    }
});

$('.dec-reg-btn').click(() => {
    window.location.href = "guest-archived.php";
})

$('.docViewBtn').click(() => {
    document.querySelector('.dropdown-list').classList.toggle('hidden');
})

$('.dec-reg-btn.backBtn').click(() => {
    history.back()
})

$('.new-document-btn.newUserBtn').click(() => {
    window.location.href = "add-new-users.php?type=handler";
})

$('.new-document-btn.newGuestUserBtn').click(() => {
    window.location.href = "add-new-users.php?type=handler";
})


$('.new-document-btn').click(() => {
    $("#newDocModal").toggleClass("hidden");
    $("#documentType").select();
})

$("#editDocModal").keydown((e) => {
    if (e.key === "Escape") {
        $('#editDocModal').toggleClass("hidden");
    }
})

$("#editDocModal").click((e) => {
    const target = e.target;
    if (target.className.includes("close-btn")) {
        $('#editDocModal').toggleClass("hidden");
    }
})

$("#newDocModal").keydown((e) => {
    if (e.key === "Escape") {
        $("#newDocModal").toggleClass("hidden");
    }
})

$("#newDocModal").click((e) => {
    const target = e.target;
    if (target.className.includes("close-btn")) {
        $("#newDocModal").toggleClass("hidden");
    }
})

$("#newDocumentFormbtn").click(function(e) {
    if ($("#newDocumentForm")[0].checkValidity()) {
        e.preventDefault();

        $('.loader-container').fadeIn();
        let formData = new FormData($("#newDocumentForm")[0]);
        formData.append("action", "create_document");

        $.ajax({
            url: "../../controller/document-type-controller.php",
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
                        titleText: 'Successful',
                        html: `<p class="text-sm text-neutral-500">${response.message}</p>`,
                        icon: 'success',
                        confirmButtonColor: 'oklch(62.7% 0.194 149.214)',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }


            },
            error: function(xhr, status, error) {
                // Handle the error here
                let errorMessage = 'An error occurred while processing your request.';
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

$("#addNewOfficebtn").click(function(e) {
    if ($("#addNewOffice")[0].checkValidity()) {
        e.preventDefault();

        $('.loader-container').fadeIn();
        let formData = new FormData($("#addNewOffice")[0]);
        formData.append("action", "add_office");

        $.ajax({
            url: "../../controller/office-name-controller.php",
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
                        titleText: 'Successful',
                        html: `<p class="text-sm text-neutral-500">${response.message}</p>`,
                        icon: 'success',
                        confirmButtonColor: 'oklch(62.7% 0.194 149.214)',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();

                        }
                    });
                }


            },
            error: function(xhr, status, error) {
                // Handle the error here
                let errorMessage = 'An error occurred while processing your request.';
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

$('#mainTable').on('click', '.dropdown-btn', (e) => {
    const id = $(e.currentTarget).data('drop-id');
    const targetDropdown = $(`#dropdownList${id}`);
    const isCurrentlyVisible = !targetDropdown.hasClass('hidden');

    // Hide all dropdowns
    $('[id^="dropdownList"]').addClass('hidden');

    // If it was hidden before, show it
    if (!isCurrentlyVisible) {
        targetDropdown.removeClass('hidden');
    }
})

// Attach a click event to the edit button
$('#mainTable').on('click', '.edit-button', (e) => {
    const id = $(e.target).data('id');
    $('#editDocModal').toggleClass("hidden");

    switch (currentPage) {
        case "cdts-document.php":
            const documentType = $(e.target).data('document');
            $('#document_id').val(id);
            $('#editDocumentType').val(documentType);
            $('#editDocumentType').select();
            break;
        case "list-office-names.php":
            const officeName = $(e.target).data('office');
            const officeCode = $(e.target).data('code');
            $('#officeId').val(id);
            $('#editOfficeName').val(officeName);
            $('#editOfficeCode').val(officeCode);
            $('#editOfficeName').select();
        default:
            break;
    }

});

$("#editofficeinfobtn").click(function(e) {
    if ($("#editofficeinfo")[0].checkValidity()) {
        e.preventDefault();

        $('.loader-container').fadeIn();
        let formData = new FormData($("#editofficeinfo")[0]);
        formData.append("action", "edit_office");

        $.ajax({
            url: "../../controller/office-name-controller.php",
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
                        titleText: 'Successful',
                        html: `<p class="text-sm text-neutral-500">${response.message}</p>`,
                        icon: 'success',
                        confirmButtonColor: 'oklch(62.7% 0.194 149.214)',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }


            },
            error: function(xhr, status, error) {
                // Handle the error here
                let errorMessage = 'An error occurred while processing your request.';
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

$("#editDocumentFormbtn").click(function(e) {
    if ($("#editDocumentForm")[0].checkValidity()) {
        e.preventDefault();

        $('.loader-container').fadeIn();
        let formData = new FormData($("#editDocumentForm")[0]);
        formData.append("action", "edit_document");

        $.ajax({
            url: "../../controller/document-type-controller.php",
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
                        titleText: 'Successful',
                        html: `<p class="text-sm text-neutral-500">${response.message}</p>`,
                        icon: 'success',
                        confirmButtonColor: 'oklch(62.7% 0.194 149.214)',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();

                        }
                    });
                }


            },
            error: function(xhr, status, error) {
                // Handle the error here
                let errorMessage = 'An error occurred while processing your request.';
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

function decline(button) {
    let userId = button.dataset.id;
    Swal.fire({
        titleText: "Decline Registration?",
        html: `<p class="text-sm text-neutral-500">This will decline the registration of the user and notify via email.</p>`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "oklch(57.7% 0.245 27.325)",
        confirmButtonText: "Decline"
    }).then((result) => {
        if (result.isConfirmed) {
            $('.loader-container').fadeIn();
            $.ajax({
                url: "../../controller/crud-users-controller.php",
                type: "POST",
                data: "action=decline_account&id=" + userId,
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
                            titleText: 'Successful',
                            html: `<p class="text-sm text-neutral-500">${response.message}</p>`,
                            icon: 'success',
                            confirmButtonColor: 'oklch(62.7% 0.194 149.214)',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();

                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    let errorMessage = 'An error occurred while processing your request.';
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

function approve(button) {
    let userId = button.dataset.id;
    Swal.fire({
        titleText: "Approve Registration?",
        html: `<p class="text-sm text-neutral-500">This will approve the registration of the user and notify via email.`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "oklch(52.7% 0.154 150.069)",
        confirmButtonText: "Approve",
    }).then((result) => {
        if (result.isConfirmed) {
            $('.loader-container').fadeIn();
            $.ajax({
                url: "../../controller/crud-users-controller.php",
                type: "POST",
                data: "action=approve_account&id=" + userId,
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
                            titleText: 'Successful',
                            html: `<p class="text-sm text-neutral-500">${response.message}</p>`,
                            icon: 'success',
                            confirmButtonColor: 'oklch(62.7% 0.194 149.214)',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();

                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    let errorMessage = 'An error occurred while processing your request.';
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


function unarchiveAccount(button) {
    let userId = button.dataset.id;
    Swal.fire({
        titleText: "Unarchive account?",
        html: `<p class="text-sm text-neutral-500">The user will again access to the system again.</p>`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "oklch(70.7% 0.165 254.624)",
        confirmButtonText: "Unarchive"
    }).then((result) => {
        if (result.isConfirmed) {
            $('.loader-container').fadeIn();
            $.ajax({
                url: "../../controller/crud-users-controller.php",
                type: "POST",
                data: "action=unarchive_account&id=" + userId,
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
                            titleText: 'Successful',
                            html: `<p class="text-sm text-neutral-500">${response.message}</p>`,
                            icon: 'success',
                            confirmButtonColor: 'oklch(62.7% 0.194 149.214)',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();

                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    let errorMessage = 'An error occurred while processing your request.';
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

$("#update_information_button").click(function(e) {
    if ($("#update_information")[0].checkValidity()) {
        e.preventDefault();
        Swal.fire({
            titleText: 'Are you sure?',
            html: `<p class="text-sm text-neutral-500">You are about to update the information</p>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "oklch(62.7% 0.194 149.214)",
            confirmButtonText: 'Update'

        }).then((result) => {
            // If the user clicks "Yes, update it!", submit the form
            if (result.isConfirmed) {
                $('.loader-container').fadeIn();
                $.ajax({
                    url: "../../controller/crud-users-controller.php",
                    type: "POST",
                    data: $("#update_information").serialize() + "&action=update_information",
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
                                titleText: 'Successful',
                                html: `<p class="text-sm text-neutral-500">${response.message}</p>`,
                                icon: 'success',
                                confirmButtonColor: 'oklch(62.7% 0.194 149.214)',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();

                                }
                            });
                        }


                    },
                    error: function(xhr, status, error) {
                        // Handle the error here
                        let errorMessage = 'An error occurred while processing your request.';
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
});


$("#add_user_btn").click(function(e) {
    debugger;

    if ($("#user_form")[0].checkValidity()) {
        e.preventDefault();

        $('.loader-container').fadeIn();
        $.ajax({
            url: "../../controller/crud-users-controller.php",
            type: "POST",
            data: $("#user_form").serialize() + "&action=add_new_user",
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
                        titleText: 'Successful',
                        html: `<p class="text-sm text-neutral-500">Account added successfully.</p>`,
                        icon: 'success',
                        confirmButtonColor: 'oklch(62.7% 0.194 149.214)',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();

                        }
                    });
                }


            },
            error: function(xhr, status, error) {
                // Handle the error here
                let errorMessage = 'An error occurred while processing your request.';
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

function createConversation() {
    Swal.fire({
        title: "Want to have conversation with admin?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, i want it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $('.loader-container').fadeIn();
            $.ajax({
                url: "../../controller/conversation-controller.php",
                type: "POST",
                data: "action=create_new_conversation",
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
                    }
                    else if (response.status === "success") {
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

