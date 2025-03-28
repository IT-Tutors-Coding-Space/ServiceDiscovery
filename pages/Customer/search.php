<?php
require_once "../../php/session_handler.php";

if (!isCustomer()) {
    exit("<p>You must be logged in as a customer.</p>");
}
?>

<div class="search-services">
    <h2>Search for Services</h2>
    <input type="text" id="search-box" placeholder="Search for businesses...">
    <button onclick="searchServices()">Search</button>
    <div id="search-results"></div>
</div>

<script>
function searchServices() {
    const query = document.getElementById("search-box").value;
    fetch(`/ServiceDiscovery/php/search.php?q=${query}`)
        .then(response => response.json())
        .then(data => {
            let resultsDiv = document.getElementById("search-results");
            resultsDiv.innerHTML = data.map(business => 
                `<p><strong>${business.name}</strong> - ${business.category}</p>`
            ).join('');
        })
        .catch(error => console.error("Search error:", error));
}
</script>
