<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$success = '';
$error = '';
$debugOutput = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["to_email"])) {
    $to_email = $_POST["to_email"];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'iacedos11@gmail.com'; // your Gmail
        $mail->Password = 'jmtipygfrkhamygu'; // your App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Enable verbose debug output
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = function($str, $level) use (&$debugOutput) {
            $debugOutput .= htmlspecialchars($str) . "<br>";
        };

        $mail->setFrom('iacedos11@gmail.com', 'PHPMailer Tester');
        $mail->addAddress($to_email);

        $mail->isHTML(true);
        $mail->Subject = 'Test Email from PHPMailer';
        $mail->Body    = '<b>This is a test email</b> sent from your XAMPP server using Gmail SMTP.';

        $mail->send();
        $success = "✅ Message has been sent successfully to <strong>$to_email</strong>!";
    } catch (Exception $e) {
        $error = "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHPMailer Gmail Tester</title>
    <style>
        body {
            background: #F1F1F1;
            font-family: Arial, sans-serif;
            padding: 20px;
            color: #000;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        input[type="submit"] {
            background: #E6BD37;
            color: #000;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #d9aa2f;
        }
        .output {
            background: #eee;
            padding: 10px;
            margin-top: 20px;
            font-size: 14px;
            overflow-x: auto;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>PHPMailer Gmail SMTP Tester</h2>
    <form method="post" action="">
        <label for="to_email">Recipient Email:</label>
        <input type="text" id="to_email" name="to_email" placeholder="example@domain.com" required>
        <input type="submit" value="Send Test Email">
    </form>

    <?php if ($success): ?>
        <div style="color: green; margin-top: 15px;"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div style="color: red; margin-top: 15px;"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($debugOutput): ?>
        <div class="output"><?php echo $debugOutput; ?></div>
    <?php endif; ?>
</div>

</body>
</html>
