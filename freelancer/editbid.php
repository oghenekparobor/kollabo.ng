<?php
include('install.php');

    $bidid = mysqli_real_escape_string($con, $_POST['bid_id']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $duration = mysqli_real_escape_string($con, $_POST['duration']);

    $sql = "UPDATE bidder SET price = '$price', duration = '$duration' WHERE id = '$bidid' ";
    $res = mysqli_query($con, $sql);

    if ($res) {
        echo "BID_EDITED";
    } else {
        echo "BID_EDIT_ERROR";
    }
