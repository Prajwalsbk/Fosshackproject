<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable detailed error reporting

// Database connection
$servername = "localhost";
$username = "root";  // Change if necessary
$password = "";  // Change if necessary
$database = "user_auth";  // Change if necessary

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Initialize variables
$designationFilter = "Pension & Financial Inclusion Schemes";  
$schemes = [];

// Fetch scheme data
$sql = "SELECT id, title FROM schemes WHERE designation = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("s", $designationFilter);
$stmt->execute();
$result = $stmt->get_result();

// Store fetched schemes in an array
while ($row = $result->fetch_assoc()) {
    $schemes[] = $row;
}

// Debugging: Check if query fetched any data
if (empty($schemes)) {
    echo "<p class='text-danger'>No schemes found for '$designationFilter'.</p>";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pension & Financial Inclusion Schemes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .container { max-width: 700px; margin: 20px auto; }
        .scheme-list { list-style-type: none; padding: 0; }
        .scheme-list li { margin: 10px 0; }
        .scheme-link { text-decoration: none; font-size: 18px; font-weight: bold; color: #007bff; cursor: pointer; }
        .scheme-link:hover { text-decoration: underline; }
        .scheme-details { display: none; border: 1px solid #ddd; padding: 15px; margin-top: 20px; background: #f9f9f9; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Pension & Financial Inclusion Schemes</h2>
        <a href="dashboard.php" class="btn btn-secondary mb-3">Back</a>

        <?php if (!empty($schemes)) : ?>
            <ul class="scheme-list">
                <?php foreach ($schemes as $scheme) : ?>
                    <li>
                        <a href="#" class="scheme-link" data-id="<?php echo $scheme['id']; ?>">
                            <?php echo htmlspecialchars($scheme['title']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p class="text-danger">No Pension & Financial Inclusion Schemes available at the moment.</p>
        <?php endif; ?>

        <!-- Scheme Details Section -->
        <div id="scheme-details" class="scheme-details"></div>
    </div>

    <script>
        $(document).ready(function() {
            $(".scheme-link").click(function(e) {
                e.preventDefault();
                var schemeId = $(this).data("id");

                $.ajax({
                    url: "fetch_scheme.php",
                    type: "GET",
                    data: { id: schemeId },
                    success: function(response) {
                        $("#scheme-details").html(response).fadeIn();
                    },
                    error: function(xhr, status, error) {
                        alert("Error fetching scheme details: " + error);
                    }
                });
            });
        });
    </script>
</body>
</html>
