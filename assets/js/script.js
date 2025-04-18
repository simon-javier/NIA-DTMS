const sidebarTitle = document.querySelector("#sidebarTitle");
const pages = document.querySelectorAll(".sidebar-item");

let currentlyActiveItem = null; // Variable to store the currently active item

// Find the initially active item (if any) on page load
// This assumes one item might start with the active classes.
// Adjust the selector if your active state is marked differently initially.
currentlyActiveItem = document.querySelector(".sidebar-item.bg-green-600");


document.addEventListener("DOMContentLoaded", () => {
    const currentPage = window.location.pathname.split('/').pop();
    pages.forEach((item) => {
        if (item.classList.contains(currentlyActiveItem)) {
            return;
        }

        const linkHref = item.getAttribute("href");
        if (linkHref !== null && linkHref.includes(currentPage)) {
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
const submenu = userManagementMenu.parentElement.querySelector(".hidden");
const chevron = userManagementMenu.querySelector(".chevron");

userManagementMenu.addEventListener("click", () => {

    chevron.classList.toggle("bx-chevron-down");
    chevron.classList.toggle("bx-chevron-up");
    submenu.classList.toggle('hidden');
})

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
