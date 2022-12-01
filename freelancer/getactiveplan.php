<?php
session_start(); 
require("../admin/database/connect.php");
$db = new DbConnect();
$con = $db->connect();
$date = date('D d M Y h:i:s a');

$freelancer = $_POST['freelancer_id'];
$today = date("Y-m-d");

$first = "SELECT * FROM `active_plan` WHERE freelancer_id = '$freelancer' ";
$first_res = mysqli_query($con, $first);

if (mysqli_num_rows($first_res) > 0) {

    $second = "SELECT * FROM `active_plan` WHERE freelancer_id = '$freelancer' ";
    $secondres = mysqli_query($con, $second);
    $plan = mysqli_fetch_assoc($secondres);
    $expiry = $plan['expiry_date'];

    $expiry = strtotime($expiry);
    $today = strtotime($today);

    if ($today > $expiry) {
        echo "PLAN_EXPIRED";
    } else {
        echo "PLAN_ACTIVE";
    }

} else {
    echo "NO_ACTIVE_PLAN";
}