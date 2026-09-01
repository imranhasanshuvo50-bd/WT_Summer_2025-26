 <?php

$connection = mysqli_connect("localhost", "root", "", "projec");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>