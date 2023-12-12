<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/forgot.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image" href="pics/WIT-Logo.png">
    <title>Search Result</title>
</head>

<body>

    <div class="side-logo">
        <img src="Images/WIT-Logo.png" class="bar_logo">
    </div>

    <div class="container">
        <div class="title">Search Result</div>
        <span><a href="ForgotPass.php">Go back</a></span>
        <div class="content">

            <?php
            // Replace these values with your actual database credentials
            $servername = "localhost";
            $username = "root";
            $password = "witlibrary2023password";
            $dbname = "database_users";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get the email from the form
                $email = $_POST["email"];

                // SQL query to search for the email in the users_db table
                $sql = "SELECT id, email, fname, lname, suffix FROM users_db WHERE email = '$email'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Email found, display the results in a scrollable table
                    echo "<div style='overflow-x:auto;'>";
                    echo "<table>";
                    echo "<tr><th>User and Email</th><th></th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        $fullName = $row["suffix"] . " " . $row["lname"] . ", " . $row["fname"];

                        echo "<tr>";
                        echo "<td><span class='full-name'>" . $fullName . "</span>  <span class='email'>" . $row["email"] . "</span></td>";
                        echo "<td><a href='send_email.php?id=" . $row["id"] . "' class='account-button'>This is my account</a></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    // Email not found
                    echo "<p>Email not found.</p>";
                }
            }

            // Close the database connection
            $conn->close();
            ?>

        </div>
    </div>

</body>

</html>
