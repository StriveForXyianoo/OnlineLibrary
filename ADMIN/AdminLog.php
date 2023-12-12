<?php
$hostname = "localhost"; // Replace with your database hostname
$username = "root"; // Replace with your database username
$password = "witlibrary2023password"; // Replace with your database password
$database = "database_users"; // Replace with your database name

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

// Check if the user is already logged in, redirect to AdminMain.php
if (isset($_SESSION["username"])) {
    header("Location: Admin Main.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM admin_db WHERE user_name = ? AND pass = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Store the result
    mysqli_stmt_store_result($stmt);

    // Check if there is a match
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Authentication successful
        $_SESSION["username"] = $username;
        header("Location: Admin Main.php");
        exit();
    } else {
        $login_error = "Login failed. Please check your user name and password.";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Log.css?v= <?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image" href="pics/WIT-Logo.png">
    <title>Admin Login</title>
</head>
<body>
<div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="Images/WIT-Logo.png" alt="">
        <div class="text">
          <span class="text-1">Welcome <br> WIT Librarians</span>
          <span class="text-2">Let's get connected</span>
        </div>
      </div>
      <div class="back">
        <img class="backImg" src="" alt="">
        <div class="text">
          <span class="text-1">Complete miles of journey <br> with one step</span>
          <span class="text-2">Let's get started</span>
        </div>
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
 
          <div class="login-form">
          <div class="back-link" onclick="window.location.href='../Main Page.php';">
          <i class="fas fa-user-lock admin-icon custom-font-style"> &nbsp;Main Page</i>
                </div>
            <div class="title">For Library Staffs only!</div>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fas fa-envelope"></i>
                <input type="text" name="username" placeholder="Enter the user name" required>
              </div>
              <div class="input-box">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
            <i class="fas fa-eye eye-icon" id="togglePassword"></i>
        </div>
            
              <div class="button input-box">
                <input type="submit" value="Submit">
              </div>
             
            </div>
            <?php
    if (isset($login_error)) {
        echo "<p class='error-message'>$login_error</p>";
    }
    ?>
        </form>
        <script>
    const passwordInput = document.getElementById("password");
    const togglePasswordButton = document.getElementById("togglePassword");

    togglePasswordButton.addEventListener("click", function () {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);

        setTimeout(function () {
            passwordInput.setAttribute("type", "password");
        }, 5000); // Display password for 5 seconds
    });
</script>

      </div>
       
    </div>
  </div>

</body>
</html>
