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
        
        <h3 class="h3wit">Western Institute of Technology</h3>

        <h2 class="h2hours">LIBRARY HOURS</h2>

        <h3 class="h3monday">Monday To Friday</h3>

        <p>8:00 A.M - 8:00 P.M</p>

        <h3 class="h3saturday">Saturday</h3>

        <p>8:00 A.M - 5:00 P.M</p>


        <h1 class="h1break">NO NOON BREAK</h1>

        <h2 class="h2loan">Overnight Loans</h2>

        <p class="pmonday">Monday-Friday (6:00 P.M)</p>

            <br>

        <p>Saturday (10:00 A.M)</p>
       
            </div>
        </div>
    </div>


</body>
</html>