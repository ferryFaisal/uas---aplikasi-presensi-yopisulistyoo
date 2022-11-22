<?php
include "connect_db.php";

$nim = $_POST['nim'];
$nama = $_POST['nama'];
$kelas = $_POST['kelas'];

$sql = "INSERT INTO mahasiswa (nim, nama, kelas) VALUES ('$nim', '$nama', '$kelas')";

if ($conn->query($sql) === TRUE) {
    // echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header('location: table_mahasiswa.php');