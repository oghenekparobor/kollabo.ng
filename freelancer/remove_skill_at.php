<?php
include('install.php');

$freelancer_id = $_POST['freelancer_id'];
$index = $_POST['index'];

$sql = "SELECT * FROM freelancer WHERE user_id = '$freelancer_id' LIMIT 1";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($result);
$skills = $user['skills'];

$tag = explode(",", $skills);
unset($tag[$index]);

$skill = implode(",",$tag);

$reupdate = "UPDATE freelancer SET skills = '$skill' WHERE user_id = '$freelancer_id' ";
if (mysqli_query($con, $reupdate)) {
    echo true;
} else {
    echo false;
}

// print_r($tag);