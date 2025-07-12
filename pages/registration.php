<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$host = 'localhost';
$db   = 'etierreg';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

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
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];

    if (!preg_match("/^[A-Za-z0-9_]{3,20}$/", $username)) {
        $message = "<div class='error'>Invalid username format.</div>";
    } elseif (!preg_match("/^.{6,}$/", $password)) {
        $message = "<div class='error'>Password must be at least 6 characters long.</div>";
    } elseif ($password !== $confirm_password) {
        $message = "<div class='error'>Passwords do not match.</div>";
    } else {
        $sql = "INSERT INTO users 
            (first_name, middle_name, last_name, birthday, street_name, house_number, building, postal_code, barangay, province, city, region, username, password, email, contact_number) 
            VALUES 
            ('$first_name', '$middle_name', '$last_name', '$birthday', '$street_name', '$house_number', '$building', '$postal_code', '$barangay', '$province', '$city', '$region', '$username', '$password', '$email', '$contact_number')";
        
        if ($conn->query($sql) === TRUE) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'iacedos11@gmail.com';
                $mail->Password = 'jmtipygfrkhamygu';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('iacedos11@gmail.com', 'My Website');
                $mail->addAddress($email, $first_name);

                $mail->isHTML(true);
                $mail->Subject = 'Welcome to Etier Registration';
                $mail->Body = "
                    <h3 style='color: #000;'>Hello $first_name!</h3>
                    <p style='color: #000;'>Thank you for registering. Your account has been created.</p>
                ";

                $mail->send();
                $message = "<div class='success'>Registration successful! A welcome email has been sent to $email.</div>";
            } catch (Exception $e) {
                $message = "<div class='error'>Email could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
            }
        } else {
            $message = "<div class='error'>Database error: {$conn->error}</div>";
        }
    }

    if (!empty($message)) {
        setcookie("hide_message", "1", time() + 5, "/");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Etier Registration</title>
    <style>
        body {
            background-color: #F1F1F1;
            font-family: Arial, sans-serif;
            color: #000000;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #000000;
            background: #FFFFFF;
            padding: 15px;
            border-radius: 10px;
        }
        fieldset {
            background-color: #FFFFFF;
            border: 2px solid #E6BD37;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        legend {
            font-weight: bold;
            color: #E6BD37;
            padding: 0 10px;
        }
        label {
            display: block;
            margin-top: 15px;
        }
        input[type="text"],
        input[type="password"],
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #E6BD37;
            color: #000000;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            border: none;
        }
        input[type="submit"]:hover {
            background-color: #d9aa2f;
        }
        .success {
            background: #E6BD37;
            color: #000000;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin: 20px 0;
        }
        .error {
            background: red;
            color: #FFFFFF;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>

<h1>Etier Registration</h1>
<?php
if (!empty($message) && isset($_COOKIE["hide_message"])) {
    echo $message;
}
?>
<form method="post" action="">
    <fieldset>
        <legend>Personal Information</legend>
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" pattern="[A-Za-z\s]+" required>

        <label for="middle_name">Middle Name (Optional)</label>
        <input type="text" name="middle_name" id="middle_name" pattern="[A-Za-z\s]*">

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" pattern="[A-Za-z\s]+" required>

        <label for="birthday">Birthday</label>
        <input type="date" name="birthday" id="birthday" required>

        <label for="email">Email</label>
        <input type="text" name="email" id="email" pattern="^[A-Za-z]+[A-Za-z0-9._]*@[A-Za-z0-9]+\.[A-Za-z]{2,}$" required>

        <label for="contact_number">Contact Number</label>
        <input type="text" name="contact_number" id="contact_number" pattern="^09[0-9]{9}$" required>
    </fieldset>

    <fieldset>
        <legend>Address Information</legend>
        <label for="street_name">Street Name</label>
        <input type="text" name="street_name" id="street_name" required>

        <label for="house_number">House Number</label>
        <input type="text" name="house_number" id="house_number" required>

        <label for="building">Building (Optional)</label>
        <input type="text" name="building" id="building">

        <label for="postal_code">Postal Code</label>
        <input type="text" name="postal_code" id="postal_code" pattern="[1-9][0-9]{3}" required>

        <label for="barangay">Barangay</label>
        <input type="text" name="barangay" id="barangay" required>

        <label for="province">Province</label>
        <input type="text" name="province" id="province" required>

        <label for="city">City</label>
        <input type="text" name="city" id="city" required>

        <label for="region">Region</label>
        <input type="text" name="region" id="region" required>
    </fieldset>

    <fieldset>
        <legend>Account Information</legend>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" pattern="^[A-Za-z0-9_]{3,20}$" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
    </fieldset>

    <input type="submit" value="Register">
</form>

</body>
</html>
