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
<div class="back-btn"><a href="../Admin Main.php">Back to Admin Panel</a></div>
<div class="note"><a class="takenote"  onclick="openForm('NoteTop')">Important Note!</a></div>

<div id="NoteTopForm" class="form-container-note">
       
        <h2>Please Take Note!</h2>

        <p> &nbsp;First is select the desired library where you want the book to be configure.</p>

        <p> &nbsp;After selecting a Library, please select only the library section of the current library that you selected.</p>
        <button class="close-btn-note" onclick="closeForm('NoteTop')">Close</button>
    </div>

<div class="background-main">
    <img src="WIT-LOGO.png" class="mainlogo" alt="">
</div>







<div id="BookConfigurationsForm" class="form-container-books">
       
        <h2>Manage Book Details and Configurations</h2>

<!------------------------------------------------------------------Main library Form ------------------------------------------------------------>
<?php
$hostname = "localhost";
$username = "root";
$password = "witlibrary2023password";
$database = "database_users";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["action"])) {
        $librarySection = $_POST["action"];
        
       
        $tableMappings = array(
            "Reserve" => "main_library_reserve_section",
            "Circulation" => "main_library_circulation_section",
            "Filipinana" => "main_library_filipinana_section",
            "Reference" => "main_library_reference_section",
            "Archives" => "main_library_archives_section",
            "Periodicals" => "main_library_periodical_section",
            "Thesis Dissertation" => "main_library_thesisdissertation_section",
            "Fiction" => "main_library_fiction_section"
        );
        
       
        if (isset($tableMappings[$librarySection])) {
            $tableName = $tableMappings[$librarySection];
            
           
            $sql = "SELECT book_id, bk_title, bk_author, front_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, front_image FROM $tableName";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<div class="table-container-book">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Quantity</th>
                            <th>Copyright Date</th>
                            <th>Publisher</th>
                            <th>Place of Publication</th>
                            <th>Subject</th>
                            <th>Call Number</th>
                            <th>ISBN</th>
                            <th>Book Front Image</th>
                            <th class="action-header">Actions</th> 
                        </tr>
                    </thead>
                    <tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<form method="post">';
                        echo '<input type="hidden" name="action" value="' . $librarySection . '">';
                        echo '<input type="hidden" name="delete_book_id" value="' . $row["book_id"] . '">';
                        echo '<tr>';
                        echo '<td>' . $row["bk_title"] . '</td>';
                        echo '<td>' . $row["bk_author"] . '</td>';
                        echo '<td>' . $row["quantity"] . '</td>';
                        echo '<td>' . $row["copyright_date"] . '</td>';
                        echo '<td>' . $row["publisher"] . '</td>';
                        echo '<td>' . $row["place_publication"] . '</td>';
                        echo '<td>' . $row["subject"] . '</td>';
                        echo '<td>' . $row["call_number"] . '</td>';
                        echo '<td>' . $row["isbn"] . '</td>';
                    
                        echo '<td><img src="../BookFront/' . $row["front_image"] . '" alt="Front Image" style="width: 100px; height: 100px;"></td>';
                    
                        echo '<td>';
                        echo "<a class='update-btn' href='Update.php?id={$row['book_id']}&section={$librarySection}'>Update</a>";
                        
                        
                        echo '<button class="delete-button" type="submit" name="delete_book" value="' . $row["book_id"] . '">Delete</button>';
                        
                        echo '</td>';
                        echo '</tr>';
                        echo '</form>';
                }

                echo '</tbody></table></div>';
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    if (isset($_POST["action"])) {
                        
                        
                        if (isset($_POST["delete_book"])) {
                            
                            $bookToDelete = $_POST["delete_book"];
                            $sql = "DELETE FROM $tableName WHERE book_id = $bookToDelete";
                            if ($conn->query($sql) === TRUE) {
                                echo '<script type="text/javascript">alert("Book deleted successfully.");</script>';
                            } else {
                                echo '<script type="text/javascript">alert("Error deleting book: ' . $conn->error . '");</script>';
                            }
                        }
                    }
                }
            } else {
                echo '<script type="text/javascript">alert("No books found in the selected Main Library section.");</script>';
            }
        } else {
            
            echo '<script type="text/javascript">alert("Invalid section selected.");</script>';
        }
    } else {
        
        echo '';
    }
}
?>






<form class="custom-form" action="UpdateDelete.php" method="POST">
    <label class="custom-label" for="action">Choose Main Library Section:</label>
    <select class="custom-select" name="action" id="action">
        <option value="Reserve">Reserve</option>
        <option value="Circulation">Circulation</option>
        <option value="Filipinana">Filipinana</option>
        <option value="Reference">Reference</option>
        <option value="Archives">Archives</option>
        <option value="Periodicals">Periodicals</option>
        <option value="Thesis Dissertation">Thesis/Dissertation</option>
        <option value="Fiction">Fiction</option>
    </select>
    <input class="custom-button" type="submit" value="Display">
</form>




<!------------------------------------------------------------------Main Library Form ------------------------------------------------>



<!------------------------------------------------------------------RTS Library Form ------------------------------------------------>
<?php
$hostname = "localhost";
$username = "root";
$password = "witlibrary2023password";
$database = "database_users";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["rts_action"])) {
        $librarySection = $_POST["rts_action"];


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

        
        if (isset($tableMappings[$librarySection])) {
            $tableName = $tableMappings[$librarySection];

           
            $sql = "SELECT book_id, bk_title, bk_author, front_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, front_image FROM $tableName";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<div class="table-container-book">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Quantity</th>
                            <th>Copyright Date</th>
                            <th>Publisher</th>
                            <th>Place of Publication</th>
                            <th>Subject</th>
                            <th>Call Number</th>
                            <th>ISBN</th>
                            <th>Book Front Image</th>
                            <th class="action-header">Actions</th> 
                        </tr>
                    </thead>
                    <tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<form method="post">';
                    echo '<input type="hidden" name="rts_action" value="' . $librarySection . '">';
                    echo '<input type="hidden" name="delete_book_id" value="' . $row["book_id"] . '">';
                    echo '<tr>';
                    echo '<td>' . $row["bk_title"] . '</td>';
                    echo '<td>' . $row["bk_author"] . '</td>';
                    echo '<td>' . $row["quantity"] . '</td>';
                    echo '<td>' . $row["copyright_date"] . '</td>';
                    echo '<td>' . $row["publisher"] . '</td>';
                    echo '<td>' . $row["place_publication"] . '</td>';
                    echo '<td>' . $row["subject"] . '</td>';
                    echo '<td>' . $row["call_number"] . '</td>';
                    echo '<td>' . $row["isbn"] . '</td>';
                    echo '<td><img src="../RTSBookFront/' . $row["front_image"] . '" alt="Front Image" style="width: 100px; height: 100px;"></td>';

                   

                    echo '<td>';
                    echo "<a class='update-btn' href='RTSupdate.php?id={$row['book_id']}&section={$librarySection}'>Update</a>";

                    
                    echo '<button class="delete-button" type="submit" name="delete_rts_book" value="' . $row["book_id"] . '">Delete</button>';

                    echo '</td>'; 
                    echo '</tr>';
                    echo '</form>';
                }

                echo '</tbody></table></div>';
            } else {
                echo '<script type="text/javascript">alert("No books found in the selected RTS Library section.");</script>';
            }
        } else {
            
            echo '';
        }
    } else {
       
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["delete_rts_book"])) {
        $bookToDelete = $_POST["delete_rts_book"];
        $sql = "DELETE FROM $tableName WHERE book_id = $bookToDelete";
        if ($conn->query($sql) === TRUE) {
            echo '<script type="text/javascript">alert("Book deleted successfully.");</script>';
        } else {
            echo '<script type="text/javascript">alert("Error deleting book: ' . $conn->error . '");</script>';
        }
    }
}
?>




<form class="custom-form-RTS" action="UpdateDelete.php" method="POST">
    <label class="custom-label-RTS" for="rts_action">Choose RTS Library Section:</label>
    <select class="custom-select-RTS" name="rts_action" id="rts_action">
        <option value="RTS_Reserve">Reserve</option>
        <option value="RTS_Circulation">Circulation</option>
        <option value="RTS_Filipinana">Filipinana</option>
        <option value="RTS_Reference">Reference</option>
        <option value="RTS_Archives">Archives</option>
        <option value="RTS_Periodicals">Periodicals</option>
        <option value="RTS_ThesisDissertation">Thesis/Dissertation</option>
        <option value="RTS_Fiction">Fiction</option>
    </select>
    <input class="custom-button" type="submit" value="Display">
</form>



<!------------------------------------------------------------------RTS Library Form ------------------------------------------------>

<!------------------------------------------------------------------GRADUATE Library Form ------------------------------------------------>
<?php
$hostname = "localhost";
$username = "root";
$password = "witlibrary2023password";
$database = "database_users";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["gs_action"])) {
        $librarySection = $_POST["gs_action"];

       
        $tableMappings = array(
            "GraduateSchool_Reserve" => "graduateschool_library_reserve_section",
            "GraduateSchool_Circulation" => "graduateschool_library_circulation_section",
            "GraduateSchool_Filipinana" => "graduateschool_library_filipinana_section",
            "GraduateSchool_Reference" => "graduateschool_library_reference_section",
            "GraduateSchool_Archives" => "graduateschool_library_archive_section",
            "GraduateSchool_Periodicals" => "graduateschool_library_periodical_section",
            "GraduateSchool_ThesisDissertation" => "graduateschool_library_thesisdissertation_section"
        );

        
        if (isset($tableMappings[$librarySection])) {
            $tableName = $tableMappings[$librarySection];

           
            $sql = "SELECT book_id, bk_title, bk_author, front_image, quantity, copyright_date, publisher, place_publication, subject, call_number, isbn, front_image FROM $tableName";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<div class="table-container-book">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Quantity</th>
                            <th>Copyright Date</th>
                            <th>Publisher</th>
                            <th>Place of Publication</th>
                            <th>Subject</th>
                            <th>Call Number</th>
                            <th>ISBN</th>
                            <th>Book Front Image</th>
                            <th class="action-header">Actions</th> 
                        </tr>
                    </thead>
                    <tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<form method="post">';
                    echo '<input type="hidden" name="gs_action" value="' . $librarySection . '">';
                    echo '<input type="hidden" name="delete_book_id" value="' . $row["book_id"] . '">';
                    echo '<tr class="book-row" data-book-id="' . $row["book_id"] . '">';
                    echo '<td>' . $row["bk_title"] . '</td>';
                    echo '<td>' . $row["bk_author"] . '</td>';
                    echo '<td>' . $row["quantity"] . '</td>';
                    echo '<td>' . $row["copyright_date"] . '</td>';
                    echo '<td>' . $row["publisher"] . '</td>';
                    echo '<td>' . $row["place_publication"] . '</td>';
                    echo '<td>' . $row["subject"] . '</td>';
                    echo '<td>' . $row["call_number"] . '</td>';
                    echo '<td>' . $row["isbn"] . '</td>';
                    echo '<td><img src="../GraduateSchoolBookFront/' . $row["front_image"] . '" alt="Front Image" style="width: 100px; height: 100px;"></td>';
                    echo '<td>';
                    echo "<a class='update-btn' href='GSupdate.php?id={$row['book_id']}&section={$librarySection}'>Update</a>";

                   
                    echo '<button class="delete-button" type="submit" name="delete_gs_book" value="' . $row["book_id"] . '">Delete</button>';

                    echo '</td>';
                    echo '</tr>';
                    echo '</form>';
                }

                echo '</tbody></table></div>';
            } else {
                echo '<script type="text/javascript">alert("No books found in the selected Graduate School Library section.");</script>';
            }
        } else {
            
            echo '';
        }
    } else {
        
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_gs_book"])) {
    $bookToDelete = $_POST["delete_gs_book"];
    $sql = "DELETE FROM $tableName WHERE book_id = $bookToDelete";
    if ($conn->query($sql) === TRUE) {
        echo '<script type="text/javascript">alert("Book deleted successfully.");</script>';
    } else {
        echo '<script type="text/javascript">alert("Error deleting book: ' . $conn->error . '");</script>';
    }
}
?>



<form class="custom-form-GraduateLibrary" action="UpdateDelete.php" method="POST">
    <label class="custom-label-GraduateLibrary" for="gs_action">Choose Graduate School Library Section:</label>
    <select class="custom-select-GraduateLibrary" name="gs_action" id="gs_action">
        <option value="GraduateSchool_Reserve">Reserve</option>
        <option value="GraduateSchool_Circulation">Circulation</option>
        <option value="GraduateSchool_Filipinana">Filipinana</option>
        <option value="GraduateSchool_Reference">Reference</option>
        <option value="GraduateSchool_Archives">Archives</option>
        <option value="GraduateSchool_Periodicals">Periodicals</option>
        <option value="GraduateSchool_ThesisDissertation">Thesis/Dissertation</option>
    </select>
    <input class="custom-button" type="submit" value="Display">
</form>


<!------------------------------------------------------------------GRADUATE Library Form ------------------------------------------------>

        <button class="close-btn" onclick="window.location='../Admin Main.php'">Hide</button>
    </div>








</body>
</html>