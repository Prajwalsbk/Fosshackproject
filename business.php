<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$database = "user_auth";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];

    // Sanitize and validate inputs
    function cleanInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $startupName = cleanInput($_POST['startupName'] ?? '');
    $isDPIITRecognized = cleanInput($_POST['isDPIITRecognized'] ?? '');
    $turnover = filter_var($_POST['turnover'], FILTER_VALIDATE_FLOAT);
    $turnoverUnit = cleanInput($_POST['turnoverUnit'] ?? '');
    $businessType = cleanInput($_POST['businessType'] ?? '');
    $designation = cleanInput($_POST['designation'] ?? '');

    // Validate required fields
    if (empty($startupName) || empty($isDPIITRecognized) || !$turnover || empty($turnoverUnit) || empty($businessType) || empty($designation)) {
        die("<p style='color: red;'>Error: All fields are required.</p>");
    }

    // Check eligibility conditions
    if ($isDPIITRecognized !== "yes") {
        die("<p style='color: red;'>Scheme and scholarship not applicable.</p>");
    }
    if (!in_array($businessType, ["PLC", "LLP"])) {
        die("<p style='color: orange;'>Your business type must be either PLC or LLP.</p>");
    }

    // Insert data into the database
    $sql = "INSERT INTO startup_info (user_id, startup_name, is_dpiit_recognized, turnover, turnover_unit, business_type, designation) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("<p style='color: red;'>Error preparing statement: " . $conn->error . "</p>");
    }

    $stmt->bind_param("issdsss", $user_id, $startupName, $isDPIITRecognized, $turnover, $turnoverUnit, $businessType, $designation);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Startup details submitted successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business and Entrepreneurship Schemes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function validateForm() {
            let isDPIITRecognized = document.forms["startupForm"]["isDPIITRecognized"].value;
            let businessType = document.forms["startupForm"]["businessType"].value;
            let designation = document.forms["startupForm"]["designation"].value;
            
            if (isDPIITRecognized.toLowerCase() !== "yes") {
                alert("Scheme and scholarship not applicable.");
                return false;
            }
            
            if (businessType !== "PLC" && businessType !== "LLP") {
                alert("Your business type must be either PLC or LLP.");
                return false;
            }

            if (designation === "") {
                alert("Please select a designation.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">Business and Entrepreneurship Schemes</h2>
            <form name="startupForm" method="post" action="new2.php" onsubmit="return validateForm()">
    <div class="mb-3">
        <label class="form-label">Startup Name:</label>
        <input type="text" name="startupName" class="form-control" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Is your startup recognized by DPIIT? (yes/no)</label>
        <select name="isDPIITRecognized" class="form-control" required>
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Turnover:</label>
        <div class="input-group">
            <input type="number" name="turnover" class="form-control" required>
            <select name="turnoverUnit" class="form-control" required>
                <option value="Lakhs">Lakhs</option>
                <option value="Crores">Crores</option>
            </select>
        </div>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Business Type:</label>
        <select name="businessType" class="form-control" required>
            <option value="PLC">PLC</option>
            <option value="LLP">LLP</option>
            <option value="Partnership">Partnership</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="designation" class="form-label">Confirm Your Designation:</label>
        <select id="designation" name="designation" class="form-select" required>
            <option value="">Select Designation</option>

            <option value="Business & Entrepreneurship Schemes">Business & Entrepreneurship Schemes</option>
        </select>
    </div>
    
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
