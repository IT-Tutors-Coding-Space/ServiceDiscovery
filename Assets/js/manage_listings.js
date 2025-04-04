//send
document.getElementById("listing-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData(this);

    fetch("/ServiceDiscovery/php/Business/updateService.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Listing added successfully!");
            closeModal();
            fetchListings(); // Refresh table after adding a listing
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
});

//fetch
function fetchListings() {
    fetch("/ServiceDiscovery/php/Business/getService.php")
    .then(response => response.json())
    .then(data => {
        let listingsBody = document.getElementById("listings-body");
        listingsBody.innerHTML = "";

        if (data.length === 0) {
            listingsBody.innerHTML = `<tr id="empty-state">
                <td colspan="8">No listings found. <button onclick="openModal()">Create your first listing</button></td>
            </tr>`;
            return;
        }

        data.forEach(listing => {
            let row = document.createElement("tr");
            row.innerHTML = `
                <td><input type="checkbox" class="listing-checkbox" value="${listing.id}"></td>
                <td>${listing.title}</td>
                <td>${listing.category}</td>
                <td>${listing.description}</td>
                <td>${listing.price}</td>
                <td>${listing.status}</td>
                <td>${listing.created_at}</td>
                <td>
                    <button onclick="editListing(${listing.id})">Edit</button>
                    <button onclick="deleteListing(${listing.id})">Delete</button>
                </td>
            `;
            listingsBody.appendChild(row);
        });
    })
    .catch(error => console.error("Error fetching listings:", error));
}

document.addEventListener("DOMContentLoaded", fetchListings);

//delete
function deleteListing(id) {
    if (!confirm("Are you sure you want to delete this listing?")) return;

    fetch("/ServiceDiscovery/php/delete_listing.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "id=" + encodeURIComponent(id)
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) fetchListings();
    })
    .catch(error => console.error("Error deleting listing:", error));
}

// Function to open the modal
function openModal() {
    document.getElementById("add-listing-modal").style.display = "block";
}

// Function to close the modal
function closeModal() {
    document.getElementById("add-listing-modal").style.display = "none";
}

// Close modal if user clicks outside of it
window.onclick = function(event) {
    let modal = document.getElementById("add-listing-modal");
    if (event.target === modal) {
        closeModal();
    }
}

// Handle form submission
document.getElementById("listing-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission
    
    let formData = new FormData(this);

    fetch("/ServiceDiscovery/php/Business/process_listings.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) 
    .then(data => {
        if(data.status == 'sucess'){
        alert('saved successfully!'); // Show success or error message
        closeModal(); // Close modal after submission
        location.reload();
        } else{
            alert("Error:" + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
});
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("listing-form");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission
        
        let formData = {
            sname: document.getElementById("listing-title").value.trim(),
            scategory: document.getElementById("listing-category").value.trim(),
            sdescription: document.getElementById("listing-description").value.trim(),
            sprice: parseFloat(document.getElementById("listing-price").value),
        };

        let listingId = form.getAttribute("data-id"); // If updating, an ID is present
        if (listingId) {
            formData.id = listingId;
        }

        fetch("/ServiceDiscovery/php/Business/process_listings.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(formData),
        })
        .then(response => response.json())
        .then(data => {
            showPopupMessage(data.message, data.success ? "success" : "error");

            if (data.success) {
                setTimeout(() => {
                    location.reload(); // Reload to update listings
                }, 1500);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            showPopupMessage("An unexpected error occurred. Please try again.", "error");
        });
    });
});

// Function to show a popup message
function showPopupMessage(message, type) {
    let popup = document.createElement("div");
    popup.className = "popup-message " + type;
    popup.textContent = message;

    document.body.appendChild(popup);

    setTimeout(() => {
        popup.remove();
    }, 3000);
}
