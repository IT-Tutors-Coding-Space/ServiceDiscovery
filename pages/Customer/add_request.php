<?php
require_once "../../php/session_handler.php";
if (!isCustomer()) {
    exit("<p>You must be logged in as a customer.</p>");
}
?>

<div class="request-form">
    <h2>Post a Service Request</h2>
    <form id="service-request-form">
        <input type="text" id="title" placeholder="Title" required>
        <textarea id="description" placeholder="Describe your request" required></textarea>
        <input type="text" id="category" placeholder="Category" required>
        <input type="number" id="budget" placeholder="Budget (optional)">
        <button type="submit">Post Request</button>
    </form>
    <p id="request-message"></p>
</div>

<script>
document.getElementById("service-request-form").addEventListener("submit", function(event) {
    event.preventDefault();
    let formData = new FormData();
    formData.append("title", document.getElementById("title").value);
    formData.append("description", document.getElementById("description").value);
    formData.append("category", document.getElementById("category").value);
    formData.append("budget", document.getElementById("budget").value);

    fetch("/ServiceDiscovery/php/Customer/add_request.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById("request-message").innerText = data;
        document.getElementById("service-request-form").reset();
    })
    .catch(error => console.error("Error:", error));
});
</script>
