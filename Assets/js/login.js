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
