const toggleButton = document.querySelector('.nav-toggle');
const navLinks = document.querySelector('.nav-links');

// Toggle navigation menu
toggleButton.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});

// Close the nav menu when a link is clicked
const navItems = document.querySelectorAll('.nav-links a');
navItems.forEach(item => {
    item.addEventListener('click', () => {
        navLinks.classList.remove('active'); // Hide the menu after click
    });
});

// Profile picture preview
function previewImage(event) {
    const file = event.target.files[0]; // Get the selected file
    const reader = new FileReader(); // Create a new FileReader instance

    reader.onload = function () {
        const profilePic = document.getElementById('profileImage'); // Corrected ID here
        profilePic.src = reader.result; // Set the image preview to the selected file
    };

    if (file) {
        reader.readAsDataURL(file); // Convert the image to a data URL
    }
}

function clearCustomAmount() {
    // When a radio button is selected, clear the custom amount field
    document.querySelector('[name="custom_amount"]').value = '';
}

function clearDropdown() {
    // When a custom amount is entered, clear the selected radio button
    let radios = document.querySelectorAll('[name="donation_amount"]');
    radios.forEach(function (radio) {
        radio.checked = false;
    });
}
