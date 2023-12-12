<?php
$hostname = "localhost"; 
$username = "root"; 
$password = "witlibrary2023password"; 
$database = "database_users"; 

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    
    if ($action === 'approve') {
        $newStatus = 'Approved';
    } elseif ($action === 'reject') {
        $newStatus = 'Rejected';
    }

   
    $sql_update_status = "UPDATE users_db SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update_status);
    $stmt->bind_param("si", $newStatus, $id);

    if ($stmt->execute()) {
       
        echo "<script>alert('Status updated to " . $newStatus . "');</script>";
    } else {
        
        echo "<script>alert('Error updating status: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}


?>


<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Create a PHPMailer instance
$mail = new PHPMailer();

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com'; // SMTP host
$mail->SMTPAuth = true;
$mail->Username = 'calderon.janrasheedcit2011@gmail.com'; // SMTP username
$mail->Password = 'tfeyfpskdtvbtsvs'; // SMTP password
$mail->SMTPSecure = 'ssl'; // Use SSL or 'tls' for TLS encryption
$mail->Port = 465; // Set the appropriate port

// Set email details
$mail->setFrom('librarysample2011@gmail.com', 'WIT LIBRARY ADMINISTRATION');

// Retrieve the user's email from the database based on user ID
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $hostname = "localhost"; // Replace with your database hostname
    $username = "root"; // Replace with your database username
    $password = "witlibrary2023password"; // Replace with your database password
    $database = "database_users"; // Replace with your database name

    $conn = mysqli_connect($hostname, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT email, lname, fname, idnum FROM users_db WHERE id = $userId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userEmail = $row['email'];
        $userName = $row['lname'] . ', ' . $row['fname']; // Concatenate last name and first name
        $idNum = $row['idnum'];

        // Subject and body based on the action
        $mail->addAddress($userEmail, $userName);
        $mail->isHTML(true);

        if ($action === 'approve') {
            $mail->Subject = 'Approval Notification';
            $mail->Body = "Dear $userName (ID: $idNum),\n\n Congratulations you are approved by the WIT Admin. Enjoy Searching!";
        } elseif ($action === 'reject') {
            $mail->Subject = 'Rejection Notification';
            $mail->Body = "Dear $userName (ID: $idNum),\n\nYour qualification and identification failed to meet the Admin's requirements.";

            // Delete the user from the database based on idnum when action is 'reject'
            $deleteQuery = "DELETE FROM users_db WHERE idnum = $idNum";
            if ($conn->query($deleteQuery) === TRUE) {

            } else {
                echo "Error deleting user: " . $conn->error;
            }
        }

        // Send the email
        if ($mail->send()) {
            echo '<script>alert("Email sent successfully");</script>';
        } else {
            echo '<script>alert("Email could not be sent.");</script>';
        }
    }
    $conn->close();
    
  
header("Location: Admin Main.php");
exit();

}
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css?v= <?php echo time(); ?>">
    <link rel="icon" type="image" href="pics/WIT-Logo.png">
    <link rel="stylesheet" href="path/to/custom-lightbox.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>WIT Administration library</title>
</head>
<body>
<script src="javascripts/mainjs.js"></script>
<div class="maintitle">
    <h1>WESTERN INSTITUTE OF TECHNOLOGY ADMINISTRATION LIBRARY</h1>
</div>
<!----------------------------------------------LOG OUT BUTTON---------------------------------------------------->
<div class="logout-container">
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: AdminLog.php");
    exit();
}

// Logout handling
if (isset($_GET["logout"]) && $_GET["logout"] == "true") {
    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location: AdminLog.php");
    exit();
}
?>
    <form id="logout-form" method="get" action="Admin Main.php">
        <a href="#" class="logout-link" onclick="document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <input type="hidden" name="logout" value="true"> <!-- Hidden input for logout -->
    </form>
</div>


<!-----------------------------------------------LOG OUT BUTTON--------------------------------------------------->
<div class="background-main">
    <img src="pics/WIT-LOGO.png" class="mainlogo" alt="">
</div>

<div class="left-side-box">
 <button class="button" onclick="window.location='Records.php'">Records</button>

 <button class="button" onclick="window.location='BookLog.php'">Book Log</button>

 <button class="button" onclick="window.location='BookSituation.php'">Book Situation</button>
 <?php
$hostname = "localhost"; 
$username = "root";
$password = "witlibrary2023password";
$database = "database_users"; 

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$query = "SELECT COUNT(*) AS pending_requests FROM books_approval WHERE status = 'Pending'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$pendingRequestsCount = $row['pending_requests'];
?>
 <button class="button" onclick="window.location='BookRequest.php'">Pending Book Request/s <span class="red-text">
  (<?php echo $pendingRequestsCount; ?>)
</span>
</button>

 <?php
$hostname = "localhost"; 
$username = "root";
$password = "witlibrary2023password";
$database = "database_users"; 

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql_pending_count = "SELECT COUNT(*) AS count FROM users_db WHERE status='Pending'";
$result_pending_count = mysqli_query($conn, $sql_pending_count);
$row_count = mysqli_fetch_assoc($result_pending_count);
$pending_count = $row_count['count'];
?>

 <button class="button" onclick="window.location='UsersApproval.php'">Users Approval <span class="red-text">(<?php echo $pending_count; ?>)</span>
</button>

 <button class="button" onclick="window.location='AddBook.php'">Add Book/s</button>

 <button class="button" onclick="window.location='UpdateDelete/UpdateDelete.php'">Book Configurations</button>

 <button class="button" onclick="window.location='UsersConfiguration.php'">Users Configurations</button>

 <button class="button" onclick="window.location='LibraryLog.php'">Library Log</button>

 <button class="button" onclick="window.location='WITImages.php'">WIT Images Updates</button>
</div>



<!---------------------------------------------------------------------------------------------------------->

    

<!---------------------------------------------------------------------------------------------------------->






<!---------------------------------------------------------------------------------------------------------->

<!---------------------------------------------------------------------------------------------------------->




<!---------------------------------------------------------------------------------------------------------->




</body>
</html>