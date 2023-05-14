<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Create an instance; Pass `true` to enable exceptions 
$mail = new PHPMailer;
// Server settings 
$RecordID = $_POST['RecordID'];
$EmailAddress = $_POST['EmailAddress'];
$Firstname = $_POST['Firstname'];
$Lastname = $_POST['Lastname'];
/* $Files =  $_FILES['file']['name']; */

$mail->isSMTP(); // Set mailer to use SMTP 
$mail->Host = 'smtp-relay.sendinblue.com'; // Specify main and backup SMTP servers 
$mail->SMTPAutoTLS = false;
$mail->SMTPSecure = false;
$mail->SMTPAuth = true; // Enable SMTP authentication 
$mail->Username = 'sales@toyntoys.asia'; // SMTP username 
$mail->Password = 'ZB4vXcpETdsArwqN'; // SMTP password 
$mail->Port = 587; // TCP port to connect to

// Sender info 
$mail->setFrom('teamwebnology@gmail.com', 'FETCH.IT'); 
$mail->addReplyTo('teamwebnology@gmail.com', 'FETCH.IT'); 

// Add a recipient 
$mail->addAddress($EmailAddress); 
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com'); 
// Set email format to HTML 
$mail->isHTML(true);
 
// Mail subject 
$mail->Subject = 'Requested Document'; 
 
// Mail body content 
$bodyContent = '<h1>Hi,'.$Firstname. ' '  .$Lastname.'</h1>'.'<br>'.'<b>Attach below is your document</b>'; 
$mail->Body = $bodyContent; 
$mail->addAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name']);

$result = "";
// Send email 
if(!$mail->send()) { 
    $result = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo; 
} else { 
    $result = 'Success'; 
}
echo json_encode($result);
?>