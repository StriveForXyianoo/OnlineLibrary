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
<!------------------------------------------------------------------------------------------------------------->

<?php
$hostname = "localhost";
$username = "root";
$password = "witlibrary2023password";
$database = "database_users";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to select all records from the book_log table
$query = "SELECT * FROM book_inventory";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Close the connection
mysqli_close($conn);
?>

<div class="book-log">

<table class='scrollable-table-log'>
    <tr>
        <th>Full Name</th>
        <th>ID Number</th>
        <th>Course</th>
        <th>Book Title</th>
        <th>ISBN</th>
        <th>Date Borrowed</th>
        <th>Date Expected Return</th>
        <th>Library/Section</th>
        <th>Status</th>
        <th>Date Returned to Inventory</th>
        <th>Penalty</th>
    </tr>

    <?php
    // Loop through the result set and output data
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";

        $fullName = $row['lname'] . ", " . $row['fname'];
        echo "<td>" . $fullName . "</td>";
        echo "<td>" . $row['idnum'] . "</td>";
        echo "<td>" . $row['course'] . "</td>";
        echo "<td>" . $row['bk_title'] . "</td>";
        echo "<td>" . $row['isbn'] . "</td>";
        echo "<td>" . $row['date_borrow'] . "</td>";
        echo "<td style='width: 80px;'><b>" . $row['date_return'] . "</b></td>";

        echo "<td>" . $row['section'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>" . $row['date_confirmed'] . "</td>";
        echo "<td style='width: 50px;'><b>" . $row['penalty_balance'] . "</b></td>";


        echo "</tr>";
    }
    ?>
</table>
</div>
<!------------------------------------------------------------------------------------------------------------->
</body>
</html>