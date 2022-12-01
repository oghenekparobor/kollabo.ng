<?php
include('install.php');

$employer = $_POST['employer'];
$freelancer = $_POST['freelancer'];
$message = nl2br(addslashes($_POST['message']));

$send = "INSERT INTO `messages` (`id`, `sender`, `recipient`, `message`, `status_emp`, `status_flc`, `created`) 
            VALUES (NULL, '$freelancer', '$employer', '$message', 'new', 'new', current_timestamp())";
if (mysqli_query($con, $send)) {
    echo "MESSAGE_SENT";
}