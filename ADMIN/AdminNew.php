<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css?v= <?php echo time(); ?>">
    <link rel="icon" type="image" href="pics/WIT-Logo.png">
    <link rel="stylesheet" href="path/to/custom-lightbox.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
  <!-- Include Flatpickr JS -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <title>WIT Administration library</title>
</head>
<body>
<script src="javascripts/mainjs.js"></script>
<div class="maintitle">
    <h1>WESTERN INSTITUTE OF TECHNOLOGY ADMINISTRATION LIBRARY</h1>
</div>
<div class="back-btn"><a href="Admin Main.php">Back to Admin Panel</a></div>

<div class="background-main">
    <img src="pics/WIT-LOGO.png" class="mainlogo" alt="">
</div>

<div class="left-side-box">

<button class="button" onclick="window.location='Records.php'">
    <i class="fas fa-file-alt"></i> Records
</button>


<button class="button" onclick="window.location='BookLog.php'">
    <i class="fas fa-book"></i> Book Log
</button>


<button class="button" onclick="window.location='BookSituation.php'">
    <i class="fas fa-chart-pie"></i> Book Situation
</button>

 <?php
include '../Configure.php';


$query = "SELECT COUNT(*) AS pending_requests FROM books_approval WHERE status = 'Pending'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$pendingRequestsCount = $row['pending_requests'];
?>
<button class="button" onclick="window.location='BookRequest.php'">
    <i class="fas fa-book"></i> Pending Book Request/s 
    <span class="red-text">(<?php echo $pendingRequestsCount; ?>)</span>
</button>


 <?php
include '../Configure.php';

$sql_pending_count = "SELECT COUNT(*) AS count FROM users_db WHERE status='Pending'";
$result_pending_count = mysqli_query($conn, $sql_pending_count);
$row_count = mysqli_fetch_assoc($result_pending_count);
$pending_count = $row_count['count'];
?>

<button class="button" onclick="window.location='UsersApproval.php'">
    <i class="fas fa-user-check"></i> Users Approval <span class="red-text">(<?php echo $pending_count; ?>)</span>
</button>

<button class="button" onclick="window.location='AddBook.php'">
    <i class="fas fa-book-open"></i> Add Book/s
</button>



<button class="button" onclick="window.location='UpdateDelete/UpdateDelete.php'">
    <i class="fas fa-cogs"></i> Book Configurations
</button>


<button class="button" onclick="window.location='UsersConfiguration.php'">
    <i class="fas fa-users-cog"></i> Users Configurations
</button>


<button class="button" onclick="window.location='LibraryLog.php'">
    <i class="fas fa-list-alt"></i> Library Log
</button>


<button class="button" onclick="window.location='WITImages.php'">
    <i class="fas fa-images"></i> WIT Images Updates
</button>


 <button class="button" onclick="window.location='AdminNew.php'">
    <i class="fas fa-user-plus"></i> Create Admin
</button>


</div>




<!------------------------------------------------------------------------------------------->
<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"]; 
    $confirmPassword = $_POST["confirm-password"];

    if ($password != $confirmPassword) {
        echo "<script>alert('The Passwords do not match');</script>";
    } else {
        // Display a confirmation message with the username and password
        echo "<script>alert('Admin Name: $username\\nPassword: $password has been created as new Library Admin');</script>";

        // Execute the SQL statement to insert the admin
        $sql = "INSERT INTO admin_db (user_name, pass) VALUES ('$username', '$password')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Admin successfully added to the WIT Library System');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}

mysqli_close($conn);
?>



<div class="custom-form-container-admin">

<div class="configure-button-admin" onclick="window.location.href='AdminUpdate.php';">
    <i class="fas fa-pencil-alt icon">&nbsp;Edit Admin</i>
</div>






    <h2>Create New Admin User</h2>

<form action="AdminNew.php" method="post" class="admin-form" onsubmit="verifyInformation()">
    <label for="username">Admin Name:</label>
    <input type="text" id="adminName" name="username" required>

    <label for="password">Password:</label>
    <div class="password-container">
        <input type="password" id="password" name="password" required>
        <span class="password-toggle-1" onclick="togglePasswordVisibility('password')">&#x1F441;</span>
    </div>

    <label for="retypePassword">Retype Password:</label>
    <div class="password-container">
        <input type="password" id="retypePassword" name="confirm-password" required>
        <span class="password-toggle-2" onclick="togglePasswordVisibility('retypePassword')">&#x1F441;</span>
    </div>

    <button type="submit">Register Admin</button>

    <script>
    function togglePasswordVisibility(fieldId) {
        var passwordField = document.getElementById(fieldId);
        var icon = document.querySelector('#' + fieldId + ' + .password-toggle-' + fieldId.charAt(fieldId.length - 1));

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.innerHTML = '&#x1F440;';
        } else {
            passwordField.type = 'password';
            icon.innerHTML = '&#x1F441;';
        }
    }

    function verifyInformation() {
        alert("Verify Information before submitting.");
    }
</script>




</form>

</div>


<!---------------------------------------------------------------------------------------------------------->

</body>
</html>