<?php
include('install.php');

// * notify involved freelancer that bid has been cancelled

$tid = $_GET['task_id'];

$task = "DELETE FROM tasks WHERE id = '$tid'";
$task = mysqli_query($con, $task);

$logs = "Tasks deleted";
mysqli_query($con, "INSERT INTO `logs` (`id`, `log_message`, `created`) VALUES (NULL, '$logs', current_timestamp())");

if ($task) {

    $bid = "DELETE FROM bidder WHERE task_id = '$tid' ";
    $bid = mysqli_query($con, $bid);
    
    if ($bid) {
        echo "<script>window.location='active-bids.php';</script>";
    } else {
        echo "<script>window.location='active-bids.php';</script>";
    }
    
} else {
    echo "<script>window.location='active-bids.php';</script>";
}