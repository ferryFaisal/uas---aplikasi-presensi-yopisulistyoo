<?php

include 'connect_db.php';

$tgl_presensi = $_POST['tgl_presensi'];
$makul = $_POST['makul'];
$kelas = $_POST['kelas'];
$nim = $_POST['nim'];
$nama = $_POST['nama'];
$status_presensi = $_POST['status_presensi'];

$sql = ("INSERT INTO presensi (tgl_presensi, makul, kelas, nim, nama, status_presensi) VALUES ('$tgl_presensi', '$makul', '$kelas', '$nim', '$nama', '$status_presensi');");
if($query){
    echo 'Data berhasil disimpan';
}  else {
    echo 'Data gagal disimpan';
}

?>