<?php
include('install.php');

$nid = $_GET['bookmark_id'];

$noteid = "DELETE FROM bookmark_freelancer WHERE id = '$nid' ";
$res = mysqli_query($con, $noteid);

if ($res) {
    echo "<script>window.location='dashboard-bookmarks.php';</script>";
} else {
    echo "<script>window.location='dashboard-bookmarks.php';</script>";
}