document.addEventListener("DOMContentLoaded", function () {
    fetch("/ServiceDiscovery/php/Cprofile.php")
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                window.location.href = "/ServiceDiscovery/pages/Home/login.php";
                return;
            }

            // Remove skeleton effect by replacing placeholders with actual data
            document.getElementById("customer-name").innerText = data.name;
            document.getElementById("customer-name").classList.remove("skeleton-text");

            document.getElementById("customer-email").innerText = data.email;
            document.getElementById("customer-email").classList.remove("skeleton-text");

            document.getElementById("customer-contact").innerText = data.phone || "Not provided";
            document.getElementById("customer-contact").classList.remove("skeleton-text");

            document.getElementById("customer-location").innerText = data.address || "Not provided";
            document.getElementById("customer-location").classList.remove("skeleton-text");

            // Remove profile image skeleton
            document.querySelector(".profile-pic").classList.remove("skeleton");
        })
        .catch(error => console.error("Error fetching profile:", error));
});
