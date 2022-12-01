<?php
include('install.php');

$id = $_GET['category_id'];

$first = "DELETE FROM category WHERE id = '$id' ";
$res = mysqli_query($con, $first);

if ($res) {
    // echo "<script>alert('Deleted');</script>";
    echo "<script>window.location='ViewCategory.php';</script>";
} else {
    echo "<script>alert('Error');</script>";
    echo "<script>window.location='ViewCategory.php';</script>";
}