<?php
require "connect_db.php";
session_start();

$pass = sha1($pass);
$Nemail = $_POST['email'];
$sql1 = "UPDATE user SET name ='$name', password='$pass', role='$role', date_modified = curdate() WHERE email='$Nemail'";

if (mysqli_query($conn, $sql1)) {
    if (($_SESSION['role']) == 'Admin') {
        header('location: table_user.php');
        ob_end_flush();
    }
} else {
    echo "Error: " . $sql1 . "<br>" . $conn->error;
}

mysqli_close($conn);