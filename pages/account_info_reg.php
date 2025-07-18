<?php
$host = 'localhost';
$db   = 'etierproducts';
$user = 'root';
$pass = '';
 
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$message = "";

// Retain form inputs
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Retain hidden fields from previous steps
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
        $message = "<div class='error-text'>Please complete your personal information before registering.</div>";
    } elseif (empty($street_name) || empty($house_number) || empty($barangay) || empty($province) || empty($city) || empty($region) || empty($postal_code)) {
        $message = "<div class='error-text'>Please complete your address information before registering.</div>";
    } elseif (!preg_match("/^[A-Za-z0-9_]{3,20}$/", $username)) {
        $message = "<div class='error-text'>Invalid username format.</div>";
    } elseif (!preg_match("/^.{6,}$/", $password)) {
        $message = "<div class='error-text'>Password must be at least 6 characters.</div>";
    } elseif ($password !== $confirm_password) {
        $message = "<div class='error-text'>Passwords do not match.</div>";
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
                $subject = "Welcome to Etier – Your Account Has Been Successfully Created!";

                $body = "
                <html>
                <head>
                  <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .header { background-color: #E6BD37; padding: 20px; text-align: center; color: white; }
                    .content { padding: 20px; }
                    .footer { font-size: 0.9em; color: #777; text-align: center; padding: 20px; border-top: 1px solid #ddd; margin-top: 30px; }
                  </style>
                </head>
                <body>
                  <div class='header'>
                    <h2>Welcome to Etier</h2>
                </div>
                  <div class='content'>
                    <p>Dear <strong>$first_name</strong>,</p>
                    <p>We’re excited to welcome you to <strong>Etier</strong> – your go-to destination for stylish, high-quality apparel. Your account has been successfully created.</p>

                    <p>As a registered member, you now have access to:</p>
                    <ul>
                      <li>Exclusive product launches and offers</li>
                      <li>Faster checkout and order tracking</li>
                      <li>Personalized recommendations</li>
                    </ul>

                    <p>You may now sign in and begin shopping.</p>

                    <p>If you did not create this account or have any concerns, please let us know.</p>

                    <p>Thank you for choosing Etier. We’re glad to have you with us!</p>

                    <p>Warm regards,<br>
                    <strong>The Etier Team</strong></p>
                  </div>
                  <div class='footer'>
                    &copy; 2025 BeyondOne | Etier Clothing<br>
                    This website is for educational purposes only and is a final project requirement.
                  </div>
                </body>
                </html>";

                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8\r\n";
                $headers .= "From: Etier <no-reply@etier-clothing>\r\n";

                if (mail($to, $subject, $body, $headers)) {
                    $message = "<div class='success'>Registered! Email sent to $email.</div>";
                    echo "<script>setTimeout(function(){ window.location.href = 'signin.php'; }, 2000);</script>";
                } else {
                    $message = "<div class='error-text'>Registered, but email failed to send.</div>";
                }
            } else {
                $message = "<div class='error-text'>DB error: {$stmt->error}</div>";
            }
            $stmt->close();
        } else {
            $message = "<div class='error-text'>Prepare error: {$conn->error}</div>";
        }
    }
}

include 'header.php';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
        }
        body {
            font-family: Arial, sans-serif;
            color: #000;
            background: #fff;
            padding: 20px;
            padding-top: 170px;
        }
        fieldset {
            border: 2px solid #E6BD37;
            border-radius: 10px;
            padding: 20px;
            background: #fff;
            width: 90%;
            max-width: 480px;
            margin: auto;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        fieldset:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        }
        legend {
            font-weight: bold;
            color: #E6BD37;
            font-size: 1.2rem;
        }
        label {
            display: block;
            margin-top: 15px;
            font-size: 1rem;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #F9F9F9;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background: #E6BD37;
            color: #fff;
            font-weight: bold;
            margin-top: 20px;
            padding: 14px;
            font-size: 1.1rem;
            width: 100%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s, color 0.3s, border 0.3s;
        }
        input[type="submit"]:hover {
            background: #fff;
            color: #E6BD37;
            border: 2px solid #E6BD37;
        }
        .success, .error-text {
            text-align: center;
            padding: 10px;
            margin-top: 15px;
            font-size: 1rem;
        }
        .success { color: green; }
        .error-text { color: red; }

    /* responsiveness across devices */
        @media (max-width: 768px) {
    h1 {
        font-size: 1.7rem;
    }
    fieldset {
        padding: 16px;
        margin: 10px auto;
    }
    input[type="submit"] {
        font-size: 1rem;
        padding: 10px;
    }
}

@media (max-width: 480px) {
    h1 {
        font-size: 1.5rem;
    }
    fieldset {
        padding: 14px;
        margin: 8px auto;
    }
    input[type="text"], input[type="password"] {
        padding: 6px;
        font-size: 0.9rem;
    }
    input[type="submit"] {
        font-size: 0.95rem;
        padding: 9px;
    }
    label {
        font-size: 0.95rem;
    }
}

    </style>
</head>
<body>

<h1>Registration</h1>
<form method="post">
    <fieldset>
        <legend>Account Information</legend>
        <label>Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <?php
        foreach ($_POST as $key => $value) {
            if (!in_array($key, ['username', 'password', 'confirm_password', 'register'])) {
                echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
            }
        }
        ?>

        <?= $message ?>

        <input type="submit" name="register" value="Register">
    </fieldset>
</form>

<p style="text-align:center; margin-top: 20px;">
    Already have an account?
    <a href="signin.php" style="color: #E6BD37; text-decoration: underline;">Sign in</a>
</p>
<?php include 'footer.php'; ?>
</body>
</html>
