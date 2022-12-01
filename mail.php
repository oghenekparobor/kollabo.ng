<?php
require 'PHPMailer/class.phpmailer.php';
require 'PHPMailer/PHPMailerAutoload.php';

class CreateMail {

    public function sendMail($to, $subject, $body, $name) {
			$mail = new PHPMailer;

			$mail->isSMTP();
			$mail->Port = 465; 
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'SSL';
			$mail->Host = "mail.soft-kode.com";
			$mail->Mailer = "SMTP";

			$mail->Username = "softkodes@soft-kode.com";
			$mail->Password = "Ex=*sM~]w6ZT";

			$mail->From = $to;
			$mail->FromName = $name;

			$mail->addAddress('robor.eminokanju@gmail.com');

			$mail->Subject = $subject;
			$mail->Body = $body;
			$mail->IsHTML(true);

			if($mail->send()) {
				return 'MAIL_SUCCESS';
			} else {
				return 'MAIL_FAILED';
			}
    }

}