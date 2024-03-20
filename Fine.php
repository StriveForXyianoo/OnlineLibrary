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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="icon" type="image" href="Pics/WIT-Logo.png">
    <title>Borrowing Rights</title>
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


<div class="container-fine">
        <div class="blur-box">
            <div class="content">
        
    <h2>Fines</h2>

    <br>

    <p>1. Overdue fees apply to late returns of materials:</p>

    <p>Php5.00/Day-General Circulation Books</p>
    <p>Php5.00/Hour-Reserve Books</p>

    <br>

    <p>2. When the ULRC is available for service, the Fine is assessed.</p>

    <br>

    <p>3. Until all library accounts are resolved, borrowers who have overdue books or an existing debt to the library will not be permitted to borrow.</p>


</div>
        </div>

        </div>

</body>
</html>