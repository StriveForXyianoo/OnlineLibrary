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




<!----------------------------------------------------------------------------------------------------->

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


$query = "SELECT * FROM book_status";
$result = mysqli_query($conn, $query);
?>
<div class="book-log">
        
        <h2>Book Status</h2>

        <div class="search-form-container">
    <form method="post" action="BookSituation.php">
        <input class="search-input" type="text" name="search" placeholder="Search...">
        <button class="search-button" type="submit">Search</button>
    </form>
</div>

<?php
$hostname = "localhost"; 
$username = "root"; 
$password = "witlibrary2023password"; 
$database = "database_users"; 

// Establishing a connection to the database
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handling the search functionality
if (isset($_POST['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_POST['search']); 
    $query = "SELECT * FROM book_status 
              WHERE fname LIKE '%$searchTerm%' 
              OR lname LIKE '%$searchTerm%' 
              OR idnum LIKE '%$searchTerm%' 
              OR bk_title LIKE '%$searchTerm%' 
              OR isbn LIKE '%$searchTerm%'";
} else {
    // Default query without search
    $query = "SELECT * FROM book_status";
}

// Executing the query
$result = mysqli_query($conn, $query);

// Check for query execution success
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>


        
<table class='scrollable-table-log'>
        <tr>
        <th>Full Name</th>
        <th>ID #</th>
        <th>Course</th>
        <th>RF</th>
        <th>Book Title</th>
        <th>ISBN</th>
        <th>Library/Section</th>
        <th>Date Borrow</th>
        <th>Date Return</th>
        <th>Status</th>
        <th>Penalty</th>
        <th>Pin Code</th>

        <th>Book Return</th> 

    </tr>
    <?php
$sectionToTableMap = [
    'Graduate School Library Archive Section' => 'graduateschool_library_archive_section',
    'Graduate School Library Circulation Section' => 'graduateschool_library_circulation_section',
    'Graduate School Library Filipinana Section' => 'graduateschool_library_filipinana_section',
    'Graduate School Library Periodical Section' => 'graduateschool_library_periodical_section',
    'Graduate School Library Reference Section' => 'graduateschool_library_reference_section',
    'Graduate School Library Reserve Section' => 'graduateschool_library_reserve_section',
    'Graduate School Library Thesis/Dissertation Section' => 'graduateschool_library_thesisdissertation_section',
    'Graduate School Library Thesis/Dissertations Section' => 'graduateschool_library_thesisdissertation_section',
    'Main Library Archives Section' => 'main_library_archives_section',
    'Main Library Circulation Section' => 'main_library_circulation_section',
    'Main Library Fiction Section' => 'main_library_fiction_section',
    'Main Library Filipinana Section' => 'main_library_filipinana_section',
    'Main Library Periodical Section' => 'main_library_periodical_section',
    'Main Library Reference Section' => 'main_library_reference_section',
    'Main Library Reserve Section' => 'main_library_reserve_section',
    'Main Library Thesis/Dissertation Section' => 'main_library_thesisdissertation_section',
    'RTS Library Archive Section' => 'rts_library_archive_section',
    'RTS Library Circulation Section' => 'rts_library_circulation_section',
    'RTS Library Fiction Section' => 'rts_library_fiction_section',
    'RTS Library Filipinana Section' => 'rts_library_filipinana_section',
    'RTS Library Periodical Section' => 'rts_library_periodical_section',
    'RTS Library Reference Section' => 'rts_library_reference_section',
    'RTS Library Reserve Section' => 'rts_library_reserve_section',
    'RTS Library Thesis/Dissertation Section' => 'rts_library_thesisdissertation_section',
];

$messages = array(); 

while ($row = mysqli_fetch_assoc($result)) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["confirmation_code"]) && isset($_POST["row_id"])) {
            $enteredCode = $_POST["confirmation_code"];
            $rowId = $_POST["row_id"];

            $query = "SELECT code, section, isbn, status FROM book_status WHERE id = $rowId";
            $codeResult = mysqli_query($conn, $query);
            $codeRow = mysqli_fetch_assoc($codeResult);
            $correctCode = $codeRow['code'];
            $section = $codeRow['section'];
            $isbn = $codeRow['isbn'];

            if ($enteredCode === $correctCode) {
                // Check if the status is not already 'On-Hand'
                if ($codeRow['status'] !== 'On-Hand') {
                    $updateQuery = "UPDATE book_status SET status = 'On-Hand' WHERE id = $rowId";
                    $updateResult = mysqli_query($conn, $updateQuery);
            
                    if (!$updateResult) {
                        $messages[$rowId] = '<span class="code-error">Status Update Failed</span>';
                        // Handle update failure if needed
                    }
                }
            
                if ($codeRow['status'] !== 'Returned') {
                    // Set the final penalty_count value
                  
            
                    if (!$insertLogResult) {
                        // Handle insertion failure if needed
                        $messages[$rowId] = '<span class="code-error">Failed to Return in Inventory</span>';
                    }
                }
            
                $messages[$rowId] = '<span class="code-matched">Code Matched</span>';
                echo '<script>
                        alert("Code Matched");
                        window.location.href = "BookSituation.php";
                      </script>';
            } else {
                $messages[$rowId] = 'Code Incorrect';
            }
            
        }
    }

    echo "<tr>";
    echo "<td>" . $row['lname'] . ", " . $row['fname'] . "</td>";
    echo "<td class='idnum-cell'>" . $row['idnum'] . '</td>';
    echo "<td class='course-cell'>" . $row['course'] . "</td>";

    $rfQuery = "SELECT users_rf FROM users_db WHERE idnum = '" . $row['idnum'] . "'";
$rfResult = mysqli_query($conn, $rfQuery);

if ($rfResult) {
    $rfRow = mysqli_fetch_assoc($rfResult);
    $rfData = base64_encode($rfRow['users_rf']); // Assuming 'users_rf' is a BLOB, encode for display
    $rfImageSrc = "data:image/png;base64,{$rfData}";

    // Link to open the modal
    echo "<td><a href='#' onclick='openModal(\"{$rfImageSrc}\")'>Click Here</a></td>";
} else {
    echo "<td>Error fetching RF data</td>";
}

    echo '<td class="bk-title-cell"><b>' . $row['bk_title'] . '</b></td>';
    echo "<td>" . $row['isbn'] . "</td>";
    echo "<td class='section-cell'>" . $row['section'] . "</td>";
    echo "<td class='date-cell'>" . $row['date_borrow'] . "</td>";
    echo "<td class='date-cell' style='font-weight: 800;'>" . $row['date_return'] . "</td>";

    echo '<td class="status-'  . strtolower($row['status']) . '">' . $row['status'] . '</td>';
    echo "<td class='date-cell'>" . $row['penalty_count'] . "</td>";

    echo '<td>
        <form method="post" action="BookSituation.php">
            <input class="confirmation-input" type="text" name="confirmation_code" maxlength="5">
            <button class="confirm-button" type="submit">Confirm</button>
            <input type="hidden" name="row_id" value="' . $row['id'] . '">
        </form>';

    if (isset($messages[$row['id']])) {
        echo '<div class="message">' . $messages[$row['id']] . '</div>';
    }

    echo "</td>";
    echo '<td>
    <form method="post" action="BookSituation.php" onsubmit="return confirm(\'Confirm returning book to the inventory?\')">
        <button class="return-button" type="submit" name="return_book" value="' . $row['id'] . '">Return Book</button>
    </form>';

    if (isset($_POST['return_book']) && $_POST['return_book'] == $row['id']) {
        $decreaseUserQuery = "UPDATE users_db SET users_onhand = users_onhand - 1 WHERE idnum = '" . $row['idnum'] . "'";
        $decreaseUserResult = mysqli_query($conn, $decreaseUserQuery);

        $section = $row['section'];
        $isbn = $row['isbn'];
        $tableToUpdate = $sectionToTableMap[$section];
        $increaseQuantityQuery = "UPDATE $tableToUpdate SET quantity = quantity + 1 WHERE isbn = '" . $isbn . "'";
        $increaseQuantityResult = mysqli_query($conn, $increaseQuantityQuery);

        if ($decreaseUserResult && $increaseQuantityResult) {
            // Delete the row from book_status
            $deleteQuery = "DELETE FROM book_status WHERE id = " . $row['id'];
            $deleteResult = mysqli_query($conn, $deleteQuery);

            if (!$deleteResult) {
                // Handle deletion failure if needed
            }

            $updateQuery = "UPDATE book_status SET status = 'Returned' WHERE id = " . $row['id'];
            $updateResult = mysqli_query($conn, $updateQuery);
            $finalPenaltyCount = $row['penalty_count'];
                
            // Move data to book_log table
            $insertLogQuery = "INSERT INTO book_inventory (fname, lname, idnum, course, bk_title, isbn, section, status, penalty_balance, date_return, code, date_confirmed, date_borrow)
                                VALUES ('" . $row['fname'] . "', '" . $row['lname'] . "', " . $row['idnum'] . ", '" . $row['course'] . "', '" . $row['bk_title'] . "', " . $row['isbn'] . ", '" . $row['section'] . "', 'Returned', $finalPenaltyCount, '" . $row['date_return'] . "', '" . $row['code'] . "', CURRENT_TIMESTAMP, '" . $row['date_borrow'] . "')";
        
            $insertLogResult = mysqli_query($conn, $insertLogQuery);



            if ($updateResult && $insertLogResult) {
                echo '<script>
                    alert("The book has been returned to the inventory.");
                    window.location.href = "BookSituation.php"; // Redirect to the same page
                </script>';
                exit; 
            } else {
                echo '<script>
                    alert("Failed to update the book status.");
                    window.location.href = "BookSituation.php"; // Redirect to the same page
                </script>';
                exit; 
            }
        } else {
            echo '<script>
                alert("Failed to update user and book data.");
                window.location.href = "BookSituation.php"; // Redirect to the same page
            </script>';
            exit; 
        }
    }
    
    echo "</td>";
    
    echo "</tr>";
}
?>
<script>
function openModal(imageSrc) {
    var modal = document.createElement("div");
    modal.classList.add("custom-modal");

    var modalContent = document.createElement("div");
    modalContent.classList.add("custom-modal-content");

    var image = document.createElement("img");
    image.src = imageSrc;
    image.style.width = "100%";
    image.style.height = "100%";

    modalContent.appendChild(image);
    modal.appendChild(modalContent);

    modal.addEventListener("click", function() {
        document.body.removeChild(modal);
    });

    document.body.appendChild(modal);
}
</script>

                <script>
    var message = '<?php echo addslashes($messages[$rowId]); ?>';
    alert(message);
</script>


    </table>




<!---------------------------------------------------------------------------------------------------------->







<!--------------------------------------------------------------------------------------------------------->



</body>
</html>