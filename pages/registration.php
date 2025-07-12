<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $birthday = $_POST['birthday'];
    $street_name = $_POST['street_name'];
    $house_number = $_POST['house_number'];
    $building = $_POST['building'];
    $postal_code = $_POST['postal_code'];
    $barangay = $_POST['barangay'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $region = $_POST['region'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];

    $token = bin2hex(random_bytes(16));

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'iacedos11@gmail.com'; // your Gmail
        $mail->Password = 'jmtipygfrkhamygu'; // your generated App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->Debugoutput = 'html';

        $mail->setFrom('iacedos11@gmail.com', 'My Website');
        $mail->addAddress($email, $first_name);

        $mail->isHTML(true);
        $mail->Subject = 'Confirm your registration';
        $mail->Body = "
            <h3>Hello $first_name!</h3>
            <p>Thank you for registering. Please confirm your email by clicking the link below:</p>
            <p><a href='http://localhost/verify.php?email=$email&token=$token'>Confirm Email</a></p>
            <p>If you did not sign up, please ignore this email.</p>
        ";

        $mail->send();
        echo "<div style='background:#E6BD37;color:#000;padding:10px;border-radius:5px;text-align:center;'>
                Registration successful! A confirmation email has been sent to $email.
              </div>";
    } catch (Exception $e) {
        echo "<div style='background:red;color:#fff;padding:10px;border-radius:5px;text-align:center;'>
                Email could not be sent. Mailer Error: {$mail->ErrorInfo}
              </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <style>
        body {
            background-color: #F1F1F1;
            font-family: Arial, sans-serif;
            color: #000000;
            padding: 20px;
        }
        h1 {
            color: #000000;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 10px;
        }
        label {
            display: block;
            margin-top: 15px;
            color: #000000;
        }
        input[type="text"],
        input[type="password"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .note {
            font-size: 12px;
            color: #888F92;
        }
        input[type="submit"] {
            background-color: #E6BD37;
            color: #000000;
            border: none;
            padding: 12px 20px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #d9aa2f;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Registration Form</h1>
    <form method="post" action="">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" pattern="[A-Za-z\s]+" title="Letters only">

        <label for="middle_name">Middle Name (Optional)</label>
        <input type="text" name="middle_name" id="middle_name" pattern="[A-Za-z\s]*" title="Letters only">

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" pattern="[A-Za-z\s]+" title="Letters only">

        <label for="birthday">Birthday</label>
        <input type="date" name="birthday" id="birthday">

        <label for="street_name">Street Name</label>
        <input type="text" name="street_name" id="street_name">

        <label for="house_number">House Number</label>
        <input type="text" name="house_number" id="house_number">

        <label for="building">Building (Optional)</label>
        <input type="text" name="building" id="building">

        <label for="postal_code">Postal Code</label>
        <input type="text" name="postal_code" id="postal_code" pattern="[1-9][0-9]{3}" title="Must be 4 digits starting from 1-9">

        <label for="barangay">Barangay</label>
        <input type="text" name="barangay" id="barangay">

        <label for="province">Province</label>
        <input type="text" name="province" id="province">

        <label for="city">City</label>
        <input type="text" name="city" id="city">

        <label for="region">Region</label>
        <input type="text" name="region" id="region">

        <label for="username">Username</label>
        <input type="text" name="username" id="username" pattern="^[A-Za-z0-9_]{3,20}$" title="3-20 characters, letters, numbers, underscores">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <label for="email">Email</label>
        <input type="text" name="email" id="email"
               pattern="^[A-Za-z]+[A-Za-z0-9._]*@[A-Za-z0-9]+\.[A-Za-z]{2,}$"
               title="Must be a valid email address">

        <label for="contact_number">Contact Number</label>
        <input type="text" name="contact_number" id="contact_number"
               pattern="^09[0-9]{9}$" title="Must start with 09 and be 11 digits">

        <input type="submit" value="Register">
    </form>
</div>

</body>
</html>
