<?php
ob_start();
require 'connect_db.php';
session_start();

$sql = "SELECT * FROM presensi where id = '$_GET[id]'";
$result = mysqli_query($conn, $sql);

if (isset($_SESSION['login'])) {
} else {
    die("Can't Access, please <a href='login.php'>Login here</a>");
}

$sql2 = "SELECT * FROM user where email = '$_SESSION[login]'";
$result2 = mysqli_query($conn, $sql2);

$tglErr = $makulErr = "";
$valid_tgl = $valid_makul = false;
$message = "";

if (isset($_POST['submit'])) {
    if (empty($_POST['tgl'])) {
        $valid_tgl = false;
        $tglErr = "*required field";
    } else {
        $valid_tgl = true;
    }

    if (empty($_POST['makul'])) {
        $valid_makul = false;
        $makulErr = "*required field";
    } else {
        $valid_makul = true;
    }
}

if (isset($_GET["success"])) {
    $message = '
  <div class="alert alert-success alert-dismissible">
    <a href="index.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Selesai di ubah
  </div>
  ';
}

if ($result->num_rows > 0) {

    $attrWebProg = $attrProgLab = $attrSoftDev = "";
    while ($row = mysqli_fetch_assoc($result)) {

        switch ($row['makul']) {
            case 'WebProg':
                $attrWebProg = "selected";
                break;
            case 'ProgLab':
                $attrProgLab = "selected";
                break;
            case 'SoftDev':
                $attrSoftDev = "selected";
                break;
        }
        $nnim = $row['nim'];
        $nnama = $row['nama'];
    }
?>

    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Input | Presensi Mahasiswa</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

        <style>
            .error {
                color: red;
            }
        </style>
    </head>

    <body class="bg-dark">
        <h1></h1>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

        <div class="container">
            <div class="card card-register mx-auto mt-5">
                <div class="card-header text-center">
                    <h4>Pengisian Kehadiran Mahasiswa</h4>
                    <span><?= $message ?></span>
                    <?php
                    if (isset($_SESSION['login'])) {
                        while ($row = mysqli_fetch_assoc($result2)) { ?>
                            User: <?= $row['name']; ?><br>
                        <?php  }
                    } else { ?>
                        <a href="admin/login.php">Login</a><br>
                    <?php } ?>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <!-- <div class="form-group"> -->
                        <div class="row form-row mb-1">
                            <div class="col-md-4">
                                <div class="form-label-group">
                                    <select name="makul" id="makul" class="form-control" autofocus="autofocus">
                                        <option value=""> -- Pilih Mata Kuliah -- </option>
                                        <option value="WebProg" <?= $attrWebProg ?>> Pemrograman Web </option>
                                        <option value="WebProgLab" <?= $attrProgLab ?>> Praktik Pemrograman Web </option>
                                        <option value="SoftDev" <?= $attrSoftDev ?>> Rekayasa Perangkat Lunak </option>
                                    </select>
                                    <span class="error"><?= $makulErr ?></span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row text-center">
                            <div class="col-md-4"><strong>Nomor Induk Mahasiswa</strong></div>
                            <div class="col-md-4"><strong>Nama Lengkap</strong></div>
                            <div class="col-md-4"><strong>Status Presensi</strong></div>
                        </div>
                        <hr>

                        <div class="row form-row mb-1">
                            <div class="col-md-4">
                                <div class="form-label-group">
                                    <input type="text" readonly id="nim" name="nim" class="form-control" placeholder="NIM" autofocus="autofocus" value="<?= $nnim ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-label-group">
                                    <input type="text" readonly id="nama" name="nama" class="form-control" placeholder="Nama" autofocus="autofocus" value="<?= $nnama ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-label-group">
                                    <select name="presensi" id="presensi" class="form-control" autofocus="autofocus">
                                        <option value="Hadir"> Hadir </option>
                                        <option value="Sakit"> Sakit </option>
                                        <option value="Izin"> Izin </option>
                                        <option value="Alpa"> Alpa </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>

                        <p class="text-center">
                            <input type="submit" name="submit" value="Simpan Presensi" class="btn btn-primary btn-block">
                        </p>
                        <!-- <a class="btn btn-secondary btn-block" href="users.php">Cancel</a> -->
                    </form>
                    <div class="text-center">
                        <br>Copyright © Program Studi Teknik Informatika - <?= date('Y'); ?><br>
                    </div>
                </div>
            </div>

            <?php
            if ($valid_makul == true) {
                include 'insert_edit_presensi.php';
            }
            ?>

    </body>

    </html>

<?php
} else {
    echo "0 results";
}
mysqli_close($conn);
?>