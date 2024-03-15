<?php

session_start();

$host = "localhost"; 
$username = "root";
$password = "witlibrary2023password";
$database = "database_users"; 
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['login'])) {
    $username = $_POST['idnum'];
    $password = $_POST['pass'];

   
    $query = "SELECT lname, fname, addr, email, users_balance, users_lost, users_penalty, users_onhand, users_rf, status, course, users_num, suffix FROM users_db WHERE idnum = ? AND pass = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->bind_result($lastName, $firstName, $address, $email, $usersBalance, $usersLost, $usersPenalty, $usersOnhand, $profileImage, $status, $course, $usersNum, $suffix);

    if ($stmt->fetch()) {
        if ($status === 'Approved') {
           
            $_SESSION['lname'] = $lastName;
            $_SESSION['fname'] = $firstName;
            $_SESSION['addr'] = $address;
            $_SESSION['email'] = $email;
            $_SESSION['users_balance'] = $usersBalance;
            $_SESSION['users_lost'] = $usersLost;
            $_SESSION['users_penalty'] = $usersPenalty;
            $_SESSION['users_onhand'] = $usersOnhand;
            $_SESSION['profile_image'] = $profileImage;
            $_SESSION['course'] = $course;
            $_SESSION['idnum'] = $username;
            $_SESSION['users_num'] = $usersNum;
            $_SESSION['suffix'] = $suffix;

           
            header("Location: Dashboard.php");
            exit();
        } elseif ($status === 'Pending') {
           
            echo "<script>alert('Your account is pending approval. Please wait for confirmation to log in.');</script>";
        } else {
           
            echo "<script>alert('Your account has been rejected. Please contact the admin for more information.');</script>";
        }
    } else {
   
        $query = "SELECT idnum FROM users_db WHERE idnum = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
           
            echo "<script>alert('You are not registered in the system.');</script>";
        } else {
         
            echo "<script>alert('Incorrect password.');</script>";
        }
    }

    $stmt->close();
}

$conn->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Main.css?v= <?php echo time(); ?>">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
     integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" 
     crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link rel="icon" type="image" href="WIT-Logo.png">
    <title>WIT Library</title>
</head>
<body id="particles-js">

<script type="text/javascript"  src="javascripts/Functions.js"></script>

<header>
<div class="navbar">
    <div class="logo"> 
    <img src="WIT-Logo.png" class="bar_logo">     
</div>
    <ul class="links">
        <li href=""><a href="">Home</a></li>
       <li> <a href="#" onclick="scrollToContent()">Mission/Vision</a> </li>
       <li> <a href="#" onclick="scrollToContentLog()">Log In</a> </li>
       <li> <a href="#" onclick="scrollToNewContent()">Latest Updates</a></li>
      
        <li href=""><a onclick="window.location='SignIn.php'">Sign Up</a></li>
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
<li href=""><a href="">Home</a></li>
       <li> <a href="#" onclick="scrollToContent()">Mission/Vision</a> </li>
       <li> <a href="#" onclick="scrollToNewContent()">Latest Updates</a></li>
       <li> <a href="#" onclick="scrollToContentLog()">Log In</a> </li>
        <li ><a onclick="window.location='Signuser.php'">Sign Up</a></li>
        
</div> 
<script>
// Function to scroll to a specific content section

</script>
</header>
<!------------------------------------------------------------------------------------------------------------------------>

<!--- MAIN CONTENT --->

<div class="main_title">
    <h1>WIT ONLINE LIBRARY</h1>
</div>


    <div class="below-text">
        Find Academic Books, Articles, And Journals On A Single, Seamless Platform
    </div>


<!--- MAIN CONTENT --->
<!---------------------------------------------------------------------------------------------------------------------->
<div id="contentLog">

<div class="animated bounceInDown">
  <div class="container-login">
    <span class="error animated tada" id="msg"></span>
    <form method="post" name="form1" class="box" onsubmit="return checkStuff()">
      <h4>WIT<span>&nbsp;Library</span></h4>
      <h5>Log in to your account.</h5>

        <input type="text" for="idnum" name="idnum" placeholder="Identification #" autocomplete="off">
     

        <div class="password-container">
        <input type="password" name="pass" id="pwd" placeholder="Password" autocomplete="off">
        <i class="toggle-password fas fa-eye" onclick="togglePasswordVisibility()"></i>
    </div>
 
        <a href="ADMIN/ForgotPass.php" class="forgetpass">Forgot Password?</a>
        <input type="submit" value="Login" name="login" class="btn1">
      </form>
      <script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('pwd');
        var eyeIcon = document.querySelector('.toggle-password');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');

            // Automatically hide the password after 5 seconds
            setTimeout(function() {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }, 5000);
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>


        <a href="SignIn.php" class="dnthave">Don’t have an account? Sign up</a>

        <a href="ADMIN/AdminLog.php" class="dnthave1"><i class="fas fa-user-circle"></i></a>




  </div> 

</div>

<script>
    var pwd = document.getElementById('pwd');
var eye = document.getElementById('eye');

eye.addEventListener('click',togglePass);

function togglePass(){

   eye.classList.toggle('active');

   (pwd.type == 'password') ? pwd.type = 'text' : pwd.type = 'password';
}

// Form Validation

function checkStuff() {
  var email = document.form1.email;
  var password = document.form1.password;
  var msg = document.getElementById('msg');
  
  if (email.value == "") {
    msg.style.display = 'block';
    msg.innerHTML = "Please enter your email";
    email.focus();
    return false;
  } else {
    msg.innerHTML = "";
  }
  
   if (password.value == "") {
    msg.innerHTML = "Please enter your password";
    password.focus();
    return false;
  } else {
    msg.innerHTML = "";
  }
   var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  if (!re.test(email.value)) {
    msg.innerHTML = "Please enter a valid email";
    email.focus();
    return false;
  } else {
    msg.innerHTML = "";
  }
}

// ParticlesJS

// ParticlesJS Config.
particlesJS("particles-js", {
  "particles": {
    "number": {
      "value": 60,
      "density": {
        "enable": true,
        "value_area": 800
      }
    },
    "color": {
      "value": "#ffffff"
    },
    "shape": {
      "type": "circle",
      "stroke": {
        "width": 0,
        "color": "#000000"
      },
      "polygon": {
        "nb_sides": 5
      },
      "image": {
        "src": "img/github.svg",
        "width": 100,
        "height": 100
      }
    },
    "opacity": {
      "value": 0.1,
      "random": false,
      "anim": {
        "enable": false,
        "speed": 1,
        "opacity_min": 0.1,
        "sync": false
      }
    },
    "size": {
      "value": 6,
      "random": false,
      "anim": {
        "enable": false,
        "speed": 40,
        "size_min": 0.1,
        "sync": false
      }
    },
    "line_linked": {
      "enable": true,
      "distance": 150,
      "color": "#ffffff",
      "opacity": 0.1,
      "width": 2
    },
    "move": {
      "enable": true,
      "speed": 1.5,
      "direction": "top",
      "random": false,
      "straight": false,
      "out_mode": "out",
      "bounce": false,
      "attract": {
        "enable": false,
        "rotateX": 600,
        "rotateY": 1200
      }
    }
  },
  "interactivity": {
    "detect_on": "canvas",
    "events": {
      "onhover": {
        "enable": false,
        "mode": "repulse"
      },
      "onclick": {
        "enable": false,
        "mode": "push"
      },
      "resize": true
    },
    "modes": {
      "grab": {
        "distance": 400,
        "line_linked": {
          "opacity": 1
        }
      },
      "bubble": {
        "distance": 400,
        "size": 40,
        "duration": 2,
        "opacity": 8,
        "speed": 3
      },
      "repulse": {
        "distance": 200,
        "duration": 0.4
      },
      "push": {
        "particles_nb": 4
      },
      "remove": {
        "particles_nb": 2
      }
    }
  },
  "retina_detect": true
});
</script>
    </div>

    <button id="scrollButton" onclick="scrollToTop()">Top</button>

    <script>
        function scrollToContentLog() {
            const newContentSection = document.getElementById('contentLog');
            newContentSection.scrollIntoView({ behavior: 'smooth' });
        }
    </script>


<!---------------------------------------------------------------------------------------------------------------------->

<!--- bottom CONTENT --->
<div id="content">
<div class="mission-vision">
<h1 class="mission">WIT Mission</h1>
        <p class="mission_content">&nbsp; &nbsp;&nbsp; &nbsp;The WIT Libraries would support the curricular offerings 
 of the institute as well as the information, research and the recreational needs of the clienteles.</p>

        <h1 class="vision">WIT Vision</h1>
        <p class="vision_content">&nbsp; &nbsp;&nbsp; &nbsp;The WIT Libraries are operationally responsive to 
the research and information needs of the students, faculty and staff, 
trough the provisions of appropriate information technology; professionally managed,
adequately manned and equipped toward the enhancement of quality education.</p>
    </div>
    </div>

    <button id="scrollButton" onclick="scrollToTop()">Top</button>
  

<!---------------------------------------------------------------------------------------------------------------------->
<!--- MISSION VISION CONTENT --->
<div id="new-content" class="new-content-section">
        <!-- Your second content here -->

        <div class="update">
          LATEST UPDATES!! 
        </div>
        <div class="slideshow-container">
        <?php
@include 'Configure.php';

// Fetch images from the database
$sql = "SELECT image_name, image_path FROM images"; 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="mySlides"><img src="' . $row["image_path"] . '"></div>';
    }
}

// Close the database connection
$conn->close();
?>

    </div>

    <script>
        // JavaScript for the automatic slideshow
        var slideIndex = 0;

        function showSlides() {
            var slides = document.getElementsByClassName("mySlides");
            for (var i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }
            slides[slideIndex - 1].style.display = "block";
            setTimeout(showSlides, 2000); // Change image every 2 seconds (adjust as needed)
        }

        // Start the slideshow when the page loads
        window.onload = function () {
            showSlides();
        };
    </script>

 </div>


      <!-- Your second content here -->
    </div>

    <script>
        function scrollToNewContent() {
            const newContentSection = document.getElementById('new-content');
            newContentSection.scrollIntoView({ behavior: 'smooth' });
        }
    </script>

<!--- MISSION VISION CONTENT --->

<!---------------------------------------------------------------------------------------------------------------------->

<!--FOOTER -->
<footer class="footer">
        <p>&copy;  2023 Online Library System. All Rights Reserved.</p>
    </footer>
<!-- FOOTER -->
</body>
</html>