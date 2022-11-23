<?php
session_start();

// define variable
$email = $password = "";
$emailErr = $passwordErr = "";
$valid_email = $valid_password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["email"])) {
    $emailErr = "*Email is required";
    $valid_email = false;
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "*Invalid email format";
      $valid_email = false;
    }
  }

  if (empty($_POST["password"])) {
    $passwordErr = "*Password is required";
  }

  require "connect_db.php";
  $password = sha1($_POST['password']);
  $email = $_POST['email'];
  $sql = "SELECT * from user where email = '$email' AND password = '$password'";
  $result =  mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    if ($row['role'] == 'Admin') {
      $_SESSION['login'] = $row['email'];
      $_SESSION['role'] = "Admin";
      header('location: admin_panel.php');
    }

    if ($row['role'] == 'Dosen') {
      $_SESSION['login'] = $row['email'];
      $_SESSION['role'] = "Dosen";
      header('location: index.php');
    }
  } else {
    // var_dump($password);
    $passwordErr = "*invalid";
  }
  mysqli_close($conn);
}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">

  <style>
    .error {
      color: #FF0000;
    }
  </style>

</head>

<body>
  <?php
  if (isset($_SESSION['login']) && ($_SESSION['role'] == 'Admin')) {
    header('location: admin_panel.php');
  }
  if (isset($_SESSION['login']) && ($_SESSION['role'] == 'Dosen')) {
    header('location: index.php');
  }
  ?>

  <div class="header">
    <!--Content before waves-->

    <div class="container col-md-6 col-11 py-1">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header" style="color: black;">Login</div>
        <div class="card-body">
          <form method="post" action="">
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" name="email" id="Email" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
                <label for="Email">Email</label>
                <span class="error"><?php echo $emailErr; ?></span>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" value="<?php echo $password; ?>">
                <label for="inputPassword">Password</label>
                <span class="error"><?php echo $passwordErr; ?></span>
              </div>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label style="color: black">
                  <input type="checkbox" value="remember-me">
                  Remember Password
                </label>
              </div>
            </div>
            <input type="submit" name="submit" value="Login" class="btn btn-primary btn-block">
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="register.php">Register an Account</a>
            <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
          </div>
        </div>
      </div>
    </div>

    <!--Waves Container-->
    <div>
      <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
        <defs>
          <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
        </defs>
        <g class="parallax">
          <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
          <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
          <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
          <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
        </g>
      </svg>
    </div>
    <!--Waves end-->
  </div>
  <!--Header ends-->


  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>