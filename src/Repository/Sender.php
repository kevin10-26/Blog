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
			$mail->Host = '';
			$mail->SMTPAuth = true;
			$mail->Username = '';
			$mail->Password = '';
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
			$mail->Port = 465;

			$mail->setFrom('', '');
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
	
