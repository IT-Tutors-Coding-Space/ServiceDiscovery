document.addEventListener("DOMContentLoaded", function () {
    let errorMessage = document.getElementById("error-message");
    if (errorMessage) {
        setTimeout(() => {
            errorMessage.style.display = "none";
        }, 5000); // Hide after 5 seconds
    }
});
