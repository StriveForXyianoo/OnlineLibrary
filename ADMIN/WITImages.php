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
    <img src="Pics/WIT-LOGO.png" class="mainlogo" alt="">
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
include '../Configure.php';


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

<div id="WITImagesUpdatesForm" class="form-container-images">

<?php

if (isset($_FILES['file'])) {
$uploadDirectory = 'Pics/'; 
$uploadedFile = $uploadDirectory . basename($_FILES['file']['name']);


$imageFileType = strtolower(pathinfo($uploadedFile, PATHINFO_EXTENSION));
$allowedExtensions = array('jpg', 'jpeg', 'png'); 
if (in_array($imageFileType, $allowedExtensions)) {
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadedFile)) {
        
       

        
        $imagePath = mysqli_real_escape_string($conn, $uploadedFile);
        $imageName = mysqli_real_escape_string($conn, $_FILES['file']['name']);

        
        $sql = "INSERT INTO images (image_name, image_path) VALUES ('$imageName', '$imagePath')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Image Successfully Uploaded.');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

       
        $conn->close();
    } else {
        echo "<script>alert('Error Uploading Image.');</script>";
    }
} else {
    echo "<script>alert('Only JPG, JPEG, and PNG files are allowed.');</script>";
}
} 
?>
<br>

<div class="upload-text">
<h2>Upload Picture below.</h2>
</div>
<form action="WITImages.php" method="POST" enctype="multipart/form-data">
<input type="file" class="upload-btn" id="file" name="file" accept="image/*" onchange="previewImage()">

<img id="image-preview" class="box" src="Images" alt="Select Image then it will display here.">

<button id="submitButton" type="submit" value="Submit" class="submit-button">Submit</button>
</form>




    <?php




if (isset($_POST['delete_image'])) {
$imageId = $_POST['image_id'];


$sql = "DELETE FROM images WHERE id = $imageId";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Image Successfully Deleted.');</script>";
} else {
    echo "Error deleting image: " . $conn->error;
}
}


$sql = "SELECT * FROM images";
$result = $conn->query($sql);
?>

<div class="table-container-images">
    <table>
    <tr>
        
        <th>Image</th>
        <th>Description</th>
        <th>Action</th>
    </tr>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";

        echo '<td><img src="' . $row["image_path"] . '" alt="' . $row["image_name"] . '"></td>';
        echo "<td>" . $row['image_path'] . "</td>";
        echo "<td>
                <form method='POST'>
                    <input type='hidden' name='image_id' value='" . $row['id'] . "'>
                    <input type='submit' name='delete_image' value='Delete'>
                </form>
              </td>";
        echo "</tr>";
    }
    ?>
</table>
</div>


</div>


<!----------------------------------------------------------------------------------------------------------------------------------->


</body>
</html>