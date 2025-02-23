<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Enable error reporting for debugging (Remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = "localhost";
$user = "root";  
$pass = "";      
$dbname = "user_auth";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize form data
$first_name = trim($_POST['firstName']);
$middle_name = isset($_POST['middleName']) ? trim($_POST['middleName']) : null;
$last_name = trim($_POST['lastName']);
$phone = trim($_POST['phone']);
$dob = trim($_POST['dob']);
$address = trim($_POST['address']);
$aadhar = trim($_POST['aadhar']);
$email = trim($_POST['email']);
$age = (int) $_POST['age'];
$income = (int) $_POST['income'];
$nationality = trim($_POST['nationality']);
$state = isset($_POST['state']) ? trim($_POST['state']) : null;
$other_nationality = isset($_POST['otherNationality']) ? trim($_POST['otherNationality']) : null;
$gender = trim($_POST['gender']);
$category = trim($_POST['category']);
$designation = trim($_POST['designation']); // Trim to remove extra spaces

// Debugging output (remove in production)
// echo "Selected Designation: " . $designation;
// exit();

// SQL Query
$sql = "INSERT INTO userdata (first_name, middle_name, last_name, phone, dob, address, aadhar, email, age, income, nationality, state, other_nationality, gender, category, designation) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("ssssssssiiisssss", 
    $first_name, $middle_name, $last_name, $phone, $dob, $address, 
    $aadhar, $email, $age, $income, $nationality, $state, 
    $other_nationality, $gender, $category, $designation
);

// Execute the statement
if ($stmt->execute()) {
    // Redirect based on designation
    switch ($designation) {
        case "Education & Skill Development Schemes":
            header("Location: education.php");
            break;
        case "Agriculture Schemes":
            header("Location: agriculture.php");
            break;
        case "Rural Development Schemes": // Removed extra space
            header("Location: rural.php");
            break;
        case "Business & Entrepreneurship Schemes":
            header("Location: business.php");
            break;
        case "Employment & Unemployment Schemes":
            header("Location: employment.php");
            break;
        case "Healthcare & Social Welfare Schemes":
            header("Location: healthcare.php");
            break;
        case "Women Empowerment & Child Welfare":
            header("Location: women.php");
            break;
        case "Housing & Urban Development Schemes":
            header("Location: housing.php");
            break;
        case "Pension & Financial Inclusion Schemes":
            header("Location: pension.php");
            break;
        case "Minority & SC/ST Welfare Schemes":
            header("Location: minority.php");
            break;
        case "Environmental & Renewable Energy Schemes":
            header("Location: environment.php");
            break;
        case "Special Schemes for Specific Sectors":
            header("Location: special_schemes.php");
            break;
        default:
            header("Location: dashboard.php"); // Redirect to dashboard if no match
            break;
    }
    exit();
} else {
    die("Error executing query: " . $stmt->error);
}

// Close the connection
$stmt->close();
$conn->close();
?>
