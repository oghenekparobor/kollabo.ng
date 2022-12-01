<?php
include('install.php');

// $notify = new Notification();

$employer = $_POST['employer'];
$freelancer = $_POST['freelancer'];
$message = nl2br(addslashes($_POST['message']));

$send = "INSERT INTO `messages` (`id`, `sender`, `recipient`, `message`, `status_emp`, `status_flc`, `created`) 
            VALUES (NULL, '$employer', '$freelancer', '$message', 'new', 'new', current_timestamp())";
if (mysqli_query($con, $send)) {
    echo "MESSAGE_SENT";
    // $notify->createNotification($freelancer, "You have a new message", "message");
}

// $logs = "Message sent to freelancer";
// mysqli_query($con, "INSERT INTO `logs` (`id`, `log_message`, `created`) VALUES (NULL, '$logs', current_timestamp())");

