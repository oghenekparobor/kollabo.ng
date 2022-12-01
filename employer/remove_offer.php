<?php
include('install.php');


$oid = $_GET['offer_id'];

    $bid = "DELETE FROM make_offer WHERE id = '$oid' ";
    $bid = mysqli_query($con, $bid);
    
    if ($bid) {
        echo "<script>window.location='my-offers.php';</script>";
    } else {
        echo "<script>window.location='my-offers.php';</script>";
    }
