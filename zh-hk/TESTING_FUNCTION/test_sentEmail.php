<?php
// Include required phpmailer files
require 'phpMailer/PHPMailer.php';
require 'phpMailer/SMTP.php';
require 'phpMailer/Exception.php';

// Define name sapces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Create instance of phpmailer
$mail = new PHPMailer();

try {
  // Server settings
  $mail -> isSMTP();
  $mail -> Host = "smtp.gmail.com";
  $mail -> SMTPAuth = "true";
  $mail -> Port = "587";
  $mail -> Username = "ivefyp487@gmail.com";
  $mail -> Password = "as102030";

  // Set sender email
  $mail -> setFrom("ivefyp487@gmail.com");

  // Add recipient
  $mail -> addAddress("tmw9151@gmail.com");

  //Content
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject = 'Here is the subject';
  $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  // Finally send email
  $mail -> Send();
  echo 'Message has been sent';
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
} finally {
  // Closing smtp connection
  $mail -> smtpClose();
}
?>