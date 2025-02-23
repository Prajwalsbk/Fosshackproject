<?php
$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$database = "user_auth"; // Change to your actual database name

// Connect to database
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $about = $_POST['about'];
    $eligibility = $_POST['eligibility'];
    $benefits = $_POST['benefits'];
    $documentation = $_POST['documentation'];
    $how_to_apply = $_POST['how_to_apply'];
    $apply_link = $_POST['apply_link'];
    $designation = $_POST['designation'];

    $sql = "INSERT INTO schemes (title, about, eligibility, benefits, documentation, how_to_apply, apply_link, designation)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $title, $about, $eligibility, $benefits, $documentation, $how_to_apply, $apply_link, $designation);

    if ($stmt->execute()) {
        echo "New scheme added successfully!";
    } else {
        echo "Error: " . $stmt->error;
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
    <title>Admin - Add Scheme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color:rgb(171, 176, 180); }
        .container { max-width: 800px; margin: 40px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .form-label { font-weight: bold; }
        textarea { width: 50%; height: 50px; }
    </style>
</head>
<body>
    <center>
    <h2>Add New Scheme/Scholarship</h2>
    <form method="POST">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>About the Scheme:</label><br>
        <textarea name="about" required></textarea><br><br>

        <label>Eligibility:</label><br>
        <textarea name="eligibility" required></textarea><br><br>

        <label>Benefits:</label><br>
        <textarea name="benefits" required></textarea><br><br>

        <label>Required Documentation:</label><br>
        <textarea name="documentation" required></textarea><br><br>

        <label>How to Apply:</label><br>
        <textarea name="how_to_apply" required></textarea><br><br>

        <label>Application Link:</label><br>
        <input type="url" name="apply_link" ><br><br>

        <label>Designation:</label><br>
        <select name="designation" required>
            <option value="Education & Skill Development Schemes">Education & Skill Development Schemes</option>
            <option value="Agriculture Schemes">Agriculture Schemes</option>
            <option value="Rural Development Schemes">Rural Development Schemes</option>
            <option value="Business & Entrepreneurship Schemes">Business & Entrepreneurship Schemes</option>
            <option value="Employment & Unemployment Schemes">Employment & Unemployment Schemes</option>
            <option value="Healthcare & Social Welfare Schemes">Healthcare & Social Welfare Schemes</option>
            <option value="Women Empowerment & Child Welfare">Women Empowerment & Child Welfare</option>
            <option value="Housing & Urban Development Schemes">Housing & Urban Development Schemes</option>
            <option value="Pension & Financial Inclusion Schemes">Pension & Financial Inclusion Schemes</option>
            <option value="Minority & SC/ST Welfare Schemes">Minority & SC/ST Welfare Schemes</option>
            <option value="Environmental & Renewable Energy Schemes">Environmental & Renewable Energy Schemes</option>
            <option value="Special Schemes for Specific Sectors">Special Schemes for Specific Sectors</option>
        </select><br><br>

        <button type="submit" class="btn btn-primary w-full py-2 text-white">Add Scheme</button>    </form>
        </center>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
