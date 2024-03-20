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


<!------------------------------------------------------------------------------------------------------------------>

<div id="UsersInfoForm" class="form-container-books">
    <h2>Users Info Form</h2>



    <!--------------------------Insert Code in here ------------------------------------------>
    <?php


$query = "SELECT *, section, date_return, date_borrow FROM books_approval";

$result = mysqli_query($conn, $query);

?>

<div class="search-form-container">
    <form method="POST" action="BookRequest.php">
    <input class="search-input-status" type="text" name="search" placeholder="Search...">
        <button class="search-button" type="submit">Search</button>
    </form>
</div>
<?php


// Handling the search functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    $search = mysqli_real_escape_string($conn, $_POST["search"]);

    $query = "SELECT *, section, date_return, date_borrow FROM books_approval
              WHERE fname LIKE '%$search%' OR
                    lname LIKE '%$search%' OR
                    email LIKE '%$search%' OR
                    idnum LIKE '%$search%' OR
                    isbn LIKE '%$search%' OR
                    bk_title LIKE '%$search%'";
} else {
    // Default query without search
    $query = "SELECT *, section, date_return, date_borrow FROM books_approval";
}

// Executing the query
$result = mysqli_query($conn, $query);

// Check for query execution success
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

?>


<div class="custom-table">
    <table>
    <tr class="title-row">
    <th>Full Name</th>
    <th>Email</th>
    <th>Course</th>
    <th>ID #</th>
    <th>Phone #</th>
    <th>RF</th> 
    <th>Book Title</th>
    <th>ISBN</th>
    <th>Book Section</th>
    <th>Date Borrow</th>
    <th>Date Return</th>

    <th>Approval</th>
</tr>


        <?php
$rowNumber = 0; 
while ($row = mysqli_fetch_assoc($result)) {
    $rowNumber++;
    $userEmail = $row['email'];
    $fname = $row['fname'];
    $lname = $row['lname'];
    $idnum = $row['idnum'];
    $usersNum = $row['users_num'];
    $course = $row['course'];
    $bk_title = $row['bk_title'];
    $section = $row['section'];
    $isbn = $row['isbn'];
    $code = $row['code'];
    $dateReturn = $row['date_return'];
    $dateBorrow = $row['date_borrow'];
    $fullName = $fname . ' ' . $lname; 
    $rowColor = $rowNumber % 2 == 0 ? "#f2f2f2" : "#ffffff";
    echo "<tr style='background-color: $rowColor;'>";
    echo "<td style='width: 80px;'>{$fullName}</td>";

    echo "<td>{$userEmail}</td>";
    echo "<td style='width: 120px;'>{$course}</td>";
    echo "<td>{$idnum}</td>";
    echo "<td>{$usersNum}</td>"; 
        // Fetch RF data from the users_db table based on idnum
        $rfQuery = "SELECT users_rf FROM users_db WHERE idnum = '$idnum'";
        $rfResult = mysqli_query($conn, $rfQuery);
        
        if ($rfResult) {
            $rfRow = mysqli_fetch_assoc($rfResult);
            $rfData = base64_encode($rfRow['users_rf']); // Assuming 'users_rf' is a BLOB, encode for display
            $rfImageSrc = "data:image/png;base64,{$rfData}";
    
            // Link to open the modal
    
        } else {
            echo "<td>Error fetching RF data</td>";
        }
    echo "<td><a href='#' onclick='openModal(\"{$rfImageSrc}\")'>Click Here</a></td>";
    echo "<td><strong style='font-size: 14px;'>{$bk_title}</strong></td>";
    echo "<td>{$isbn}</td>";
    echo "<td style='width: 150px;'>{$section}</td>";
    echo "<td>{$dateBorrow}</td>";
    echo "<td><strong style='font-size: 14px;'>{$dateReturn}</strong></td>";



    echo '<td>
        <form method="GET" action="Approval.php">
        <input type="hidden" name="userEmail" value="' . $userEmail . '">
        <input type="hidden" name="fname" value="' . $fname . '">
        <input type="hidden" name="lname" value="' . $lname . '">
        <input type="hidden" name="idnum" value="' . $idnum . '">
        <input type="hidden" name="course" value="' . $course . '">
        <input type="hidden" name="bk_title" value="' . $bk_title . '">
        <input type="hidden" name="section" value="' . $section . '">
        <input type="hidden" name="isbn" value="' . $isbn . '">
        <input type="hidden" name="code" value="' . $code . '">
        <input type="hidden" name="dateBorrow" value="' . $dateBorrow . '">
        <input type="hidden" name="dateReturn" value="' . $dateReturn . '">
        <input type="hidden" name="id" value="' . $row['id'] . '">
        <button type="submit" class="approve-button">Approve</button>
        </form>
        
        <form method="GET" action="Denial.php">
        <input type="hidden" name="userEmail" value="' . $userEmail . '">
        <input type="hidden" name="fname" value="' . $fname . '">
        <input type="hidden" name="lname" value="' . $lname . '">
        <input type="hidden" name="idnum" value="' . $idnum . '">
        <input type="hidden" name="course" value="' . $course . '">
        <input type="hidden" name="bk_title" value="' . $bk_title . '">
        <input type="hidden" name="section" value="' . $section . '">
        <input type="hidden" name="isbn" value="' . $isbn . '">
        <input type="hidden" name="code" value="' . $code . '">
        <input type="hidden" name="dateReturn" value="' . $dateReturn . '">
        <input type="hidden" name="dateBorrow" value="' . $dateBorrow . '">
        <input type="hidden" name="id" value="' . $row['id'] . '">
        <button type="submit" class="deny-button">Deny</button>
        </form>
    </td>';
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


        
    </table>
</div>

    </div>




</body>
</html>