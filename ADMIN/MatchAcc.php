<?php
include '../Configure.php';

// Initialize variables
$message = "";
$suffix = "";
$lastName = "";
$firstName = "";
$email = "";

// Include PHPMailer dependencies
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered code from the form
    $enteredCode = $_POST["code"];

    // SQL query to check if the entered code matches any pin codes in the users_db table
    $sql = "SELECT fname, lname, suffix, email, idnum, course, addr, users_num, pass FROM users_db WHERE pin_code = '$enteredCode'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        while ($row = $result->fetch_assoc()) {
            $userEmail = $row['email'];
            $userName = $row['suffix'] ? $row['suffix'] . ' ' : '';
            $userName .= $row['lname'] . ', ' . $row['fname']; 
            $lastName =$row['lname'];
            $firstName = $row['fname'];
            $idNum = $row['idnum'];
            $course = $row['course'];
            $suffix = $row['suffix'];
            $addr = $row['addr'];
            $userNum = $row['users_num'];
            $password = $row['pass'];

            $message = "Pin Code Match!";

            // Create a PHPMailer instance
            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP host
            $mail->SMTPAuth = true;
            $mail->Username = 'calderon.janrasheedcit2011@gmail.com'; // SMTP username
            $mail->Password = 'tfeyfpskdtvbtsvs'; // SMTP password
            $mail->SMTPSecure = 'ssl'; // Use SSL or 'tls' for TLS encryption
            $mail->Port = 465; // Set the appropriate port

            // Set email details
            $mail->setFrom('librarysample2011@gmail.com', 'WIT LIBRARY ADMINISTRATION');

            // Subject and body
            $mail->addAddress($userEmail, $lastName . ', ' . $firstName);

            $mail->isHTML(true);

            // Customize your email subject and body here
            $mail->Subject = 'Subject Here';
            $mail->Body = "Dear $userName,<br><br>" .
            "We hope this message finds you well. We are delighted to inform you that your account verification process has been successfully completed. Below are the details associated with your account:<br><br>" .
            "Full Name: $userName<br>" .
            "Identification Number: $idNum<br>" .
            "Account Password: $password<br>" .
            "Email Address: $userEmail<br>" .
            "Course Enrolled: $course<br>" .
            "Address: $addr<br>" .
            "User Number: $userNum<br><br>" .
            "As a valued member of our community, we want to assure you that your security is our top priority. All your personal information, including your identification number and email address, is handled with the utmost confidentiality and stored securely. We employ industry-standard security measures to safeguard your data against unauthorized access.<br><br>" .
            "If you have any inquiries or notice any suspicious activity related to your account, please do not hesitate to contact us immediately. Your vigilance contributes to the overall security of our community.<br><br>" .
            "Thank you for choosing WIT Library. We look forward to serving you and providing you with an enriching experience.<br><br>" .
            "Best regards,<br>" .
            "WIT LIBRARY ADMINISTRATION";

            if ($mail->send()) {
                
            } else {
                echo '<script>alert("Email could not be sent.");</script>';
            }
        }
    } else {
        // Code did not match
        echo '<script>alert("Code not matched.");</script>';
    }
}

$conn->close();
?>




<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/forgot.css?v= <?php echo time(); ?>">
    <link rel="icon" type="image" href="pics/WIT-Logo.png">
    <title>Code Verification</title>
</head>
<body>
    <div class="side-logo"> 
        <img src="Images/WIT-Logo.png" class="bar_logo">     
    </div>

    <div class="container1">
        <div class="title">Verification Code</div>
        <div class="content1">
            <form action="MatchAcc.php" method="post" class="form-container" id="verificationForm">
                <div class="user-details1">
                    <p class="name"><?php echo $suffix . " " . $lastName . " " . $firstName; ?></p>
                    <p class="email">  <a href="ForgotPass.php" class="not-you">Not You?</a></p>
                </div>
                <div class="input-container <?php echo $message === 'Pin Code Match!' ? 'hidden' : ''; ?>">
                    <input type="number" class="code-input" placeholder="Enter code" name="code" oninput="limitDigits(this)">
                    <span><button type="submit" class="submit-button">Submit</button></span>
                </div>
                <div class="message-container <?php echo $message === 'Pin Code Match!' ? '' : 'hidden'; ?>">
                    <?php echo $message; ?>
                </div>

                <button type="button" class="additional-button" onclick="window.location='../Main Page.php'">Log In?</button>


            </form>
            <script>
    function limitDigits(input) {
        if (input.value.length > 5) {
            input.value = input.value.slice(0, 5);
        }
    }

    function hideForm() {
        var messageContainer = document.querySelector(".message-container");
        if (messageContainer.innerText === 'Pin Code Match!') {
            document.getElementById("verificationForm").classList.add("hidden");
        }
    }
</script>

        </div>
    </div>
</body>
</html>