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
function showPopupMessage(message, type) {
    const popup = document.createElement('div');
    popup.className = `popup-message ${type}-message show`;
    popup.innerText = message;
    document.body.appendChild(popup);
    setTimeout(() => popup.remove(), 3000);
}

