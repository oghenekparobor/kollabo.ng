<?php
include('install.php');

$id = $_GET['user_id'];

$first = "SELECT * FROM users WHERE id = '$id' ";
$res = mysqli_fetch_assoc(mysqli_query($con, $first));
$block = $res['block_status'];

if ($block == 'opened') {
    if (mysqli_query($con, "UPDATE users SET block_status = 'closed' WHERE id = '$id' ")) {
        echo "<script>alert('User account blocked');</script>";
        echo "<script>window.location='element_search.php';</script>";
    } else {
        echo "<script>alert('Error!');</script>";
        echo "<script>window.location='element_search.php';</script>";
    }
} else {
    if (mysqli_query($con, "UPDATE users SET block_status = 'opened' WHERE id = '$id' ")) {
        echo "<script>alert('User account unblocked');</script>";
        echo "<script>window.location='element_search.php';</script>";
    } else {
        echo "<script>alert('Error!');</script>";
        echo "<script>window.location='element_search.php';</script>";
    }
}