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

if (isset($_POST['account_setting'])) {
    
    $valid_ext = array('png','jpeg','jpg');

    $userid = mysqli_real_escape_string($con, $_POST['userid']);
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $rate = mysqli_real_escape_string($con, $_POST['rate']);
    $skills = mysqli_real_escape_string($con, $_POST['skills']);
    $attachment = $_FILES['attachment']['name'];
    $tagline = mysqli_real_escape_string($con, $_POST['tagline']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
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

    $sql = "SELECT * FROM freelancer WHERE user_id = '$userid' LIMIT 1";
	$result = mysqli_query($con, $sql);
	$user = mysqli_fetch_assoc($result);
    
	$profileimage;
	if (empty($_FILES['file']['name'])) {
		$profileimage = $user['picture'];
	} else {
		$profileimage = $_FILES['file']['name'];
	}
    $directory = "../images/freelancer/profile/".$profileimage;

    $attch;
	if (empty($_FILES['attachment']['name'])) {
		$attch = $user['attachment'];
	} else {
        $attch = $_FILES['attachment']['name'];
        move_uploaded_file($_FILES['attachment']['tmp_name'], "../images/freelancer/documents/".$attch);
	}

    $file_extension1 = pathinfo($directory, PATHINFO_EXTENSION);
    $file_extension1 = strtolower($file_extension1);
    
	if(in_array($file_extension1, $valid_ext)){
		compressImage($_FILES['file']['tmp_name'], $directory, 40);
	} else if(empty($file_extension1)) {
	} else {
        echo "<script>alert('Please select a valid image');</script>";
        echo "<script>window.location='dashboard-settings.php';</script>";
	}

    if ($passwordcheckcount < 1) {
        echo "<script>alert('Password does not match');</script>";
        echo "<script>window.location='dashboard-settings.php';</script>";
    } else {
        if (empty($new_pwd)) {
            $sql = "UPDATE freelancer SET firstname = '$firstname', 
                                        lastname = '$lastname',
                                        minimal_hourly_rate = '$rate',
                                        attachment = '$attch',
                                        tagline = '$tagline',
                                        introduction = '$intro',
                                        twostep = '$twosteps',
                                        picture = '$profileimage',
                                        nationality = '$location'

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
                $sql = "UPDATE freelancer SET firstname = '$firstname', 
                                            lastname = '$lastname',
                                            minimal_hourly_rate = '$rate',
                                            attachment = '$attachment',
                                            tagline = '$tagline',
                                            introduction = '$intro',
                                            twostep = '$twosteps',
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
    $message = $_POST['textarea'];
    $offer = $_POST['offer'];

    $message = "<h6>[$offer]</h6>\n".$message;

    $send = "INSERT INTO `messages` (`id`, `sender`, `recipient`, `message`, `status_emp`, `status_flc`, `created`) 
                VALUES (NULL, '$freelancer', '$employer', '$message', 'new', 'new', current_timestamp())";
    if (mysqli_query($con, $send)) {
        echo "<script>window.location='dashboard-messages.php';</script>";
    }

}