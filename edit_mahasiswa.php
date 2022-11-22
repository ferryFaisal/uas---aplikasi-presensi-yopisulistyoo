<?php
ob_start();
require "connect_db.php";

$namaErr = $kelasErr = "";
$valid_nama = $valid_kelas = "";


$sql = "SELECT * FROM mahasiswa WHERE nim = '$_GET[nim]'";
$result =  mysqli_query($conn, $sql);
$attrAdmin = $attrDosen =  "";
// if ($result->num_rows > 0) {
//     while ($row = mysqli_fetch_assoc($result)) {
//         $nnim = $row['nim'];
//         $nnama = $row['nama'];
//         $nkelas = $row['kelas'];
//     }
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nama"])) {
        $namaErr = "*name is required";
        $valid_nama = false;
    } else {
        $nama = test_input($_POST["nama"]);
        $valid_nama = true;
    }

    if (empty($_POST["kelas"])) {
        $kelasErr = "*Kelas is Required";
    } else {
        $kelas = test_input($_POST["kelas"]);
        $valid_kelas = true;
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
                <div class="card-header" style="color: black;">Update Mahasiswa</div>
                <div class="card-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="text" name="nim" id="nim" class="form-control" placeholder="NIM" value="<?php echo $nim; ?>" readonly>
                                <label for="NIM">NIM</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="text" name="nama" id="Fullname" class="form-control" placeholder="Full name" value="<?php echo $nama; ?>">
                                <label for="Fullname">Full name</label>
                                <span class="error"><?php echo $namaErr; ?></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input type="text" name="kelas" id="Kelas" class="form-control" placeholder="Full name" value="<?php echo $kelas; ?>">
                                <label for="Kelas">Kelas</label>
                                <span class="error"><?php echo $kelasErr; ?></span>
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
    if ($valid_nama && $valid_kelas == true) {
        include 'updatemahasiswa_action.php';
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