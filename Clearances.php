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
    <title>Lost Regulations</title>
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




<div class="container-lost">
        <div class="blur-box">
            <div class="content">
        

       

        <div class="header">
            <h1>CLEARANCES</h1>
           </div>

          <div class="list">
            <div class="list1">1.Only students without liabilities will be given clearance.</div>
           
            <div class="list2">2.Library Borrower's Card should be surrenderd; otherwise,
                <br>Student's copy of the Registered Form(RF) should be presented.<br>
                If both are lost, the student must see the Librarian personally.</div>
            
            <div class="list3">3.Only clearance for the Final examination will be signed  by 
                    the <br>Librarian assigned to each library.</div>
                   
            <div class="list4">4.The general clearance shall be signed by the Chief Librarian <br> and 
                    on the reverse side by the librarian of the said library.</div>
          </div>

       

</div>

</div>

</div>

</body>
</html>