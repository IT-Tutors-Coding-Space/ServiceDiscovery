<?php
// Start the session
session_start();

// Database connection
require_once "conn.php";

// Ensure the database connection is valid
if (!isset($conn) || !$conn instanceof PDO) {
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
    exit;
}

// Get the search query
$query = trim($_GET['query'] ?? '');

if (empty($query)) {
    echo json_encode(["status" => "error", "message" => "Please enter a search query."]);
    exit;
}

// Search for services that match the query
$stmt = $conn->prepare("SELECT id, sname AS name, scategory AS category, sdescription AS description, sprice AS price, status FROM services 
                        WHERE sname LIKE ? OR scategory LIKE ? OR sdescription LIKE ?");
$searchTerm = "%$query%";
$stmt->execute([$searchTerm, $searchTerm, $searchTerm]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if any results found
if (!$results) {
    $errorMessage = "No services found.";
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
    <link rel="stylesheet" href="/ServiceDiscovery/Assets/css/search.css">
</head>
<body class="bg-gray-100 text-gray-800">
    <header class="bg-blue-600 text-white py-4 shadow-md text-center">
        <h1 class="text-2xl font-bold">Search Results</h1>
    </header>
    
    <div class="container mx-auto mt-6 p-4">
        <?php if ($results): ?>
            <h2 class="text-xl font-bold mb-4">Services Matching: "<?php echo htmlspecialchars($query); ?>"</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($results as $service): ?>
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition">
            <h3 class="text-lg font-bold text-blue-600"><?php echo htmlspecialchars($service['sname']); ?></h3>
            <p class="text-gray-600 mt-2"><?php echo htmlspecialchars($service['sdescription']); ?></p>
            <p class="text-sm font-semibold text-gray-800 mt-2">Category: <?php echo htmlspecialchars($service['scategory']); ?></p>
            <p class="text-lg font-bold text-green-600 mt-2">$<?php echo htmlspecialchars($service['sprice']); ?></p>
            <p class="text-sm text-gray-700 mt-1">Status: 
                <span class="font-semibold <?php echo $service['status'] === 'Available' ? 'text-green-600' : 'text-red-600'; ?>">
                    <?php echo htmlspecialchars($service['status']); ?>
                </span>
            </p>
                        <!-- Order Now Button -->
                        <form action="/ServiceDiscovery/php/order.php" method="POST" class="mt-4">
                            <input type="hidden" name="service_id" value="<?php echo $service['id'] ? htmlspecialchars($service['id']) : ''; ?>">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                                Order Now
                            </button>
                        </form>                

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
