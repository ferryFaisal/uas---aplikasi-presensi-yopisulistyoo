<?php
require 'connect_db.php';

$makul = $_POST['makul'];
$kelas = $_POST['kelas'];
$nim = $_POST['nim'];
$nama = $_POST['nama'];
$presensi = $_POST['presensi'];

$count = count($nim);
$sql = "INSERT INTO presensi (tgl_presensi,makul,kelas,nama,nim,status_presensi) VALUES ";
for ($i = 0; $i < $count; $i++) {
    $sql .= "(CURDATE(),'$makul','$kelas','{$nama[$i]}','{$nim[$i]}','{$presensi[$i]}')";
    $sql .= ",";
}

$sql = rtrim($sql, ",");

$insert = $conn->query($sql);

header('location: index.php?success=1');
ob_end_flush();