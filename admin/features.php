<?php
include('install.php');

if (isset($_POST['log_in'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    
    $log = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND acct_type = 'admin' ";
    $res = mysqli_query($con, $log);
    $user = mysqli_fetch_assoc($res);
    if (mysqli_num_rows($res) < 0) {
        echo "<script>alert('Invalid authentication')</script> ";
        echo "<script>window.location='auth_login.php'</script>";
    } else {
        $_SESSION['admin_id'] = $user['id'];

        header("Location: index.php");
    }
}

// if (isset($_POST[('send_dm')])) {
//     $sender = $_POST['sender'];
//     $recipient = $_POST['recipient'];
//     $message = $_POST['message'];

//     $send = "INSERT INTO `messages` (`id`, `sender`, `recipient`, `message`, `status_emp`, `status_flc`, `created`) VALUES (NULL, '$sender', '$recipient', '$message', 'new', 'new', current_timestamp())";
//     if (mysqli_query($con, $send)) {
//         echo "<script>window.location='apps_chat.php'</script>";
//     }
// }

if (isset($_POST['create_category'])) {
    $title = $_POST['title'];
    $image = $_FILES['file']['name'];

    $first = "INSERT INTO `category` (`id`, `category`, `category_image`, `created`) VALUES (NULL, '$title', '$image', current_timestamp())";
    if (mysqli_query($con, $first)) {
        move_uploaded_file($_FILES['file']['tmp_name'], "../images/admin/category/".$image);
        echo "<script>alert('Category added successfully')</script> ";
        echo "<script>window.location='AddCategory.php'</script>";
    } else {
        echo "<script>alert('Error')</script> ";
        echo "<script>window.location='AddCategory.php'</script>";
    }
}

if (isset($_POST['send-pm'])) {
    $task_one = mysqli_real_escape_string($con, $_POST['task_one']);
    $task_two = mysqli_real_escape_string($con, $_POST['task_two']);
    $task_two_text = mysqli_real_escape_string($con, $_POST['task_two_text']);
    $task_two_progress = mysqli_real_escape_string($con, $_POST['task_two_progress']);
    $task_three = mysqli_real_escape_string($con, $_POST['task_three']);
    $task_three_file = mysqli_real_escape_string($con, $_POST['task_three_file']);

    if (!empty($task_one)) {
        $first = "INSERT INTO `list` (`id`, `title`, `sub_list`, `created`) VALUES (NULL, '$task_one', '1', current_timestamp())";
        $first_res = mysqli_query($con, $first);
        $last_id = ($con);

        $second = "INSERT INTO `sub_list_one` (`id`, `list_id`, `task`, `created`) VALUES (NULL, '$last_id', '', current_timestamp())";
    }

}