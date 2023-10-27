// add hovered class to selected list item
let list = document.querySelectorAll("#navigation li");

function activeLink() {
    list.forEach((item) => {
        item.classList.remove("hovered");
    });
    this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle
let toggle = document.querySelector("#toggle");
let navigation = document.querySelector("#navigation");
let main = document.querySelector("#main");

toggle.onclick = function () {
    navigation.classList.toggle("active");
    main.classList.toggle("active");
};

// //edit profile

// // Get DOM elements
// const editButton = document.getElementById("edit-button");
// const saveButton = document.getElementById("save-button");
// const formInputs = document.querySelectorAll("#profile-form input");

// // Function to toggle form edit mode
// function toggleFormEditMode() {
//     formInputs.forEach((input) => {
//         input.disabled = !input.disabled;
//     });

//     saveButton.disabled = !saveButton.disabled;
//     editButton.textContent =
//         editButton.textContent === "Edit" ? "Cancel" : "Edit";
// }

// // Event listener for edit button click
// editButton.addEventListener("click", toggleFormEditMode);

// // Event listener for form submission
// document.getElementById("profile-form").addEventListener("submit", (e) => {
//     e.preventDefault();
//     toggleFormEditMode();
//     // Perform save or update logic here
// });
