<?php
require "connect_db.php";
session_start();

$password = sha1($password);
$dc = date("Y-m-d");
$dm = date("Y-m-d");
// $Nemail = $_POST['email'];
$sql = "INSERT INTO user (email, name, password, role, date_created, date_modified, photo)
        VALUES ('$email', '$name', '$password', '$role', '$dc', '$dm', '$image')";
// $sql1 = "UPDATE user SET name ='$name', password='$pass', role='$role', date_modified = curdate() WHERE email='$Nemail'";

if (mysqli_query($conn, $sql)) {
    echo "Success";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);
header('Location: login.php');