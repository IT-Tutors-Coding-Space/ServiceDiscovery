<?php
    require_once "../../php/session_handler.php";

    if (!isCustomer()) {
        header("Location: /ServiceDiscovery/pages/Home/login.php");
        exit();
    }

        // Fetch customer details from the session or database
        $user_id = $_SESSION['id'];
        require_once "../../php/conn.php";
    
        $stmt = $conn->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
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
    fetch(`/ServiceDiscovery/php/search_handler.php?q=${query}`)
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
