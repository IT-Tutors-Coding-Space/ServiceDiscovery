//for signup
document.addEventListener("DOMContentLoaded", function () {
    let errorMessage = document.getElementById("error-message");
    if (errorMessage) {
        setTimeout(() => {
            errorMessage.style.display = "none";
        }, 5000); // Hide after 5 seconds
    }
});

//for login
document.addEventListener("DOMContentLoaded", function() {
    // Select all the popup messages
    const messages = document.querySelectorAll('.popup-message');

    messages.forEach(function(message) {
        // Show the message
        message.classList.add('show');

        // Hide the message after 3 seconds
        setTimeout(function() {
            message.classList.remove('show');
        }, 3000); // Adjust the time (in milliseconds) as needed
    });
});
