<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css?v= <?php echo time(); ?>">
    <link rel="icon" type="image" href="pics/WIT-Logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
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
<!------------------------------------------------------------------------------------------------------------->
<?php


$query = "SELECT * FROM book_inventory";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["return_month"])) {
    $selectedReturnMonth = mysqli_real_escape_string($conn, $_POST["return_month"]);
    if (!empty($selectedReturnMonth) && is_numeric($selectedReturnMonth) && $selectedReturnMonth >= 1 && $selectedReturnMonth <= 12) {
        $query = "SELECT * FROM book_inventory WHERE MONTH(date_return) = '$selectedReturnMonth'";
    } else {
        echo "Invalid return month selection.";
        exit; 
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["borrow_month"])) {
    $selectedBorrowMonth = mysqli_real_escape_string($conn, $_POST["borrow_month"]);
    if (!empty($selectedBorrowMonth) && is_numeric($selectedBorrowMonth) && $selectedBorrowMonth >= 1 && $selectedBorrowMonth <= 12) {
        $query = "SELECT * FROM book_inventory WHERE MONTH(date_borrow) = '$selectedBorrowMonth'";
    } else {
        echo "Invalid borrow month selection.";
        exit; 
    }
}

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<div class="filter-box">
    <form id="return-month-filter-form" action="BookLog.php" method="post">
        <label for="return-month-filter">Filter by Month:</label>
        <select id="return-month-filter" name="return_month">
            <option value="">Books Returned by Month</option>
            <option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
    </form>

    <form id="borrow-month-filter-form" action="BookLog.php" method="post">
        <select id="borrow-month-filter" name="borrow_month">
            <option value="">Books Borrowed by Month</option>
            <option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
    </form>
</div>



<div class="book-log" >
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
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                $fullName = $row['lname'] . ", " . $row['fname'];
                echo "<td>" . htmlspecialchars($fullName) . "</td>";
                echo "<td>" . htmlspecialchars($row['idnum']) . "</td>";
                echo "<td>" . htmlspecialchars($row['course']) . "</td>";
                echo "<td>" . htmlspecialchars($row['bk_title']) . "</td>";
                echo "<td>" . htmlspecialchars($row['isbn']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date_borrow']) . "</td>";
                echo "<td style='width: 80px;'><b>" . htmlspecialchars($row['date_return']) . "</b></td>";
                echo "<td>" . htmlspecialchars($row['section']) . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date_confirmed']) . "</td>";
                echo "<td style='width: 50px;'><b>" . htmlspecialchars($row['penalty_balance']) . "</b></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='11'>No records found.</td></tr>";
        }
        ?>
    </table>
</div>

<?php
mysqli_close($conn);
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("return-month-filter").addEventListener("change", function(event) {
            event.preventDefault();
            document.getElementById("return-month-filter-form").submit();
        });

        document.getElementById("borrow-month-filter").addEventListener("change", function(event) {
            event.preventDefault();
            document.getElementById("borrow-month-filter-form").submit();
        });
    });
</script>








<!------------------------------------------------------------------------------------------------------------->
</body>
</html>