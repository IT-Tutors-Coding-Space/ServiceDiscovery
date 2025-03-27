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
