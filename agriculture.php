<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "user_auth";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hasLand = $_POST['hasLand'];
    $hasFarmerID = $_POST['hasFarmerID'];
    $farmerID = (!empty($_POST['farmerID'])) ? $_POST['farmerID'] : NULL;
    $designation = $_POST['designation'];

    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO farmer_registration (hasLand, hasFarmerID, farmerID, designation) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $hasLand, $hasFarmerID, $farmerID, $designation);

    // Execute and check for errors
    if ($stmt->execute()) {
        // ✅ Redirect to new2.php after successful insertion
        header("Location: new2.php");
        exit(); // Ensure script stops execution after redirection
    } else {
        echo "Query Failed: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function toggleFarmerIDOptions() {
            let hasLand = document.querySelector("select[name='hasLand']").value;
            let farmerIDSection = document.getElementById("farmerIDSection");
            farmerIDSection.style.display = hasLand === "yes" ? "block" : "none";
        }

        function toggleFarmerIDInput() {
            let hasFarmerID = document.querySelector("select[name='hasFarmerID']").value;
            let farmerIDInput = document.getElementById("farmerIDInput");
            farmerIDInput.style.display = hasFarmerID === "yes" ? "block" : "none";
        }
    </script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center">Farmer Registration Form</h2>
            <form action="new2.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Do you have registered land?</label>
                    <select name="hasLand" class="form-select" required onchange="toggleFarmerIDOptions()">
                        <option value="">Select</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>

                <div id="farmerIDSection" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label">Do you have a Farmer ID?</label>
                        <select name="hasFarmerID" class="form-select" required onchange="toggleFarmerIDInput()">
                            <option value="">Select</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>

                    <div id="farmerIDInput" class="mb-3" style="display: none;">
                        <label class="form-label">If yes, enter your Farmer ID:</label>
                        <input type="text" name="farmerID" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="designation" class="form-label">Confirm Your Designation:</label>
                    <select id="designation" name="designation" class="form-select" required>
                        <option value="">Select Designation</option>
                        <option value="Agriculture Schemes">Agriculture Schemes</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success w-100">Submit</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
