<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "user_auth";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the selected designation from the session
$designationFilter = isset($_SESSION['selected_designation']) ? $_SESSION['selected_designation'] : "";

$sql = "SELECT designation, title FROM schemes";
if (!empty($designationFilter)) {
    $sql .= " WHERE designation = ?";
}
$sql .= " ORDER BY designation, title";

$stmt = $conn->prepare($sql);
if (!empty($designationFilter)) {
    $stmt->bind_param("s", $designationFilter);
}
$stmt->execute();
$result = $stmt->get_result();

// Store schemes in an array
$schemes = [];
while ($row = $result->fetch_assoc()) {
    $schemes[$row['designation']][] = $row['title'];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Scholarships & Schemes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Available Scholarships & Schemes</h2>

    <div class="d-flex justify-content-between">
        <a href="dashboard.php" class="btn btn-secondary">Back</a>
    </div>

    <?php if (!empty($designationFilter)) : ?>
        <p>Showing schemes for: <strong><?php echo htmlspecialchars($designationFilter); ?></strong></p>
    <?php endif; ?>

    <?php if (!empty($schemes)) : ?>
        <?php foreach ($schemes as $designation => $titles) : ?>
            <div class="designation"><?php echo htmlspecialchars($designation); ?></div>
            <ul class="scheme-list">
                <?php foreach ($titles as $title) : ?>
                    <li>
                        <a href="educ.php?scheme=<?php echo urlencode($title); ?>"><?php echo htmlspecialchars($title); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No schemes available for this designation.</p>
    <?php endif; ?>
</div>

</body>
</html>
