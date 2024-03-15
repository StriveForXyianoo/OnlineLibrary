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
<?php
$hostname = "localhost";
$username = "root";
$password = "witlibrary2023password";
$database = "database_users";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_POST['search']);
    $query = "SELECT * FROM users_db 
              WHERE fname LIKE '%$searchTerm%' 
              OR lname LIKE '%$searchTerm%' 
              OR idnum LIKE '%$searchTerm%' 
              OR course LIKE '%$searchTerm%' 
              OR addr LIKE '%$searchTerm%' 
              OR users_num LIKE '%$searchTerm%' ";
    $result = mysqli_query($conn, $query);
} else {
    $query = "SELECT * FROM users_db";
    $result = mysqli_query($conn, $query);
}

if (isset($_POST['delete_submit'])) {
    $userIdToDelete = $_POST['delete_submit'];

    // Define the SQL query for deletion
    $deleteSql = "DELETE FROM users_db WHERE id = $userIdToDelete";

    if (mysqli_query($conn, $deleteSql)) {
        echo '<script>window.location.href = "UsersConfiguration.php";</script>';
        exit();
    } else {
        echo 'Error deleting user: ' . mysqli_error($conn);
    }
}

?>

<div class="book-log">
    <h2>Users Info Form</h2>

    <div class="search-form-container">
        <form method="post" action="UsersConfiguration.php">
            <input class="search-input" type="text" name="search" placeholder="Search...">
            <button class="search-button" type="submit">Search</button>
        </form>
    </div>

    <form method="post">
    <table class='scrollable-table-log'>
    <table class="users-table">
    <thead>
        <tr>
            <th class="table-header">Last & First Name</th>
            <th class="table-header">Middle Initial</th>
            <th class="table-header">Address</th>
            <th class="table-header">Email</th>
            <th class="table-header">Course</th>
            <th class="table-header">Identification Number</th>
            <th class="table-header">Password</th>
            <th class="table-header">Phone Number</th>
            <th class="table-header">Gender</th>
            <th class="table-header" style="width: 40px;">Remaining Balance</th>

            <th class="table-header">Penalty</th>
            <th class="table-header">Lost</th>
            <th class="table-header">On Hand</th>
            <th class="table-header">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['lname'] . ', ' . $row['fname'] . '</td>';
            echo '<td>' . $row['middle_initial'] . '</td>';
            echo '<td>' . $row['addr'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['course'] . '</td>';
            echo '<td>' . $row['idnum'] . '</td>';
            echo '<td>' . $row['pass'] . '</td>';
            echo '<td>' . $row['users_num'] . '</td>';
            echo '<td>' . $row['gender'] . '</td>';
            echo '<td>' . $row['users_balance'] . '</td>';
            echo '<td>' . $row['users_penalty'] . '</td>';
            echo '<td>' . $row['users_lost'] . '</td>';
            echo '<td>' . $row['users_onhand'] . '</td>';
            echo '<td>';
            echo '<div class="update-container">';
            echo '<a class="update-btn" href="crudedit.php?id=' . $row['id'] . '">Update</a>';
            echo '<button name="delete_submit" class="delete-btn" value="' . $row['id'] . '" onclick="return confirm(\'Please confirm to delete ' . $row['lname'] . ', ' . $row['fname'] .'?\');">Delete</button>';
            echo '</div>'; // Close the update-container div
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>

        </div>
    </form>

</div>

<?php
mysqli_close($conn);
?>

    
</body>
</html>