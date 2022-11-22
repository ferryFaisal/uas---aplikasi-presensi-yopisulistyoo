<?php
require 'connect_db.php';

$nim = $_GET['nim'];

$sql = "DELETE FROM mahasiswa WHERE nim = '$nim'";
if (mysqli_query($conn, $sql)) {

    header('Location: table_mahasiswa.php');
    ob_end_flush();

} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);