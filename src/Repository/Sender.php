<?php declare(strict_types=1);

namespace Blog\Repository;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Http\Request;

class Sender {

	private $data;

	public function __construct($input) {
		$this->data = $input;
	}

	public function send() {

		try {
			$mail = new PHPMailer(true);
			$mail->CharSet = 'UTF-8';
			$mail->SMTPDebug = SMTP::DEBUG_SERVER;
			$mail->isSMTP();
			$mail->Host = 'smtp.free.fr';
			$mail->SMTPAuth = true;
			$mail->Username = 'kevin.bento@free.fr';
			$mail->Password = '26062003';
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
			$mail->Port = 465;

			$mail->setFrom('russeherriot@free.fr', 'Kévin BENTO');
			$mail->addAddress($this->data['email'], $this->data['name']);
	
			$mail->isHtml(false);
			$mail->Subject = $this->data['topic'];
			$mail->Body = $this->data['content'];

			$mail->send();
			echo 'Sent !';
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
}
	
