<?php
include '../Configure.php';

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    
    if ($action === 'approve') {
        $newStatus = 'Approved';
    } elseif ($action === 'reject') {
        $newStatus = 'Rejected';
    }

   
    $sql_update_status = "UPDATE users_db SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update_status);
    $stmt->bind_param("si", $newStatus, $id);

    if ($stmt->execute()) {
       
        echo "<script>alert('Status updated to " . $newStatus . "');</script>";
    } else {
        
        echo "<script>alert('Error updating status: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}


?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);    
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com'; // SMTP host
$mail->SMTPAuth = true;
$mail->Username = 'calderon.janrasheedcit2011@gmail.com'; // SMTP username
$mail->Password = 'tfeyfpskdtvbtsvs'; // SMTP password
$mail->SMTPSecure = 'ssl'; // Use SSL or 'tls' for TLS encryption
$mail->Port = 465; // Set the appropriate port

// Set email details
$mail->setFrom('librarysample2011@gmail.com', 'WIT LIBRARY ADMINISTRATION');

// Retrieve the user's email from the database based on user ID
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    include '../Configure.php';

    $query = "SELECT email, lname, fname, idnum, course, addr, users_num, suffix FROM users_db WHERE id = $userId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userEmail = $row['email'];
        $userName = $row['suffix'] . ', ' . $row['lname'] . ', ' . $row['fname'];
        $idNum = $row['idnum'];
        $course = $row['course'];
        $addr  =$row['addr'];
        $users_num = $row['users_num'];
        $suffix = $row['suffix'];

        // Subject and body based on the action
        $mail->addAddress($userEmail, $userName);
        $mail->isHTML(true);

        if ($action === 'approve') {
            $mail->Subject = 'Approval Notification';
            $mail->Body = "
            <strong>Western Institute of Technology Library</strong><br><br>
            
            Recipient's Name: $userName<br>
            Recipient's Address: $addr<br><br>
            
            <strong>Subject:</strong> Approval Notification<br><br>
            
            Dear $userName,<br><br>
            
            &nbsp; &nbsp; &nbsp; I am delighted to inform you that your application for library access at the Western Institute of Technology (WIT) Library has been carefully reviewed and approved by the WIT Library administration. Congratulations!<br><br>
            
            &nbsp; &nbsp; &nbsp; We were impressed with your mention specific strengths or qualifications, and we believe that your dedication to specific aspects will greatly contribute to our library community. Your commitment aligns with our values, and we look forward to welcoming you.<br><br>
            
            Here are some additional details you may find useful:<br><br>
            
            - <strong>Full Name:</strong> $suffix, {$row['lname']}, {$row['fname']}<br>
            - <strong>Identification #:</strong> $idNum<br>
            - <strong>Email Address:</strong> $userEmail<br>
            - <strong>Course:</strong> $course<br>
            - <strong>Address:</strong> $addr<br>
            - <strong>Users Number:</strong> $users_num<br>
            - <strong>Suffix:</strong> $suffix<br><br>
            
            &nbsp; &nbsp; &nbsp; If you have any questions or require further information, please feel free to email us at <a href=\"mailto:witlib57@gmail.com\" target=\"_blank\">witlib57@gmail.com</a> or connect with us on Facebook through our official page: <a href=\"https://www.facebook.com/profile.php?id=100071289624935\" target=\"_blank\">WIT Library Facebook</a>. We value your inquiries and are here to provide support in any way we can.<br><br>
            
            Enjoy browsing at our Online Library, where a vast collection of resources awaits you.<br><br>
        
            Once again, congratulations on your approval. We are excited to have you as part of the WIT Library community.<br><br>
            
            Best regards,<br><br>
            
            <strong>$userName</strong><br>
            <strong>Western Institute of Technology Library</strong><br>
            <strong>$users_num</strong><br>
        ";
        
        
        
        } elseif ($action === 'reject') {
            $mail->Subject = 'Rejection Notification';
            $mail->Body = "
            <strong>Western Institute of Technology Library</strong><br><br>
            
            Recipient's Name: $userName<br>
            Recipient's Address: $addr<br><br>
            
            <strong>Subject:</strong> Rejection Notification<br><br>
            
            Dear $userName,<br><br>
            
            &nbsp; &nbsp; &nbsp; I regret to inform you that after careful consideration, your application for library access at the Western Institute of Technology (WIT) Library has not been approved by the WIT Library administration at this time.<br><br>
            
            &nbsp; &nbsp; &nbsp; While we appreciate your interest and effort, we regret to inform you that your qualifications do not meet the criteria required for specific reasons for rejection. After careful examination, it has come to our attention that there may be concerns regarding the accuracy of the information provided. The administration suspects possible fraudulent information or identity theft, or the details provided in the Reference Form (RF) may be outdated for the current semester. <br><br>
            
            Here are some details from your application:<br><br>
            
            - <strong>Full Name:</strong> $suffix, {$row['lname']}, {$row['fname']}<br>
            - <strong>Identification #:</strong> $idNum<br>
            - <strong>Email Address:</strong> $userEmail<br>
            - <strong>Course:</strong> $course<br>
            - <strong>Address:</strong> $addr<br>
            - <strong>Users Number:</strong> $users_num<br>
            - <strong>Suffix:</strong> $suffix<br><br>

            &nbsp; &nbsp; &nbsp; We understand that this news may be disappointing, and we encourage you to review the information provided and ensure its accuracy. If you believe there has been an error or if you have any questions, please feel free to contact us at <a href=\"mailto:witlib57@gmail.com\" target=\"_blank\">witlib57@gmail.com</a> or connect with us on Facebook through our official page: <a href=\"https://www.facebook.com/profile.php?id=100071289624935\" target=\"_blank\">WIT Library Facebook</a>. We value your inquiries and are here to provide support in any way we can.<br><br>
            
            &nbsp; &nbsp; &nbsp; Thank you for considering WIT Library, and we wish you the best in your future endeavors.<br><br>
            
            Sincerely,<br><br>
            
            <strong>$userName</strong><br>
            <strong>Western Institute of Technology Library</strong><br>
            <strong>$users_num</strong><br>
        ";
        
            // Delete the user from the database based on idnum when action is 'reject'
            $deleteQuery = "DELETE FROM users_db WHERE idnum = $idNum";
            if ($conn->query($deleteQuery) === TRUE) {
                // User deleted successfully
            } else {
                echo "Error deleting user: " . $conn->error;
            }
        }

        // Send the email
        if ($mail->send()) {
            echo '<script>alert("Email sent successfully");</script>';
        } else {
            echo '<script>alert("Email could not be sent.");</script>';
        }
    }
    $conn->close();
    
    // Redirect after processing
    header("Location: UsersApproval.php");
    exit();
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
include '../Configure.php';


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
    


<!---------------------------------------------------------------------------------------------------------->

<div class="book-log">
    
    <h2>Users Approval</h2>
    <div class="search-form-container">
    <form method="post" action="UsersApproval.php">
        <input class="search-input" type="text" name="search" placeholder="Search...">
        <button class="search-button" type="submit">Search</button>
    </form>
</div>

<?php


if (isset($_POST['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_POST['search']); 
    $query = "SELECT * FROM users_db 
              WHERE fname LIKE '%$searchTerm%' 
              OR lname LIKE '%$searchTerm%' 
              OR idnum LIKE '%$searchTerm%' 
              OR course LIKE '%$searchTerm%' 
              OR email LIKE '%$searchTerm%'";
    $result = mysqli_query($conn, $query);
} else {
    $query = "SELECT * FROM book_status";
    $result = mysqli_query($conn, $query);
}
?>
    
    <table class='scrollable-table-log'>
    <tr>
        <th>Full Name</th>
        <th>M.I.</th>
        <th>Suffix</th>
        <th>Gender</th>
        <th>Course</th>
        <th>Address</th>
        <th>ID #</th>
        <th>Email</th>
        <th>Contact #</th>
        <th>RF Picture</th>
        <th>Action</th>
    </tr>

<?php



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $searchTerm = mysqli_real_escape_string($conn, $_POST['search']);
    
 
    $sql_pending = "SELECT id, fname, lname, addr, idnum, users_rf, users_num, course, gender, middle_initial, email, suffix FROM users_db WHERE status='Pending' AND (fname LIKE '%$searchTerm%' OR lname LIKE '%$searchTerm%' OR idnum LIKE '%$searchTerm%' OR users_num LIKE '%$searchTerm%')";
} else {
    
    $sql_pending = "SELECT id, fname, lname, addr, idnum, users_rf, users_num, course, gender, middle_initial, email, suffix FROM users_db WHERE status='Pending'";
}

$result_pending = mysqli_query($conn, $sql_pending);

?>
<div class="image-container">
<?php
while ($row = mysqli_fetch_assoc($result_pending)) {
    echo "<tr>";
    echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
    echo "<td>" . $row['middle_initial'] . "</td>";
    echo "<td>" . $row['suffix'] . "</td>";
    echo "<td>" . $row['gender'] . "</td>";
    echo "<td>" . $row['course'] . "</td>";
    echo "<td>" . $row['addr'] . "</td>";
    echo "<td>" . $row['idnum'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['users_num'] . "</td>";

  
    if (!empty($row['users_rf'])) {
        $imageSrc = "data:image/jpeg;base64," . base64_encode($row['users_rf']);
        echo '<td><img src="' . $imageSrc . '" width="50" height="50" onclick="openModal(\'' . $imageSrc . '\')"></td>';
    } else {
        echo '<td>No Image</td>';
    }

  
    echo "<td>";
    echo "<a href='#' onclick='confirmAction(\"approve\", {$row['id']})'>Approve</a> | ";
    echo "<a href='#' onclick='confirmAction(\"reject\", {$row['id']})'>Reject</a>";
    echo "</td>";
    echo "</tr>";
}
?>

</div>

<script>
    function confirmAction(action, userId) {
        if (confirm("Are you sure you want to " + action + " this user?")) {
            window.location.href = 'UsersApproval.php?id=' + userId + '&action=' + action;
        }
    }
</script>

</table>

<!-- Modal -->
<div id="myModal" class="modal-rf">
    <span class="close" onclick="closeModal()">&times;</span>
    <img id="modalImage">
</div>

<script>
    function openModal(src) {
        var modal = document.getElementById('myModal');
        var modalImg = document.getElementById('modalImage');
        modal.style.display = 'block';
        modalImg.src = src;

        // Initialize zoom on the modal image
        var zoom = mediumZoom('#modalImage');
        zoom.show();
    }

    function closeModal() {
        var modal = document.getElementById('myModal');
        modal.style.display = 'none';
    }
</script>

<?php
mysqli_close($conn);
?>

<div class="full-screen-image">
        <span class="close-button" onclick="closeFullScreen()">&times;</span>
        <img id="expanded-image">
    </div>

    
</div>



<!---------------------------------------------------------------------------------------------------------->
</body>
</html>