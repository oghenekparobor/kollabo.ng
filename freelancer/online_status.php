<?php
include('install.php');

$id = $_POST['user_id'];

$first = "SELECT `status` FROM `online_status` WHERE `online_status`.`user_id` = '$id' LIMIT 1";
$res = mysqli_query($con, $first);
$stat = mysqli_fetch_assoc($res);

if ($stat['status'] == 'online') {
    if (mysqli_query($con, "UPDATE `online_status` SET `online_status`.`status` = 'invisible' WHERE `online_status`.`user_id` = '$id' ")) {
        echo "INVISIBLE";
    } else {
        echo "ERROR";
    }
} else {
    if (mysqli_query($con, "UPDATE `online_status` SET `online_status`.`status` = 'online' WHERE `online_status`.`user_id` = '$id' ")) {
        echo "ONLINE";
    } else {
        echo "ERROR";
    }
}