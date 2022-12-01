<?php
include('install.php');
require_once('../log.php');

// $createLog = new CreateLog();

$employer_id = $_POST['employer_id'];
$freelance = $_POST['freelance'];

$first = "SELECT * FROM `bookmark_employer` WHERE user_id = '$employer_id' AND freelance = '$freelance' ";
$res = mysqli_query($con, $first);
if (mysqli_num_rows($res) < 1) {
    
    $third = " INSERT INTO `bookmark_employer` (`id`, `user_id`, `freelance`, `created`) VALUES (NULL, '$employer_id', '$freelance', current_timestamp()) ";
    if (mysqli_query($con, $third)) {
        echo true;
    } else {
        echo false;
    }
    
    // $logs = "Freelancer added to bookmark";
    // mysqli_query($con, "INSERT INTO `logs` (`id`, `log_message`, `created`) VALUES (NULL, '$logs', current_timestamp())");
    
} else {
    $second = "DELETE FROM `bookmark_employer` WHERE user_id = '$employer_id' AND freelance = '$freelance' ";
    if (mysqli_query($con, $second)) {
        echo false;
    } else {
        echo false;
    }
    
    // $logs = "Freelancer removed from bookmark";
    // mysqli_query($con, "INSERT INTO `logs` (`id`, `log_message`, `created`) VALUES (NULL, '$logs', current_timestamp())");
    
}