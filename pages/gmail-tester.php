<?php
$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["to_email"], $_POST["message_body"])) {
    $to_email = trim($_POST["to_email"]);
    $message_body_raw = trim($_POST["message_body"]);
    $message_body_html = nl2br(htmlspecialchars($message_body_raw));

    $subject = "Test Email from PHP mail()";
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Etier Tester <no-reply@etier.local>\r\n";
    $headers .= "Reply-To: no-reply@etier.local\r\n";

    $body = "<html><body>";
    $body .= "<h2>Test Email from PHP mail()</h2>";
    $body .= "<p><strong>Message:</strong></p>";
    $body .= "<p>{$message_body_html}</p>";
    $body .= "<hr>";
    $body .= "<small>Sent from your XAMPP server using mail()</small>";
    $body .= "</body></html>";

    if (mail($to_email, $subject, $body, $headers)) {
        $success = "✅ Message successfully sent to <strong>" . htmlspecialchars($to_email) . "</strong>!";
    } else {
        $error = "❌ Failed to send email. Your server may not support mail(). Check your php.ini and sendmail configuration.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP mail() Tester</title>
    <style>
        body {
            background: #F1F1F1;
            font-family: Arial, sans-serif;
            padding: 20px;
            color: #000;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            resize: vertical;
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
            margin-top: 15px;
            font-size: 16px;
        }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>

<div class="container">
    <h2>PHP mail() SMTP Tester</h2>
    <form method="post" action="">
        <label for="to_email">Recipient Email:</label>
        <input type="text" id="to_email" name="to_email" placeholder="example@domain.com" required>

        <label for="message_body">Message:</label>
        <textarea id="message_body" name="message_body" rows="5" placeholder="Type your message here..." required></textarea>

        <input type="submit" value="Send Test Email">
    </form>

    <?php if ($success): ?>
        <div class="output success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="output error"><?php echo $error; ?></div>
    <?php endif; ?>
</div>

</body>
</html>
