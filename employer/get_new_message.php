<?php
include('install.php');

$employer = $_POST['employer'];
$freelancer = $_POST['freelancer'];

$check = "SELECT * FROM messages WHERE recipient = '$employer' AND sender = '$freelancer' AND status_emp = 'new' ";
$res = mysqli_query($con, $check);
if (mysqli_num_rows($res) > 0) {
    echo "NEW_MESSAGE_FOUND";
} else {
    echo "NO_NEW_MESSAGE_FOUND";
}