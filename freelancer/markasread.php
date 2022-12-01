<?php
include('install.php');

$nid = $_GET['notification_id'];

$sql = "UPDATE notification SET read_status = 'old'  WHERE id = '$nid' ";
$res = mysqli_query($con, $sql);

if ($res) {
    echo "<script>window.location='dashboard.php';</script>";
}