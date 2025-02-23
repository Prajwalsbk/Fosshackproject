<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: new.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$database = "user_auth"; // Change if necessary

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the designation from the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $designationFilter = isset($_POST['designation']) ? $_POST['designation'] : null;

    if (empty($designationFilter)) {
        echo "<p style='color: red;'>Error: Please select a designation.</p>";
        exit();
    }

    // Fetch schemes from database for the selected designation
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
}
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
    .container {
        max-width: 800px;
        margin-top: 20px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .designation {
        font-size: 22px;
        font-weight: 600;
        margin-top: 15px;
        color: #333;
    }

    .scheme-list {
        list-style: none;
        padding-left: 0;
    }

    .scheme-list li {
        margin: 8px 0;
        padding: 8px;
        background: #fff;
        border-radius: 5px;
        transition: all 0.3s ease-in-out;
    }

    .scheme-list li:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }

    .scheme-list a {
        text-decoration: none;
        color: #007bff;
        font-weight: 500;
    }

    .scheme-list a:hover {
        text-decoration: underline;
        color: #0056b3;
    }

    .btn-all-schemes {
        margin-top: 20px;
    }
</style>
</head>
<body>
    <div class="container">
        <h2>Available Scholarships & Schemes</h2>

        <div class="d-flex justify-content-between">
            <a href="dashboard.php" class="btn btn-secondary">Back</a>
            <button class="btn btn-primary btn-all-schemes" onclick="location.href='new.php'">All Schemes</button>
        </div>

        <?php if (!empty($designationFilter)) : ?>
            <p>Showing schemes for: <strong><?php echo htmlspecialchars($designationFilter); ?></strong></p>
        <?php endif; ?>

        <?php if (!empty($schemes)) : ?>
            <div class="designation"><?php echo htmlspecialchars($designationFilter); ?></div>
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
