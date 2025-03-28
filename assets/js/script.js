const sidebarTitle = document.querySelector("#sidebarTitle");
const pages = document.querySelectorAll(".sidebar-item");

let currentlyActiveItem = null; // Variable to store the currently active item

// Find the initially active item (if any) on page load
// This assumes one item might start with the active classes.
// Adjust the selector if your active state is marked differently initially.
currentlyActiveItem = document.querySelector(".sidebar-item.bg-green-600");

pages.forEach((item) => {
    item.addEventListener("click", handleItemClick);
});

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

