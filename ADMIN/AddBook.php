


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
<script src="javascripts/add.js"></script>


<div class="note"><a class="takenote"  onclick="openForm('NoteTop')">Note!</a></div>

<div id="NoteTopForm" class="form-container-note">
        
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
    <a  href="RTSadd.php" class="topnav-button">RTS Library</a>
  </div>


  <div class="topnav-column">
    <a  href="GradAdd.php" class="topnav-button">Graduate School Library</a>
  </div>
</div>

<!--------------------------------------------------------------------------------------------------------------->






</body>
</html>