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
});

// Optimized Page Loader
function loadPage(url) {
    const content = document.getElementById('content');
    if (!content) return;

    content.innerHTML = "<p>Loading...</p>"; // Show loading text

    fetch(url)
        .then(response => {
            if (!response.ok) throw new Error("Network error");
            return response.text();
        })
        .then(html => content.innerHTML = html)
        .catch(error => {
            setTimeout(() => { 
                content.innerHTML = "<p>Error loading page.</p>"; 
                console.error("Error:", error);
            }, 1000); // Delay error message for better UX
        });
}

// Secure Logout Function
const logoutButton = document.getElementById("logout-btn");
if (logoutButton) {
    logoutButton.addEventListener("click", function () {
        fetch("/ServiceDiscovery/php/logout.php", {
            method: "POST",
            credentials: "include" // Ensures session cookies are sent
        })
        .then(response => {
            if (!response.ok) throw new Error("Logout failed.");
            return response.json();
        })
        .then(data => {
            if (data.success) {
                localStorage.removeItem('userToken'); // Clear stored token
                sessionStorage.clear(); // Clear session
                window.location.href = "/ServiceDiscovery/pages/Home/login.php"; // Redirect to login
            } else {
                alert("Logout error. Please try again.");
            }
        })
        .catch(error => {
            console.error("Error during logout:", error);
            alert("Logout failed. Try again.");
        });
    });
}
>>>>>>> 1d26111a30bd939c64794a148d5c885114794e55
