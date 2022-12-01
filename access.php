<?php
session_start(); 
require("admin/database/connect.php");
$db = new DbConnect();
$con = $db->connect();
$date = date('D d M Y h:i:s a');
$dtt = date('Y-m-d');

    if (isset($_POST['register'])) {
        $accttype = mysqli_real_escape_string($con, $_POST['account-type']);
	    $email = mysqli_real_escape_string($con, $_POST['email']);
	    $password = mysqli_real_escape_string($con, $_POST['password']);
	    $cpassword = mysqli_real_escape_string($con, $_POST['password-repeat']);

	if ($password != $cpassword) {

		echo "<script>alert('Password does not match')</script> ";
		echo "<script>window.location='register.php'</script>";

	} else {

		$check = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
		$result = mysqli_query($con, $check);
        $count = mysqli_num_rows($result);

		if ($count >= 1) {

			echo "<script>alert('Email already exist')</script> ";
			echo "<script>window.location='register.php'</script>";

		} else {

			$query = "INSERT INTO users (email, password, acct_type) VALUES ('$email', '$password', '$accttype') ";
            $response = mysqli_query($con, $query);
            $last_id = mysqli_insert_id($con);

			if ($response) {

				$sql = "SELECT * FROM users WHERE id = '$last_id' ";
				$res = mysqli_query($con, $sql);
				$row = mysqli_fetch_array($res);

                $_SESSION['user_id'] = $last_id;
                
                if ($row['acct_type'] == 'employer') {
                    $sql = "INSERT INTO `employer` (`id`, `user_id`, `firstname`, `lastname`, `email`, `nationality`, `introduction`, `twosteps`, `created`, `picture`) VALUES (NULL, '$last_id', '', '', '$email', '', '', 'no', current_timestamp(), 'user-avatar-placeholder.png')";
                    if (mysqli_query($con, $sql)) {
                        header("Location: employer/dashboard.php");
                    }
                } else if ($row['acct_type'] == 'freelancer') {
                    $sql1 = "INSERT INTO `freelancer` (`id`, `user_id`, `picture`, `firstname`, `lastname`, `email`, `minimal_hourly_rate`, `skills`, `attachment`, `contract`, `tagline`, `nationality`, `introduction`, `verified`, `twostep`, `created`) 
                                        VALUES (NULL, '$last_id', 'user-avatar-placeholder.png', '', '', '$email', '', '', '', '', '', '', '', 'false', 'no', current_timestamp())";
                    if (mysqli_query($con, $sql1)) {
                        $sq = "INSERT INTO `wallet` (`id`, `balance`, `freelancer_id`, `created`) VALUES (NULL, '0', '$last_id', current_timestamp())";
                        $sq123 = "INSERT INTO `active_plan` (`id`, `freelancer_id`, `expiry_date`, `created`) VALUES (NULL, '$last_id', '$dtt', current_timestamp())";
                        if (mysqli_query($con, $sq)) {
                            mysqli_query($con, $sq123);
                            header("Location: freelancer/dashboard.php");
                        } else {
                            echo "Error creating wallet";
                        }                  
                    } else {
                        echo "erro creating freelancer";
                    }
                } else {
                    header("Location: register.php");
                }

                $id = $row['id'];
                mysqli_query($con, "INSERT INTO `online_status` (`id`, `user_id`, `status`, `created`) VALUES (NULL, '$id', 'online', current_timestamp())");

            }
		}
	}
    } else if(isset($_POST['login'])) {

        $email = mysqli_real_escape_string($con, $_POST['emailaddress']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
    
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
                    header("Location: employer/dashboard.php");
                } else if ($row['acct_type'] == 'freelancer') {
                    header("Location: freelancer/dashboard.php");
                } else {
                
                }
            }

        } else {
            // echo "<script>alert('Incorrect email or password');</script> ";
            // echo "<script>window.location='login.php';</script>";
            echo "INCORRECT_CREDENTIALS";
        }
    
    }
?>