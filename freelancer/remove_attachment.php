<?php
include('install.php');

$freelancer = $_POST['freelancer_id'];

$first = "UPDATE freelancer SET attachment = '' WHERE user_id = '$freelancer' ";
if (mysqli_query($con, $first)) {
    echo "DELETED";
}