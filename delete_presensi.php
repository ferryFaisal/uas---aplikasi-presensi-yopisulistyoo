<?php
require 'connect_db.php';
session_start();

$id = $_GET['id'];
$sql = "DELETE FROM presensi WHERE id = '$id'";

if (mysqli_query($conn, $sql)) {
    header('location: table_presensi.php');
    ob_end_flush();
} else {
    echo "Error deleting record: " . $conn->error;
}

mysqli_close($conn);