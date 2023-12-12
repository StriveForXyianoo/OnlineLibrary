<!---------------------------------------------------------CODE FOR DISPLAYING IN SEARCH BAR-------------------------------------------------------->
<?php
if (isset($_GET['book_data'])) {
    $bookDataUrl = $_GET['book_data'];
    
    $bookData = json_decode(urldecode($bookDataUrl), true);

    $bookTitle = $bookData['bookTitle'];
    $bookAuthor = $bookData['bookAuthor'];
    $bookFront = $bookData['frontImage'];
    $bookImage = $bookData['abstractImage'];
    $bookQuantity = $bookData['quantity'];
    $bookDate = $bookData['copyrightDate'];
    $bookPublisher = $bookData['publisher'];
    $bookPlace = $bookData['placePublication'];
    $bookSubject = $bookData['subject'];
    $bookISBN = $bookData['isbn'];
    $bookSection = $bookData['section']; 
} else {
   
}
?>

<?php
if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
}
?>

<!------------------------------------------------------------------------------------------------------------------------------------------------------>



<!---------------------------------------------------------CODE FOR DISPLAYING CURRENT USER'S INFO-------------------------------------------------------->
<?php


session_start();


if (isset($_SESSION['lname']) && isset($_SESSION['fname']) && isset($_SESSION['addr']) && isset($_SESSION['users_balance']) 
&& isset($_SESSION['users_lost']) && isset($_SESSION['users_penalty'])  && isset($_SESSION['users_onhand'])  && isset($_SESSION['email'])
 && isset($_SESSION['profile_image']) && isset($_SESSION['course']) && isset($_SESSION['users_num']) && isset($_SESSION['suffix']) ) {
    $lastName = $_SESSION['lname'];
    $firstName = $_SESSION['fname'];
    $address = $_SESSION['addr'];
    $email = $_SESSION['email'];
    $usersBalance = $_SESSION['users_balance'];
    $usersLost = $_SESSION['users_lost'];
    $usersPenalty = $_SESSION['users_penalty'];
    $usersOnhand = $_SESSION['users_onhand'];
    $profileImage = $_SESSION['profile_image'];
    $course = $_SESSION['course'];
    $usersNum = $_SESSION['users_num'];
    $suffix = $_SESSION['suffix'];
    
   

    
} else {
    
    header("Location: 1trial.html");
    exit();
}
?>
<!---------------------------------------------------------CODE FOR DISPLAYING CURRENT USER'S INFO-------------------------------------------------------->



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Details.css?v= <?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="icon" type="image" href="Pics/WIT-Logo.png">
    <title>Book Details</title>
</head>

<!-- Add this script block to your BookDetails.php page -->
<script>
    // Function to fetch updated data via AJAX
    function fetchUpdatedData() {
        // Make an AJAX request to get updated data
        $.ajax({
            url: 'Dashboard.php', // Use Dashboard.php as the endpoint
            method: 'GET',
            data: { book_id: <?php echo $book_id; ?> },
            dataType: 'json',
            success: function(response) {
                // Update the page content with the updated data
                // Replace the following lines with the actual updated data fields

                // Assuming you have elements with specific IDs or classes
                $('#bookTitle').text(response.bookTitle);
                $('#authorInfo').text('Author: ' + response.bookAuthor);
                $('#frontImage').attr('src', response.frontImage); // Assuming frontImage is the URL
                $('#abstractImage').attr('src', response.abstractImage); // Assuming abstractImage is the URL
                $('#quantity').text('Quantity: ' + response.quantity);
                $('#copyrightDate').text('Copyright Date: ' + response.copyrightDate);
                $('#publisher').text('Publisher: ' + response.publisher);
                $('#placePublication').text('Place of Publication: ' + response.placePublication);
                $('#subject').text('Subject: ' + response.subject);
                $('#isbn').text('ISBN: ' + response.isbn);
                $('#section').text('Section: ' + response.section);

                // Update other page elements as needed
            },
            error: function(xhr, status, error) {
                console.error('Error fetching updated data:', status, error);
            }
        });
    }

    // Fetch updated data every 2 seconds
    setInterval(fetchUpdatedData, 2000);
</script>


<body>
<ul class="navbar">
<li class="navbar-logo"><a href="#"><img src="WIT-Logo.png"></a></li>
    <li><a href="Dashboard.php">Dashboard</a></li>
    <li> <a href="#"  class="bkaccount" id="openFormBtn3" >  <?php echo "$suffix $lastName's Account";  ?></a> </li>


<div class="overlay" id="formOverlay3">
  <div class="form-container-user">
    <h2>My Account</h2>



    <br> <br>
    <div class="center-container">
    <div class="custom-text">
        <b>&nbsp;<?php echo "$suffix";?>&nbsp;<?php echo "$lastName,";?> <?php echo "$firstName";?></b>
    </div>
</div>

<br>
<div class="course-label">
    <?php echo "$course";?>
</div>

    <div class="user-contact">
    <b>Contact:</b><?php echo "$usersNum";?>
</div>



<div class="user-address">
    &nbsp; <?php echo "$address";?>
</div>

    <div class="lost-books">
    <b>Lost Books:</b> &nbsp;<u> <?php echo "$usersLost";?> book/s. </u>
</div>


<div class="library-balance">
    <b>Library Balance:</b> &nbsp; <u> <?php echo "$usersBalance";?> peso/s.</u>
</div>


<div class="on-hand-books">
    <b>On-Hand Book/s:</b> &nbsp; <u><?php echo "$usersOnhand";?></u>
</div>


    <div class="upload-form-container">
        <form action="Dashboard.php" method="post" enctype="multipart/form-data" class="upload-form">
            <label for="fileInput">Update Current RF:</label>
            <input type="file" name="fileInput" id="fileInput" accept="image/*" class="file-input">
            <button type="submit" name="submit" class="upload-button">Upload</button>
        </form>
    </div>
    <?php
$hostname = "localhost";
$username = "root";
$password = "witlibrary2023password";
$database = "database_users";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Check if a file was uploaded without errors
    if (isset($_FILES["fileInput"]) && $_FILES["fileInput"]["error"] == 0) {
        $fileTmpName = $_FILES["fileInput"]["tmp_name"];
        $userRFData = file_get_contents($fileTmpName); // Read file content

        // Get the idnum from the form or your session, assuming it's passed through the form
        $idnum = $_SESSION['idnum']; // Make sure to adjust this based on your actual session implementation

        // Update the users_rf column in the users_db table based on idnum
        $sql = "UPDATE users_db SET users_rf = ? WHERE idnum = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $userRFData, $idnum);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                echo '<script>alert("Your RF Updated Successfully.");</script>';
            } else {
                echo "Error updating users_rf column: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error in prepared statement: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading file: " . $_FILES["fileInput"]["error"];
    }
}

mysqli_close($conn);
?>


   


<button class="closebtn1" id="closeFormBtn3" role="button">X</button>
  </div>
</div>

<script>
    const openFormBtn3 = document.getElementById("openFormBtn3");
  const closeFormBtn3 = document.getElementById("closeFormBtn3");
  const formOverlay3 = document.getElementById("formOverlay3");

  openFormBtn3.addEventListener("click", () => {
    formOverlay3.style.display = "flex";
  });

  closeFormBtn3.addEventListener("click", () => {
    formOverlay3.style.display = "none";
  });

</script>
    
</ul>

    
<div class="search-content">

    <div class="main_title">
    <h1>WIT ONLINE LIBRARY</h1>
</div>


<form class="search-bar" action="Dashboard.php" method="get"  id="searchForm">
<input type="text" class="search-box" type="submit"  name="search" placeholder="Search for a keyword, author, journal or title...">
                
        <button class="search-button" type="submit" value="Search" >Search</button>

        </form>
 

    <div class="below-text">
        <p>Find Academic Books, Articles, And Journals On A Single, Seamless Platform</p>
    </div>
    </div>
   
        <!--    -->


 <!--    -->

 <?php
$bookSection; 


$sectionToFrontImageMap = [
    'Graduate School Archives Section' => 'ADMIN/GraduateSchoolBookFront/',
    'Graduate School Circulation Section' => 'ADMIN/GraduateSchoolBookFront/',
    'Graduate School Filipinana Section' => 'ADMIN/GraduateSchoolBookFront/',
    'Graduate School Periodical Section' => 'ADMIN/GraduateSchoolBookFront/',
    'Graduate School Reference Section' => 'ADMIN/GraduateSchoolBookFront/',
    'Graduate School Reserve Section' => 'ADMIN/GraduateSchoolBookFront/',
    'Graduate School Thesis/Dissertations Section' => 'ADMIN/GraduateSchoolBookFront/',

    'Main Library Archives Section' => 'ADMIN/BookFront/',
    'Main Library Circulation Section' => 'ADMIN/BookFront/',
    'Main Library Fiction Section' => 'ADMIN/BookFront/',
    'Main Library Filipinana Section' => 'ADMIN/BookFront/',
    'Main Library Periodical Section' => 'ADMIN/BookFront/',
    'Main Library Reference Section' => 'ADMIN/BookFront/',
    'Main Library Reserve Section' => 'ADMIN/BookFront/',
    'Main Library Thesis/Dissertations Section' => 'ADMIN/BookFront/',

    'RTS Library Archive Section' => 'ADMIN/RTSBookFront/',
    'RTS Library Circulation Section' => 'ADMIN/RTSBookFront/',
    'RTS Library Fiction Section' => 'ADMIN/RTSBookFront/',
    'RTS Library Filipinana Section' => 'ADMIN/RTSBookFront/',
    'RTS Library Periodical Section' => 'ADMIN/RTSBookFront/',
    'RTS Library Reference Section' => 'ADMIN/RTSBookFront/',
    'RTS Library Reserve Section' => 'ADMIN/RTSBookFront/',
    'RTS Library Thesis/Dissertations Section' => 'ADMIN/RTSBookFront/',

    'graduateschool_library_archive_section' => 'ADMIN/GraduateSchoolBookFront/',
    'graduateschool_library_circulation_section' => 'ADMIN/GraduateSchoolBookFront/',
    'graduateschool_library_filipinana_section' => 'ADMIN/GraduateSchoolBookFront/',
    'graduateschool_library_periodical_section' => 'ADMIN/GraduateSchoolBookFront/',
    'graduateschool_library_reference_section' => 'ADMIN/GraduateSchoolBookFront/',
    'graduateschool_library_reserve_section' => 'ADMIN/GraduateSchoolBookFront/',
    'graduateschool_library_thesisdissertation_section' => 'ADMIN/GraduateSchoolBookFront/',

    'main_library_archives_section' => 'ADMIN/BookFront/',
    'main_library_circulation_section' => 'ADMIN/BookFront/',
    'main_library_fiction_section' => 'ADMIN/BookFront/',
    'main_library_filipinana_section' => 'ADMIN/BookFront/',
    'main_library_periodical_section' => 'ADMIN/BookFront/',
    'main_library_reference_section' => 'ADMIN/BookFront/',
    'main_library_reserve_section' => 'ADMIN/BookFront/',
    'main_library_thesisdissertation_section' => 'ADMIN/BookFront/',
    
    'rts_library_archive_section' => 'ADMIN/RTSBookFront/',
    'rts_library_circulation_section' => 'ADMIN/RTSBookFront/',
    'rts_library_fiction_section' => 'ADMIN/RTSBookFront/',
    'rts_library_filipinana_section' => 'ADMIN/RTSBookFront/',
    'rts_library_periodical_section' => 'ADMIN/RTSBookFront/',
    'rts_library_reference_section' => 'ADMIN/RTSBookFront/',
    'rts_library_reserve_section' => 'ADMIN/RTSBookFront/',
    'rts_library_thesisdissertation_section' => 'ADMIN/RTSBookFront/',
];



if (isset($sectionToFrontImageMap[$bookSection])) {
    
    $frontImageFolder = $sectionToFrontImageMap[$bookSection];
    $imageSource = $frontImageFolder . $bookFront;
} else {
 
    echo 'Section not found in mapping.';
}
?>

<div class="book-image">
<img src="<?php echo $imageSource; ?>" alt="Book Image" class="book-logo" style="border-radius: 20px">

</div>



<!-----------------------------------------------BOOK INFORMATION------------------------------------------------>

        <div class="info">

        <div class="title">
           &nbsp; <?php echo '<span class="book-title">' . $bookTitle . '</span>'; ?>
        </div>


        <div class="author">
        <b>  Author: </b> &nbsp; <?php echo "$bookAuthor";?> 
        </div>

        <div class="publisher">
        <b>  Books Publisher: </b> &nbsp; <?php echo "$bookPublisher";?> 
        </div>

        <div class="copy-date">
        <b>  Copyright Date: </b> &nbsp; <?php echo "$bookDate";?> 
        </div>

        <div class="quantity">
    <b> Books Available: </b> &nbsp; <?php echo '<span class="book-quantity">' . $bookQuantity . '</span>'; ?>
        </div>

        <div class="section">
    <b> Section: </b> &nbsp; <?php

$sectionMapping = [
    'graduateschool_library_archive_section' => 'Graduate School Library Archive Section',
    'graduateschool_library_circulation_section' => 'Graduate School Library Circulation Section',
    'graduateschool_library_filipinana_section' => 'Graduate School Library Filipinana Section',
    'graduateschool_library_periodical_section' => 'Graduate School Library Periodical Section',
    'graduateschool_library_reference_section' => 'Graduate School Library Reference Section',
    'graduateschool_library_reserve_section' => 'Graduate School Library Reserve Section',
    'graduateschool_library_thesisdissertation_section' => 'Graduate School Library Thesis/Dissertations Section',

    'main_library_archives_section' => 'Main Library Archive Section',
    'main_library_circulation_section' => 'Main Library Circulation Section',
    'main_library_fiction_section' => 'Main Library Fiction Section',
    'main_library_filipinana_section' => 'Main Library Filipinana Section',
    'main_library_periodical_section' => 'Main Library Periodical Section',
    'main_library_reference_section' => 'Main Library Reference Section',
    'main_library_reserve_section' => 'Main Library Reserve Section',
    'main_library_thesisdissertation_section' => 'Main Library Thesis/Dissertation Section',

    'rts_library_archive_section' => 'RTS Library Archive Section',
    'rts_library_circulation_section' => 'RTS Library Circulation Section',
    'rts_library_fiction_section' => 'RTS Library Fiction Section',
    'rts_library_filipinana_section' => 'RTS Library Filipinana Section',
    'rts_library_periodical_section' => 'RTS Library Periodical Section',
    'rts_library_reference_section' => 'RTS Library Reference Section',
    'rts_library_reserve_section' => 'RTS Library Reserve Section',
    'rts_library_thesisdissertation_section' => 'RTS Library Thesis/Dissertation Section',

    'Graduate School Archives Section' => 'Graduate School Library Archive Section',
    'Graduate School Circulation Section' => 'Graduate School Library Circulation Section',
    'Graduate School Filipinana Section' => 'Graduate School Library Filipinana Section',
    'Graduate School Periodical Section' => 'Graduate School Library Periodical Section',
    'Graduate School Reference Section' => 'Graduate School Library Reference Section',
    'Graduate School Reserve Section' => 'Graduate School Library Reserve Section',
    'Graduate School Thesis/Dissertations Section' => 'Graduate School Library Thesis/Dissertations Section',

    'Main Library Archives Section' => 'Main Library Archives Section',
    'Main Library Circulation Section' => 'Main Library Circulation Section',
    'Main Library Fiction Section' => 'Main Library Fiction Section',
    'Main Library Filipinana Section' => 'Main Library Filipinana Section',
    'Main Library Periodical Section' => 'Main Library Periodical Section',
    'Main Library Reference Section' => 'Main Library Reference Section',
    'Main Library Reserve Section' => 'Main Library Reserve Section',
    'Main Library Thesis/Dissertations Section' => 'Main Library Thesis/Dissertation Section',

    'RTS Library Archive Section' => 'RTS Library Archive Section',
    'RTS Library Circulation Section' => 'RTS Library Circulation Section',
    'RTS Library Fiction Section' => 'RTS Library Fiction Section',
    'RTS Library Filipinana Section' => 'RTS Library Filipinana Section',
    'RTS Library Periodical Section' => 'RTS Library Periodical Section',
    'RTS Library Reference Section' => 'RTS Library Reference Section',
    'RTS Library Reserve Section' => 'RTS Library Reserve Section',
    'RTS Library Thesis/Dissertations Section' => 'RTS Library Thesis/Dissertation Section',
];


    $transformedSection = $sectionMapping[$bookSection];
    echo '<span class="book-quantity">' . $transformedSection . '</span>';
    ?>
</div>
</div>

<!----------------------------------------------------------------------------------------------->

<!----------------------------------------------------------------------------------------------->

<div class="info-below">

        <div class="place-publicated">
        <b>  Place of Publication: </b> &nbsp; <?php echo "$bookPlace";?> 
        </div>

        <div class="subject">
        <b>  Subject: </b> &nbsp; <?php echo "$bookSubject";?> 
        </div>

        <div class="isbn">
        <b> International Standard Book Number: </b> &nbsp; <?php echo "$bookISBN";?> 
        </div>



</div>

<!----------------------------------------------------------------------------------------------->
        </div>


        <?php



$sectionToAbstractImageMap = [
    'Graduate School Archives Section' => 'ADMIN/GraduateSchoolBookAbstract/',
    'Graduate School Circulation Section' => 'ADMIN/GraduateSchoolBookAbstract/',
    'Graduate School Filipinana Section' => 'ADMIN/GraduateSchoolBookAbstract/',
    'Graduate School Periodical Section' => 'ADMIN/GraduateSchoolBookAbstract/',
    'Graduate School Reference Section' => 'ADMIN/GraduateSchoolBookAbstract/',
    'Graduate School Reserve Section' => 'ADMIN/GraduateSchoolBookAbstract/',
    'Graduate School Thesis/Dissertations Section' => 'ADMIN/GraduateSchoolBookAbstract/',

    'Main Library Archives Section' => 'ADMIN/BookAbstract/',
    'Main Library Circulation Section' => 'ADMIN/BookAbstract/',
    'Main Library Fiction Section' => 'ADMIN/BookAbstract/',
    'Main Library Filipinana Section' => 'ADMIN/BookAbstract/',
    'Main Library Periodical Section' => 'ADMIN/BookAbstract/',
    'Main Library Reference Section' => 'ADMIN/BookAbstract/',
    'Main Library Reserve Section' => 'ADMIN/BookAbstract/',
    'Main Library Thesis/Dissertations Section' => 'ADMIN/BookAbstract/',

    'RTS Library Archive Section' => 'ADMIN/RTSBookAbstract/',
    'RTS Library Circulation Section' => 'ADMIN/RTSBookAbstract/',
    'RTS Library Fiction Section' => 'ADMIN/RTSBookAbstract/',
    'RTS Library Filipinana Section' => 'ADMIN/RTSBookAbstract/',
    'RTS Library Periodical Section' => 'ADMIN/RTSBookAbstract/',
    'RTS Library Reference Section' => 'ADMIN/RTSBookAbstract/',
    'RTS Library Reserve Section' => 'ADMIN/RTSBookAbstract/',
    'RTS Library Thesis/Dissertations Section' => 'ADMIN/RTSBookAbstract/',

    'graduateschool_library_archive_section' => 'ADMIN/GraduateSchoolBookAbstract/',
    'graduateschool_library_circulation_section' => 'ADMIN/GraduateSchoolBookAbstract/',
    'graduateschool_library_filipinana_section' => 'ADMIN/GraduateSchoolBookAbstract/',
    'graduateschool_library_periodical_section' => 'ADMIN/GraduateSchoolBookAbstract/',
    'graduateschool_library_reference_section' => 'ADMIN/GraduateSchoolBookAbstract/',
    'graduateschool_library_reserve_section' => 'ADMIN/GraduateSchoolBookAbstract/',
    'graduateschool_library_thesisdissertation_section' => 'ADMIN/GraduateSchoolBookAbstract/',

    'main_library_archives_section' => 'ADMIN/BookAbstract/',
    'main_library_circulation_section' => 'ADMIN/BookAbstract/',
    'main_library_fiction_section' => 'ADMIN/BookAbstract/',
    'main_library_filipinana_section' => 'ADMIN/BookAbstract/',
    'main_library_periodical_section' => 'ADMIN/BookAbstract/',
    'main_library_reference_section' => 'ADMIN/BookAbstract/',
    'main_library_reserve_section' => 'ADMIN/BookAbstract/',
    'main_library_thesisdissertation_section' => 'ADMIN/BookAbstract/',

    'rts_library_archive_section' => 'ADMIN/RTSBookAbstract/',
    'rts_library_circulation_section' => 'ADMIN/RTSBookAbstract/',
    'rts_library_fiction_section' => 'ADMIN/RTSBookAbstract/',
    'rts_library_filipinana_section' => 'ADMIN/RTSBookAbstract/',
    'rts_library_periodical_section' => 'ADMIN/RTSBookAbstract/',
    'rts_library_reference_section' => 'ADMIN/RTSBookAbstract/',
    'rts_library_reserve_section' => 'ADMIN/RTSBookAbstract/',
    'rts_library_thesisdissertation_section' => 'ADMIN/RTSBookAbstract/',
];


?>
<div class="preview">
    <?php
   
    if (isset($sectionToAbstractImageMap[$bookSection])) {
        
        $abstractImageFolder = $sectionToAbstractImageMap[$bookSection];
        $abstractImageSource = $abstractImageFolder . $bookImage;
        echo '<img src="' . $abstractImageSource . '">';
    } else {
     
        echo 'Section not found in mapping.';
    }
    ?>
</div>







<!--------------------------------------------- 3 BUTTONS-------------------------------------------------->


<div class="custom-container">


<form method="post">
    <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
    <input type="submit" class="custom-button" name="add_to_reserve" value="Reserve Book" />
</form>
<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['idnum'])) {
    header("Location: login.php");
    exit();
}

@include 'Configure.php';

if (isset($_POST['add_to_reserve'])) {

    $userId = $_SESSION['idnum'];

    $bookTitle = $bookData['bookTitle'];
    $bookAuthor = $bookData['bookAuthor'];
    $bookISBN = $bookData['isbn'];
    $bookSection = $bookData['section'];
    $bookQuantity = 1;

    $checkQuery = "SELECT COUNT(*) FROM reserve_book WHERE user_id = ? AND isbn = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("is", $userId, $bookISBN);
    $checkStmt->execute();
    $checkStmt->bind_result($bookCount);
    $checkStmt->fetch();
    $checkStmt->close(); // Close the result set explicitly

    if ($bookCount > 0) {
        echo "<script>alert('The book is already in your reserve list.');</script>";
        echo "<script>window.location.href = 'Dashboard.php';</script>";
        exit();
    } else {
        $insertReserveQuery = "INSERT INTO reserve_book (user_id, book_title, book_author, isbn, section, quantity) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertReserveQuery);
        $stmt->bind_param("issisi", $userId, $bookTitle, $bookAuthor, $bookISBN, $bookSection, $bookQuantity);

        if ($stmt->execute()) {
            echo "<script>window.location.href = 'Dashboard.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to reserve the book. Please try again.');</script>";
        }
    }
}

$conn->close();
?>










         
<!-------------------------------------------------FOR WISHLIST-------------------------------------------->
<form method="post">
<input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
    <input type="submit" class="custom-button" name="add_to_wishlist" value="Add to Wishlist" />
</form>

<?php
// Starting the session if not already started
if (!isset($_SESSION)) {
    session_start();
}

// Checking if the user is logged in, redirecting to login.php if not
if (!isset($_SESSION['idnum'])) {
    header("Location: login.php");
    exit();
}

// Including Configure.php file
@include 'Configure.php';

// Checking if the 'add_to_wishlist' form was submitted
if (isset($_POST['add_to_wishlist'])) {

    // Getting user ID from the session
    $userId = $_SESSION['idnum'];



    $bookTitle = $bookData['bookTitle'];
    $bookAuthor = $bookData['bookAuthor'];
    $bookISBN = $bookData['isbn'];
    $bookSection = $bookData['section'];

    // Checking if the book is already in the user's wishlist
    $checkQuery = "SELECT COUNT(*) FROM wishlist WHERE user_id = ? AND isbn = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("is", $userId, $bookISBN);
    $checkStmt->execute();
    $checkStmt->bind_result($bookCount);
    $checkStmt->fetch();
    $checkStmt->close(); // Close the result set

    // If the book is already in the wishlist, display a message and redirect
    if ($bookCount > 0) {
        echo "<script>alert('The book is already in your wishlist.');</script>";
        echo "<script>window.location.href = 'Dashboard.php';</script>";
        exit();
    } else {
        // If the book is not in the wishlist, insert it into the wishlist
        $insertWishlistQuery = "INSERT INTO wishlist (user_id, book_title, book_author, isbn, section) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertWishlistQuery);
        $stmt->bind_param("issis", $userId, $bookTitle, $bookAuthor, $bookISBN, $bookSection);

        // If the insertion is successful, redirect to Dashboard.php
        if ($stmt->execute()) {
            echo "<script>window.location.href = 'Dashboard.php';</script>";
            exit();
        } else {
            // If insertion fails, display an error message
            echo "<script>alert('Failed to add the book to your wishlist. Please try again.');</script>";
        }
    }
}

// Closing the database connection
$conn->close();
?>








<!-------------------------------------------------FOR WISHLIST-------------------------------------------->

<!--------------------------------------------------------FOR BORROW BOOK------------------------------------------------------------------>
<div class="custom-button-borrow" id="openFormBtn2">Borrow Book</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var bookQuantity = <?php echo $bookQuantity; ?>; // Assuming $bookQuantity is your PHP variable

    var borrowButton = document.getElementById("openFormBtn2");

    if (bookQuantity === 1) {
        borrowButton.addEventListener("click", function() {
            alert("There is just one copy of the book left in the inventory, so it cannot be checked out.\n \nPlease Cancel the Inquiry.");
            location.reload(); // Reload the page
        });

        borrowButton.disabled = true;
    }
});
</script>



        <div class="overlay" id="formOverlay2">

        <div class="form-container-borrow">
    <h2>Inquire</h2>
    <form action="BookDetails.php" method="post" class="centered-form">

<div class="form-group">
    <label for="borrow_date">Date Expected to Borrow:</label>
    <input type="date" class="input-box" id="borrow_date" placeholder="Select Date:" name="dateExpectedToBorrow" required>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Get the current date without the time component
    var currentDate = new Date();
    currentDate.setHours(0, 0, 0, 0);

    // Get the current year
    var currentYear = currentDate.getFullYear();

    // Initialize Flatpickr with options
    flatpickr("#borrow_date", {
        disable: [
            function(date) {
                // Disable Sundays
                return date.getDay() === 0;
            }
        ],
        dateFormat: "Y-m-d",
        minDate: currentDate, // Set the minimum selectable date to the current date without the time component
        maxDate: currentYear + "-12-31", // Set the maximum selectable date to the last day of the current year
        // Add any additional options you need
    });
});

    </script>

<div class="form-group">
    <label for="return_date">Date Expected to Return:</label>
    <input type="date" class="input-box" id="return_date" placeholder="Select Date:" name="dateExpectedToReturn" required>
</div>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  
    var currentDate = new Date();
    currentDate.setHours(0, 0, 0, 0);


    var currentYear = currentDate.getFullYear();


    flatpickr("#return_date", {
        disable: [
            function(date) {
            
                return date.getDay() === 0;
            }
        ],
        dateFormat: "Y-m-d",
        minDate: currentDate, 
        maxDate: currentYear + "-12-31",
       
    });
});

    </script>

<div class="form-group">

        <input type="hidden" name="bookTitle" value="<?php echo $bookTitle; ?>">
        <input type="hidden" name="bookAuthor" value="<?php echo $bookAuthor; ?>">
        <input type="hidden" name="users_num" value="<?php echo $usersNum; ?>">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input type="hidden" name="course" value="<?php echo $course; ?>">
        <input type="hidden" name="idnum" value="<?php echo $idnum; ?>">
        <input type="hidden" name="isbn" value="<?php echo $bookISBN; ?>">
        <input type="hidden" name="section" value="<?php echo $transformedSection; ?>">  
        <input type="hidden" name="lname" value="<?php echo $lastName; ?>">  
        <input type="hidden" name="fname" value="<?php echo $firstName; ?>">  
        <input type="hidden" name="email" value="<?php echo $email; ?>">

 
</div>

<!-- Add more hidden fields for other book and user information -->

<div class="form-group">
    <p><b>Take Note:</b> &nbsp; Wait for the email will be received from WIT Library Admin for the approval and the confirmation code.</p>
</div>

<div class="form-group">
    <button type="submit">Inquire</button>
</div>

</form>


    <button class="closebtn" id="closeFormBtn2" role="button">Close</button>
</div>
<?php
if (!isset($_SESSION)) {
    session_start();
}


if (!isset($_SESSION['idnum'])) {
    
    header("Location: login.php"); 
    exit();
}

@include 'Configure.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dateExpectedToBorrow = $_POST['dateExpectedToBorrow'];
    $dateExpectedToReturn = $_POST['dateExpectedToReturn'];
    $idnum = $_SESSION['idnum'];
    $bookTitle = $_POST['bookTitle'];
    $isbn = $_POST['isbn'];
    $transformedSection = $_POST['section'];
    $lastName = $_POST['lname'];
    $firstName = $_POST['fname'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $usersNum = $_POST['users_num'];

    function generateRandomCode($length = 5) {
        $characters = '123456789abcdefghijklmnopqrstuvwxyz';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $code;
    }

    $code = generateRandomCode();

   


    $insertOrderQuery = "INSERT INTO books_approval (idnum, date_borrow, date_return, status, bk_title, isbn, section, lname, fname, email, course, users_num, code)
                         VALUES (?, ?, ?, 'Pending', ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertOrderQuery);
    $stmt->bind_param("ssssssssssss", $idnum, $dateExpectedToBorrow, $dateExpectedToReturn, $bookTitle, $isbn, $transformedSection, $lastName, $firstName, $email, $course, $usersNum, $code);

    if ($stmt->execute()) {
        echo '<script>alert("Successful inquiring book, please wait for the the confirmation message.");</script>';
        echo '<script>
                setTimeout(function() {
                    window.location="Dashboard.php";
                }, 20);
              </script>';
        exit();
    } else {
        echo '<script>alert("Error in Ordering Book");</script>';
       
        exit();
    }
    $stmt->close();
    $conn->close();
}

?>









</div>
<!--------------------------------------------------------FOR BORROW BOOK------------------------------------------------------------------>
<script>
const openFormBtn2 = document.getElementById("openFormBtn2");
const closeFormBtn2 = document.getElementById("closeFormBtn2");
const formOverlay2 = document.getElementById("formOverlay2");

openFormBtn2.addEventListener("click", () => {
formOverlay2.style.display = "flex";
});

closeFormBtn2.addEventListener("click", () => {
formOverlay2.style.display = "none";
});

</script>




    </div>




<!--------------------------------------------- 3 BUTTONS-------------------------------------------------->



         <!--    -->
        <script type="text/javascript"  src="javascripts/Functions.js"></script>   
        </body>
</html>