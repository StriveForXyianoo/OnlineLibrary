<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../Configure.php';
    
    // Get form data
    $bookTitle = $_POST["bookTitle"];
    $bookAuthor = $_POST["bookAuthor"];
    $copyrightDate = $_POST["copyrightDate"];
    $publisher = $_POST["publisher"];
    $placeOfPublication = $_POST["placeOfPublication"];
    $subject = $_POST["subject"];
    $isbn = $_POST["isbn"];
    $callNumber = $_POST["callNumber"];
    $bookQuantity = $_POST["bookQuantity"];
    
    // Handle file uploads
    $frontImage = $_FILES["frontPage"]["name"];
    $abstractImage = $_FILES["abstract"]["name"];
    
    // Define the upload directories for front and abstract images
    $frontUploadDir = "RTSBookAbstract/"; // Change to your desired directory for front images
    $abstractUploadDir = "RTSBookFront/"; // Change to your desired directory for abstract images
    
    // Define the file paths for front and abstract images
    $frontImagePath = $frontUploadDir . $frontImage;
    $abstractImagePath = $abstractUploadDir . $abstractImage;
    
    // Define the section and corresponding table
    $section = $_POST["section"];
    $table = ''; // Initialize the table name

    // Map the section to the corresponding table
    switch ($section) {
        case "Circulation":
            $table = "rts_library_circulation_section";
            break;
        case "Fiction":
            $table = "rts_library_fiction_section";
            break;
        case "Filipinana":
            $table = "rts_library_filipinana_section";
            break;
        case "Periodicals":
            $table = "rts_library_periodical_section";
            break;
        case "Reference":
            $table = "rts_library_reference_section";
            break;
        case "Reserve":
            $table = "rts_library_reserve_section";
            break;
        case "Thesis Dissertation":
            $table = "rts_library_thesisdissertation_section";
            break;
        case "Archives":
            $table = "rts_library_archive_section";
            break;
        default:
            // Handle invalid section
            die("Invalid section selected.");
    }


    if (move_uploaded_file($_FILES["frontPage"]["tmp_name"], $frontImagePath) && move_uploaded_file($_FILES["abstract"]["tmp_name"], $abstractImagePath)) {

        $sql = "INSERT INTO $table (book_id, bk_title, bk_author, front_image, abstract_image, copyright_date, publisher, place_publication, subject, isbn, call_number, quantity) VALUES (NULL, '$bookTitle', '$bookAuthor', '$frontImage', '$abstractImage', '$copyrightDate', '$publisher', '$placeOfPublication', '$subject', '$isbn', '$callNumber', '$bookQuantity')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Book added successfully to $section.');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Handle file upload errors
        echo "<script>alert('File upload failed.');</script>";
    }

    // Close the database connection
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/addbook.css?v= <?php echo time(); ?>">
    <link rel="icon" type="image" href="pics/WIT-Logo.png">
    <link rel="stylesheet" href="path/to/custom-lightbox.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <title>WIT Administration library</title>
</head>
<body>

<!----------------------------------------------------------------------------------------------------------------->
<script src="javascripts/add.js"></script>


<div class="note"><a class="takenote"  onclick="openForm('NoteTop')">Note!</a></div>

<div id="NoteTopForm" class="form-container-note">
        <!-- Your Records form content goes here -->
        <h2>Please Take Note!</h2>

        <p> &nbsp;Before adding books, please select any of the Library where the book will be stored.</p>

        <p> &nbsp;&nbsp;&nbsp;After uploading and filling up the info's of the book. Select any of the section below where the book will be stored.</p>
        <button class="close-btn-note" onclick="closeForm('NoteTop')">Close</button>
    </div>


<div class="maintitle">
    <h1>WESTERN INSTITUTE ADMINISTRATION LIBRARY</h1>
</div>

<div class="back-btn"><a href="Admin Main.php">Back to Admin Panel</a></div>

<div class="background-main">
    <img src="pics/WIT-LOGO.png" class="mainlogo" alt="">
</div>


<div class="topnav">
  <div class="topnav-column">
    <a  href="MainAdd.php" class="topnav-button">Main Library</a>
  </div>


  <div class="topnav-column">
    <a href="RTSadd.php" class="topnav-button">RTS Library</a>
  </div>


  <div class="topnav-column">
    <a href="GradAdd.php" class="topnav-button">Graduate School Library</a>
  </div>
</div>




<!----------------------------------------------------------------------------------------------------------------->


<div id="MainLibraryForm" class="form-container">
        <!-- Your Records form content goes here -->
        <h2>Add Book in RTS Library</h2>

        <div class="left-form">
        <form method="post" action="RTSadd.php" enctype="multipart/form-data">
    <input type="hidden" name="form_type" value="rts_library">
    <div class="select">
        <label for="section"> Section:</label>
        <select id="section" name="section" class="custom-select-add">

            <option value="Reserve">Reserve</option>
            <option value="Circulation">Circulation</option>
            <option value="Fiction">Fiction</option>
            <option value="Filipinana">Filipinana</option>
            <option value="Periodicals">Periodicals</option>
            <option value="Reference">Reference</option>
            <option value="Thesis Dissertation">Thesis Dissertation</option>
            <option value="Archives">Archives</option>
            
        </select>
    </div>
    <label for="bookTitle">Book Title:</label>
    <input type="text" id="bookTitle" name="bookTitle" required><br>

    <label for="bookAuthor">Book Author:</label>
    <input type="text" id="bookAuthor" name="bookAuthor" required><br>

    <label for="copyrightDate">Copyright Date:</label>
    <input type="date" id="copyrightDate" name="copyrightDate" required><br>

    <label for="publisher">Publisher:</label>
    <input type="text" id="publisher" name="publisher" required><br>

    <label for="placeOfPublication">Place of Publication:</label>
    <input type="text" id="placeOfPublication" name="placeOfPublication" required><br>

    <label for="subject">Subject:</label>
    <input type="text" id="subject" name="subject" required><br>

    <label for="isbn">ISBN:</label>
    <input type="text" id="isbn" name="isbn" required><br>

    <label for="callNumber">Call Number:</label>
    <input type="number" id="callNumber" name="callNumber" required><br>

    <label for="bookQuantity">Book Quantity:</label>
    <input type="number" id="bookQuantity" name="bookQuantity" required><br>
        
          
    <div class="footer">
        <button><a type="submit" class="footer-button">Add Book</a></button>
    </div>

    <button class="close-btn" onclick="window.location='AddBook.php'">Hide</button>
</div>

<div class="upload-pic">
    <div class="center-content">
        <label for="frontPage">Upload Book Front Page:</label>
        <input type="file" name="frontPage" id="frontPage" accept="image/*" onchange="previewImage('frontPage', 'frontPageImage')" required>
    </div>

    <!-- Upload Book's Abstract -->
    <div class="center-content">
        <label for="abstract">Upload Book's Abstract:</label>
        <input type="file" name="abstract" id="abstract" accept="image/*" onchange="previewImage('abstract', 'abstractImage')" required>
    </div>
</div>

<div class="pic-preview">
    <div class="preview-box1">
        <img id="frontPageImage" class="box1" alt="Preview Box for Book's Front Page">
    </div>
   
    <div class="preview-box2">
        <img id="abstractImage" class="box2" alt="Preview Box for Book's Abstract">
    </div>
</div>
</form>


       

    </div>
    
</body>
</html>