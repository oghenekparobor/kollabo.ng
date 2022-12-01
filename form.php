<?php
require_once 'mail.php';
$mail = new CreateMail();

if($_POST['contact_us']) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $comments = $_POST['comments'];

    $body = "Customer name: $name \n Email: $email \n\n Message: $comments";

    $res = $mail->sendMail($email, $subject, $body, $name);

    if ($res == 'MAIL_SUCCESS') {
        echo "<script>alert('Message sent!')</script> ";
		echo "<script>window.location='contact.php'</script>";
    } else {
        echo "<script>alert('Message not sent!')</script> ";
		echo "<script>window.location='contact.php'</script>";
    }

}

