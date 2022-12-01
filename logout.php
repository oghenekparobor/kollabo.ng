<?php
// Initialize the session.
// If you are using session_name("something"), don't forget it now!
require("admin/database/connect.php");
$db = new DbConnect();
$con = $db->connect();

session_start();

$id = $_SESSION['user_id'];
mysqli_query($con, "UPDATE online_status SET status = 'invisible' WHERE `online_status`.`user_id` = '$id' ");

$_SESSION = array(); // destroy all $_SESSION data

setcookie("PHPSESSID", "", time() - 3600, "/");

// Finally, destroy the session.
session_destroy();
header('location: index.php');
?>