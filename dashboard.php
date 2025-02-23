<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard | Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
    /* General Styling */
    body {
        background: linear-gradient(to right,rgb(230, 232, 234),rgb(241, 243, 245));
        font-family: 'Poppins', sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Container */
    .container {
        max-width: 650px;
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
    }

    /* Headings */
    h2 {
        text-align: center;
        color: #145DA0;
        font-weight: 600;
        margin-bottom: 20px;
    }

    /* Form Labels */
    label {
        font-weight: 500;
        display: block;
        margin-top: 10px;
        color: #333;
    }

    /* Form Inputs */
    input, select, textarea {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
        background: #f9f9f9;
        color: #333;
        transition: 0.3s;
    }

    input:focus, select:focus, textarea:focus {
        border-color: #4A90E2;
        background: #fff;
        outline: none;
    }

    /* Button Styling */
    button {
        background: #4A90E2;
        color: #fff;
        padding: 12px;
        border: none;
        font-size: 18px;
        font-weight: bold;
        border-radius: 6px;
        width: 100%;
        cursor: pointer;
        transition: background 0.3s;
        margin-top: 15px;
    }

    button:hover {
        background:rgb(1, 12, 21);
    }

    /* Logout Button */
    .btn-danger {
        background: #E63946;
        display: block;
        text-align: center;
        padding: 10px;
        text-decoration: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: bold;
        color: white;
        margin-top: 15px;
        transition: 0.3s;
    }

    .btn-danger:hover {
        background: #D62839;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            max-width: 90%;
        }
    }
</style>

    <script>
        function toggleNationalityFields() {
            var nationality = document.getElementById("nationality").value;
            var stateDiv = document.getElementById("stateDiv");
            var otherNationalityDiv = document.getElementById("otherNationalityDiv");

            if (nationality === "Indian") {
                stateDiv.style.display = "block";
                otherNationalityDiv.style.display = "none";
            } else if (nationality === "Other") {
                stateDiv.style.display = "none";
                otherNationalityDiv.style.display = "block";
            } else {
                stateDiv.style.display = "none";
                otherNationalityDiv.style.display = "none";
            }
        }

        function validateForm() {
            const email = document.getElementById('email').value;
            if (!email.includes('@') || !email.includes('.')) {
                alert('Please enter a valid email address.');
                return false;
            }
            return true;
        }
    </script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h2>
        <h2>Enter Your Details</h2>

        <form action="submit.php" method="POST" onsubmit="return validateForm()">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required>
            <br>
            <label for="middleName">Middle Name:</label>
            <input type="text" id="middleName" name="middleName">
            <br>
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required>
            <br>
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" pattern="\d{10}" required>
            <br>
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>
            <br>
            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>
            <br>
            <label for="aadhar">Aadhar Number:</label>
            <input type="text" id="aadhar" name="aadhar" pattern="\d{12}" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" min="1" max="100" required>
            <br>
            <label for="income">Income:</label>
            <input type="number" id="income" name="income" min="0" step="0.01" required>
            <br>
            <label for="nationality">Nationality:</label>
            <select id="nationality" name="nationality" required onchange="toggleNationalityFields()">
                <option value="">Select</option>
                <option value="Indian">Indian</option>
                <option value="Other">Other</option>
            </select>
            <br>

            <div id="stateDiv" style="display: none;">
                <label for="state">State:</label>
                <select id="state" name="state">
                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                    <option value="Assam">Assam</option>
                    <option value="Bihar">Bihar</option>
                    <option value="Chhattisgarh">Chhattisgarh</option>
                    <option value="Goa">Goa</option>
                    <option value="Gujarat">Gujarat</option>
                    <option value="Haryana">Haryana</option>
                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                    <option value="Jharkhand">Jharkhand</option>
                    <option value="Karnataka">Karnataka</option>
                    <option value="Kerala">Kerala</option>
                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                    <option value="Maharashtra">Maharashtra</option>
                    <option value="Manipur">Manipur</option>
                    <option value="Meghalaya">Meghalaya</option>
                    <option value="Mizoram">Mizoram</option>
                    <option value="Nagaland">Nagaland</option>
                    <option value="Odisha">Odisha</option>
                    <option value="Punjab">Punjab</option>
                    <option value="Rajasthan">Rajasthan</option>
                    <option value="Sikkim">Sikkim</option>
                    <option value="Tamil Nadu">Tamil Nadu</option>
                    <option value="Telangana">Telangana</option>
                    <option value="Tripura">Tripura</option>
                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                    <option value="Uttarakhand">Uttarakhand</option>
                    <option value="West Bengal">West Bengal</option>
                </select>
                <br>
            </div>

            <div id="otherNationalityDiv" style="display: none;">
                <label for="otherNationality">Enter Your Nationality:</label>
                <input type="text" id="otherNationality" name="otherNationality">
                <br>
            </div>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            <br>
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="General">General</option>
                <option value="SC">SC</option>
                <option value="ST">ST</option>
                <option value="OBC">OBC</option>
            </select>
            <br>
            <label for="designation">Select Designation:</label>
            <select id="designation" name="designation" required>
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
            </select>
            <br>
            <button type="submit">Submit</button>
            <form action="submit.php" method="POST" onsubmit="return validateForm()">
        </form>

        <a href="logout.php" class="btn btn-danger">Logout</a>
    
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 