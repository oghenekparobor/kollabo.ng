<?php
include('install.php');

$nid = $_GET['transaction_id'];

$noteid = "DELETE FROM transactions WHERE id = '$nid' ";
$res = mysqli_query($con, $noteid);

if ($res) {
    echo "<script>window.location='wallet.php';</script>";
} else {
    echo "<script>window.location='wallet.php';</script>";
}