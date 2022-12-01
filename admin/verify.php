<?php
include('install.php');

$id = $_GET['user_id'];

$first = "UPDATE freelancer SET verified = 'true' WHERE user_id = '$id' ";
$res = mysqli_query($con, $first);

if ($res) {
    echo "<script>alert('Freelancer account verified');</script>";
    echo "<script>window.location='element_search.php';</script>";
} else {
    echo "<script>alert('Error');</script>";
    echo "<script>window.location='element_search.php';</script>";
}