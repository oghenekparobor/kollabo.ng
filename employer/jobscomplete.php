<?php
include('install.php');

$date = date('Y-m-d');

$mytask = $_GET['mytask_id'];

$fir = "UPDATE mytask SET finished = '$date' WHERE id = '$mytask' ";
if (mysqli_query($con, $fir)) {
    header("Location: dashboard-reviews.php");
}