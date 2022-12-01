<?php
include('install.php');

$employer = $_POST['employer'];
$sq = "SELECT * FROM employer WHERE user_id = '$employer' LIMIT 1";
$res = mysqli_query($con, $sq);
$user = mysqli_fetch_assoc($res);
$em_picture = $user['picture'];

$freelancer = $_POST['freelancer'];
$sl = "SELECT * FROM freelancer WHERE user_id = '$freelancer' LIMIT 1";
$rt = mysqli_query($con, $sl);
$usr = mysqli_fetch_assoc($rt);
$fr_picture = $usr['picture'];
$fr_first = $usr['firstname'];
$fr_last = $usr['lastname'];

echo "
<div class='messages-headline'>
	<h4 id='reciept'>$fr_first $fr_last</h4>
	<!-- <a href='' class='message-action'><i class='icon-feather-trash-2'></i> Delete Conversation</a> -->
</div>
<div class='message-content-inner' id='innerMessage' >
";

$first = "SELECT * FROM messages WHERE sender = '$employer' AND recipient = '$freelancer' OR recipient = '$employer' AND sender='$freelancer'  ORDER BY DATE(created) ASC ";
$first_res = mysqli_query($con, $first);
while ($row = mysqli_fetch_assoc($first_res)) {
    $mid = $row['id'];
    $date = $row['created'];

    $send = "SELECT * FROM messages WHERE sender = '$employer' AND recipient = '$freelancer' AND id = '$mid' LIMIT 1 ";
    $send_res = mysqli_query($con, $send);
    if ($sent = mysqli_fetch_assoc($send_res)) {
        $sent_message = $sent['message'];
        echo "
        <div class='message-bubble me'>
            <div class='message-bubble-inner'>
                <div class='message-avatar'><img src='../images/employer/profile/$em_picture' alt='' /></div>
                <div class='message-text'><p>$sent_message.</p></div>
            </div>
            <div class='clearfix'></div>
        </div>";
    }

    $recieve = "SELECT * FROM messages WHERE sender = '$freelancer' AND recipient = '$employer' AND id = '$mid' LIMIT 1 ";
    $recieve_res = mysqli_query($con, $recieve);
    if ($recieved = mysqli_fetch_assoc($recieve_res)) {
        $recieved_message = $recieved['message'];
        echo "
        <div class='message-bubble'>
            <div class='message-bubble-inner'>
                <div class='message-avatar'><img src='../images/freelancer/profile/$fr_picture' alt='' /></div>
                <div class='message-text'><p>$recieved_message</p></div>
            </div>
            <div class='clearfix'></div>
        </div>
        ";
    }

}

$final = " UPDATE messages SET `status_emp` = 'old' WHERE sender = '$employer' OR recipient = '$employer' AND recipient = '$freelancer' OR sender = '$freelancer' ";
mysqli_query($con, $final);

echo "
</div>
<div class='message-reply'>
	<textarea cols='1' rows='1' id='message' placeholder='Your Message' data-autoresize></textarea>
	<button onclick='sendMessage($employer, $freelancer)' class='button ripple-effect'>Send</button>
</div>
";