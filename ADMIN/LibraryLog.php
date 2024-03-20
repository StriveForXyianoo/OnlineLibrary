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
<!----------------------------------------------------------------------------------------------------------------------------------->
<div class="library-user-log-form">
    <h2>Library User Log</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="search">Search by ID or Email:</label>
    <input type="text" id="search" name="search_term" required>
    <button type="submit" name="submit">Search</button>
</form>

    <?php
   

    if (isset($_POST['search'])) {
        $searchTerm = mysqli_real_escape_string($conn, $_POST['search']);
        $query = "SELECT * FROM users_db 
                  WHERE fname LIKE '%$searchTerm%' 
                  OR lname LIKE '%$searchTerm%' 
                  OR idnum LIKE '%$searchTerm%' 
                  OR email LIKE '%$searchTerm%'";
    } else {
        // If no search term, set a condition that will not return any results
        $query = "SELECT * FROM users_db WHERE 1=0";
    }

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }
    ?>
    <div class="user-details-container">
    <?php


function generateRandomCode($length = 5) {
    $characters = '123456789abcdefghijklmnopqrstuvwxyz';
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Declare $row outside the loop
$row = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_POST['search_term']);

    $query = "SELECT * FROM users_db WHERE idnum = '$searchTerm' OR email = '$searchTerm'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
         
            echo "<form method='post' action='{$_SERVER['PHP_SELF']}'>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Full Name</th><th>Email</th><th>Course</th><th>RF</th><th>Book Title</th><th>Section</th><th>ISBN</th><th>Date Borrow</th><th>Date Return</th><th>Action</th></tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                // Store user information in variables
                $userId = $row['idnum'];
                $userFname = $row['fname'];
                $userLname = $row['lname'];
                $userEmail = $row['email'];
                $userCourse = $row['course'];

                echo "<tr>";
                echo "<td>{$userId}</td>";
                echo "<td>{$userFname} {$userLname}</td>";

                echo "<td>{$userEmail}</td>";
                echo "<td>{$userCourse}</td>";
                echo "<td class='users-rf'><a href='#' onclick=\"openModal('data:image/jpeg;base64," . base64_encode($row['users_rf']) . "')\">View</a></td>";
                echo "<td><input type='text' name='book_title'></td>";
                echo "<td><select name='section'>";
                echo "<option value=''>Select a Section</option>";
                
                $options = array(
                    'Graduate School Library Archive Section',
                    'Graduate School Library Circulation Section',
                    'Graduate School Library Filipinana Section',
                    'Graduate School Library Periodical Section',
                    'Graduate School Library Reference Section',
                    'Graduate School Library Reserve Section',
                    'Graduate School Library Thesis/Dissertation Section',
                    'Main Library Archive Section',
                    'Main Library Circulation Section',
                    'Main Library Fiction Section',
                    'Main Library Filipinana Section',
                    'Main Library Periodical Section',
                    'Main Library Reference Section',
                    'Main Library Reserve Section',
                    'Main Library Thesis/Dissertation Section',
                    'RTS Library Archive Section',
                    'RTS Library Circulation Section',
                    'RTS Library Fiction Section',
                    'RTS Library Filipinana Section',
                    'RTS Library Periodical Section',
                    'RTS Library Reference Section',
                    'RTS Library Reserve Section',
                    'RTS Library Thesis/Dissertation Section'
                );
                
                foreach ($options as $option) {
                    // Preserve the case of the original option, use htmlspecialchars to encode special characters
                    $value = htmlspecialchars($option, ENT_QUOTES);
                    echo "<option value='$value'>$option</option>";
                }
                
                echo "</select></td>";
                
                
                
                
                echo "<td><input type='number' name='isbn' style='width: 70px;'></td>";
                echo "<td><input type='text' id='date_borrow' name='date_borrow' style='width: 70px;'></td>";
                echo "<td><input type='text' id='date_return' name='date_return' style='width: 70px;'></td>";
                            
                echo "<td><button type='submit' name='submit_form' onclick='return confirm(\"Are you sure you want to submit the form?\");'>Submit</button></td>";
                echo "<input type='hidden' name='user_id' value='{$userId}'>";
                echo "<input type='hidden' name='user_email' value='{$userEmail}'>";
                echo "<input type='hidden' name='user_fname' value='{$userFname}'>";
                echo "<input type='hidden' name='user_lname' value='{$userLname}'>";
                echo "<input type='hidden' name='user_course' value='{$userCourse}'>";
                echo "<input type='hidden' name='user_section' value=''>";
                echo "<input type='hidden' name='user_isbn' value=''>";
                echo "</tr>";
            }

            echo "</table>";
            echo "</form>";
        } else {
            echo "<p>No results found.</p>";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_form'])) {
    $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
    $bookTitle = mysqli_real_escape_string($conn, $_POST['book_title']);
    $section = mysqli_real_escape_string($conn, $_POST['section']);
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
    $dateBorrow = mysqli_real_escape_string($conn, $_POST['date_borrow']);
    $dateReturn = mysqli_real_escape_string($conn, $_POST['date_return']);
    $userEmail = mysqli_real_escape_string($conn, $_POST['user_email']);
    $userFname = mysqli_real_escape_string($conn, $_POST['user_fname']);
    $userLname = mysqli_real_escape_string($conn, $_POST['user_lname']);
    $userCourse = mysqli_real_escape_string($conn, $_POST['user_course']);

   
    $code = generateRandomCode();

    
    $insertQuery = "INSERT INTO book_status (idnum, lname, fname, course, bk_title, isbn, section, date_borrow, date_return, code, status) 
    SELECT idnum, lname, fname, course, '$bookTitle', '$isbn', '$section', '$dateBorrow', '$dateReturn', '$code', 'Claimed'
    FROM users_db
    WHERE idnum = '$userId'";


    $insertResult = mysqli_query($conn, $insertQuery);

    if ($insertResult) {
        // Send email with the generated code
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'calderon.janrasheedcit2011@gmail.com';
        $mail->Password = 'tfeyfpskdtvbtsvs';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('librarysample2011@gmail.com', 'WIT LIBRARY ADMINISTRATION');

        if (!empty($userEmail)) {
            $mail->addAddress($userEmail);

            $mail->isHTML(true);
            $mail->Subject = 'Western Institute of Technology Book Inquiring Confirmation Message';

            $confirmationMessage = "
            <html>
                <body>
                    <p>
                        <strong>Subject:</strong> Confirmation of Successful Acquiring Book
                    </p>
                    <p>
                    Dear {$userFname} {$userLname},
                </p>
                <p>
                    &nbsp; &nbsp; &nbsp; We are pleased to inform you that your request for the book, '$bookTitle' (ISBN: $isbn), from the '$section' of the library has been successfully processed.
                </p>
                <p>
                    <strong>Details of your transaction:</strong><br>
                    - Identification Number: {$userId}<br>
                    - Course: {$userCourse}<br>
                    - Date of Borrowing: $dateBorrow<br>
                    - Date of Return: $dateReturn<br>
                    - Confirmation Code:<strong><u> $code</u></strong>
                </p>
                    <p>
                        <strong>Please take note of the following:</strong><br>
                        - Ensure that you arrive at the library on time for the book retrieval.<br>
                        &nbsp; &nbsp; &nbsp;   - Kindly present this confirmation email or provide the confirmation code <u>'$code'</u> at the library counter.
                    </p>
                    <p>
                    &nbsp; &nbsp; &nbsp; If you have any questions or require further information, please feel free to email us at <a href=\"mailto:witlib57@gmail.com\" target=\"_blank\">witlib57@gmail.com</a> or connect with us on Facebook through our official page: <a href=\"https://www.facebook.com/profile.php?id=100071289624935\" target=\"_blank\">WIT Library Facebook</a>. We value your inquiries and are here to provide support in any way we can.
                    </p>
                    <p>
                        Thank you for using our library services. We hope you enjoy your reading!
                    </p>
                    <p>
                        Sincerely,<br>
                        WIT Library Administration
                    </p>
                </body>
            </html>
        ";

            $mail->Body = $confirmationMessage;

            if ($mail->send()) {
                echo "<script>alert('Form submitted successfully!');</script>";
            } else {
                echo 'Error sending email: ' . $mail->ErrorInfo;
            }
        } else {
            echo 'Error: The recipient email address is empty';
        }
    } else {
        echo "<p>Error submitting form: " . mysqli_error($conn) . "</p>";
    }
}

mysqli_close($conn);
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var currentDate = new Date();
    currentDate.setHours(0, 0, 0, 0);
    var currentYear = currentDate.getFullYear();
    var currentMonth = currentDate.getMonth();

    var borrowDateInput = document.getElementById('date_borrow');
    var returnDateInput = document.getElementById('date_return');

    var lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    var lastWeekOfCurrentMonth = new Date(currentYear, currentMonth, lastDayOfMonth - 6); // Get the last 7 days of the current month

    var maxDateForBorrow = new Date(currentYear, currentMonth + 2, 0); // Allow selecting up to the end of next month

    flatpickr("#date_borrow", {
        disable: [
            function(date) {
                // Disable past dates and Sundays
                return (date < currentDate || date.getDay() === 0) && date.getMonth() !== currentMonth + 1; 
            }
        ],
        dateFormat: "Y-m-d",
        minDate: currentDate,
        maxDate: maxDateForBorrow, // Allow selecting up to the end of next month
        onChange: function(selectedDates, dateStr, instance) {
            var borrowDate = new Date(dateStr);
            var nextDay = new Date(borrowDate.getTime() + 24 * 60 * 60 * 1000); // Get the next day
            var sevenDaysLater = new Date(borrowDate.getTime() + 6 * 24 * 60 * 60 * 1000); // Six days later

            // Adjust maxDate for return date picker
            var maxDate = new Date(borrowDate.getTime() + 7 * 24 * 60 * 60 * 1000);
            maxDate.setHours(23, 59, 59, 999); // Set the time to the end of the day

            flatpickr("#date_return", {
                disable: [
                    function(date) {
                        return date.getDay() === 0; // Exclude Sundays
                    }
                ],
                dateFormat: "Y-m-d",
                minDate: borrowDate, // Allow selecting borrowing date
                maxDate: maxDate
            });

            returnDateInput.disabled = false;
            returnDateInput.focus();
        }
    });

    returnDateInput.disabled = true;
});
</script>




<div id="imageModal" class="modal-log">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modalImage" src="" alt="User Image">
    </div>
</div>

<script>

function openModal(imageSrc) {
    $("#modalImage").attr("src", imageSrc);
    $("#imageModal").css("display", "block");
}


function closeModal() {
    $("#imageModal").css("display", "none");
}


$(window).on("click", function(event) {
    if (event.target == document.getElementById("imageModal")) {
        closeModal();
    }
});


function submitForm(userId) {
 
    $("#user_id_input").val(userId);
    

    $("#submit_form").submit();
}
</script>


<form id="submit_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" id="user_id_input" name="user_id" value="">
    <input type="hidden" name="book_title" value="">
    <input type="hidden" name="section" value="">
    <input type="hidden" name="isbn" value="">
    <input type="hidden" name="date_borrow" value="">
    <input type="hidden" name="date_return" value="">
    <input type="hidden" name="submit_form" value="1">
</form>



    </div>






<!----------------------------------------------------------------------------------------------------------------------------------->
</body>
</html>