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
   
    $host = "localhost"; 
    $username = "root"; 
    $password = "witlibrary2023password"; 
    $database = "database_users"; 

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
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
    <link rel="stylesheet" href="css/side.css?v= <?php echo time(); ?>">
    <link rel="icon" type="image" href="Pics/WIT-Logo.png">
    <title>Library Hours</title>
</head>
<body>
    
<header>

<div class="navbar">
    <div class="logo"> 
    <img src="WIT-Logo.png" class="bar_logo">     
</div>
    <ul class="links">
        <li href=""><a onclick="window.location='Dashboard.php'">Home</a></li>
        <li>

    </li>
    </ul>
  
</div>

</header>


<div class="container-borrow">
        <div class="blur-box">
            <div class="content">
        

       


        <div class=""><br><br></div>
  
        <div class="header">
            <h3>Western Institute of Technology</h3>
            <h1>LIBRARY HOURS</h1>
           </div>
           <br>
            <div class="div1">
                <p>Monday-Friday<p>
                <p>8:00 A.M - 8:00 P.M</p>
            </div>

            <div class="div2">
                <p>Saturday</p>
                <p>8:00 A.M - 5:00 P.M</p>
            </div>
            <br>
          
            <div class="nnb">
                <h1>NO NOON BREAK</h1>
            </div>
            <span class="divider"></span>
        

            <div class="OL">
                <h2>Overnight Loans</h2>
                <h3>Monday-Friday (6:00 P.M)</h3>
                <h3>Saturday (10:00 A.M)</h3>
            </div>
        



       
            </div>
        </div>
    </div>


</body>
</html>