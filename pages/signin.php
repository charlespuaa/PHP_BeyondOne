<?php
session_start();

$host = 'localhost';
$db   = 'etierproducts'; // Your registration database
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$error_message = "";

if (isset($_COOKIE['login_error'])) {
    $error_message = $_COOKIE['login_error'];
    setcookie('login_error', '', time() - 3600, "/"); // Clear the cookie
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Select both password and user ID
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($user_id, $hashed_password); // Bind user_id
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;       // Store user ID in session
                $_SESSION['username'] = $username;     // Store username in session
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

// Ensure header.php includes session_start() at its very top as well.
// If not, it should be added there for consistency.
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In - Etier</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    /* sticky footer base layout */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .page-wrapper {
        min-height: 100%;
        display: flex;
        flex-direction: column;
    }

    .page-wrapper main {
        flex: 1;
    }

    body {
        font-family: Arial, sans-serif;
        color: #000;
        background: #fff;
        padding: 20px;
        padding-top: 150px;
        margin-bottom: 90px;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 2rem;
        color: #000000ff;
    }

    fieldset {
        border: 2px solid #E6BD37;
        border-radius: 10px;
        padding: 20px;
        background: #fff;
        max-width: 400px;
        margin: auto;
        width: 90%;
        box-sizing: border-box;
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
    }

    label {
        display: block;
        margin-top: 15px;
        font-size: 0.95rem;
    }

    input[type="text"], input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        background: #F9F9F9;
        box-sizing: border-box;
    }

    .error-text {
        color: red;
        font-size: 14px;
        margin-top: 10px;
        text-align: center;
    }

    input[type="submit"] {
        background: #E6BD37;
        color: #fff;
        font-weight: bold;
        margin-top: 20px;
        padding: 12px;
        width: 100%;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: background 0.3s, color 0.3s, border 0.3s;
    }

    input[type="submit"]:hover {
        background: #fff;
        color: #E6BD37;
        border: 2px solid #E6BD37;
    }

    .register-link {
        max-width: 400px;
        width: 90%;
        margin: 30px auto 0;
        padding: 15px;
        border: 2px solid #E6BD37;
        border-radius: 10px;
        background: #fff;
        text-align: center;
        box-sizing: border-box;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .register-link:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }

    .register-link p {
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .register-link button {
        background: #E6BD37;
        color: #fff;
        font-weight: bold;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: background 0.3s, color 0.3s, border 0.3s;
    }

    .register-link button:hover {
        background: #fff;
        color: #E6BD37;
        border: 2px solid #E6BD37;
    }

    /* responsiveness across devices */
    @media (max-width: 768px) {
        body {
            padding-top: 130px;
            padding-left: 10px;
            padding-right: 10px;
        }

        h1 {
            font-size: 1.6rem;
        }

        input[type="submit"],
        .register-link button {
            font-size: 0.95rem;
            padding: 10px;
        }

        label {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        h1 {
            font-size: 1.3rem;
        }

        input[type="text"],
        input[type="password"] {
            font-size: 0.95rem;
            padding: 8px;
        }

        .register-link button {
            font-size: 0.9rem;
            padding: 8px 16px;
        }

        .register-link {
            padding: 10px;
        }
    }
</style>
</head>
<body>

<div class="page-wrapper">

<main>
    <h1>Sign In</h1>
    <form method="post">
        <fieldset>
            <legend>Sign In</legend>
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
</main>

<?php include 'footer.php'; ?>

</div>
</body>
</html>