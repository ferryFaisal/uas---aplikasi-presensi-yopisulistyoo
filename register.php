<?php
ob_start();
// define variables and set to empty values
$nameErr = $emailErr = $passwordErr = $roleErr = $imageErr = "";
$name = $email = $password = $confpassword = $role = $image = "";
$valid_email = $valid_name = $valid_passwordword = $valid_role = $valid_image = false;
$password_same = $password_notsame = "";

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
    } else {
      require "connect_db.php";
      $sql = "SELECT email FROM user";
      $result =  mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          if ($row["email"] != $email) {
            $valid_email = true;
          } else {
            $valid_email = false;
            $emailErr = "*Email already exist";
            break;
          }
        }
      } else {
        echo "0 results";
      }
      mysqli_close($conn);
    }
  }

  if (empty($_POST["name"])) {
    $nameErr = "*Name is Required";
    $valid_name = false;
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
      $nameErr = "*Only letters and white space allowed";
      $valid_name = false;
    } else {
      $valid_name = true;
    }
  }

  if (empty($_POST["password"])) {
    $passwordErr = "*Password is required";
    $valid_password = false;
  } else {
    $password = test_input($_POST["password"]);
    if ($_POST['password'] == $_POST['confpass']) {
      $valid_password = true;
    } else {
      $valid_password = false;
      $passwordErr = "*Password is not same";
    }
  }

  if (empty($_POST["role"])) {
    $roleErr = "*Role is Required";
  } else {
    $role = test_input($_POST["role"]);
    $valid_role = true;
  }

  $image = $_FILES['file']['name'];
  $target_dir = "images/";
  $target_file = $target_dir . basename($_FILES["file"]["name"]);

  // Select file type
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Valid file extensions
  $extensions_arr = array("jpg", "jpeg", "png", "gif");

  // Check extension
  if (in_array($imageFileType, $extensions_arr)) {
    // Upload file
    move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $image);
    // Insert record
    $valid_image = true;
  } else {
    $imageErr = "*Photo is required or invalid file photo";
    $valid_image = false;
  }
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

  <title>SB Admin - Register</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style-bg.css">

  <style>
    .error {
      color: #FF0000;
    }
  </style>

</head>

<body>

  <div class="header">
    <!--Content before waves-->

    <div class="container col-md-6 col-11 py-1">
      <div class="card card-register mx-auto col-6 mt-5">
        <div class="card-header" style="color: black;">Register an Accounts</div>
        <div class="card-body">
          <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" name="email" id="Email" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
                <label for="Email">Email</label>
                <span class="error"><?php echo $emailErr; ?></span>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" name="name" id="Fullname" class="form-control" placeholder="Full name" value="<?php echo $name; ?>">
                <label for="Fullname">Full name</label>
                <span class="error"><?php echo $nameErr; ?></span>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" value="<?php echo $password; ?>">
                    <label for="inputPassword">Password</label>
                    <span class="error"><?php echo $passwordErr; ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" name="confpass" id="confirmPassword" class="form-control" placeholder="Confirm password" value="<?php echo $confpassword; ?>">
                    <label for="confirmPassword">Confirm password</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <select name='role' class="form-select">
                  <option value=""> -Select a role- </option>
                  <option value="Admin">Admin</option>
                  <option value="Dosen">Dosen</option>
                </select><br>
                <span class="error"><?php echo $roleErr; ?></span>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="file" name="file" id="File">
                <label for="File">Upload Image</label><br>
                <span class="error"><?php echo $imageErr; ?></span>
              </div>
            </div>
            <input type="submit" name="submit" value="Register" class="btn btn-primary btn-block">
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="login.php">Login Page</a>
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
  <!--Content ends-->

  <?php
  if ($valid_email && $valid_name && $valid_password && $valid_image && $valid_role == true) {
    include 'insert_data_user.php';
  }
  ?>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>