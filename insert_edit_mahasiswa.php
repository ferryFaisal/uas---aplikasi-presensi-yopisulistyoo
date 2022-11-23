<?php
require "connect_db.php";

$nimm = $_POST['nim'];
$nama = $_POST['nama'];
$kelas = $_POST['kelas'];
$sql2 = "UPDATE mahasiswa SET nama = '$nama', kelas ='$kelas'
        WHERE nim='$nimm'";

if ($conn->query($sql2) == TRUE) {
    echo "<br>";
    // echo "New Record created successfully";
    header('Location: table_mahasiswa.php');
} else {
    echo "Error: " . $sql2 . "<br>" . $conn->error;
}

$conn->close();