<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "user_auth";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION["user_id"])) {
    die("User not logged in. Please log in first.");
}

// Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $bplFamily = $_POST['bplFamily'];
    $hasHealthCard = $_POST['hasHealthCard'];
    $healthCardType = $_POST['healthCardType'] ?? null;
    $stateHealthCardType = $_POST['stateHealthCardType'] ?? null;
    $designation = $_POST['designation'] ?? null;

    if ($hasHealthCard == "yes" && empty($healthCardType)) {
        die("Please select a health card type.");
    } elseif ($healthCardType == "State-Specific" && empty($stateHealthCardType)) {
        die("Please select a state-specific health card type.");
    }

    // Insert data into database
    $sql = "INSERT INTO healthcare_info (user_id, bpl_family, has_health_card, health_card_type, state_health_card_type, designation)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("isssss", $user_id, $bplFamily, $hasHealthCard, $healthCardType, $stateHealthCardType, $designation);

    if ($stmt->execute()) {
        // Store designation in session before redirecting
        $_SESSION['designation'] = $designation;

        header("Location: new3.php"); // Redirect to new3.php
        exit();
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Healthcare & Social Welfare Schemes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .form-container:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.4);
            outline: none;
        }

        label {
            font-size: 16px;
            font-weight: 500;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            border-radius: 8px;
            border: none;
            background: #007bff;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Healthcare & Social Welfare Schemes</h2>
        <form name="healthForm" method="post">
            <label>Do you belong to BPL family?</label>
            <select name="bplFamily" class="form-select" required>
                <option value="APL">APL</option>
                <option value="BPL">BPL</option>
            </select><br><br>

            <label>Do you have any government-issued health card?</label>
            <select name="hasHealthCard" class="form-select" onchange="toggleHealthCardOptions()" required>
                <option value="">-Select-</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select><br><br>

            <div id="healthCardOptions" style="display: none;">
                <label>Select your Health Card:</label>
                <select name="healthCardType" class="form-select" onchange="toggleStateHealthCardOptions()">
                    <option value="PM-JAY">Ayushman Bharat Health Card (PM-JAY Card)</option>
                    <option value="ABHA">ABHA Card (Digital Health ID)</option>
                    <option value="ESIC">Employees’ State Insurance (ESIC e-Pehchan Card)</option>
                    <option value="CGHS">Central Government Health Scheme (CGHS Card)</option>
                    <option value="RSBY">Rashtriya Swasthya Bima Yojana (RSBY Card)</option>
                    <option value="State-Specific">State-Specific Health Cards</option>
                </select><br><br>
            </div>

            <div id="stateHealthCardOptions" style="display: none;">
                <label>Select your State-Specific Health Card:</label>
                <select name="stateHealthCardType" class="form-select">
                    <option value="Arogya Karnataka">Arogya Karnataka Card</option>
                    <option value="Swasthya Sathi">Swasthya Sathi Card (West Bengal)</option>
                    <option value="YSR Aarogyasri">Dr. YSR Aarogyasri Card</option>
                </select><br><br>
            </div>

            <label>Confirm Your Designation:</label>
            <select name="designation" class="form-select" required>
                <option value="">Select Designation</option>
                <option value="Healthcare & Social Welfare Schemes">Healthcare & Social Welfare</option>
            </select><br><br>

            <input type="submit" class="btn-primary" value="Submit">
        </form>
    </div>

    <script>
        function toggleHealthCardOptions() {
            let hasHealthCard = document.forms["healthForm"]["hasHealthCard"].value;
            document.getElementById("healthCardOptions").style.display = (hasHealthCard === "yes") ? "block" : "none";
        }

        function toggleStateHealthCardOptions() {
            let healthCardType = document.forms["healthForm"]["healthCardType"].value;
            document.getElementById("stateHealthCardOptions").style.display = (healthCardType === "State-Specific") ? "block" : "none";
        }
    </script>
</body>
</html>
