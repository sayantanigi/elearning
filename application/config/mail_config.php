<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Mail Config file
| -------------------------------------------------------------------------
| This file lets you define all mail config variables to initilize 
| 
| for further use. to know more about PHPMAILER Pacakage 
|  
| follow this link : https://github.com/PHPMailer/PHPMailer
|	
*/
 
// Mail config variables 
$config['ADMIN_NAME'] = "E-Learning";
$config['ADMIN_MAIL'] = "igi223@goigi.in";  //igi223@goigi.in
$config['ADMIN_CC_MAIL'] = "admin@gmail.com"; //banerjeeneel.live@gmail.com

$config['MAIL_HOST'] = "smtp.gmail.com"; //smtp.gmail.com
$config['MAIL_PORT'] = "465";
$config['MAIL_SMTPSECURE'] = "ssl";
$config['MAIL_SMTPAUTH'] = TRUE;

$config['MAIL_USERNAME'] = "testsmtpsentmail@gmail.com"; //testsmtpsentmail@gmail.com
$config['MAIL_PASSWORD'] = 'dowlpeberazpiqbk';  // dowlpeberazpiqbk

$config['BUSINESS_PHONE'] = "E-Learning Business Phone";
$config['BUSINESS_EMAIL'] = "E-Learning Business Email";
$config['BUSINESS_ADDRESS'] = "E-Learning Address";




