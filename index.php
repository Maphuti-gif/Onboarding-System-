<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 2.5rem;
        }

        form {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="date"],
        input[type="tel"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            font-size: 1rem;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="tel"]:focus,
        input[type="email"]:focus,
        textarea:focus {
            border-color: #0056b3;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.2);
        }

        button[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background: #0056b3;
            color: white;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button[type="submit"]:hover {
            background: #004494;
        }

        .error {
            color: red;
            font-size: 0.9rem;
            margin-top: -15px;
            margin-bottom: 15px;
        }

        .success {
            color: green;
            font-size: 1rem;
        }

        @media (min-width: 768px) {
            form {
                grid-template-columns: repeat(2, 1fr);
                gap: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Intern Information Form</h1>

        <?php
        // Database credentials
        $servername = "localhost";
        $username = "root";  // Replace with your DB username
        $password = "";      // Replace with your DB password
        $dbname = "intern_registration";  // Replace with your database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("<p class='error'>Connection failed: " . $conn->connect_error . "</p>");
        }

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Function to sanitize input
            function clean_input($data) {
                return htmlspecialchars(stripslashes(trim($data)));
            }

            // Sanitize and validate input fields
            $name = clean_input($_POST['name']);
            $dob = clean_input($_POST['dob']);
            $demographics = clean_input($_POST['demographics']);
            $education = clean_input($_POST['education']);
            $skills = clean_input($_POST['skills']);
            $languages = clean_input($_POST['languages']);
            $mobile = clean_input($_POST['mobile']);
            $email = clean_input($_POST['email']);
            $address = clean_input($_POST['address']);
            $work_experience = clean_input($_POST['work-experience']);

            // Server-side email validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<p class='error'>Invalid email format.</p>";
            } 
            // Server-side mobile number validation (10 digits)
            elseif (!preg_match("/^[0-9]{10}$/", $mobile)) {
                echo "<p class='error'>Invalid mobile number. 10 digits required.</p>";
            } 
            else {
                // Prepare SQL query to insert data
                $sql = "INSERT INTO interns (name, dob, demographics, education, skills, languages, mobile, email, address, work_experience) 
                        VALUES ('$name', '$dob', '$demographics', '$education', '$skills', '$languages', '$mobile', '$email', '$address', '$work_experience')";

                // Check if data is inserted
                if ($conn->query($sql) === TRUE) {
                    echo "<p class='success'>Record added successfully!</p>";
                } else {
                    echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
                }

                // Close the connection
                $conn->close();
            }
        }
        ?>

        <form action="" method="post">
            <!-- Name Section -->
            <div>
                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name" required>
            </div>

            <!-- Date of Birth / ID Section -->
            <div>
                <label for="dob">Date of Birth (DOB):</label><br>
                <input type="date" id="dob" name="dob" required>
            </div>

            <!-- Demographics Section -->
            <div>
                <label for="demographics">Demographics:</label><br>
                <input type="text" id="demographics" name="demographics" placeholder="e.g., South African, African, Male" required>
            </div>

            <!-- Education Section -->
            <div>
                <label for="education">Education:</label><br>
                <textarea id="education" name="education" rows="4" placeholder="e.g., Diploma in Informatics - Tshwane University of Technology" required></textarea>
            </div>

            <!-- Skills/Competencies Section -->
            <div>
                <label for="skills">Skills/Competencies:</label><br>
                <textarea id="skills" name="skills" rows="4" placeholder="e.g., Time management, Programming (Java), SQL" required></textarea>
            </div>

            <!-- Languages Section -->
            <div>
                <label for="languages">Languages:</label><br>
                <input type="text" id="languages" name="languages" placeholder="e.g., English, Sesotho" required>
            </div>

            <!-- Mobile Section -->
            <div>
                <label for="mobile">Mobile Number:</label><br>
                <input type="tel" id="mobile" name="mobile" placeholder="e.g., 0812760245" required>
            </div>

            <!-- Email Section -->
            <div>
                <label for="email">Email Address:</label><br>
                <input type="email" id="email" name="email" placeholder="e.g., example@gmail.com" required>
            </div>

            <!-- Address Section -->
            <div>
                <label for="address">Address:</label><br>
                <textarea id="address" name="address" rows="2" placeholder="e.g., 2 Aubrey Matlakala St, Soshanguve" required></textarea>
            </div>

            <!-- Work Experience Section -->
            <div>
                <label for="work-experience">Work Experience:</label><br>
                <textarea id="work-experience" name="work-experience" rows="4" placeholder="e.g., General Worker at Mbunana Construction" required></textarea>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</body>
</html>
