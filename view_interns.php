<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "intern_registration"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Download logic only happens if a GET request with 'action' is set to 'download'
if (isset($_GET['action']) && $_GET['action'] == 'download') {
    // Fetch records from the database
    $sql = "SELECT name, dob, demographics, education, skills, languages, mobile, email, address, work_experience FROM interns";
    $result = $conn->query($sql);

    // Start buffering the output
    ob_start();
    ?>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>DOB</th>
                <th>Demographics</th>
                <th>Education</th>
                <th>Skills</th>
                <th>Languages</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Address</th>
                <th>Work Experience</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['dob'] . "</td>";
                    echo "<td>" . $row['demographics'] . "</td>";
                    echo "<td>" . $row['education'] . "</td>";
                    echo "<td>" . $row['skills'] . "</td>";
                    echo "<td>" . $row['languages'] . "</td>";
                    echo "<td>" . $row['mobile'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['work_experience'] . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <?php
    $html = ob_get_clean(); // Get the HTML content from the buffer

    // Force download as an HTML file
    header('Content-Type: application/html');
    header('Content-Disposition: attachment; filename="interns_data.html"');
    echo $html;
    exit();
}

// Default page to display the table (no duplication now)
$sql = "SELECT name, dob, demographics, education, skills, languages, mobile, email, address, work_experience FROM interns";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interns Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>Interns Information Table</h2>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>DOB</th>
                <th>Demographics</th>
                <th>Education</th>
                <th>Skills</th>
                <th>Languages</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Address</th>
                <th>Work Experience</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['dob'] . "</td>";
                    echo "<td>" . $row['demographics'] . "</td>";
                    echo "<td>" . $row['education'] . "</td>";
                    echo "<td>" . $row['skills'] . "</td>";
                    echo "<td>" . $row['languages'] . "</td>";
                    echo "<td>" . $row['mobile'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['work_experience'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <br>

    <!-- Download Button -->
    <a href="?action=download"><button>Download as HTML</button></a>

</body>
</html>

<?php
// Close connection
$conn->close();
?>

