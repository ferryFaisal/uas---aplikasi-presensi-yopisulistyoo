<?php
ob_start();
require "connect_db.php";

$tglErr = $makulErr = $presensiErr = "";
$valid_tgl = $valid_makul = $valid_presensi = false;

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
    if (empty($_POST['presensi'])) {
        $valid_presensi = false;
        $presensiErr = "*required field";
    } else {
        $valid_presensi = true;
    }
}

$sql1 = " SELECT * FROM presensi WHERE nim = '$_GET[nim]'";
$result = $conn->query($sql1);
if ($result->num_rows > 0) {
    $attrWebProg = $attrProgLab = $attrSoftDev = "";
    $attrHadir = $attrSakit = $attrIzin = $attrAlfa = "";
    while ($row = $result->fetch_assoc()) {
        $nimm = $row['nim'];
        $namaa = $row['nama'];
        //view value which is selected
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
            default:
                $attrWebProg = $attrProgLab = $attrSoftDev = "";
        }
        //view value which is selected
        switch ($row['status_presensi']) {
            case 'Hadir':
                $attrHadir = "selected";
                break;
            case 'Sakit':
                $attrSakit = "selected";
                break;
            case 'Izin':
                $attrIzin = "selected";
                break;
            case 'Alfa':
                $attrAlfa = "selected";
                break;
            default:
                $attrHadir = $attrSakit = $attrIzin = $attrAlfa = "";
        }
    }

?>



    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Form Mahasiswa</title>
        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">
        <style>
            .error {
                color: #FF0000;
            }
        </style>

    </head>

    <body>

        <body class="bg-dark">

            <div class="container">
                <div class="card card-login mx-auto mt-5">
                    <h3 class="card-header ">Update Data Mahasiswa</h3>
                    <div class="card-body">
                        <form action="" method="POST">
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
                            <!-- <hr>
                                <div class="row text-center">
                                    <div class="col-md-4"><strong>Nomor Induk Mahasiswa</strong></div>
                                    <div class="col-md-4"><strong>Nama Lengkap</strong></div>
                                    <div class="col-md-4"><strong>Status Presensi</strong></div>
                                </div>
                                <hr> -->

                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="number" name="nim" readonly class="form-control" autofocus="autofocus" value="<?= $nimm ?>">
                                    <label for="inputnim">NIM</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="text" name="nama" class="form-control" autofocus="autofocus" value="<?= $namaa ?>">
                                    <label for="inputnama">Nama</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <select name="presensi" id="presensi" class="form-control" autofocus="autofocus">
                                        <option value="Hadir" <?= $attrHadir ?>> Hadir </option>
                                        <option value="Sakit" <?= $attrSakit ?>> Sakit </option>
                                        <option value="Izin" <?= $attrIzin ?>> Izin </option>
                                        <option value="Alpa" <?= $attrAlfa ?>> Alpa </option>
                                    </select>
                                    <span class="error"><?= $presensiErr ?></span>
                                </div>
                            </div>
                            <br>

                            <input type="submit" name="submit" value="Selesai" class="btn btn-primary btn-block">
                        </form>
                    </div>
                </div>
            </div>
            <?php
            if ($valid_makul && $valid_presensi == true) {
                include 'update_insert_presensi.php';
            }
            ?>
        </body>

    </html>

<?php
} //end of while
?>