

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/forgot.css?v= <?php echo time(); ?>">
    <link rel="icon" type="image" href="pics/WIT-Logo.png">
    <title>Sign Up</title>
</head>
<body>


<div class="side-logo"> 
    <img src="Images/WIT-Logo.png" class="bar_logo">     
</div>

<div class="container">
    <div class="title">Forgot Password?</div>
    <div class="content">

        <form action="FindAcc.php" method="post">

            <div class="user-details">
                <div class="input-box">
                    <span class="details" for="email">Find your account using your email.</span>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
            </div>

            <div class="button">
                <input type="submit" value="Find...">
            </div>

        </form>

    </div>
</div>
    
</body>
</html>