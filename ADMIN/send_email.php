<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Check if id is set in the URL parameters
if (isset($_GET["id"])) {
    include '../Configure.php';

    $query = "SELECT email, lname, fname, course, suffix, idnum, addr, users_num, pin_code FROM users_db WHERE id = $userId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userEmail = $row['email'];
        $userName = $row['suffix'] ? $row['suffix'] . ' ' : '';
        $userName .= $row['lname'] . ', ' . $row['fname']; 
        $idNum = $row['idnum'];
        $course = $row['course'];
        $suffix = $row['suffix'];
        $addr = $row['addr'];
        $userNum = $row['users_num'];
        $pincode = $row['pin_code'];

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
        $mail->addAddress($userEmail, $userName);
        $mail->isHTML(true);

        // Customize your email subject and body here
        $mail->Subject = 'Account Verification';
        $mail->Body = "Dear $userName,<br><br>
        Greetings from the WIT Library Administration. We trust this message finds you well.<br><br>
        In line with our commitment to ensuring the utmost security for your WIT Library account, we have initiated a critical security verification process. This process is crucial for confirming the legitimacy of any account-related requests.<br><br>
        As part of this process, a unique Verification Code (PIN) has been generated for your account. Please find the details associated with your account below:<br><br>
        - Email Address: $userEmail<br>
        - User ID: $idNum<br>
        - Name: $userName<br>
        - Course: $course<br>
        - Suffix: $suffix<br>
        - Address: $addr<br>
        - User Number: $userNum<br>
        - Verification Code (PIN): <strong>$pincode</strong><br><br>
        This Verification Code (PIN) serves as a crucial element in validating the authenticity of your account-related actions. To proceed with the security verification process, please follow the detailed instructions provided in the verification email sent to your registered email address.<br><br>
        Please remember, for security reasons, never share this Verification Code (PIN) or any other confidential information with anyone. Should you not have initiated this process or if you harbor any concerns regarding the security of your account, please do not hesitate to contact our dedicated support team at your earliest convenience.<br><br>
        We appreciate your understanding and cooperation in this matter.<br><br>
        Kind regards,<br>
        WIT Library Administration";

        // Send the email
        if ($mail->send()) {
            echo '<script>alert("Email sent successfully");</script>';
        } else {
            echo '<script>alert("Email could not be sent.");</script>';
        }
    }

    $conn->close();

    header("Location: MatchAcc.php");
    exit();
} else {
    echo "User ID not provided.";
}
?>

