<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userEmail = $_POST['userEmail'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $idnum = $_POST['idnum'];
    $course = $_POST['course'];
    $bk_title = $_POST['bk_title'];
    $section = $_POST['section'];
    $isbn = $_POST['isbn'];
    $code = $_POST['code'];
    $dateReturn = $_POST['date_return'];
    $dateBorrow = $_POST['date_borrow'];
    $id = $_POST['id'];

    // Now you have the data from the "Deny" button in these variables.
    // You can use them as needed.
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
    <title>WIT Administration library</title>
</head>
<body>
<script src="javascripts/mainjs.js"></script>
<div class="maintitle">
    <h1>WESTERN INSTITUTE ADMINISTRATION LIBRARY</h1>
</div>
<div class="back-btn"><a href="BookRequest.php">Back to Admin Panel</a></div>
<div class="background-main">
    <img src="pics/WIT-LOGO.png" class="mainlogo" alt="">
</div>
<body>

<div class="info-container">
<?php
// Access the variables using $_GET from the query parameters in the URL
$userEmail = $_GET['userEmail'];
$fname = $_GET['fname'];
$lname = $_GET['lname'];
$idnum = $_GET['idnum'];
$course = $_GET['course'];
$bk_title = $_GET['bk_title'];
$section = $_GET['section'];
$isbn = $_GET['isbn'];
$dateReturn = $_GET['dateReturn'];
$dateBorrow = $_GET['dateBorrow'];
$id = $_GET['id'];
$code = $_GET['code'];
echo "<h2>User Information</h2>";
echo "<p><strong>Name:</strong> $fname $lname</p>"; 
echo "<p><strong>Email:</strong> $userEmail</p>";
echo "<p><strong>ID #:</strong> $idnum</p>";
echo "<p><strong>Course:</strong> $course</p>";
echo "<p><strong>Book Title:</strong> $bk_title</p>";
echo "<p><strong>Section:</strong> $section</p>";
echo "<p><strong>ISBN:</strong> $isbn</p>";
echo "<p><strong>Date Borrow:</strong> $dateBorrow</p>";
echo "<p><strong>Date Return:</strong> $dateReturn</p>";
echo "<p><strong>Code:</strong> $code</p>";


?>
</div>


<div class="custom-form-container-denial" id="form-container-approve">
    <h3>Approval Form</h3>
    <p><b>Take Note!</b> &nbsp; Please leave the receiver a custom message about inquiring the book. </p>
    <form method="post" action="Approval.php" onsubmit="return showConfirmation()">
        <input type="hidden" name="action" value="approval">
        <input type="hidden" name="email" value="<?php echo $userEmail; ?>">
        <input type="hidden" name="fname" value="<?php echo $fname; ?>">
        <input type="hidden" name="lname" value="<?php echo $lname; ?>">
        <input type="hidden" name="idnum" value="<?php echo $idnum; ?>">
        <input type="hidden" name="course" value="<?php echo $course; ?>">
        <input type="hidden" name="bk_title" value="<?php echo $bk_title; ?>">
        <input type="hidden" name="section" value="<?php echo $section; ?>">
        <input type="hidden" name="isbn" value="<?php echo $isbn; ?>">
        <input type="hidden" name="code" value="<?php echo $code; ?>">
        <input type="hidden" name="dateBorrow" value="<?php echo $dateBorrow; ?>">
        <input type="hidden" name="dateReturn" value="<?php echo $dateReturn; ?>">

        <label for="message">Message:</label>
        <textarea id="message" name="message" class="message-input"></textarea>
        <button class="send-link" type="submit">Send</button>
    </form>
    <script>
    function showConfirmation() {
      var confirmation = confirm("Are you sure you want to confirm the approval of acquiring the book?");
      if (confirmation) {
        // If the user clicks 'OK', you can perform further actions or submit the form
        alert("Confirmation received. Book acquisition approved!");
        // Add your additional logic or form submission here
        return true; // Continue with form submission
      } else {
        // If the user clicks 'Cancel', you can handle it accordingly
        alert("Confirmation canceled. Book acquisition not approved.");
        return false; // Cancel form submission
      }
    }
  </script>
    <button class="close-button" id="close-button" onclick="window.location.href = 'BookRequest.php'">Close</button>
</div>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$code = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userEmail = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $idnum = $_POST['idnum'];
    $course = $_POST['course'];
    $bk_title = $_POST['bk_title'];
    $message = $_POST['message'];
    $section = $_POST['section'];
    $isbn = $_POST['isbn'];
    $code = $_POST['code'];
    $dateBorrow = $_POST['dateBorrow'];
    $dateReturn = $_POST['dateReturn'];

    if (!empty($userEmail)) {
        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'calderon.janrasheedcit2011@gmail.com';
        $mail->Password = 'tfeyfpskdtvbtsvs';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('librarysample2011@gmail.com', 'WIT LIBRARY ADMINISTRATION');
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
                        Dear $fname $lname,
                    </p>
                    <p>
                    &nbsp; &nbsp; &nbsp; We are pleased to inform you that your request for the book, '$bk_title' (ISBN: $isbn), from the '$section' of the library has been successfully processed.
                    </p>
                    <p>
                        <strong>Details of your transaction:</strong><br>
                        - Identification Number: $idnum<br>
                        - Course: $course<br>
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
                    $message
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
            $hostname = "localhost";
            $username = "root";
            $password = "witlibrary2023password";
            $database = "database_users";

            $conn = mysqli_connect($hostname, $username, $password, $database);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $isbn = mysqli_real_escape_string($conn, $isbn);

            $queryInsert = "INSERT INTO book_status (fname, lname, idnum, course, bk_title, isbn, section, status, date_borrow, date_return, code) VALUES (?, ?, ?, ?, ?, ?, ?, 'Unclaimed', ?, ?, ?)";
            $stmtInsert = mysqli_prepare($conn, $queryInsert);
            
            if ($stmtInsert) {
                mysqli_stmt_bind_param($stmtInsert, 'ssississss', $fname, $lname, $idnum, $course, $bk_title, $isbn, $section, $dateBorrow, $dateReturn, $code);

                if (mysqli_stmt_execute($stmtInsert)) {
                    $queryDelete = "DELETE FROM books_approval WHERE isbn = ?";
                    $stmtDelete = mysqli_prepare($conn, $queryDelete);

                    if ($stmtDelete) {
                        mysqli_stmt_bind_param($stmtDelete, 's', $isbn);

                        if (mysqli_stmt_execute($stmtDelete)) {
                            echo '<script>window.location = "BookRequest.php";</script>';
                        } else {
                            echo 'Error: ' . mysqli_error($conn);
                        }

                        mysqli_stmt_close($stmtDelete);
                    } else {
                        echo 'Error: ' . mysqli_error($conn);
                    }
                } else {
                    echo 'Error: ' . mysqli_error($conn);
                }

                mysqli_stmt_close($stmtInsert);
            } else {
                echo 'Error: ' . mysqli_error($conn);
            }

            mysqli_close($conn);
        } else {
            echo 'Error: ' . $mail->ErrorInfo;
        }
    } else {
        echo 'Error: The recipient email address is empty';
    }
}
?>




    
</body>
</html>