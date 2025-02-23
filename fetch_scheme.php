<?php
$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$database = "user_auth"; // Change if necessary

// Connect to database
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch scheme details
$selected_scheme = null;
if (isset($_GET['id'])) {
    $schemeId = $_GET['id'];
    
    $sql = "SELECT * FROM schemes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $schemeId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $selected_scheme = $result->fetch_assoc();
    } else {
        die("<p class='text-danger'>Scheme not found.</p>");
    }
    $stmt->close();
} else {
    die("<p class='text-danger'>No scheme selected.</p>");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($selected_scheme['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #f8f9fa; }
        .hero { background: linear-gradient(to right, #007bff, #6610f2); color: white; text-align: center; padding: 50px 20px; }
        .content-section { padding: 40px; background: white; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); margin-bottom: 30px; }
        .btn-apply { background-color: #28a745; color: white; font-weight: bold; padding: 12px 20px; border-radius: 5px; text-decoration: none; }
        .btn-apply:hover { background-color: #218838; }
        .footer { background: #343a40; color: white; text-align: center; padding: 15px; margin-top: 20px; }
    </style>
</head>
<body>

<div class="hero">
    <h1><?php echo htmlspecialchars($selected_scheme['title']); ?></h1>
    <p><?php echo htmlspecialchars($selected_scheme['about']); ?></p>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 content-section">
            <h3>About The Program</h3>
            <p><?php echo nl2br(htmlspecialchars($selected_scheme['about'])); ?></p>
        </div>
        <div class="col-lg-12 content-section">
            <h3>Eligibility</h3>
            <p><?php echo nl2br(htmlspecialchars($selected_scheme['eligibility'])); ?></p>
        </div>
        <div class="col-lg-12 content-section">
            <h3>Benefits</h3>
            <p><?php echo nl2br(htmlspecialchars($selected_scheme['benefits'])); ?></p>
        </div>
        <div class="col-lg-12 content-section">
            <h3>Required Documents</h3>
            <p><?php echo nl2br(htmlspecialchars($selected_scheme['documentation'])); ?></p>
        </div>
        <div class="col-lg-12 content-section">
            <h3>How to Apply</h3>
            <p><?php echo nl2br(htmlspecialchars($selected_scheme['how_to_apply'])); ?></p>
            <a href="<?php echo htmlspecialchars($selected_scheme['apply_link']); ?>" class="btn-apply">Apply Now</a>
        </div>
    </div>
</div>

<div class="footer">
    <p>&copy; 2024 National Scholarship Portal | Government of India</p>
</div>

</body>
</html>
