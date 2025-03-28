document.addEventListener("DOMContentLoaded", () => {
    // Sidebar navigation (SPA behavior)
    document.querySelectorAll(".sidebar a[data-page]").forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const page = this.getAttribute("data-page");
            loadPage(page);
        });
    });

    // Profile dropdown toggle
    document.getElementById("profile-btn").addEventListener("click", function () {
        document.getElementById("profile-dropdown").classList.toggle("show");
    });

    // Logout function
    window.logout = function() {
        fetch("/ServiceDiscovery/php/logout.php")
            .then(() => window.location.href = "/ServiceDiscovery/pages/Home/login.php")
            .catch(err => console.error("Logout failed", err));
    };
});

function loadPage(page) {
    fetch(`/ServiceDiscovery/pages/Customer/${page}.php`)
        .then(response => response.text())
        .then(data => {
            document.getElementById("content").innerHTML = data;
        })
        .catch(error => console.error("Error loading page:", error));
}
