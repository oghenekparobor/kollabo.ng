<?php
include('install.php');

// * notify involved freelancer that bid has been cancelled

$tid = $_GET['bidder_id'];

    $bid = "DELETE FROM bidder WHERE id = '$tid' ";
    $bid = mysqli_query($con, $bid);
    
    if ($bid) {
        echo "<script>window.location='dashboard-my-active-bids.php';</script>";
    } else {
        echo "<script>window.location='dashboard-my-active-bids.php';</script>";
    }
