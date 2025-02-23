<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Form Container */
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

        /* Form Elements */
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

        /* Label Styling */
        label {
            font-size: 16px;
            font-weight: 500;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        /* Button Styling */
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

        /* Custom Card Style */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.02);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                max-width: 90%;
                padding: 20px;
            }
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Hidden Fields */
        #below_10th_fields,
        #tenth_fields,
        #puc_fields,
        #ug_pg_fields,
        #card_options {
            display: none;
        }

        /* Checkbox Styling */
        input[type="checkbox"] {
            margin-right: 10px;
        }

        /* Other Input Field */
        #other_card_name {
            display: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Education & Skill Development Information</h2>
        <form action="new2.php" method="post">
            <label for="highest_qualification">Highest Qualification:</label>
            <select name="highest_qualification" id="highest_qualification" onchange="showFields()" required>
                <option value="" disabled selected>Select Qualification</option>
                <option value="Below 10th">Below 10th</option>
                <option value="10th">10th</option>
                <option value="PUC">PUC (Pre-University Course)</option>
                <option value="UG">Undergraduate (UG)</option>
                <option value="PG">Postgraduate (PG)</option>
            </select><br><br>

            <!-- Fields for Below 10th -->
            <div id="below_10th_fields" style="display:none;">
                <label for="qualification">Qualification:</label>
                <input type="text" name="qualification"><br><br>

                <label for="percentage">Percentage:</label>
                <input type="text" name="percentage"><br><br>

                <label for="school_name">School Name:</label>
                <input type="text" name="school_name"><br><br>

                <label for="passout_year">Passout Year:</label>
                <input type="number" name="passout_year"><br><br>
            </div>

            <!-- Fields for 10th -->
            <div id="tenth_fields" style="display:none;">
                <label for="tenth_board">Board of Education:</label>
                <input type="text" name="tenth_board"><br><br>

                <label for="tenth_marks">Marks Obtained:</label>
                <input type="text" name="tenth_marks"><br><br>

                <label for="tenth_percentage">Percentage:</label>
                <input type="text" name="tenth_percentage"><br><br>

                <label for="tenth_school">School Name:</label>
                <input type="text" name="tenth_school"><br><br>

                <label for="tenth_passout_year">Passout Year:</label>
                <input type="number" name="tenth_passout_year"><br><br>
            </div>

            <!-- Fields for PUC -->
            <div id="puc_fields" style="display:none;">
                <label for="puc_college">College Name:</label>
                <input type="text" name="puc_college"><br><br>

                <label for="puc_marks">Marks Obtained:</label>
                <input type="text" name="puc_marks"><br><br>

                <label for="puc_percentage">Percentage:</label>
                <input type="text" name="puc_percentage"><br><br>

                <label for="puc_passout_year">Passout Year:</label>
                <input type="number" name="puc_passout_year"><br><br>
            </div>

            <!-- Fields for UG & PG -->
            <div id="ug_pg_fields" style="display:none;">
                <label for="degree">Degree Name:</label>
                <input type="text" name="degree"><br><br>

                <label for="university">University Name:</label>
                <input type="text" name="university"><br><br>

                <label for="ug_pg_marks">Marks Obtained:</label>
                <input type="text" name="ug_pg_marks"><br><br>

                <label for="ug_pg_cgpa">CGPA:</label>
                <input type="text" name="ug_pg_cgpa"><br><br>

                <label for="ug_pg_passout_year">Passout Year:</label>
                <input type="number" name="ug_pg_passout_year"><br><br>
            </div>

            <!-- Valid Card Section -->
            <label for="has_valid_card">Do you have any valid card?</label>
            <select name="has_valid_card" id="has_valid_card" onchange="showCardOptions()" required>
                <option value="" disabled selected>Select Option</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select><br><br>

            <div id="card_options" style="display:none;">
                <label>Select Your Card(s):</label><br>
                <input type="checkbox" name="valid_cards[]" value="e-Shram Card"> e-Shram Card / Shramik Card / Labour Card <br>
                <input type="checkbox" name="valid_cards[]" value="Farmers ID Card"> Farmers ID Card / Krushi Card <br>
                <input type="checkbox" name="valid_cards[]" value="Ex-defence/Ex-servicemen"> Ex-defence / Ex-servicemen Identity Card <br>
                <input type="checkbox" name="valid_cards[]" value="EWS certificate"> EWS Certificate (General Category with Lower Income) <br>
                <input type="checkbox" name="valid_cards[]" value="Disability certificate"> Disability Certificate (Physically Disabled) <br>
                <input type="checkbox" id="other_card" name="valid_cards[]" value="Other" onchange="showOtherInput()"> Other <br>
                <input type="text" id="other_card_name" name="other_card_name" placeholder="Enter Card Name" style="display:none;">
            </div><br>

            <label for="designation">Confirm Your Designation:</label>
            <select id="designation" name="designation" required>
                <option value="">Select Designation</option>
                <option value="Education & Skill Development Schemes">Education & Skill Development Schemes</option>
            </select><br><br>

            <input type="submit" class="btn-primary" value="Submit">
        </form>
    </div>

    <script>
        function showFields() {
            var qualification = document.getElementById("highest_qualification").value;

            // Hide all sections initially
            document.getElementById("below_10th_fields").style.display = "none";
            document.getElementById("tenth_fields").style.display = "none";
            document.getElementById("puc_fields").style.display = "none";
            document.getElementById("ug_pg_fields").style.display = "none";

            // Show relevant fields based on selection
            if (qualification === "Below 10th") {
                document.getElementById("below_10th_fields").style.display = "block";
            } else if (qualification === "10th") {
                document.getElementById("tenth_fields").style.display = "block";
            } else if (qualification === "PUC") {
                document.getElementById("puc_fields").style.display = "block";
            } else if (qualification === "UG" || qualification === "PG") {
                document.getElementById("ug_pg_fields").style.display = "block";
            }
        }

        function showCardOptions() {
            var hasCard = document.getElementById("has_valid_card").value;
            var cardOptions = document.getElementById("card_options");

            if (hasCard === "Yes") {
                cardOptions.style.display = "block";
            } else {
                cardOptions.style.display = "none";
                document.getElementById("other_card_name").style.display = "none";
            }
        }

        function showOtherInput() {
            var otherCheckbox = document.getElementById("other_card");
            var otherInput = document.getElementById("other_card_name");

            if (otherCheckbox.checked) {
                otherInput.style.display = "block";
            } else {
                otherInput.style.display = "none";
            }
        }
    </script>
</body>
</html>
