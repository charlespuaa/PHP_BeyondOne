<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'iacedos11@gmail.com';           // gmail address mo
    $mail->Password   = 'jmtipygfrkhamygu';             // search mo how mag get ng app password sa gmail
    $mail->SMTPSecure = 'tls';                           
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('iacedos11@gmail.com', 'ETIER Clothing');
    $mail->addAddress('charlespuasdf@gmail.com', 'Charles Pua'); // change sa email ng magrereceive

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body    = 'This is a <b>test email</b> sent using PHPMailer and Gmail SMTP.';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>