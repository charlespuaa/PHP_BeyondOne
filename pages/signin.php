<?php
session_start();

$host = 'localhost';
$db   = 'etierreg';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$error_message = "";

if (isset($_COOKIE['login_error'])) {
    $error_message = $_COOKIE['login_error'];
    setcookie('login_error', '', time() - 3600, "/"); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $username;
                header("Location: store.php");
                exit;
            } else {
                setcookie("login_error", "Invalid password.", 0, "/");
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        } else {
            setcookie("login_error", "Username not found.", 0, "/");
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
        $stmt->close();
    } else {
        setcookie("login_error", "Database error: {$conn->error}", 0, "/");
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In - Etier</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            background: #fff;
            padding: 20px;
            padding-top: 220px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        fieldset {
            border: 2px solid #E6BD37;
            border-radius: 10px;
            padding: 20px;
            background: #F9F9F9;
            max-width: 400px;
            margin: auto;
        }
        legend {
            font-weight: bold;
            color: #E6BD37;
        }
        label {
            display: block;
            margin-top: 15px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .error-text {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
        input[type="submit"] {
            background: #E6BD37;
            color: #000;
            font-weight: bold;
            margin-top: 20px;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #d9aa2f;
        }
        .register-link {
            max-width: 400px;
            margin: 30px auto 0;
            padding: 15px;
            border: 2px solid #E6BD37;
            border-radius: 10px;
            background: #F9F9F9;
            text-align: center;
        }
        .register-link p {
            margin-bottom: 10px;
        }
        .register-link button {
            background: #E6BD37;
            color: #000;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .register-link button:hover {
            background: #d9aa2f;
        }
    </style>
</head>
<body>

<h1>Sign In</h1>
<form method="post">
    <fieldset>
        <legend>Login</legend>
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <?php if (!empty($error_message)): ?>
            <div class="error-text"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <input type="submit" value="Sign In">
    </fieldset>
</form>

<div class="register-link">
    <p>Don't have an account?</p>
    <form action="personal_info_reg.php">
        <button type="submit">Register Now</button>
    </form>
</div>

</body>
</html>
