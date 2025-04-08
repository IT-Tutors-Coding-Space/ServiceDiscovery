document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const menuToggle = document.getElementById("menu-toggle");
    const profileBtn = document.getElementById("profile-btn");
    const profileDropdown = document.getElementById("profile-dropdown");
    const content = document.getElementById("content");

    // Sidebar toggle functionality
    menuToggle.addEventListener("click", function () {
        sidebar.classList.toggle("open");
    });

    // Profile dropdown toggle
    profileBtn.addEventListener("click", (event) => {
        event.stopPropagation();
        profileDropdown.style.display = (profileDropdown.style.display === "block") ? "none" : "block";
    });

    // Close dropdown on outside click
    document.addEventListener("click", (event) => {
        if (!profileBtn.contains(event.target) && !profileDropdown.contains(event.target)) {
            profileDropdown.style.display = "none";
        }
    });


    // Sidebar navigation functionality
    document.querySelectorAll(".sidebar a").forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const page = this.getAttribute("data-page");
            navigateTo(page);
        });
    });

    // Load content dynamically
    function loadPage(url) {
        fetch(url)
            .then(response => response.text())
            .then(html => {
                content.innerHTML = html;
            })
            .catch(error => {
                content.innerHTML = "<p>Error loading page.</p>";
                console.error("Error:", error);
            });
    }

    // Navigation handler
    function navigateTo(page) {
        const url = page === "profile"
            ? "/ServiceDiscovery/pages/Dashboard/profile.php"
            : `/ServiceDiscovery/pages/Dashboard/${page}.php`;
        
        history.pushState({}, "", `#${page}`);
        loadPage(url);
    }

    // Load page based on hash or default to dashboard
    function loadPageFromHash() {
        const page = window.location.hash.replace("#", "") || "business_dashboard";
        navigateTo(page);
    }

    // Handle back/forward navigation
    window.addEventListener("popstate", loadPageFromHash);

    // Initial page load
    loadPageFromHash();

    // Attach logout function to logout button
    document.getElementById("logout-btn").addEventListener("click", logout);
});
