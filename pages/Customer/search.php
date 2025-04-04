<?php
require_once "../../php/session_handler.php";

if (!isCustomer()) {
    exit("<p>You must be logged in as a customer.</p>");
}

//fetch user id
$user_id = $_SESSION['id'];
require_once "../../php/conn.php";

?>
<link rel="stylesheet" href="/ServiceDiscovery/Assets/css/search.css">
<link rel="stylesheet" href="/ServiceDiscovery/Assets/css/Cprofile.css">

<section class="search-services">
    <h2>Find the Best Services</h2>
    <div class="search-bar">
        <input type="text" id="search-box" placeholder="Search for businesses, categories..." onkeyup="searchServices()">
        <button onclick="searchServices()">
            🔍 Search
        </button>
    </div>
    <div id="loading" class="loading">Searching...</div>
    <div id="search-results"></div>
</section>

<script>
function searchServices() {
    const query = document.getElementById("search-box").value.trim();
    if (query.length < 2) {
        document.getElementById("search-results").innerHTML = "";
        return;
    }

    document.getElementById("loading").style.display = "block"; // Show loading

    fetch(`/ServiceDiscovery/php/search.php?q=${query}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById("loading").style.display = "none"; // Hide loading
            let resultsDiv = document.getElementById("search-results");

            if (data.length === 0) {
                resultsDiv.innerHTML = "<p class='no-results'>No businesses found.</p>";
                return;
            }

            resultsDiv.innerHTML = data.map(business => 
                `<div class="business-card">
                    <h3>${business.name}</h3>
                    <p>Category: <strong>${business.category}</strong></p>
                    <a href="/ServiceDiscovery/pages/Business/profile.php?id=${business.id}" class="view-profile">
                        View Profile →
                    </a>
                </div>`
            ).join('');
        })
        .catch(error => {
            document.getElementById("loading").style.display = "none";
            console.error("Search error:", error);
        });
}
</script>
