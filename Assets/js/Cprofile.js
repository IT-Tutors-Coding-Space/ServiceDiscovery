document.addEventListener("DOMContentLoaded", function () {
<<<<<<< HEAD
    fetch("/Service/php/Cprofile.php")
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                window.location.href = "/Service/pages/Home/login.html";
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
=======
    fetch("/ServiceDiscovery/php/Cprofile.php")
        .then(response => {
            if (!response.ok) throw new Error(`Network response was not ok: ${response.status}`);
            return response.json();
        })
        .then(data => { 
            if (data.error) {
                alert(data.error);
                window.location.href = "/ServiceDiscovery/pages/Home/login.php";
                return;
            }

            // Function to safely update elements
            const setTextContent = (id, text) => {
                let element = document.getElementById(id);
                if (element) {
                    element.innerText = text;
                    element.classList.remove("skeleton-text");
                }
            };

            // Update UI with user data
            setTextContent("customer-name", data.username);
            setTextContent("customer-email", data.email);
            setTextContent("customer-phone", data.phone || "Not provided"); // Updated to match HTML ID
            setTextContent("customer-address", data.address || "Not provided"); // Updated to match HTML ID

            // Remove profile image skeleton
            document.querySelector(".profile-pic")?.classList.remove("skeleton");
        })
        .catch(error => {
            console.error("Error fetching profile:", error);
            alert("Failed to load profile. Please check your connection.");
        });
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".sidebar a[data-page]").forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const page = this.getAttribute("data-page");
            loadPage(page);
        });
    });
});

function loadPage(page) {
    fetch(`/ServiceDiscovery/pages/Customer/${page}.php`)
        .then(response => response.text())
        .then(data => {
            document.getElementById("content").innerHTML = data;
        })
        .catch(error => console.error("Error loading page:", error));
}
document.addEventListener("DOMContentLoaded", () => {
    fetch("/ServiceDiscovery/php/getUserProfile.php")
        .then(response => response.json())
        .then(data => {
            document.getElementById("username").textContent = data.username || "Unknown";
            document.getElementById("email").textContent = data.email || "Not available";
            document.getElementById("phone").textContent = data.phone || "N/A";
            document.getElementById("address").textContent = data.address || "N/A";
        })
        .catch(error => console.error("Error fetching profile data:", error));
});
