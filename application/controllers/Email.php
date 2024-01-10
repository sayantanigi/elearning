

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\SMTP;

use PHPMailer\PHPMailer\Exception;



class Email extends CI_Controller 

{

	function __construct(){

		parent::__construct();

		require 'vendor/autoload.php';

	}



	function send_email() 

	{

		

		$mail = new PHPMailer(true);

		$subject = 'Test subject';

		$body = 'Hi there, <strong>Testing</strong> here.<br/> This is our email body.';

		$email = 'igi128@goigi.com';



		$mail->CharSet = 'UTF-8';

		$mail->SetFrom('no-reply@goigi.com','Munna');



		$mail->AddAddress($email,"Munna Kumar");

		$mail->AddAddress($email);

		//Address to which recipient will reply

		//$mail->addReplyTo("reply@yourdomain.com","Reply");

		//$mail->addCC("cc@example.com");

		//$mail->addBCC("bcc@example.com");



		//Add a file attachment

		//$mail->addAttachment("file.txt", "File.txt");        

		$mail->addAttachment(base_url()."uploads/thanks.jpg"); //Filename is optional



		//You could send the body as an HTML or a plain text

		$mail->IsHTML(true);



		$mail->Subject = $subject;

		$mail->Body = $body;



		//Send email via SMTP

		$mail->IsSMTP();

		$mail->SMTPAuth   = true; 

		$mail->SMTPSecure = "ssl";  //tls

		$mail->Host       = "smtp.googlemail.com";

		$mail->Port       = 465; //you could use port 25, 587, 465 for googlemail

		$mail->Username   = "no-reply@goigi.com";

		$mail->Password   = "b6wb]gJ-_tG},9FW";



		if(!$mail->send()){

			$response['message'] = 'Email has been sent successfully';

		}

		else{

			$response['message'] = 'Oops! Something went wrong while trying to send your email.';

		}

			echo json_encode($response);

	}

}