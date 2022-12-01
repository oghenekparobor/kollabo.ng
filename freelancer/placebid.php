<?php
include('install.php');

$employer_id = mysqli_real_escape_string($con, $_POST['employer_id']);
$freelancer_id = mysqli_real_escape_string($con, $_POST['freelancer_id']);
$task_id = mysqli_real_escape_string($con, $_POST['task_id']);
$price = mysqli_real_escape_string($con, $_POST['price']);
$duration = mysqli_real_escape_string($con, $_POST['duration']);

$first = "SELECT * FROM bidder WHERE freelancer_id = '$freelancer_id' AND task_id = '$task_id' ";
$firstresult = mysqli_query($con, $first);
if (mysqli_num_rows($firstresult) > 0) {
    echo "BID_EXIST";
} else {
    $second = "INSERT INTO `bidder` (`id`, `employer_id`, `freelancer_id`, `task_id`, `price`, `duration`, `created`) 
                    VALUES (NULL, '$employer_id', '$freelancer_id', '$task_id', '$price', '$duration', current_timestamp())";
    if (mysqli_query($con, $second)) {
        echo "BID_PLACED";
    } else {
        echo "BID_ERROR";
    }
}