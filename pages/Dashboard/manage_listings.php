<?php
require_once "../../php/session_handler.php";
require_once "../../php/conn.php"; // Include the connection file

// Ensure that the user is logged in as a business owner
if (!isBusinessOwner()) {
    header("Location: /ServiceDiscovery/pages/Home/login.php");
    exit();
}

// Fetch the business owner ID from the session
$business_owner_id = $_SESSION['business_id']; // Assuming this is stored in the session

// Query to get the business's services from the database
$sql = "SELECT id, sname, scategory, sdescription, sprice, status, created_at FROM services WHERE owner_id = :business_owner_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':business_owner_id', $business_owner_id, PDO::PARAM_INT);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Listings</title>
    <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/Dashboard/listings.css">
</head>
<body> 

<section class="manage-listings">
    <div class="listing-header">
        <h1 class="dashboard-header">Manage Listings</h1>
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
                <?php if (!empty($services)): ?>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td><input type="checkbox" class="listing-select" value="<?php echo htmlspecialchars($service['id']); ?>"></td>
                            <td><?php echo htmlspecialchars($service['sname']); ?></td>
                            <td><?php echo htmlspecialchars($service['scategory']); ?></td>
                            <td><?php echo htmlspecialchars($service['sdescription']); ?></td>
                            <td><?php echo htmlspecialchars($service['sprice']); ?></td>
                            <td><?php echo htmlspecialchars($service['status']); ?></td>
                            <td><?php echo htmlspecialchars($service['created_at']); ?></td>
                            <td>
                                <!-- Add action buttons for edit, deactivate, delete, etc. -->
                                <button>Edit</button>
                                <button>Delete</button>
                            </td>
                        </tr>                                             
                        <button type="submit" onclick="openModal()">+ Add service</button>                       
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No listings found. <button type="submit" onclick="openModal()">+ Add service</button></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<div id="add-listing-modal" class="modal" style="display: none;" >
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()" aria-label="Close modal">&times;</span>
        <h2 id="modal-title">Add New Listing</h2>
        
        <form id="listing-form" class="listing-form" action="/ServiceDiscovery/php/Business/process_listings.php" method="post">
            <!-- Basic Information -->
            <div class="form-group">
                <label for="listing-title">Title*</label>
                <input type="text" id="listing-title" name="listing-title" required aria-required="true">
            </div>
            
            <div class="form-group">
             <label for="listing-category">Category*</label>
                 <select id="listing-category" name="listing-category" required aria-required="true">
        <option value="">Select a category</option>
        <option value="repair">Computer Repair</option>
        <option value="plumbing">Plumbing</option>
        <option value="consulting">Consulting</option>
        <option value="education">Tutoring</option>
        <option value="cleaning">Cleaning</option>
        <option value="cyber">Cyber Security</option>
        <!-- 100+ other categories go here -->
        <option value="accounting">Accounting</option>
        <option value="architecture">Architecture</option>
        <option value="art">Art</option>
        <option value="automotive">Automotive</option>
        <option value="beauty">Beauty</option>
        <option value="carpentry">Carpentry</option>
        <option value="catering">Catering</option>
        <option value="construction">Construction</option>
        <option value="design">Design</option>
        <option value="event-planning">Event Planning</option>
        <option value="fitness">Fitness</option>
        <option value="gardening">Gardening</option>
        <option value="graphic-design">Graphic Design</option>
        <option value="housekeeping">Housekeeping</option>
        <option value="interior-design">Interior Design</option>
        <option value="it-services">IT Services</option>
        <option value="legal">Legal</option>
        <option value="marketing">Marketing</option>
        <option value="massage">Massage</option>
        <option value="music">Music</option>
        <option value="photography">Photography</option>
        <option value="real-estate">Real Estate</option>
        <option value="repair">Repairs</option>
        <option value="transport">Transportation</option>
        <option value="web-development">Web Development</option>
        <option value="writing">Writing</option>
        <option value="yoga">Yoga</option>
        <!-- Add more as needed, up to 100+ categories -->
        <option value="advertising">Advertising</option>
        <option value="air-conditioning">Air Conditioning</option>
        <option value="app-development">App Development</option>
        <option value="business-coaching">Business Coaching</option>
        <option value="business-consulting">Business Consulting</option>
        <option value="calligraphy">Calligraphy</option>
        <option value="car-detailing">Car Detailing</option>
        <option value="construction-management">Construction Management</option>
        <option value="data-analysis">Data Analysis</option>
        <option value="digital-marketing">Digital Marketing</option>
        <option value="event-photography">Event Photography</option>
        <option value="financial-planning">Financial Planning</option>
        <option value="freelancing">Freelancing</option>
        <option value="gardening-services">Gardening Services</option>
        <option value="home-improvement">Home Improvement</option>
        <option value="house-painting">House Painting</option>
        <option value="landscaping">Landscaping</option>
        <option value="marketing-strategy">Marketing Strategy</option>
        <option value="mobile-app-development">Mobile App Development</option>
        <option value="networking">Networking</option>
        <option value="personal-training">Personal Training</option>
        <option value="pet-care">Pet Care</option>
        <option value="photo-editing">Photo Editing</option>
        <option value="plumbing-services">Plumbing Services</option>
        <option value="social-media-management">Social Media Management</option>
        <option value="tax-preparation">Tax Preparation</option>
        <option value="tutoring">Tutoring</option>
        <option value="videography">Videography</option>
        <option value="virtual-assistance">Virtual Assistance</option>
        <option value="web-design">Web Design</option>
        <option value="wedding-planning">Wedding Planning</option>
        <!-- Continue adding categories as needed -->        
    </select>
</div>      
            <!-- Price and Status -->
            <div class="form-group">
                <label for="listing-price">Price (/=)*</label>
                <input type="number" id="listing-price" min="100" name="listing-price" step="1" required aria-required="true">
            </div>
            
            <div class="form-group">
                <label for="listing-status">Status</label>
                <select id="listing-status" name="listing-status" aria-label="Status">
                    <option value="Available">Available</option>
                    <option value="Not available">Not available</option>
                    <!-- <option value="pending">Pending Approval</option> -->
                </select>
            </div>
            
            <!-- Description -->
            <div class="form-group full-width">
                <label for="listing-description">Description*</label>
                <textarea id="listing-description" name="listing-description" required aria-required="true"></textarea>
            </div>
            
            <!-- Form Actions -->
            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                <button type="submit" class="submit-btn">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Listing Modal (hidden by default) -->
<div id="add-listing-modal" class="modal" style="display: none;" aria-hidden="true">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()" aria-label="Close modal">&times;</span>
        <h2>Add New Listing</h2>
        <!-- Form content would go here -->
    </div>
</div>

<script src="/ServiceDiscovery/Assets/js/manage_listings.js"></script>
</body>
</html>