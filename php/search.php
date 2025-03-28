<?php
// Database connection
require_once "conn.php";

// Ensure the database connection is valid
if (!isset($conn) || !$conn instanceof PDO) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}

// Get the search query
$query = trim($_GET['query'] ?? '');

if (empty($query)) {
    echo json_encode(["status" => "error", "message" => "Please enter a search query."]);
    exit;
}

// Search for services that match the query
$stmt = $conn->prepare("SELECT sname, scategory, sdescription, sprice, status FROM services 
                        WHERE sname LIKE ? OR scategory LIKE ? OR sdescription LIKE ?");
$searchTerm = "%$query%";
$stmt->execute([$searchTerm, $searchTerm, $searchTerm]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if any results found
if (!$results) {
    echo json_encode(["status" => "error", "message" => "No services found."]);
    exit;
}

// Display results
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <header class="bg-blue-600 text-white py-4 shadow-md text-center">
        <h1 class="text-2xl font-bold">Search Results</h1>
    </header>
    
    <div class="container mx-auto mt-6 p-4">
        <?php if ($results): ?>
            <h2 class="text-xl font-bold mb-4">Services Matching: "<?php echo htmlspecialchars($query); ?>"</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <?php foreach ($results as $service): ?>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-bold text-blue-600"><?php echo htmlspecialchars($service['sname']); ?></h3>
                        <p class="text-gray-600"><?php echo htmlspecialchars($service['sdescription']); ?></p>
                        <p class="text-sm font-semibold text-gray-800 mt-2">Category: <?php echo htmlspecialchars($service['scategory']); ?></p>
                        <p class="text-lg font-bold text-green-600 mt-2">$<?php echo htmlspecialchars($service['sprice']); ?></p>
                        <p class="text-sm text-gray-700 mt-1">Status: <?php echo htmlspecialchars($service['status']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-red-600 font-semibold mt-4">No services found.</p>
        <?php endif; ?>
    </div>

    <footer class="bg-blue-600 text-white py-6 text-center mt-12">
        <p>&copy; 2025 Service Connect. All rights reserved.</p>
    </footer>
</body>
</html>
