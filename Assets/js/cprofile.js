document.addEventListener("DOMContentLoaded", function () {
    const editBtn = document.getElementById("edit-profile-btn");
    const saveBtn = document.getElementById("save-profile-btn");

    const phoneText = document.getElementById("phone-text");
    const phoneInput = document.getElementById("phone-input");

    const addressText = document.getElementById("address-text");
    const addressInput = document.getElementById("address-input");

    let originalPhone = phoneInput.value;
    let originalAddress = addressInput.value;

    // Show input fields and allow editing
    editBtn.addEventListener("click", function () {
        phoneText.classList.add("hidden");
        phoneInput.classList.remove("hidden");
        phoneInput.focus(); // Auto-focus input

        addressText.classList.add("hidden");
        addressInput.classList.remove("hidden");

        editBtn.classList.add("hidden");
        saveBtn.classList.remove("hidden");
    });

    // Track input changes to enable/disable save button
    function checkForChanges() {
        saveBtn.disabled = phoneInput.value === originalPhone && addressInput.value === originalAddress;
    }
    phoneInput.addEventListener("input", checkForChanges);
    addressInput.addEventListener("input", checkForChanges);

    // Save changes
    saveBtn.addEventListener("click", function () {
        const phone = phoneInput.value.trim();
        const address = addressInput.value.trim();

        // Validate inputs
        if (phone === "" || address === "") {
            showErrorMessage("Fields cannot be empty!");
            return;
        }

        saveBtn.textContent = "Saving..."; // Indicate processing
        saveBtn.disabled = true;

        // Send data to server using AJAX
        fetch("/ServiceDiscovery/php/Customers/update_profile.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `phone=${encodeURIComponent(phone)}&address=${encodeURIComponent(address)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                phoneText.textContent = phone;
                addressText.textContent = address;

                originalPhone = phone; // Update stored values
                originalAddress = address;

                phoneText.classList.remove("hidden");
                phoneInput.classList.add("hidden");

                addressText.classList.remove("hidden");
                addressInput.classList.add("hidden");

                editBtn.classList.remove("hidden");
                saveBtn.classList.add("hidden");
            } else {
                showErrorMessage("Failed to update profile. Try again.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            showErrorMessage("An error occurred. Please try again.");
        })
        .finally(() => {
            saveBtn.textContent = "Save"; // Reset button text
            saveBtn.disabled = false; // Re-enable button
        });
    });

    // Function to show error messages
    function showErrorMessage(message) {
        let errorMsg = document.getElementById("error-message");
        if (!errorMsg) {
            errorMsg = document.createElement("p");
            errorMsg.id = "error-message";
            errorMsg.style.color = "red";
            errorMsg.style.fontWeight = "bold";
            saveBtn.insertAdjacentElement("beforebegin", errorMsg);
        }
        errorMsg.textContent = message;
    }
});
