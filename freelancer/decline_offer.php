<?php
include('install.php');

// * notify involved freelancer that bid has been cancelled

$oid = $_GET['offer_id'];

    $bid = "UPDATE make_offer SET acceptance_status = 'declined' WHERE id = '$oid' ";
    $bid = mysqli_query($con, $bid);
    
    if ($bid) {
        echo "<script>window.location='my-offers.php';</script>";
    } else {
        echo "<script>window.location='my-offers.php';</script>";
    }
