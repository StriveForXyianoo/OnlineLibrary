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




<div class="hidden">
    <div class="form-header">
        <h2>Edit Admin User</h2>
        <button id="close-button-admin" onclick="location.href='AdminNew.php'">
    <i class="fas fa-arrow-left"></i> Go Back
</button>


<script>
    function goBackToAdminNew() {
        window.location.href = 'AdminNew.php';
    }
</script>

    </div>
    <!----------------------------------Inside Admin Edit--------------------------------------->

    <?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_changes'])) {
        foreach ($_POST['save_changes'] as $userId) {
            $newUsername = mysqli_real_escape_string($conn, $_POST['user_name'][$userId]);
            $newPassword = mysqli_real_escape_string($conn, $_POST['pass'][$userId]);

            $updateQuery = "UPDATE admin_db SET user_name = '$newUsername', pass = '$newPassword' WHERE id = $userId";
            $result = mysqli_query($conn, $updateQuery);

            if ($result) {
                // Changes saved successfully
                echo "<script>alert('Changes saved successfully for user: $newUsername'); window.location='AdminUpdate.php';</script>";

            } else {
                // Error saving changes
                echo "<script>alert('Error saving changes for user with ID: $userId');</script>";
            }
        }
    }

    if (isset($_POST['delete_user'])) {
        foreach ($_POST['delete_user'] as $userId) {
            $deleteQuery = "DELETE FROM admin_db WHERE id = $userId";
            $result = mysqli_query($conn, $deleteQuery);

            if ($result) {
                // User deleted successfully
                echo "<script>alert('User deleted successfully'); window.location='AdminUpdate.php';</script>";
            } else {
                // Error deleting user
                echo "<script>alert('Error deleting user with ID: $userId');</script>";
            }
        }
    }
}

$query = "SELECT * FROM admin_db";
$result = mysqli_query($conn, $query);
?>








<div class="admin-table">
<form action="AdminUpdate.php" method="post">
    <table id="adminTable">
        <thead>
            <tr>
                <th>Admin Name</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><input type='text' name='user_name[$row[id]]' value='" . $row['user_name'] . "'></td>";
                echo "<td><input type='text' name='pass[$row[id]]' value='" . $row['pass'] . "'></td>";
                echo "<td>";
                echo "<button type='submit' name='save_changes[]' value='" . $row['id'] . "' class='save-button' onclick='return confirm(\"Are you sure you want to save changes?\");'>Save Changes</button>";
                echo "<button type='submit' name='delete_user[]' value='" . $row['id'] . "' class='delete-button' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete User</button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</form>

</div>

<!------------------------------------------------------------------------------------------------------>




<script>
    const passwordInput = document.getElementById("password");
    const confirmInput = document.getElementById("confirm-password");
    const togglePasswordButton = document.getElementById("togglePassword");
    const toggleConfirmPasswordButton = document.getElementById("toggleConfirmPassword");

    togglePasswordButton.addEventListener("click", function () {
        toggleVisibility(passwordInput);
    });

    toggleConfirmPasswordButton.addEventListener("click", function () {
        toggleVisibility(confirmInput);
    });

    function toggleVisibility(inputElement) {
        const type = inputElement.getAttribute("type") === "password" ? "text" : "password";
        inputElement.setAttribute("type", type);

        setTimeout(function () {
            inputElement.setAttribute("type", "password");
        }, 10000);
    }


    function submitForm(userId) {
        document.querySelector('input[name="save_changes[]"][value="' + userId + '"]').form.submit();
    }
</script>


<!---------------------------------------------------------------------------------------------------------->

</body>
</html>