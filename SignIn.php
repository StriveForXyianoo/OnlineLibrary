<?php
require_once "Configure.php";

if (isset($_POST["signup"])) {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $middleinitial = $_POST["middle_initial"];
    $addr = $_POST["addr"];
    $email = $_POST["email"];
    $idnum = $_POST["idnum"];
    $course = $_POST["course"];
    $pass = $_POST["pass"];
    $gender = $_POST["gender"];
    $users_num = $_POST["number"];
    $suffix = $_POST["suffix"];

    // Handle file upload for profile picture
    $users_rf_tmp = $_FILES["profile_rf"]["tmp_name"];
    $users_rf_content = file_get_contents($users_rf_tmp);

    // Check for file upload errors
    if ($_FILES['profile_rf']['error'] !== UPLOAD_ERR_OK) {
        echo 'Upload failed with error code ' . $_FILES['profile_rf']['error'];
    }

    $sql_check = "SELECT * FROM users_db WHERE idnum='$idnum' OR email='$email'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        echo "<script> alert('User with the given Identification Number or Email already exists. Please choose a different Identification Number or Email.'); </script>";
    } else {
       
        $sql = "INSERT INTO users_db (id, fname, lname, middle_initial, addr, email, idnum, course, pass, gender, users_num, users_rf, status, suffix)
                VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssssssssssss', $fname, $lname, $middleinitial, $addr, $email, $idnum, $course, $pass, $gender, $users_num, $users_rf_content, $suffix);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script> alert('Successfully Registered. Wait for an email for confirmation to approve your account.'); </script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/Signup.css?v= <?php echo time(); ?>">
    <link rel="icon" type="image" href="WIT-Logo.png">
    <title>Sign Up</title>
</head>
<body>


<div id="reminder-container">
    <p>
    <strong id="reminder-icon">&#9888;</strong> 
        <strong>Reminder:</strong><br>
        &nbsp; &nbsp;&nbsp;Please fill out every field marked in red. You must include these details in your online application. <br> 
        &nbsp;&nbsp;&nbsp;Your application may be delayed or rejected if you provide false information or misrepresentation in your profile.
    </p>
    <button id="noted-btn">Noted</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var reminderContainer = document.getElementById('reminder-container');
        var notedBtn = document.getElementById('noted-btn');

        // Show the reminder container
        reminderContainer.style.display = 'block';

        // Event listener for the "Noted" button
        notedBtn.addEventListener('click', function () {
            // Hide the reminder container
            reminderContainer.style.display = 'none';
        });
    });
</script>
    <div class="logo"> 
    <img src="WIT-Logo.png" class="bar_logo">     
</div>
    <ul class="links">
        <li href=""><a onclick="window.location='Main Page.php'">Home</a></li>
    </ul>
  
</div>



<div class="container">
    <div class="title">Library Registration</div>
    <div class="content">
    <form action="SignIn.php" method="post" enctype="multipart/form-data">


        <div class="user-details">

          <div class="input-box">
            <span class="details"><span style="color: red; font-weight: bold;">*</span>&nbsp;First Name</span>
            <input type="text" placeholder="Enter your first name" name="fname" required>
          </div>


          <div class="input-box">
            <span class="details"> <span style="color: red; font-weight: bold;">*</span>&nbsp;Last Name</span>
            <input type="text" placeholder="Enter your last name" name="lname"  required>
          </div>


          <div class="input-box">
  <label for="middle_initial" class="details"><span style="color: red; font-weight: bold;">*</span>&nbsp;Middle Initial</label>
  <input type="text" placeholder="Enter your middle initial only" name="middle_initial" maxlength="1" required>
</div>




          <div class="input-box suffix-dropdown">
          <label for="suffix"><span style="color: red; font-weight: bold;">*</span>&nbsp;Select Suffix</label>
  <select id="suffix" name="suffix" required>
  <option value="" selected>Select a suffix (optional)</option>
  <option value="">None</option>
    <option value="Jr.">Jr. (Junior)</option>
    <option value="Sr.">Sr. (Senior)</option>
    <option value="II">II (Second)</option>
    <option value="III">III (Third)</option>
    <option value="Esq.">Esq. (Esquire)</option>
    <option value="Ph.D.">Ph.D. (Doctor of Philosophy)</option>
    <option value="M.D.">M.D. (Doctor of Medicine)</option>
    <option value="D.D.S.">D.D.S. (Doctor of Dental Surgery)</option>
    <option value="DDS">DDS (Dentist)</option>
    <option value="MD">MD (Medical Doctor)</option>
    <option value="RN">RN (Registered Nurse)</option>
  
  </select>
  
</div>


          <div class="input-box">
            <span class="details"><span style="color: red; font-weight: bold;">*</span>&nbsp;Email</span>
            <input type="text" placeholder="Enter your username" name="email" required>
          </div>


          <div class="input-box">
            <span class="details"><span style="color: red; font-weight: bold;">*</span>&nbsp;Address</span>
            <input type="text" placeholder="Street/Barangay/Municipality/Province/Country" name="addr" required>
          </div>


          <div class="input-box">
           <span class="details"><span style="color: red; font-weight: bold;">*</span>&nbsp;Phone Number</span>
          <input type="text" placeholder="Enter your number" name="number" maxlength="11" required>
            </div>

          <div class="input-box">
            <span class="details"><span style="color: red; font-weight: bold;">*</span>&nbsp;Identification Number</span>
            <input type="number" placeholder="Enter your ID Number"  name="idnum" required>
          </div>
          
          <div class="input-box">
  <span class="details"><span style="color: red; font-weight: bold;">*</span>&nbsp;Password</span>
  <input type="password" placeholder="Enter your password" name="pass" id="pass" required>
  <i class="fas fa-eye toggle-password-icon" data-target="pass"></i>
</div>

<div class="input-box">
  <span class="details"><span style="color: red; font-weight: bold;">*</span>&nbsp;Confirm Password</span>
  <input type="password" placeholder="Confirm your password" name="confirm_pass" id="confirm_pass" required>
  <i class="fas fa-eye toggle-password-icon" data-target="confirm_pass"></i>
  <span id="password_error" class="error"></span>
</div>


          <div class="input-box">
            <span class="details"><span style="color: red; font-weight: bold;">*</span>&nbsp;Upload Current Semester RF Picture</span>
            <input type="file" name="profile_rf" accept="image/jpeg, image/png" required><br>
          </div>

          <div class="input-box course-dropdown">
    <label for="course"><span style="color: red; font-weight: bold;">*</span>&nbsp;Course</label>
    <select name="course" id="course" required>
        <option value="" disabled selected>Select your course</option>
        <option value="BS Accountancy">Bs Accountancy</option>
        <option value="BS Biology">BS Biology</option>
        <option value="BS Business Administration">BS Business Administration</option>
        <option value="BS Civil Engineering">BS Civil Engineering</option>
        <option value="BS Computer Engineering">BS Computer Engineering</option>
        <option value="BS Electrical Engineering">BS Electrical Engineering</option>
        <option value="AB English Language">AB English Language</option>
        <option value="BS Hospitality Management">BS Hospitality Management</option>
        <option value="BS Information Technology">BS Information Technology</option>
        <option value="BS Marine Engineering">BS Marine Engineering</option>
        <option value="BS Mechanical Engineering">BS Mechanical Engineering</option>
        <option value="AB Political Science">AB Political Science</option>
        <option value="Master in Business Management (MBM)">Master in Business Management (MBM)</option>
        <option value="Master of Engineering (MEng)">Master of Engineering (MEng)</option>

    </select>
</div>

          
          <div class="gender-details">
    <input type="radio" name="gender" id="dot-1" value="Male">
    <input type="radio" name="gender" id="dot-2" value="Female">
   
    <span class="gender-title"><span style="color: red; font-weight: bold;">*</span>&nbsp;Gender</span>
    <div class="category">
        <label for="dot-1">
            <span class="dot one"></span>
            <span class="gender">Male</span>
        </label>

        <label for="dot-2">
            <span class="dot two"></span>
            <span class="gender">Female</span>
        </label>
    </div>
</div>



        <div class="button">
          <input type="submit" name="signup" value="Sign Up">
        </div>

      </form>
      <script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('form').onsubmit = function () {
      var password = document.getElementById("pass").value;
      var confirmPassword = document.getElementById("confirm_pass").value;

      if (password !== confirmPassword) {
        // Display an alert instead of setting innerHTML
        alert("Passwords do not match");
        return false;
      } else {
        return true;
      }
    };

    document.querySelectorAll('.toggle-password-icon').forEach(function (icon) {
      icon.addEventListener('click', function () {
        var targetId = this.getAttribute('data-target');
        var passwordInput = document.getElementById(targetId);

        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
          setTimeout(function () {
            passwordInput.type = 'password';
          }, 5000); // Show password for 5 seconds

          // Toggle active class for visual indication
          this.classList.add('active');
          setTimeout(function () {
            icon.classList.remove('active');
          }, 5000);
        }
      });
    });
  });
</script>


    </div>
  </div>
    
</body>
</html>