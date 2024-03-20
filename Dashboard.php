<?php

session_start();

if (!isset($_SESSION['idnum'])) {
    header("Location: Main Page.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: Main Page.php");
    exit();
}


if (isset($_SESSION['idnum'])) {
   
    include 'Configure.php';

   
    $query = "SELECT lname, fname, addr, email, users_balance, users_lost, users_penalty, users_onhand, course, users_num, suffix FROM users_db WHERE idnum = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_SESSION['idnum']);
    $stmt->execute();
    $stmt->bind_result($lastName, $firstName, $address, $email, $usersBalance, $usersLost, $usersPenalty, $usersOnhand, $course, $usersNum, $suffix);

    if ($stmt->fetch()) {
     
        $_SESSION['lname'] = $lastName;
        $_SESSION['fname'] = $firstName;
        $_SESSION['addr'] = $address;
        $_SESSION['email'] = $email;
        $_SESSION['users_balance'] = $usersBalance;
        $_SESSION['users_lost'] = $usersLost;
        $_SESSION['users_penalty'] = $usersPenalty;
        $_SESSION['users_onhand'] = $usersOnhand;
        $_SESSION['course'] = $course;
        $_SESSION['users_num'] = $usersNum;
        $_SESSION['suffix'] = $suffix;
    }

    $stmt->close();
    $conn->close();
}


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

?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/Dashboard.css">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
     integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" 
     crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link rel="icon" type="image" href="Pics/WIT-Logo.png">
    <title>WIT Library</title>

</head>
<body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        
        const isLoggedIn = <?php echo isset($_SESSION['lname']) ? 'true' : 'false'; ?>;

        
        if (!isLoggedIn) {
            window.location.href = "Log.php";
        }
    });
</script>

<header>
<div class="navbar">

<script type="text/javascript"  src="javascripts/JsFile.js"></script>
<div id="mySidenav" class="sidenav">
    


          <a href="javascript:void(0)" class="closebtnSide" onclick="closeNav()">&times;</a>
      
          <li><a onclick="window.location='LibraryHours.php'">Library Operating Hours</a></li>
          <li> <a onclick="window.location='Fine.php'">Fines</a></li>
          <li><a onclick="window.location='Clearances.php'">Clearances</a></li>
      

          <div class="MainLibrary">
    <h2>Main Library Sections</h2>
    <li class="a"><a href="Dashboard.php?section=Main Library Reserve Section">Reserve</a></li>
    <li class="a"><a href="Dashboard.php?section=Main Library Circulation Section">Circulation</a></li>
    <li class="a"><a href="Dashboard.php?section=Main Library Filipinana Section">Filipiñana</a></li>
    <li class="a"><a href="Dashboard.php?section=Main Library Reference Section">Reference</a></li>
    <li class="a"><a href="Dashboard.php?section=Main Library Archives Section">Archives</a></li>
    <li class="a"><a href="Dashboard.php?section=Main Library Periodical Section">Periodicals</a></li>
    <li class="a"><a href="Dashboard.php?section=Main Library Thesis/Dissertations Section">Thesis/Dissertations</a></li>
    <li class="a"><a href="Dashboard.php?section=Main Library Fiction Section">Fiction</a></li>
</div>

<div class="RTSLibrary">
    <h2>RTS Library Sections</h2>
    <li class="a"><a href="Dashboard.php?section=RTS Library Reserve Section">Reserve</a></li>
    <li class="a"><a href="Dashboard.php?section=RTS Library Circulation Section">Circulation</a></li>
    <li class="a"><a href="Dashboard.php?section=RTS Library Filipinana Section">Filipiñana</a></li>
    <li class="a"><a href="Dashboard.php?section=RTS Library Reference Section">Reference</a></li>
    <li class="a"><a href="Dashboard.php?section=RTS Library Archive Section">Archives</a></li>
    <li class="a"><a href="Dashboard.php?section=RTS Library Periodical Section">Periodicals</a></li>
    <li class="a"><a href="Dashboard.php?section=RTS Library Thesis/Dissertations Section">Thesis/Dissertations</a></li>
    <li class="a"><a href="Dashboard.php?section=RTS Library Fiction Section">Fiction</a></li>
</div>

<div class="GraduateSchoolLibrary">
    <h2>Graduate School Library Sections</h2>
    <li class="a"><a href="Dashboard.php?section=Graduate School Reserve Section">Reserve</a></li>
    <li class="a"><a href="Dashboard.php?section=Graduate School Circulation Section">Circulation</a></li>
    <li class="a"><a href="Dashboard.php?section=Graduate School Filipinana Section">Filipiñana</a></li>
    <li class="a"><a href="Dashboard.php?section=Graduate School Reference Section">Reference</a></li>
    <li class="a"><a href="Dashboard.php?section=Graduate School Archives Section">Archives</a></li>
    <li class="a"><a href="Dashboard.php?section=Graduate School Periodical Section">Periodicals</a></li>
    <li class="a"><a href="Dashboard.php?section=Graduate School Thesis/Dissertations Section">Thesis/Dissertations</a></li>
</div>




        </div>



        

        <div id="main">
          <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
        </div>

    <div class="logo"> 
    <img src="WIT-Logo.png" class="bar_logo">     
</div>



    <ul class="links">
 
    <li> <a href="#"  id="openFormBtn2">Book History</a> </li>
    
<div class="overlay" id="formOverlay2">
<div class="form-container">
<h2>My History</h2>

<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['idnum'])) {
    $idnum = $_SESSION['idnum'];

    require 'Configure.php';

    $sql = "SELECT bk_title, section, date_confirmed FROM book_status WHERE idnum = ?
            UNION
            SELECT bk_title, section, date_confirmed FROM book_inventory WHERE idnum = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $idnum, $idnum);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<ul class="clean-list">';
        while ($row = $result->fetch_assoc()) {
            echo '<li class="list-item">';
            echo '<span class="book-title-history"> ' . $row['bk_title'] . '</span><br>';
            echo '<span class="book-section-history"> ' . $row['section'] . '</span><br>';
            echo '<span class="book-date-confirmed">Date Confirmed: ' . $row['date_confirmed'] . '</span>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        

    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: 1trial.html");
    exit();
}
?>




<button class="closebtn" id="closeFormBtn2" role="button">X</button>
</div>
</div>

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


<!------------------------------------------------------------------------------------->

  <li> <a href="#" class="bklist" id="openFormBtnA">Reserve Book/s</a> </li>



<div class="overlay" id="formOverlayA">
<div class="form-container">
<h2>Reserve Book List</h2>
<div class="scrollable-table">
        <table class="custom-table">
<!-----------------------------Insert here------------------------------------------->
<?php

if (!isset($_SESSION)) {
    session_start();
}


if (isset($_SESSION['idnum'])) {
    
    $idnum = $_SESSION['idnum'];

    @include 'Configure.php';

    if (isset($_POST['bringBackBook']) && isset($_POST['isbn'])) {
        
        $isbnToDelete = $_POST['isbn'];
        $deleteQuery = "DELETE FROM reserve_book WHERE user_id = ? AND isbn = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("ss", $idnum, $isbnToDelete);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    
    $query = "SELECT book_title, book_author, isbn, section, inserted_at FROM reserve_book WHERE user_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $idnum);
    $stmt->execute();
    $stmt->bind_result($bookTitle, $bookAuthor, $isbn, $section, $reserveDate);

    echo '<div class="scrollable-list">';

    while ($stmt->fetch()) {

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
            'Graduate School Thesis/Dissertations Section' => 'Graduate School Library Thesis/Dissertation Section',
        
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
        $ReserveSection = $sectionMapping[$section];
        
        $iconFolder = 'ADMIN/BookIcon/';
        $iconFiles = glob($iconFolder . '*.png');
        if (empty($iconFiles)) {
            $defaultIconFolder = 'ADMIN/BookIcon/';
            $defaultIconFiles = glob($defaultIconFolder . '*.png');
            if (empty($defaultIconFiles)) {
                $defaultIcon = 'default/default_icon.png';
            } else {
                $defaultIcon = $defaultIconFiles[array_rand($defaultIconFiles)];
            }
            $randomIcon = $defaultIcon;
        } else {
            $randomIcon = $iconFiles[array_rand($iconFiles)];
        }



        
        echo '<div class="custom-list-item">';
        echo '<img src="' . $randomIcon . '" alt="Book Icon" width="80" class="book-icon">';
        echo '<div class="book-info">';
        echo '<strong class="title">Book Title:</strong> <a class="book-title" href="Dashboard.php?search=' . urlencode($isbn) . '">' . $bookTitle . '</a><br>';
        echo '<strong class="author">Book Author:</strong> <span class="book-author">' . $bookAuthor . '</span><br>';
        echo '<strong class="isbn">ISBN:</strong> <span class="book-isbn">' . $isbn . '</span><br>';
        echo '<strong class="section">Section:</strong> <span class="book-section">' . $ReserveSection . '</span><br>';
        echo '<strong class="date">Date Reserved:</strong> <span class="book-date">' . $reserveDate . '</span><br>';
        echo '<form method="POST">'; 
        echo '<input type="hidden" name="isbn" value="' . $isbn . '">'; 
        echo '<button type="submit" name="bringBackBook" class="delete-button" onclick="return confirm(\'Are you sure you want to return this book: ' . $bookTitle . '?\')">Bring back book</button>';
        echo '</form>';

        echo '</div>';
        echo '</div>';
    }

    echo '</div>';

    
    $stmt->close();
    $conn->close();
} else {
    
    header("Location: 1trial.html");
    exit();
}
?>



<!----------------------------------------------------------------------------->
</table>
    </div>
<button class="closebtn" id="closeFormBtnA" role="button">X</button>
</div>
</div>

<script>
const openFormBtnA = document.getElementById("openFormBtnA");
const closeFormBtnA = document.getElementById("closeFormBtnA");
const formOverlayA = document.getElementById("formOverlayA");

openFormBtnA.addEventListener("click", () => {
formOverlayA.style.display = "flex";
});

closeFormBtnA.addEventListener("click", () => {
formOverlayA.style.display = "none";
});

</script>



       <li> <a href="#" class="bklist" id="openFormBtn4">My List</a> </li>


       
<div class="overlay" id="formOverlay4">
<div class="form-container">
    <h2>Book Wishlist</h2>
    <div class="scrollable-table">
        <table class="custom-table">
<!-----------------------------Insert code in here------------------------------------------->        
<?php

if (!isset($_SESSION)) {
    session_start();
}


if (isset($_SESSION['idnum'])) {
    
    $idnum = $_SESSION['idnum'];

    @include 'Configure.php';

    
    if (isset($_POST['deleteBook'])) {
        $bookTitleToDelete = $_POST['bookTitleToDelete'];
        $deleteQuery = "DELETE FROM wishlist WHERE user_id = ? AND book_title = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("ss", $idnum, $bookTitleToDelete);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    
    $query = "SELECT book_title, book_author, isbn, section, date_added FROM wishlist WHERE user_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $idnum);
    $stmt->execute();
    $stmt->bind_result($bookTitle, $bookAuthor, $isbn, $section, $dateAdded);

   
    echo '<form method="POST">'; 
    echo '<div class="scrollable-list">';

    while ($stmt->fetch()) {

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
            'Graduate School Thesis/Dissertations Section' => 'Graduate School Library Thesis/Dissertation Section',
        
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
        $transformedSection = $sectionMapping[$section];
        
        $iconFolder = 'ADMIN/BookIcon/';
        $iconFiles = glob($iconFolder . '*.png');
        if (empty($iconFiles)) {
            $defaultIconFolder = 'ADMIN/BookIcon/';
            $defaultIconFiles = glob($defaultIconFolder . '*.png');
            if (empty($defaultIconFiles)) {
                $defaultIcon = 'default/default_icon.png';
            } else {
                $defaultIcon = $defaultIconFiles[array_rand($defaultIconFiles)];
            }
            $randomIcon = $defaultIcon;
        } else {
            $randomIcon = $iconFiles[array_rand($iconFiles)];
        }

        
        echo '<div class="custom-list-item">';
        echo '<img src="' . $randomIcon . '" alt="Book Icon" width="80" class="book-icon">';
        echo '<div class="book-info">';
        echo '<strong class="title">Book Title:</strong> <a class="book-title" href="Dashboard.php?search=' . urlencode($bookTitle) . '">' . $bookTitle . '</a><br>';
        echo '<strong class="author">Book Author:</strong> <span class="book-author">' . $bookAuthor . '</span><br>';
        echo '<strong class="isbn">ISBN:</strong> <span class="book-isbn">' . $isbn . '</span><br>';
        echo '<strong class="section">Section:</strong> <span class="book-section">' .  $transformedSection . '</span><br>';
        echo '<strong class="date">Date Added:</strong> <span class="book-date">' . $dateAdded . '</span><br>';
        echo '<input type="hidden" name="bookTitleToDelete" value="' . $bookTitle . '">'; 
        echo '<button type="submit" name="deleteBook" class="delete-button" onclick="return confirm(\'Are you sure you want to delete this book?\')">Delete</button>'; 
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
    echo '</form>'; 

    
    $stmt->close();
    $conn->close();
} else {
    
    header("Location: 1trial.html");
    exit();
}
?>



<!------------------------------------------------------------------------>       
        </table>
    </div>
    <button class="closebtn" id="closeFormBtn4" role="button">X</button>
</div>


</div>

<script>
    const openFormBtn4 = document.getElementById("openFormBtn4");
  const closeFormBtn4 = document.getElementById("closeFormBtn4");
  const formOverlay4 = document.getElementById("formOverlay4");

  openFormBtn4.addEventListener("click", () => {
    formOverlay4.style.display = "flex";
  });

  closeFormBtn4.addEventListener("click", () => {
    formOverlay4.style.display = "none";
  });

</script>






  
       <li> <a href="#"  class="bkaccount" id="openFormBtn3" >  <?php echo "$suffix  $lastName's Account";  ?></a> </li>


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
include '../Configure.php';

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




    <button class="closebtn" id="closeFormBtn3" role="button">X</button>
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

 

  <li>
    <form method="post" >
        <input type="submit" class="logout-button" name="logout" value="Log Out">
    </form>
</li>



    </ul>
  
    <div class="toggle_btn">
    <i class="fa-solid fa-bars"></i>
    </div>

</div>

<div class="dropdown_menu">
<script>
        const toggleBtn = document.querySelector('.toggle_btn')
        const toggleBtnIcon = document.querySelector('.toggle_btn i')
        const dropDownMenu = document.querySelector('.dropdown_menu')

        toggleBtn.onclick = function (){
            dropDownMenu.classList.toggle('open')
        }
    </script>
        <li href=""><a href="" id="openFormBtn2">Book History</a></li>
        <li href=""><a href="" id="openFormBtnA">Reserve Book/s</a></li>
       <li> <a href="#" id="openFormBtn4">My List</a> </li>
       <li> <a href="#" id="openFormBtn3"> <?php echo "$suffix  $lastName's Account";  ?></a></li>
        <li>
        <form method="post" >
        <input type="submit" class="logout-button" name="logout" value="Log Out">
    </form>
    </li>



        
</div> 

</header>




        <div class="search-container">
            <h1>WIT ONLINE LIBRARY</h1>
            <form action="Dashboard.php" method="get"  id="searchForm">
                <input type="text" class="search-box" type="submit" name="search" placeholder="Search for a keyword, author, journal or title...">
                <input type="submit" class="submit-button" value="Search">
               
                <label class="show-books" for="showAllBooks">Display All Books</label>
<input type="checkbox" class="check-box" id="showAllBooks" name="showAllBooks">
<input type="hidden" name="showAllBooksValue" value="0">





            </form>

    </div>




    
    <div class="table-container">


    <div class="phpcode">

    <!--------------------------------------------------PHP CODE IN EACH SECTIONS IN SIDE BAR---------------------------------------------------------->
    <?php
@include 'Configure.php';


if (isset($_GET['section'])) {
    $section = $_GET['section'];

    switch ($section) {
        case 'Graduate School Reserve Section':
            $tableName = 'graduateschool_library_reserve_section';
            break;
        case 'Graduate School Circulation Section':
            $tableName = 'graduateschool_library_circulation_section';
            break;
        case 'Graduate School Filipinana Section':
            $tableName = 'graduateschool_library_filipinana_section';
            break;
        case 'Graduate School Periodical Section':
            $tableName = 'graduateschool_library_periodical_section';
            break;
        case 'Graduate School Reference Section':
            $tableName = 'graduateschool_library_reference_section';
            break;
        case 'Graduate School Archives Section':
            $tableName = 'graduateschool_library_archive_section';
            break;
        case 'Graduate School Thesis/Dissertations Section':
            $tableName = 'graduateschool_library_thesisdissertation_section';
            break;


        case 'Main Library Archives Section':
            $tableName = 'main_library_archives_section';
            break;
        case 'Main Library Circulation Section':
            $tableName = 'main_library_circulation_section';
            break;
        case 'Main Library Fiction Section':
            $tableName = 'main_library_fiction_section';
            break;
        case 'Main Library Filipinana Section':
            $tableName = 'main_library_filipinana_section';
            break;
        case 'Main Library Periodical Section':
            $tableName = 'main_library_periodical_section';
            break;
        case 'Main Library Reference Section':
            $tableName = 'main_library_reference_section';
            break;
        case 'Main Library Reserve Section':
            $tableName = 'main_library_reserve_section';
            break;
        case 'Main Library Thesis/Dissertations Section':
            $tableName = 'main_library_thesisdissertation_section';
            break;


        case 'RTS Library Archive Section':
            $tableName = 'rts_library_archive_section';
            break;
        case 'RTS Library Circulation Section':
            $tableName = 'rts_library_circulation_section';
            break;
        case 'RTS Library Fiction Section':
            $tableName = 'rts_library_fiction_section';
            break;
        case 'RTS Library Filipinana Section':
            $tableName = 'rts_library_filipinana_section';
            break;
        case 'RTS Library Periodical Section':
            $tableName = 'rts_library_periodical_section';
            break;
        case 'RTS Library Reference Section':
            $tableName = 'rts_library_reference_section';
            break;
        case 'RTS Library Reserve Section':
            $tableName = 'rts_library_reserve_section';
            break;
        case 'RTS Library Thesis/Dissertations Section':
            $tableName = 'rts_library_thesisdissertation_section';
            break;
        default:
            $tableName = '';
            break;
    }
}


if (!empty($tableName)) {
    
    $sql = "SELECT * FROM $tableName";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="book-grid">';
        while ($row = $result->fetch_assoc()) {
            $bookData = array(
                'bookTitle' => $row['bk_title'],
                'bookAuthor' => $row['bk_author'],
                'frontImage' => $row['front_image'],
                'abstractImage' => $row['abstract_image'],
                'quantity' => $row['quantity'],
                'copyrightDate' => $row['copyright_date'],
                'publisher' => $row['publisher'],
                'placePublication' => $row['place_publication'],
                'subject' => $row['subject'],
                'callNumber' => $row['call_number'],
                'isbn' => $row['isbn'],
                'section' => $section
            );

            $bookDataUrl = urlencode(json_encode($bookData));

            echo '<div class="book">';
            echo '<div class="grid-overlay">';
            
           
            $iconFolder = 'ADMIN/BookIcon/';

            $iconFiles = glob($iconFolder . '*.png');

            if (empty($iconFiles)) {
                $defaultIconFolder = 'ADMIN/BookIcon/';
                $defaultIconFiles = glob($defaultIconFolder . '*.png');
                if (empty($defaultIconFiles)) {
                    $defaultIcon = 'default/default_icon.png';
                } else {
                    $defaultIcon = $defaultIconFiles[array_rand($defaultIconFiles)];
                }
                $randomIcon = $defaultIcon;
            } else {
                $randomIcon = $iconFiles[array_rand($iconFiles)];
            }
            
            echo '<img src="' . $randomIcon . '" alt="Book Icon" width="100">';
            
            echo '<p class="book-title"><a href="BookDetails.php?book_id=' . $row['book_id'] . '&book_data=' . $bookDataUrl . '">' . $bookData['bookTitle'] . '</a></p>';


            echo '<p class="book-author">' . $row['bk_author'] . '</p>';
            echo '<p class="book-quantity">Available: ' . $row['quantity'] . '</p>';
            
            echo '</div></div>';
        }
        echo '</div>';
    } else {
        echo 'No books found.';
    }
}


$conn->close();
?>







<!--------------------------------------------------PHP CODE IN EACH SECTIONS IN SIDE BAR---------------------------------------------------------->


        </div>




        <script>
document.addEventListener("DOMContentLoaded", function () {
    const showAllBooksCheckbox = document.getElementById("showAllBooks");
    const showAllBooksValue = document.querySelector('input[name="showAllBooksValue"]');
    const searchForm = document.getElementById("searchForm");

    showAllBooksCheckbox.addEventListener("change", function () {
        if (showAllBooksCheckbox.checked) {
            showAllBooksValue.value = "1";
        } else {
            showAllBooksValue.value = "0";
        }

        
        searchForm.submit();
    });
});
</script>





<!------------------------------------------------------THIS IS FOR SEARCH BAR ONLY--------------------------------------------------->
<?php
@include 'Configure.php'; 


$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';



if (!empty($searchTerm)) {

    $sql = "SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn,
    CASE
        WHEN section = '' THEN
            CASE
WHEN TABLE_NAME = 'graduateschool_library_archive_section' THEN 'Graduate School Archive Section'
WHEN TABLE_NAME = 'graduateschool_library_circulation_section' THEN 'Graduate School Circulation Section'
WHEN TABLE_NAME = 'graduateschool_library_filipinana_section' THEN 'Graduate School Filipinana Section'
WHEN TABLE_NAME = 'graduateschool_library_periodical_section' THEN 'Graduate School Periodical Section'
WHEN TABLE_NAME = 'graduateschool_library_reference_section' THEN 'Graduate School Reference Section'
WHEN TABLE_NAME = 'graduateschool_library_reserve_section' THEN 'Graduate School Reserve Section'
WHEN TABLE_NAME = 'graduateschool_library_thesisdissertation_section' THEN 'Graduate School Thesis/Dissertations Section'

WHEN TABLE_NAME = 'main_library_archives_section' THEN 'Main Library Archives Section'
WHEN TABLE_NAME = 'main_library_circulation_section' THEN 'Main Library Circulation Section'
WHEN TABLE_NAME = 'main_library_fiction_section' THEN 'Main Library Fiction Section'
WHEN TABLE_NAME = 'main_library_filipinana_section' THEN 'Main Library Filipinana Section'
WHEN TABLE_NAME = 'main_library_periodical_section' THEN 'Main Library Periodical Section'
WHEN TABLE_NAME = 'main_library_reference_section' THEN 'Main Library Reference Section'
WHEN TABLE_NAME = 'main_library_reserve_section' THEN 'Main Library Reserve Section'
WHEN TABLE_NAME = 'main_library_thesisdissertation_section' THEN 'Main Library Thesis/Dissertation Section'

WHEN TABLE_NAME = 'rts_library_archive_section' THEN 'RTS Library Archive Section'
WHEN TABLE_NAME = 'rts_library_circulation_section' THEN 'RTS Library Circulation Section'
WHEN TABLE_NAME = 'rts_library_fiction_section' THEN 'RTS Library Fiction Section'
WHEN TABLE_NAME = 'rts_library_filipinana_section' THEN 'RTS Library Filipinana Section'
WHEN TABLE_NAME = 'rts_library_periodical_section' THEN 'RTS Library Periodical Section'
WHEN TABLE_NAME = 'rts_library_reference_section' THEN 'RTS Library Reference Section'
WHEN TABLE_NAME = 'rts_library_reserve_section' THEN 'RTS Library Reserve Section'
WHEN TABLE_NAME = 'rts_library_thesisdissertation_section' THEN 'RTS Library Thesis/Dissertation Section'
ELSE 'Default Section'

            END
        ELSE section
    END AS section
FROM (
    SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'graduateschool_library_archive_section' AS TABLE_NAME
FROM graduateschool_library_archive_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'graduateschool_library_circulation_section'
FROM graduateschool_library_circulation_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'graduateschool_library_filipinana_section'
FROM graduateschool_library_filipinana_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'graduateschool_library_periodical_section'
FROM graduateschool_library_periodical_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'graduateschool_library_reference_section'
FROM graduateschool_library_reference_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'graduateschool_library_reserve_section'
FROM graduateschool_library_reserve_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'graduateschool_library_thesisdissertation_section'
FROM graduateschool_library_thesisdissertation_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_archives_section'
FROM main_library_archives_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_circulation_section'
FROM main_library_circulation_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_fiction_section'
FROM main_library_fiction_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_filipinana_section'
FROM main_library_filipinana_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_periodical_section'
FROM main_library_periodical_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_reference_section'
FROM main_library_reference_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_reserve_section'
FROM main_library_reserve_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_thesisdissertation_section'
FROM main_library_thesisdissertation_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_archive_section'
FROM rts_library_archive_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_circulation_section'
FROM rts_library_circulation_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_fiction_section'
FROM rts_library_fiction_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_filipinana_section'
FROM rts_library_filipinana_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_periodical_section'
FROM rts_library_periodical_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_reference_section'
FROM rts_library_reference_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_reserve_section'
FROM rts_library_reserve_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_thesisdissertation_section'
FROM rts_library_thesisdissertation_section
) AS all_sections
WHERE 
    bk_title LIKE '%$searchTerm%'
    OR bk_author LIKE '%$searchTerm%'
    OR isbn LIKE '%$searchTerm%'
ORDER BY
    CASE
        WHEN bk_title REGEXP '^[0-9]' THEN 1
        ELSE 2
    END,
    bk_title ASC";


$result = $conn->query($sql);


if ($result->num_rows > 0) {
    echo '<div class="book-grid">';
    while ($row = $result->fetch_assoc()) {

        $bookData = array(
            'bookTitle' => $row['bk_title'],
            'bookAuthor' => $row['bk_author'],
            'frontImage' => $row['front_image'],
            'abstractImage' => $row['abstract_image'],
            'quantity' => $row['quantity'],
            'copyrightDate' => $row['copyright_date'],
            'publisher' => $row['publisher'],
            'placePublication' => $row['place_publication'],
            'subject' => $row['subject'],
            'callNumber' => $row['call_number'],
            'isbn' => $row['isbn'],
            'section' => !empty($row['section']) ? $row['section'] : 'Default Section'

        );
        

        $bookDataUrl = urlencode(json_encode($bookData));
    
        echo '<div class="book">';
        echo '<div class="grid-overlay">';
        $iconFolder = 'ADMIN/BookIcon';
        $iconFiles = glob($iconFolder . '/*.png');
        $randomIcon = '';
    
        if (empty($iconFiles)) {
            $defaultIconFolder = 'ADMIN/BookIcon';
            $defaultIconFiles = glob($defaultIconFolder . '/*.png');
            if (empty($defaultIconFiles)) {
                $defaultIcon = 'default/default_icon.png';
            } else {
                $defaultIcon = $defaultIconFiles[array_rand($defaultIconFiles)];
            }
            $randomIcon = $defaultIcon;
        } else {
            $randomIcon = $iconFiles[array_rand($iconFiles)];
        }
    
        echo '<img src="' . $randomIcon . '" alt="Book Icon" width="100">';
        
       
        echo '<p class="book-title"><a href="BookDetails.php?book_id=' . $row['book_id'] . '&book_data=' . $bookDataUrl . '">' . $bookData['bookTitle'] . '</a></p>';
        
        echo '<p class "book-title">' . $bookData['bookAuthor'] . '</p>';
        echo '<p class="book-quantity">Available: ' . $bookData['quantity'] . '</p>';
        
        echo '</div></div>';
    }
    echo '</div>';
} else {
    echo '<p class="no-results-message">No results found in the inventory.</p>';

}
}

$conn->close();

?>




<!------------------------------------------------------THIS IS FOR SEARCH BAR ONLY--------------------------------------------------->

<!------------------------------------------------------THIS IS FOR SHOW ALL BOOKS ONLY--------------------------------------------------->
<?php
@include 'Configure.php'; 
if (isset($_GET['showAllBooks'])) {
    
    $sql = "SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn,
    CASE
        WHEN section = '' THEN
            CASE
WHEN TABLE_NAME = 'graduateschool_library_archive_section' THEN 'Graduate School Archive Section'
WHEN TABLE_NAME = 'graduateschool_library_circulation_section' THEN 'Graduate School Circulation Section'
WHEN TABLE_NAME = 'graduateschool_library_filipinana_section' THEN 'Graduate School Filipinana Section'
WHEN TABLE_NAME = 'graduateschool_library_periodical_section' THEN 'Graduate School Library Periodical Section'
WHEN TABLE_NAME = 'graduateschool_library_reference_section' THEN 'Graduate School Library Reference Section'
WHEN TABLE_NAME = 'graduateschool_library_reserve_section' THEN 'Graduate School Library Reserve Section'
WHEN TABLE_NAME = 'graduateschool_library_thesisdissertation_section' THEN 'Graduate School Thesis/Dissertations Section'

WHEN TABLE_NAME = 'main_library_archives_section' THEN 'Main Library Archives Section'
WHEN TABLE_NAME = 'main_library_circulation_section' THEN 'Main Library Circulation Section'
WHEN TABLE_NAME = 'main_library_fiction_section' THEN 'Main Library Fiction Section'
WHEN TABLE_NAME = 'main_library_filipinana_section' THEN 'Main Library Filipinana Section'
WHEN TABLE_NAME = 'main_library_periodical_section' THEN 'Main Library Periodical Section'
WHEN TABLE_NAME = 'main_library_reference_section' THEN 'Main Library Reference Section'
WHEN TABLE_NAME = 'main_library_reserve_section' THEN 'Main Library Reserve Section'
WHEN TABLE_NAME = 'main_library_thesisdissertation_section' THEN 'Main Library Thesis/Dissertation Section'

WHEN TABLE_NAME = 'rts_library_archive_section' THEN 'RTS Library Archive Section'
WHEN TABLE_NAME = 'rts_library_circulation_section' THEN 'RTS Library Circulation Section'
WHEN TABLE_NAME = 'rts_library_fiction_section' THEN 'RTS Library Fiction Section'
WHEN TABLE_NAME = 'rts_library_filipinana_section' THEN 'RTS Library Filipinana Section'
WHEN TABLE_NAME = 'rts_library_periodical_section' THEN 'RTS Library Periodical Section'
WHEN TABLE_NAME = 'rts_library_reference_section' THEN 'RTS Library Reference Section'
WHEN TABLE_NAME = 'rts_library_reserve_section' THEN 'RTS Library Reserve Section'
WHEN TABLE_NAME = 'rts_library_thesisdissertation_section' THEN 'RTS Library Thesis/Dissertation Section'
ELSE 'Default Section'

            END
        ELSE section
    END AS section
FROM (
    SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'graduateschool_library_archive_section' AS TABLE_NAME
FROM graduateschool_library_archive_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'graduateschool_library_circulation_section'
FROM graduateschool_library_circulation_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'graduateschool_library_filipinana_section'
FROM graduateschool_library_filipinana_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'graduateschool_library_periodical_section'
FROM graduateschool_library_periodical_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'graduateschool_library_reference_section'
FROM graduateschool_library_reference_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'graduateschool_library_reserve_section'
FROM graduateschool_library_reserve_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'graduateschool_library_thesisdissertation_section'
FROM graduateschool_library_thesisdissertation_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_archives_section'
FROM main_library_archives_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_circulation_section'
FROM main_library_circulation_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_fiction_section'
FROM main_library_fiction_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_filipinana_section'
FROM main_library_filipinana_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_periodical_section'
FROM main_library_periodical_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_reference_section'
FROM main_library_reference_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_reserve_section'
FROM main_library_reserve_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'main_library_thesisdissertation_section'
FROM main_library_thesisdissertation_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_archive_section'
FROM rts_library_archive_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_circulation_section'
FROM rts_library_circulation_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_fiction_section'
FROM rts_library_fiction_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_filipinana_section'
FROM rts_library_filipinana_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_periodical_section'
FROM rts_library_periodical_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_reference_section'
FROM rts_library_reference_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_reserve_section'
FROM rts_library_reserve_section
UNION
SELECT book_id, bk_title, bk_author, front_image, abstract_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, section, 'rts_library_thesisdissertation_section'
FROM rts_library_thesisdissertation_section
) AS all_sections
WHERE 
    bk_title LIKE '%$searchTerm%'
    OR bk_author LIKE '%$searchTerm%'
ORDER BY 
    CASE
        WHEN bk_title REGEXP '^[0-9]' THEN 1
        ELSE 2
    END,
    bk_title ASC";


$result = $conn->query($sql);


if ($result->num_rows > 0) {
    echo '<div class="book-grid">';
    while ($row = $result->fetch_assoc()) {

        $bookData = array(
            'bookTitle' => $row['bk_title'],
            'bookAuthor' => $row['bk_author'],
            'frontImage' => $row['front_image'],
            'abstractImage' => $row['abstract_image'],
            'quantity' => $row['quantity'],
            'copyrightDate' => $row['copyright_date'],
            'publisher' => $row['publisher'],
            'placePublication' => $row['place_publication'],
            'subject' => $row['subject'],
            'callNumber' => $row['call_number'],
            'isbn' => $row['isbn'],
            'section' => !empty($row['section']) ? $row['section'] : 'Default Section'

        );
        

        $bookDataUrl = urlencode(json_encode($bookData));
    
        echo '<div class="book">';
        echo '<div class="grid-overlay">';
        $iconFolder = 'ADMIN/BookIcon';
        $iconFiles = glob($iconFolder . '/*.png');
        $randomIcon = '';
    
        if (empty($iconFiles)) {
            $defaultIconFolder = 'ADMIN/BookIcon';
            $defaultIconFiles = glob($defaultIconFolder . '/*.png');
            if (empty($defaultIconFiles)) {
                $defaultIcon = 'default/default_icon.png';
            } else {
                $defaultIcon = $defaultIconFiles[array_rand($defaultIconFiles)];
            }
            $randomIcon = $defaultIcon;
        } else {
            $randomIcon = $iconFiles[array_rand($iconFiles)];
        }
    
        echo '<img src="' . $randomIcon . '" alt="Book Icon" width="100">';
        
      
        echo '<p class="book-title"><a href="BookDetails.php?book_id=' . $row['book_id'] . '&book_data=' . $bookDataUrl . '">' . $bookData['bookTitle'] . '</a></p>';
        
        echo '<p class "book-author">' . $bookData['bookAuthor'] . '</p>';
        echo '<p class="book-quantity">Available: ' . $bookData['quantity'] . '</p>';
        
        echo '</div></div>';
    }
    echo '</div>';
} else {
    echo '<p class="no-results-message">No results found in the inventory.</p>';

}
}
?>



<!------------------------------------------------------THIS IS FOR SHOW ALL BOOKS ONLY--------------------------------------------------->







</div>
</div>





  
</body>
</html>