<?php
ob_start();
require "connect_db.php";

$nameErr = $emailErr  = $passErr = $roleErr = "";
$name = $email = $pass = $confpass = $role = "";
$valid_name = $valid_password = $valid_role = false;
$pass_same = $pass_notsame = "";


$sql = "SELECT * FROM user WHERE email = '$_GET[email]'";
$result =  mysqli_query($conn, $sql);
$attrAdmin = $attrDosen =  "";
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        switch ($row['role']) {
            case 'Admin':
                $attrAdmin = "selected";
                break;
            case 'Dosen':
                $attrDosen = "selected";
                break;
        }
        $nname = $row['name'];
        $npass = $row['password'];
        $nemail = $_GET['email'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $passErr = "*Password is required";
        $valid_password = false;
    } else {
        $pass = test_input($_POST["password"]);
        if ($_POST['password'] == $_POST['confpass']) {
            $valid_password = true;
        } else {
            $valid_password = false;
            $passErr = "*Password is not same";
        }
    }

    if (empty($_POST["role"])) {
        $roleErr = "*Role is Required";
    } else {
        $role = test_input($_POST["role"]);
        $valid_role = true;
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
            <div class="card card-register mx-auto mt-5">
                <div class="card-header" style="color: black;">Update User</div>
                <div class="card-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="text" name="email" id="Email" class="form-control" placeholder="Email" value="<?php echo $email; ?>" readonly>
                                <label for="Email">Email</label>
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
                                        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password">
                                        <label for="inputPassword">Password</label>
                                        <span class="error"><?php echo $passErr; ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group">
                                        <input type="password" name="confpass" id="confirmPassword" class="form-control" placeholder="Confirm password">
                                        <label for="confirmPassword">Confirm password</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <select name='role' class="form-select">
                                    <option value=""> -Select a role- </option>
                                    <option value="Admin" <?= $attrAdmin ?>>Admin</option>
                                    <option value="Dosen" <?= $attrDosen ?>>Dosen</option>
                                </select>
                                <span class="error"><?php echo $roleErr; ?></span>
                            </div>
                        </div>
                        <input type="submit" name="submit" value="Update" class="btn btn-primary btn-block">
                    </form>
                    <div class="text-center">
                        <a class="d-block small mt-3" href="login.html">Login Page</a>
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

    <?php
    if ($valid_name && $valid_password && $valid_role == true) {
        include 'insert_data_user.php';
    }

    mysqli_close($conn);
    ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>