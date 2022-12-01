<?php
include('install.php');

$id = $_POST['user_id'];

$first = "SELECT `status` FROM `online_status` WHERE `online_status`.`user_id` = '$id' ";
$res = mysqli_query($con, $first);
$stat = mysqli_fetch_assoc($res);

if ($stat['status'] == 'online') {
    if (mysqli_query($con, "UPDATE online_status SET status = 'invisible' WHERE `online_status`.`user_id` = '$id' ")) {
        echo "INVISIBLE";
    }
} else {
    if (mysqli_query($con, "UPDATE online_status SET status = 'online' WHERE `online_status`.`user_id` = '$id' ")) {
        echo "ONLINE";
    }
}