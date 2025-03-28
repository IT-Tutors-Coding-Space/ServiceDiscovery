<?php
    require_once "../../php/session_handler.php";

    if (!isBusinessOwner()) {
        header("Location: /ServiceDiscovery/pages/Home/login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Listings</title>
    <link rel="stylesheet" href="/Assets/css/Dashboard/listings.css">
</head>
<body>

<section class="manage-listings">
    <div class="listing-header">
        <h1>Manage Listings</h1>
    </div>

    <div class="listing-controls">
        <div class="batch-actions" id="batch-actions" style="display: none;">
            <select id="bulk-action" aria-label="Bulk actions">
                <option value="">Bulk Actions</option>
                <option value="activate">Activate</option>
                <option value="deactivate">Deactivate</option>
                <option value="delete">Delete</option>
            </select>
            <button onclick="applyBulkAction()">Apply</button>
            <span id="selected-count">0 listings selected</span>
        </div>
    </div>

    <div class="table-container">
        <table class="listings-table" aria-describedby="table-description">
            <caption id="table-description" class="sr-only">List of your business service listings</caption>
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all" onclick="toggleSelectAll()"></th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="listings-body">
                <tr id="empty-state">
                    <td colspan="8">No listings found. <button type="submit"  onclick="openModal()">Create your first listing</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
<div id="add-listing-modal" class="modal" style="display: none;" aria-hidden="true">
    <div class="modal-content">
        <span class="close-btn" onclick="closeAddListingModal()" aria-label="Close modal">&times;</span>
        <h2 id="modal-title">Add New Listing</h2>
        
        <form id="listing-form" class="listing-form" onsubmit="submitListingForm(event)">
            <!-- Basic Information -->
            <div class="form-group">
                <label for="listing-title">Title*</label>
                <input type="text" id="listing-title" required aria-required="true">
            </div>
            
            <div class="form-group">
                <label for="listing-category">Category*</label>
                <select id="listing-category" required aria-required="true">
                    <option value="">Select a category</option>
                    <option value="repair">Repair Services</option>
                    <option value="cleaning">Cleaning</option>
                    <option value="consulting">Consulting</option>
                    <option value="education">Education</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <!-- Price and Status -->
            <div class="form-group">
                <label for="listing-price">Price (/=)*</label>
                <input type="number" id="listing-price" min="0" step="0.01" required aria-required="true">
            </div>
            
            <div class="form-group">
                <label for="listing-status">Status</label>
                <select id="listing-status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="pending">Pending Approval</option>
                </select>
            </div>
            
            <!-- Description -->
            <div class="form-group full-width">
                <label for="listing-description">Description*</label>
                <textarea id="listing-description" required aria-required="true"></textarea>
            </div>
            
            <!-- Images -->
            <div class="form-group full-width">
                <label for="listing-images">Images</label>
                <input type="file" id="listing-images" multiple accept="image/*">
                <div id="image-preview" class="image-preview"></div>
            </div>
            
            <!-- Form Actions -->
            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="closeAddListingModal()">Cancel</button>
                <button type="submit" class="submit-btn">Save Listing</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Listing Modal (hidden by default) -->
<div id="add-listing-modal" class="modal" style="display: none;" aria-hidden="true">
    <div class="modal-content">
        <span class="close-btn" onclick="closeAddListingModal()" aria-label="Close modal">&times;</span>
        <h2>Add New Listing</h2>
        <!-- Form content would go here -->
    </div>
</div>

<script src="/Assets/js/manage_listings.js"></script>
</body>
</html>