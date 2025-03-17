document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const menuToggle = document.getElementById("menu-toggle");

    menuToggle.addEventListener("click", function () {
        sidebar.classList.toggle("open");
    });

    const profileBtn = document.getElementById("profile-btn");
    const profileDropdown = document.getElementById("profile-dropdown");

    // Toggle the dropdown on button click
    profileBtn.addEventListener("click", (event) => {
        event.stopPropagation(); // Prevents the click from bubbling up
        profileDropdown.style.display = (profileDropdown.style.display === "block") ? "none" : "block";
    });

    // Close the dropdown when clicking outside of it
    document.addEventListener("click", (event) => {
        if (!profileBtn.contains(event.target) && !profileDropdown.contains(event.target)) {
            profileDropdown.style.display = "none";
        }
    });

    // Sidebar navigation
    const links = document.querySelectorAll(".sidebar a");
    const content = document.getElementById("content");

    links.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const page = this.getAttribute("data-page");

            // Load the page content
            fetch(`/Service/pages/Dashboard/${page}.html`)
                .then(response => response.text())
                .then(data => {
                    content.innerHTML = data;
                    window.history.pushState({}, "", `#${page}`); // Update URL without reload
                })
                .catch(error => {
                    content.innerHTML = "<p>Error loading page.</p>";
                    console.error("Error:", error);
                });
        });
    });

    // Load content from hash on page load or back navigation
    function loadPageFromHash() {
        const page = window.location.hash.replace("#", "") || "business_dashboard";
        fetch(`/Service/pages/Dashboard/${page}.html`)
            .then(response => response.text())
            .then(data => {
                content.innerHTML = data;
            })
            .catch(error => {
                content.innerHTML = "<p>Error loading page.</p>";
                console.error("Error:", error);
            });
    }

    window.addEventListener("load", loadPageFromHash);
    window.addEventListener("popstate", loadPageFromHash);

    function navigateTo(page){
        let url = page == "profile" ? "/Service/pages/Dashboard/profile.html" : `/Service/pages/Dashboard/${page}.html`;
        history.pushState({},"",`#${page}`);
        loadPage(url);

    }
    function logout(){
        localStorage.removeItem('userToken');
        sessionStorage.clear();
        loadPage("/Service/pages/Home/login.html");
    }

    function loadPage(url){
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById('content').innerHTML = html;
            })
            .catch(error => {
                content.innerHTML = "<p>Error loading page.</p>";
                console.error("Error:", error);
            });
    }
    function loadPageFromHash(){
        const page = window.location.hash.replace("#", "") || "profile";
        navigateTo(page);
    }
    window.addEventListener("load", loadPageFromHash);
    window.addEventListener("popstate", loadPageFromHash);
});
