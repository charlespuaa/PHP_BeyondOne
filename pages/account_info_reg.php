<?php
include 'header.php';
$host = 'localhost';
$db   = 'etierreg';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$message = "";

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

$first_name = $_POST['first_name'] ?? '';
$middle_name = $_POST['middle_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$birthday = $_POST['birthday'] ?? '';
$email = $_POST['email'] ?? '';
$contact_number = $_POST['contact_number'] ?? '';
$street_name = $_POST['street_name'] ?? '';
$house_number = $_POST['house_number'] ?? '';
$building = $_POST['building'] ?? '';
$postal_code = $_POST['postal_code'] ?? '';
$barangay = $_POST['barangay'] ?? '';
$province = $_POST['province'] ?? '';
$city = $_POST['city'] ?? '';
$region = $_POST['region'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    if (empty($first_name) || empty($last_name) || empty($birthday) || empty($email) || empty($contact_number)) {
        setcookie("form_message", "<div class='error-text'>Please complete your personal information before registering.</div>", time() + 5);
    }
    elseif (empty($street_name) || empty($house_number) || empty($barangay) || empty($province) || empty($city) || empty($region) || empty($postal_code)) {
        setcookie("form_message", "<div class='error-text'>Please complete your address information before registering.</div>", time() + 5);
    }
    elseif (!preg_match("/^[A-Za-z0-9_]{3,20}$/", $username)) {
        setcookie("form_message", "<div class='error-text'>Invalid username format.</div>", time() + 5);
    } elseif (!preg_match("/^.{6,}$/", $password)) {
        setcookie("form_message", "<div class='error-text'>Password must be at least 6 characters.</div>", time() + 5);
    } elseif ($password !== $confirm_password) {
        setcookie("form_message", "<div class='error-text'>Passwords do not match.</div>", time() + 5);
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users 
            (first_name, middle_name, last_name, birthday, street_name, house_number, building, postal_code, barangay, province, city, region, username, password, email, contact_number)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssssssssssssssss",
                $first_name, $middle_name, $last_name, $birthday,
                $street_name, $house_number, $building, $postal_code,
                $barangay, $province, $city, $region,
                $username, $hashed_password, $email, $contact_number
            );
            if ($stmt->execute()) {
                $to = $email;
                $subject = "Welcome to Etier!";
                $body = "<html><body><h3>Hello $first_name!</h3><p>This is to inform you that you created an account in Etier. Please confirm by signing into our website using the credentials you have entered. If this was not you please contact us at etiercustomerservice@gmail.com.</p></body></html>";
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8\r\n";
                $headers .= "From: Etier <no-reply@yourdomain.com>\r\n";

                if (mail($to, $subject, $body, $headers)) {
                    setcookie("form_message", "<div class='success'>Registered! Email sent to $email.</div>", time() + 5);
                } else {
                    setcookie("form_message", "<div class='error-text'>Registered, but email failed to send.</div>", time() + 5);
                }
                $username = "";
            } else {
                setcookie("form_message", "<div class='error-text'>DB error: {$stmt->error}</div>", time() + 5);
            }
            $stmt->close();
        } else {
            setcookie("form_message", "<div class='error-text'>Prepare error: {$conn->error}</div>", time() + 5);
        }
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

if (isset($_COOKIE['form_message'])) {
    $message = $_COOKIE['form_message'];
    setcookie("form_message", "", time() - 3600);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Info Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            background: #fff;
            padding: 20px;
            padding-top: 150px;
        }
        fieldset {
            border: 2px solid #E6BD37;
            border-radius: 10px;
            padding: 20px;
            background: #F9F9F9;
            max-width: 500px;
            margin: auto;
        }
        legend { font-weight: bold; color: #E6BD37; }
        label { display: block; margin-top: 15px; }
        input[type="text"], input[type="password"] {
            width: 100%; padding: 8px; margin-top: 5px;
            border: 1px solid #ccc; border-radius: 5px;
        }
        input[type="submit"], .signin-button {
            background: #E6BD37; color: #000; font-weight: bold;
            margin-top: 20px; padding: 12px; width: 100%;
            border: none; border-radius: 5px; cursor: pointer;
            display: block;
        }
        input[type="submit"]:hover, .signin-button:hover { background: #d9aa2f; }
        .success, .error-text {
            text-align: center; padding: 5px; margin-top: 10px;
            font-size: 14px;
        }
        .success { color: green; }
        .error-text { color: red; }
        .back-container {
            max-width: 500px; margin: 20px auto; 
            padding: 15px; border: 2px solid #E6BD37; 
            border-radius: 10px; text-align: center;
            background: #F9F9F9;
        }
    </style>
</head>
<body>

<h1 style="text-align:center;">Registration</h1>
<form method="post">
    <fieldset>
        <legend>Account Information</legend>
        <label>Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" pattern="^[A-Za-z0-9_]{3,20}$" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <?php foreach ($_POST as $key => $value): ?>
            <?php if (!in_array($key, ['username','password','confirm_password','register'])): ?>
                <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if (!empty($message)) echo $message; ?>

        <input type="submit" name="register" value="Register">
    </fieldset>
</form>

<div class="back-container">
    <p>Already have an account?</p>
    <form action="signin.php" method="get">
        <button type="submit" class="signin-button">Go back to sign in</button>
    </form>
</div>

</body>
</html>
