<?php
session_start(); 
require("admin/database/connect.php");
$db = new DbConnect();
$con = $db->connect();
$date = date('D d M Y h:i:s a');
$dtt = date('Y-m-d');

        $email = $_POST['emailaddress'];
        $password = $_POST['password'];
    
        $sql = "SELECT * FROM `users` WHERE email ='$email' AND password = '$password' ";
        $res = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($res);
        $count = mysqli_num_rows($res);
    
        if ($count == 1) {    

            if ($row['block_status'] == 'closed') {
                echo "<script>alert('Your account is currently blocked. Please contact support.');</script> ";
                echo "<script>window.location='login.php'</script>";
            } else {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['account_type'] = $row['acct_type'];

                mysqli_query($con, "UPDATE online_status SET status = 'online' WHERE `online_status`.`user_id` = '".$row['id']."' ");
    
                if ($row['acct_type'] == 'employer') {
                    echo "EMPLOYER";
                    // header("Location: employer/dashboard.php");
                } else if ($row['acct_type'] == 'freelancer') {
                    echo "FREELANCER";
                    // header("Location: freelancer/dashboard.php");
                } else {
                
                }
            }

        } else {
            // echo "<script>alert('Incorrect email or password');</script> ";
            // echo "<script>window.location='login.php';</script>";
            echo "INCORRECT_CREDENTIALS";
        }