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
    <!-- Overlay container -->
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



?>
</div>

    <div class="custom-form-container-denial" id="form-container">
    <h3>Denial Form</h3>
    <p><b>Take Note!</b> &nbsp; Please leave a custom message for the user regarding the processing of this book. Explain the denial of the request.</p>
    <form method="post" action="Denial.php" onsubmit="return showConfirmation()">
    <input type="hidden" name="email" value="<?php echo $userEmail; ?>">

    <input type="hidden" name="fname" value="<?php echo $fname; ?>">
    <input type="hidden" name="lname" value="<?php echo $lname; ?>">
    <input type="hidden" name="idnum" value="<?php echo $idnum; ?>">
    <input type="hidden" name="course" value="<?php echo $course; ?>">
    <input type="hidden" name="bk_title" value="<?php echo $bk_title; ?>">
    <input type="hidden" name="section" value="<?php echo $section; ?>">
    <input type="hidden" name="isbn" value="<?php echo $isbn; ?>">
    <input type="hidden" name="dateBorrow" value="<?php echo $dateBorrow; ?>">
        <input type="hidden" name="dateReturn" value="<?php echo $dateReturn; ?>">
    
    <label for="message">Message:</label>
    <textarea id="message" name="message" class="message-input"></textarea>
    <button class="send-link" type="submit">Send</button>
</form>
<script>
    function showConfirmation() {
      var confirmation = confirm("Are you sure you want to confirm the denial of acquiring the book?");
      if (confirmation) {
        // If the user clicks 'OK', you can perform further actions or submit the form
        alert("Confirmation received.");
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
        $mail->Subject = 'Western Institute of Technology Book Inquiry Status';

        // Compose the denial email body
        $denialMessage = "
            <html>
                <body>
                    <p>
                        <strong>Subject:</strong> Denial of Book Acquisition Request
                    </p>
                    <p>
                        Dear $fname $lname,
                    </p>
                    <p>
                        &nbsp; &nbsp; &nbsp; We regret to inform you that your request for the book, '$bk_title' (ISBN: $isbn), from the '$section' of the library has been denied.
                    </p>
                    <p>
                        <strong>Details of your request:</strong><br>
                        - Identification Number: $idnum<br>
                        - Course: $course<br>
                        - Date of Borrowing: $dateBorrow<br>
                        - Date of Return: $dateReturn
                    </p>
                    <p>
                    <strong>Reason for Denial:</strong><br>
                    &nbsp; &nbsp; &nbsp; We sincerely regret to inform you that, after careful consideration by our library personnel, your request for the book, '$bk_title' (ISBN: $isbn), from the '$section' of the library has unfortunately been denied. Our team has reviewed your requested dates and, due to high demand or scheduling conflicts, we are unable to fulfill your request at this time. We understand the importance of timely access to resources and deeply apologize for any inconvenience this may cause.
                </p>
                    <p>
                        $message
                    </p>
                    <p>
                        &nbsp; &nbsp; &nbsp; If you have any questions or require further information, please feel free to email us at <a href=\"mailto:witlib57@gmail.com\" target=\"_blank\">witlib57@gmail.com</a> or connect with us on Facebook through our official page: <a href=\"https://www.facebook.com/profile.php?id=100071289624935\" target=\"_blank\">WIT Library Facebook</a>. We value your inquiries and are here to provide support in any way we can.
                    </p>
                    <p>
                        Thank you for your understanding.
                    </p>
                    <p>
                        Sincerely,<br>
                        WIT Library Administration
                    </p>
                </body>
            </html>
        ";

        $mail->Body = $denialMessage;

        if ($mail->send()) {
            // Email sent successfully
            include '../Configure.php';

            // Assuming $bookID contains the book ID
            $isbn = mysqli_real_escape_string($conn, $isbn);

            // Use a prepared statement to delete the record
            $query = "DELETE FROM books_approval WHERE isbn = ?";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'i', $isbn); // 's' represents a string, adjust if ISBN is a different data type

                if (mysqli_stmt_execute($stmt)) {
                    echo '<script>window.location = "BookRequest.php";</script>';
                } else {
                    echo 'Error: ' . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            } else {
                echo 'Error: ' . mysqli_error($conn);
            }
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