<?php
include '../Configure.php';
$id = $_GET["id"];

if (isset($_POST["submit"])) {
  $first_name = $_POST['fname'];
  $last_name = $_POST['lname'];
  $middle_initial = $_POST['middle_initial'];
  $addr = $_POST['addr'];
  $email = $_POST['email'];
  $course = $_POST['course'];
  $idnum = $_POST['idnum'];
  $users_num = $_POST['users_num'];
  $pass = $_POST['pass'];
  $users_balance = $_POST['users_balance'];
  $users_lost = $_POST['users_lost'];
  $users_penalty = $_POST['users_penalty'];
  $users_onhand = $_POST['users_onhand'];

  $sql = "UPDATE `users_db` SET `fname`='$first_name',`lname`='$last_name',`middle_initial`='$middle_initial', `addr`='$addr', `email`='$email', `course`='$course', `idnum`='$idnum',
   `pass`='$pass',`users_num`='$users_num', `users_balance`='$users_balance', `users_lost`='$users_lost', `users_penalty`='$users_penalty', `users_onhand`='$users_onhand'  WHERE id = $id";


  $result = mysqli_query($conn, $sql);

  if ($result) {
    echo '<script>alert("Data Updated Successfully");</script>';
    header("Location: UsersConfiguration.php");
} else {
    echo '<script>alert("Something went wrong. Try Again");</script>';
    echo "Failed: " . mysqli_error($conn);
}
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/main.css?v= <?php echo time(); ?>">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Users Configuration</title>
</head>

<body>
  <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #ff7700;">
  WIT Users Information & Configuration


  <div class="back-btn" ><a href="Admin Main.php">Back to Main Panel</a></div>
  </nav>

  <div class="container">
    <div class="text-center mb-4">
      <h3>Edit User Information</h3>
      <p class="text-muted">Click update after changing any information</p>
    </div>

    <?php
    $sql = "SELECT * FROM `users_db` WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    ?>

    <div class="container d-flex justify-content-center">
      <form action="" method="post" style="width:50vw; min-width:300px;">
        <div class="row mb-3">
          <div class="col">
            <label class="form-label">First Name:</label>
            <input type="text" class="form-control" name="fname" value="<?php echo $row['fname'] ?>">
          </div>

          <div class="col">
            <label class="form-label">Middle Initial:</label>
            <input type="text" class="form-control" name="middle_initial" value="<?php echo $row['middle_initial'] ?>">
          </div>
        </div>

          <div class="col">
            <label class="form-label">Last Name:</label>
            <input type="text" class="form-control" name="lname" value="<?php echo $row['lname'] ?>">
          </div>
        </div>



        <div class="mb-3">
          <label class="form-label"><Address></Address>Address:</label>
          <input type="text" class="form-control" name="addr" value="<?php echo $row['addr'] ?>">
        </div>

        <div class="mb-4">
          <label class="form-label">Email:</label>
          <input type="email" class="form-control" name="email" value="<?php echo $row['email'] ?>">
        </div>

        <div class="mb-5">
          <label class="form-label">Course:</label>
          <input type="text" class="form-control" name="course" value="<?php echo $row['course'] ?>">
        </div>

        <div class="mb-6">
          <label class="form-label">ID #:</label>
          <input type="text" class="form-control" name="idnum" value="<?php echo $row['idnum'] ?>">
        </div>

        <div class="mb-7">
          <label class="form-label">Phone Number:</label>
          <input type="text" class="form-control" name="users_num" value="<?php echo $row['users_num'] ?>" maxlength="11">

        </div>


        <!---- USERS STATUS ---->

        <div class="mb-8">
          <label class="form-label">Users Balance: </label>
          <input type="number" class="form-control" name="users_balance" value="<?php echo $row['users_balance'] ?>">
        </div>
        <div class="mb-9">
          <label class="form-label">Users Penalty</label>
          <input type="number" class="form-control" name="users_penalty" value="<?php echo $row['users_penalty'] ?>">
        </div>
        <div class="mb-10">
          <label class="form-label">Users Lost Books</label>
          <input type="number" class="form-control" name="users_lost" value="<?php echo $row['users_lost'] ?>">
        </div>



        <div class="mb-11">
          <label class="form-label">Users On-Hand Books: </label>
          <input type="number" class="form-control" name="users_onhand" value="<?php echo $row['users_onhand'] ?>">
        </div>


        <!---- ---->

        <div class="mb-6">
          <label class="form-label">Password</label>
          <input type="text" class="form-control" name="pass" value="<?php echo $row['pass'] ?>">
        </div>

        <div>
          <button type="submit" class="btn btn-success" name="submit">Update</button>
          <a href="Admin Main.php" class="btn btn-danger">Cancel</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>