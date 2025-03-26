document.addEventListener("DOMContentLoaded", function () {
    fetchListings();
});

function fetchListings() {
    fetch("/ServiceDiscovery/php/Business/getServices.php")
        .then(response => response.json())
        .then(data => {
            let listingsTable = document.getElementById("listings-body");
            listingsTable.innerHTML = "";

            data.forEach(listing => {
                let row = `
                    <tr>
                        <td>${listing.title}</td>
                        <td>${listing.category}</td>
                        <td>${listing.description}</td>
                        <td>$${listing.price}</td>
                        <td class="${listing.status.toLowerCase()}">${listing.status}</td>
                        <td>${new Date(listing.updated_at).toLocaleDateString()}</td>
                        <td>
                            <button class="edit-btn" onclick="editListing(${listing.id})">Edit</button>
                            <button class="delete-btn" onclick="deleteListing(${listing.id})">Delete</button>
                            <button class="save-btn" onclick="saveListing(${listing.id})">Save</button>

                        </td>
                    </tr>
                `;
                listingsTable.innerHTML += row;
            });
        })
        .catch(error => console.error("Error fetching listings:", error));
}

function editListing(id) {
    window.location.href = `/ServiceDiscovery/php/Business/updateService.php?id=${id}`;
}

function deleteListing(id) {
    if (confirm("Are you sure you want to delete this listing?")) {
        fetch(`/ServiceDiscovery/php/Business/deleteService.php?id=${id}`, { method: "DELETE" })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchListings();
            })
            .catch(error => console.error("Error deleting listing:", error));
    }
}

function saveListing(id) {
    if (confirm("Save this listing?")) {
        fetch(`/ServiceDiscovery/php/Business/postService.php?id=${id}`, { method: "SAVE" })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchListings();
            })
            .catch(error => console.error("Error saving listing:", error));
    }
}
