<?php
require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->isSMTP();  

$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);  
                               // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';                    // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                            // Enable SMTP authentication
$mail->Username = 'bubbalab.marikina@gmail.com';          // SMTP username
$mail->Password = 'bubbalabfoodservices'; // SMTP password
$mail->SMTPSecure = 'tls';                         // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                 // TCP port to connect to

$mail->setFrom('bubbalab.marikina@gmail.com', 'Bubba Lab Marikina');
//$mail->addReplyTo('email@codexworld.com', 'CodexWorld');
$mail->addAddress('christin_santos@dlsu.edu.ph');   // Add a recipient
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

$mail->isHTML(true);  // Set email format to HTML

$bodyContent = '<h1>Bubba Lab - Purchase Order Form</h1>';
$bodyContent .= '<p>Click the <b><a href="http://localhost/APPDEV/production/ConfirmOrder.html">link </a> </b>for confirmation</p>';



$mail->Subject = 'Bubbalab Marikina - Purchase Order Form';
$mail->Body    = $bodyContent;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
?>
