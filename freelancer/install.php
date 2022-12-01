<?php
session_start(); 
require("../admin/database/connect.php");
$db = new DbConnect();
$con = $db->connect();
$date = date('D d M Y h:i:s a');

$today = date("Y-m-d");

// add suvscription verification here
$first = "SELECT * FROM `active_plan` WHERE freelancer_id = '".$_SESSION['user_id']."' ";
$first_res = mysqli_query($con, $first);

if (mysqli_num_rows($first_res) > 0) {

    $second = "SELECT * FROM `active_plan` WHERE freelancer_id = '".$_SESSION['user_id']."' ";
    $secondres = mysqli_query($con, $second);
    $plan = mysqli_fetch_assoc($secondres);
    $expiry = $plan['expiry_date'];

    $expiry = strtotime($expiry);
    $today = strtotime($today);

    if ($today > $expiry) {
        header("Location: pricing-plans.php");
    } else {
        // echo "PLAN_ACTIVE";
    }
    
} else {
    // header("Location: pricing-plans.php");
    echo "<script>alert('Please visit pricing plan to subscribe');</script>";
}