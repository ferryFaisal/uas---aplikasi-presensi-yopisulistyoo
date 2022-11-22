<?php
require "connect_db.php";

$makul = $_POST['makul'];
$presensi = $_POST['presensi'];
$Id = $_GET['id'];
$sql1 = "UPDATE presensi SET makul = '$makul', status_presensi = '$presensi' WHERE id='$Id'";

if ($conn->query($sql1) == TRUE) {
    echo "<br>";
    // echo "New Record created successfully";
    header('Location: table_presensi.php');
} else {
    echo "Error: " . $sql1 . "<br>" . $conn->error;
}

$conn->close();