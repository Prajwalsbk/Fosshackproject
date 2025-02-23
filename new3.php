<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Ensure designation is set in session
if (!isset($_SESSION["designation"])) {
    die("Error: Designation not set. Please complete the previous step.");
}

$designationFilter = $_SESSION["designation"];

// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "user_auth";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch schemes from database for the stored designation
$stmt = $conn->prepare("SELECT title FROM schemes WHERE designation = ?");
$stmt->bind_param("s", $designationFilter);
$stmt->execute();
$result = $stmt->get_result();

// Store fetched schemes in an array
$schemes = [];
while ($row = $result->fetch_assoc()) {
    $schemes[] = $row['title'];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Scholarships & Schemes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { max-width: 800px; margin-top: 20px; }
        .designation { font-size: 20px; font-weight: bold; margin-top: 15px; }
        .scheme-list { list-style-type: none; padding-left: 0; }
        .scheme-list li { margin: 5px 0; }
        .scheme-list a { text-decoration: none; color: #007bff; }
        .scheme-list a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Available Scholarships & Schemes</h2>

        <div class="d-flex justify-content-between">
            <a href="dashboard.php" class="btn btn-secondary">Back</a>
        </div>

        <p>Showing schemes for: <strong><?php echo htmlspecialchars($designationFilter); ?></strong></p>

        <?php if (!empty($schemes)) : ?>
            <ul class="scheme-list">
                <?php foreach ($schemes as $title) : ?>
                    <li>
                        <a href="educ.php?scheme=<?php echo urlencode($title); ?>"><?php echo htmlspecialchars($title); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>No schemes available for this designation.</p>
        <?php endif; ?>
    </div>
</body>
</html>
