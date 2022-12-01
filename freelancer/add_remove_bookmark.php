<?php
include('install.php');

$freelancer_id = $_POST['freelancer_id'];
$task_id = $_POST['task_id'];

$first = "SELECT * FROM `bookmark_freelancer` WHERE user_id = '$freelancer_id' AND task_id = '$task_id' ";
$res = mysqli_query($con, $first);
if (mysqli_num_rows($res) < 1) {
    
    $third = " INSERT INTO `bookmark_freelancer` (`id`, `user_id`, `task_id`, `created`) VALUES (NULL, '$freelancer_id', '$task_id', current_timestamp()) ";
    if (mysqli_query($con, $third)) {
        echo true;
    } else {
        echo false;
    }
} else {
    $second = "DELETE FROM `bookmark_freelancer` WHERE user_id = '$freelancer_id' AND task_id = '$task_id' ";
    if (mysqli_query($con, $second)) {
        echo false;
    } else {
        echo false;
    }
}