<?php
include '../../Configure.php';

// Initialize variables to store book information
$book = array();
$bookId = $section = "";

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"]) && isset($_GET["section"])) {
    $bookId = $_GET["id"];
    $section = $_GET["section"];

    // Determine the table name based on the section
    $tableMappings = array(
        "RTS_Reserve" => "rts_library_reserve_section",
        "RTS_Circulation" => "rts_library_circulation_section",
        "RTS_Filipinana" => "rts_library_filipinana_section",
        "RTS_Reference" => "rts_library_reference_section",
        "RTS_Archives" => "rts_library_archive_section",
        "RTS_Periodicals" => "rts_library_periodical_section",
        "RTS_ThesisDissertation" => "rts_library_thesisdissertation_section",
        "RTS_Fiction" => "rts_library_fiction_section"
    );

    if (isset($tableMappings[$section])) {
        $tableName = $tableMappings[$section];

        // Retrieve the book details from the appropriate table based on the section
        $sql = "SELECT book_id, bk_title, bk_author, quantity, call_number, copyright_date, publisher, place_publication, subject, isbn, front_image FROM $tableName WHERE book_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bookId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $book = $result->fetch_assoc();
        } else {
            // Handle the error or display a message
            echo "Error fetching book information.";
            exit;
        }
    } else {
        // Handle the case if an invalid section is selected
        echo '<script type="text/javascript">alert("Invalid section selected.");</script>';
    }
}


?>




<?php
// Database connection details


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve data from the form
    $bookId = $_POST["book_id"];
    $section = $_POST["rts_action"];
    $bk_title = $_POST["bk_title"];
    $bk_author = $_POST["bk_author"];
    $quantity = $_POST["quantity"];
    $call_number = $_POST["call_number"];
    $copyright_date = $_POST["copyright_date"];
    $publisher = $_POST["publisher"];
    $place_publication = $_POST["place_publication"];
    $subject = $_POST["subject"];
    $isbn = $_POST["isbn"];
    
    // Process the uploaded image if it's provided
    if ($_FILES["front_image"]["error"] == 0) {
        $image_dir = "../RTSBookFront/"; // Set the path to your image directory
        $image_name = $_FILES["front_image"]["name"];
        $target_file = $image_dir . basename($image_name);
        
        if (move_uploaded_file($_FILES["front_image"]["tmp_name"], $target_file)) {
            $front_image = $image_name;
        } else {
            echo "Error uploading image.";
            exit;
        }
    }

    // Determine the table name based on the selected RTS Library section
    $tableMappings = array(
        "RTS_Reserve" => "rts_library_reserve_section",
        "RTS_Circulation" => "rts_library_circulation_section",
        "RTS_Filipinana" => "rts_library_filipinana_section",
        "RTS_Reference" => "rts_library_reference_section",
        "RTS_Archives" => "rts_library_archive_section",
        "RTS_Periodicals" => "rts_library_periodical_section",
        "RTS_ThesisDissertation" => "rts_library_thesisdissertation_section",
        "RTS_Fiction" => "rts_library_fiction_section"
    );

    if (isset($tableMappings[$section])) {
        $tableName = $tableMappings[$section];

        // Update the book information in the appropriate table, including front_image
        $sql = "UPDATE $tableName SET bk_title=?, bk_author=?, quantity=?, call_number=?, copyright_date=?, publisher=?, place_publication=?, subject=?, isbn=?, front_image = COALESCE(?, front_image) WHERE book_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssisi", $bk_title, $bk_author, $quantity, $call_number, $copyright_date, $publisher, $place_publication, $subject, $isbn, $front_image, $bookId);
        
        if ($stmt->execute()) {
            // Display a success message
            echo '<script type="text/javascript">alert("Book information updated successfully.");</script>';
            
            // Redirect to the "UpdateDelete.php" page after a short delay
            echo '<script type="text/javascript">setTimeout(function(){ window.location = "UpdateDelete.php"; }, 500);</script>';
        } else {
            // Display an error message if the update fails
            echo '<script type="text/javascript">alert("Error updating book information: ' . $stmt->error . '");</script>';
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/addbook.css?v= <?php echo time(); ?>">
    <link rel="icon" type="image" href="../pics/WIT-Logo.png">
    <link rel="stylesheet" href="path/to/custom-lightbox.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <title>WIT Administration library</title>
</head>
<body>
<script src="../javascripts/add.js"></script>
<div class="maintitle">
    <h1>WESTERN INSTITUTE ADMINISTRATION LIBRARY</h1>
</div>


<!-------MAIN FORM --->
<div class="background-main">
    <img src="WIT-LOGO.png" class="mainlogo" alt="">
</div>


<div id="BookConfigurationsForm" class="form-container-books">
       
        <h2>Manage Book Details and Configurations</h2>

        <!---- Display Information of Book Here ---->
<div class="update-form-container">
<form action="RTSupdate.php" method="POST" enctype="multipart/form-data">
    <div class="update-form-group">
        <div class="update-form-column">
            <input type="hidden" name="action" value="<?php echo $librarySection; ?>">
            <label for="update-title">Title:</label>
            <input type="text" name="bk_title" value="<?php echo $book['bk_title'] ?? ''; ?>" id="update-title">
            <label for="update-author">Author:</label>
            <input type="text" name="bk_author" value="<?php echo $book['bk_author'] ?? ''; ?>" id="update-author">
            <label for="update-quantity">Quantity:</label>
            <input type="text" name="quantity" value="<?php echo $book['quantity'] ?? ''; ?>" id="update-quantity">
            <label for="update-call-number">Call Number:</label>
            <input type="text" name="call_number" value="<?php echo $book['call_number'] ?? ''; ?>" id="update-call-number">
            <label for="update-copyright-date">Copyright Date:</label>
            <input type="date" name="copyright_date" value="<?php echo $book['copyright_date'] ?? ''; ?>" id="update-copyright-date">
        </div>
        <div class="update-form-column">
            <label for="update-publisher">Publisher:</label>
            <input type="text" name="publisher" value="<?php echo $book['publisher'] ?? ''; ?>" id="update-publisher">
            <label for="update-place-of-publication">Place of Publication:</label>
            <input type="text" name="place_publication" value="<?php echo $book['place_publication'] ?? ''; ?>" id="update-place-of-publication">
            <label for="update-subject">Subject:</label>
            <input type="text" name="subject" value="<?php echo $book['subject'] ?? ''; ?>" id="update-subject">
            <label for="update-isbn">ISBN:</label>
            <input type="text" name="isbn" value="<?php echo $book['isbn'] ?? ''; ?>" id="update-isbn">
            <label for="update-front-image">Front Image:</label>
            <input type="file" name="front_image" id="update-front-image">

        </div>
    </div>
    <input type="hidden" name="book_id" value="<?php echo $bookId; ?>">
<input type="hidden" name="rts_action" value="<?php echo $section; ?>">

    <input type="submit" class="update-button" value="Update">
</form>


</div>

          <!---- Display Information of Book Here ---->

        <button class="close-btn" onclick="window.location='UpdateDelete.php'">Go Back</button>
    </div>


</body>
</html>