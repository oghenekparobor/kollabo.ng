<?php
include('install.php');

$nid = $_GET['note_id'];

$noteid = "DELETE FROM notes WHERE id = '$nid' ";
$res = mysqli_query($con, $noteid);

if ($res) {
    echo "<script>window.location='dashboard.php';</script>";
} else {
    echo "<script>window.location='dashboard.php';</script>";
}