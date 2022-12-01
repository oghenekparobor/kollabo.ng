<?php
include('install.php');

if (isset($_POST['add_note'])) {
    $priority = mysqli_real_escape_string($con, $_POST['priority']);
    $userid = mysqli_real_escape_string($con, $_POST['user_id']);
    $note = mysqli_real_escape_string($con, $_POST['note']);

    $sql = "INSERT INTO notes (user_id, priority, note) VALUES ('$userid', '$priority', '$note')";
    $res = mysqli_query($con, $sql);

    if ($res) {
        echo "<script>window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error creating note');</script>";
        echo "<script>window.location='dashboard.php';</script>";
    }
}

if (isset($_POST['acceptoffer'])) {
    $freelancer = mysqli_real_escape_string($con, $_POST['freelancer_id']);
    $employer = mysqli_real_escape_string($con, $_POST['employer_id']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $duration = mysqli_real_escape_string($con, $_POST['duration']);
    $taskid = mysqli_real_escape_string($con, $_POST['task_id']);

    $duration = date("Y-m-d", strtotime("+$duration days"));

    $sql = "INSERT INTO `mytask` (`id`, `freelancer_id`, `employer_id`, `task_id`, `delivery`, `finished`, `feedback`, `budget`, `payment_status`, `created`) 
                    VALUES (NULL, '$freelancer', '$employer', '$taskid', '$duration', NULL, NULL, '$price', 'pending', current_timestamp())";
    $res = mysqli_query($con, $sql);
    $lasttask = mysqli_insert_id($con);

    if ($res) {
        $inactive = "UPDATE tasks SET bid_status = 'inactive' WHERE id = '$taskid' ";
        if (mysqli_query($con, $inactive)) {
            $delBid = "DELETE FROM bidder WHERE task_id = '$taskid' ";
            if (mysqli_query($con, $delBid)) {
                $ref = uniqid();
                $final = "INSERT INTO `orders` (`id`, `employer_id`, `freelancer_id`, `my_task_id`, `order_ref`, `status`, `created`) 
                VALUES (NULL, '$employer', '$freelancer', '$lasttask', '$ref', 'pending', current_timestamp())";
                if (mysqli_query($con, $final)) {
                    echo "<script>alert('Goto Dashboard -> Orders section to make payment');</script>";
                    echo "<script>window.location='active-bids.php';</script>";
                }                
            }
        }
    } else {
        echo "<script>alert('Error accepting offer');</script>";
        echo "<script>window.location='active-bids.php';</script>";
    }
}

if (isset($_POST['post_a_task'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $minimum = mysqli_real_escape_string($con, $_POST['minimum']);
    $maximum = mysqli_real_escape_string($con, $_POST['maximum']);
    $skills = mysqli_real_escape_string($con, $_POST['skills']);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $description = mysqli_real_escape_string($con, nl2br(addslashes($_POST['description'])));
    $file = $_FILES['file']['name'];
    $userid = mysqli_real_escape_string($con, $_POST['user_id']);

    $sql = "INSERT INTO `tasks` (`id`, `title`, `type`, `category`, `min_salary`, `max_salary`, `tags`, `location`, `description`, `files`, `bid_status`, `user_id`, `created`) 
    VALUES (NULL, '$title', '$type', '$category', '$minimum', '$maximum', '$skills', '$location', '$description', '$file', 'active', '$userid', current_timestamp())";
    $res = mysqli_query($con, $sql);
    move_uploaded_file($_FILES['file']['tmp_name'], "../images/employer/tasks/".$_FILES['file']['name']);

    if ($res) {
        echo "<script>window.location='active-bids.php';</script>";
    } else {
        echo "<script>alert('Error creating note');</script>";
        echo "<script>window.location='dashboard.php';</script>";
    }
}

if (isset($_POST['account_setting'])) {
    
    $valid_ext = array('png','jpeg','jpg');

    $userid = mysqli_real_escape_string($con, $_POST['user_id']);
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $place = mysqli_real_escape_string($con, $_POST['place']);
    $intro = mysqli_real_escape_string($con, $_POST['intro']);
    $pwd = mysqli_real_escape_string($con, $_POST['pwd']);
    $new_pwd = mysqli_real_escape_string($con, $_POST['new_pwd']);
    $confirm_pwd = mysqli_real_escape_string($con, $_POST['confirm_pwd']);
    $twosteps;

    if (isset($_POST['twosteps'])){
        $twosteps = "yes";
    } else {
        $twosteps = "no";
    }

    $password = "SELECT * FROM users WHERE id = '$userid' AND password = '$pwd' LIMIT 1";
	$passwordcheck = mysqli_query($con, $password);
    $passwordcheckcount = mysqli_num_rows($passwordcheck);

    $sql = "SELECT * FROM employer WHERE user_id = '$userid' LIMIT 1";
	$result = mysqli_query($con, $sql);
	$user = mysqli_fetch_assoc($result);
    
	$profileimage;
	if (empty($_FILES['file']['name'])) {
		$profileimage = $user['picture'];
	} else {
		$profileimage = $_FILES['file']['name'];
	}
    $directory = "../images/employer/profile/".$profileimage;
    
    $file_extension1 = pathinfo($directory, PATHINFO_EXTENSION);
    $file_extension1 = strtolower($file_extension1);
    
	if(in_array($file_extension1, $valid_ext)){
		compressImage($_FILES['file']['tmp_name'], $directory, 40);
	} else if(empty($file_extension1)){
	} else {
        echo "<script>alert('Please select a valid image');</script>";
        echo "<script>window.location='dashboard-settings.php';</script>";
	}

    if ($passwordcheckcount < 1) {
        echo "<script>alert('Password does not match');</script>";
        echo "<script>window.location='dashboard-settings.php';</script>";
    } else {
        if (empty($new_pwd)) {
            $sql = "UPDATE employer SET firstname = '$firstname', 
                                        lastname = '$lastname',
                                        nationality = '$place',
                                        introduction = '$intro',
                                        twosteps = '$twosteps',
                                        picture = '$profileimage'

                                    WHERE user_id = '$userid' ";
            $res = mysqli_query($con, $sql);

            if ($res) {
                echo "<script>window.location='dashboard.php';</script>";
            } else {
                echo "<script>alert('Error updating profile');</script>";
                echo "<script>window.location='dashboard-settings.php';</script>";
            }
        } else {
            if ($new_pwd == $confirm_pwd) {
                $sql = "UPDATE employer SET firstname = '$firstname', 
                                            lastname = '$lastname',
                                            nationality = '$place',
                                            introduction = '$intro',
                                            twosteps = '$twosteps',
                                            picture = '$profileimage'
                                        
                                        WHERE user_id = '$userid' ";
                $res = mysqli_query($con, $sql);

                if ($res) {
                    $sql = "UPDATE users SET password = '$new_pwd' WHERE id = '$userid' ";
                    $res = mysqli_query($con, $sql);
                    if ($res) {
                        echo "<script>window.location='dashboard.php';</script>";
                    } else {
                        echo "<script>alert('Error changing password');</script>";
                        echo "<script>window.location='dashboard-settings.php';</script>";
                    }
                } else {
                    echo "<script>alert('Error updating profile');</script>";
                    echo "<script>window.location='dashboard-settings.php';</script>";
                }
            } else {
                echo "<script>alert('Password does not match');</script>";
                echo "<script>window.location='dashboard-settings.php';</script>";
            }
        }
    }
}

function compressImage($source, $destination, $quality) {

	$info = getimagesize($source);

	if ($info['mime'] == 'image/jpeg') 
		$image = imagecreatefromjpeg($source);

	elseif ($info['mime'] == 'image/gif') 
		$image = imagecreatefromgif($source);

	elseif ($info['mime'] == 'image/png') 
		$image = imagecreatefrompng($source);

	imagejpeg($image, $destination, $quality);

}

if (isset($_POST['send_message'])) {
    
    $freelancer = $_POST['freelancer_id'];
    $employer = $_POST['employer_id'];
    $message = $_POST['message'];

    $send = "INSERT INTO `messages` (`id`, `sender`, `recipient`, `message`, `status_emp`, `status_flc`, `created`) 
                VALUES (NULL, '$employer', '$freelancer', '$message', 'new', 'new', current_timestamp())";
    if (mysqli_query($con, $send)) {
        echo "<script>window.location='dashboard-messages.php';</script>";
    }

}

if (isset($_POST['leave_feedback'])) {
    
    $freelancer = $_POST['freelancer_id'];
    $mtid = $_POST['employer_id'];
    $task = $_POST['task_id'];
    $rate = $_POST['rating'];
    $messagea = $_POST['message2'];

    $sendd = "UPDATE mytask SET feedback = '$messagea' WHERE id = '$mtid' ";
    if (mysqli_query($con, $sendd)) {
        mysqli_query($con, "INSERT INTO `rating` (`id`, `freelancer_id`, `task_id`, `rating`, `created`) VALUES (NULL, '$freelancer', '$task', '$rate', current_timestamp())");
        echo "<script>window.location='single-freelancer-profile.php?freelancer=$freelancer';</script>";
    }

}

if (isset($_POST['make_offer'])) {
    
    $freelancer = $_POST['freelancer_id'];
    $userid = $_POST['user_id'];
    $textarea = $_POST['textarea'];
    $file = $_FILES['file']['name'];

    $sendd = "INSERT INTO `make_offer` (`id`, `employer_id`, `freelancer_id`, `message`, `attachment`, `acceptance_status`, `created`) VALUES (NULL, '$userid', '$freelancer', '$textarea', '$file', NULL, current_timestamp()) ";
    if (mysqli_query($con, $sendd)) {
        move_uploaded_file($_FILES['file']['tmp_name'], "../images/employer/offers/".$file);
        echo "<script>window.location='dashboard.php';</script>";
    }

}

if (isset($_POST['post_task'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $budget = mysqli_real_escape_string($con, $_POST['budget']);
    $duration = mysqli_real_escape_string($con, $_POST['duration']);
    $skills = mysqli_real_escape_string($con, $_POST['skills']);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $description = mysqli_real_escape_string($con, nl2br(addslashes($_POST['description'])));
    $file = $_FILES['file']['name'];
    $userid = mysqli_real_escape_string($con, $_POST['user_id']);
    $freelancer = mysqli_real_escape_string($con, $_POST['freelancer']);

    $duration = date("Y-m-d", strtotime("+$duration days"));

    $sql = "INSERT INTO `tasks` (`id`, `title`, `type`, `category`, `min_salary`, `max_salary`, `tags`, `location`, `description`, `files`, `bid_status`, `user_id`, `created`) 
    VALUES (NULL, '$title', '$type', '$category', '$budget', '$budget', '$skills', '$location', '$description', '$file', 'inactive', '$userid', current_timestamp())";
    $res = mysqli_query($con, $sql);
    $lasttask = mysqli_insert_id($con);

    move_uploaded_file($_FILES['file']['tmp_name'], "../images/employer/tasks/".$_FILES['file']['name']);

    if ($res) {
        $sql1 = "INSERT INTO `mytask` (`id`, `freelancer_id`, `employer_id`, `task_id`, `delivery`, `finished`, `feedback`, `budget`, `payment_status`, `created`) 
                        VALUES (NULL, '$freelancer', '$userid', '$lasttask', '$duration', NULL, NULL, '$budget', 'pending', current_timestamp())";
        $res1 = mysqli_query($con, $sql1);
        $lastmytask = mysqli_insert_id($con);
         if ($res1) {
            $ref = uniqid();
            $final = "INSERT INTO `orders` (`id`, `employer_id`, `freelancer_id`, `my_task_id`, `order_ref`, `status`, `created`) 
            VALUES (NULL, '$userid', '$freelancer', '$lastmytask', '$ref', 'pending', current_timestamp())";
            if (mysqli_query($con, $final)) {
                echo "<script>alert('Goto Dashboard -> Orders section to make payment');</script>";
                echo "<script>window.location='my-tasks.php';</script>";
            }   
         }
    } else {
        echo "<script>alert('Error creating note');</script>";
        echo "<script>window.location='dashboard-post-a-task.php';</script>";
    }
}