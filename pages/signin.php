<?php
session_start();

// Database connection details
$host = 'localhost';
$db   = 'etierproducts'; // Confirmed to be 'etierproducts'
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

// Check for and clear login error cookie
if (isset($_COOKIE['login_error'])) {
    $error_message = $_COOKIE['login_error'];
    setcookie('login_error', '', time() - 3600, "/"); // Clear the cookie by setting its expiration to the past
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // --- DEBUGGING START ---
    echo "<h2>DEBUGGING LOGIN PROCESS</h2>";
    echo "<p>Attempting login for username: <strong>" . htmlspecialchars($username) . "</strong></p>";
    // --- DEBUGGING END ---

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // --- DEBUGGING START ---
        echo "<p>SQL query prepared and executed. Number of rows found: <strong>" . $stmt->num_rows . "</strong></p>";
        // --- DEBUGGING END ---

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($user_id, $hashed_password);
            $stmt->fetch();

            // --- DEBUGGING START ---
            echo "<p>User found in DB. User ID: <strong>" . $user_id . "</strong></p>";
            echo "<p>Hashed password from DB: <strong>" . htmlspecialchars($hashed_password) . "</strong></p>";
            echo "<p>Password entered (for comparison, DO NOT DISPLAY IN PRODUCTION): <strong>" . htmlspecialchars($password) . "</strong></p>";
            // --- DEBUGGING END ---

            if (password_verify($password, $hashed_password)) {
                // --- DEBUGGING START ---
                echo "<p style='color: green; font-weight: bold;'>Password verified successfully!</p>";
                // --- DEBUGGING END ---

                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;

                // --- DEBUGGING START ---
                echo "<p>Session user_id set to: <strong>" . $_SESSION['user_id'] . "</strong></p>";
                echo "<p>Session username set to: <strong>" . $_SESSION['username'] . "</strong></p>";
                echo "<p style='color: blue;'>Redirecting to store.php...</p>";
                // If you want to see the debug messages, TEMPORARILY comment out the header() and exit; lines below
                // then uncomment them to resume normal behavior.
                // sleep(2); // Optional: pause for 2 seconds to see messages before redirect
                // --- DEBUGGING END ---

                $stmt->close();
                $conn->close(); // Close connection before redirect
                header("Location: store.php"); // Redirect to store page on successful login
                exit; // Important: terminate script after redirect
            } else {
                // --- DEBUGGING START ---
                echo "<p style='color: red; font-weight: bold;'>Password verification FAILED.</p>";
                echo "<p style='color: blue;'>Redirecting back to signin.php (due to invalid password)...</p>";
                // --- DEBUGGING END ---
                $stmt->close();
                $conn->close(); // Close connection before redirect
                setcookie("login_error", "Invalid password.", 0, "/"); // Set error cookie
                header("Location: " . $_SERVER['PHP_SELF']); // Redirect back to signin page
                exit; // Important: terminate script after redirect
            }
        } else {
            // --- DEBUGGING START ---
            echo "<p style='color: red; font-weight: bold;'>Username not found in the database.</p>";
            echo "<p style='color: blue;'>Redirecting back to signin.php (due to username not found)...</p>";
            // --- DEBUGGING END ---
            $stmt->close();
            $conn->close(); // Close connection before redirect
            setcookie("login_error", "Username not found.", 0, "/"); // Set error cookie
            header("Location: " . $_SERVER['PHP_SELF']); // Redirect back to signin page
            exit; // Important: terminate script after redirect
        }
    } else {
        // --- DEBUGGING START ---
        echo "<p style='color: red; font-weight: bold;'>Database prepare error: " . htmlspecialchars($conn->error) . "</p>";
        echo "<p style='color: blue;'>Redirecting back to signin.php (due to database error)...</p>";
        // --- DEBUGGING END ---
        $conn->close(); // Close connection before redirect
        setcookie("login_error", "Database error: {$conn->error}", 0, "/"); // Set error cookie
        header("Location: " . $_SERVER['PHP_SELF']); // Redirect back to signin page
        exit; // Important: terminate script after redirect
    }
}

// Include header.php AFTER all potential header() redirects
// This is the crucial change to prevent "headers already sent" error.
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In - Etier</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
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
        color: #E6BD37;
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

    /* responsiveness */
    @media (max-width: 768px) {
        body {
            padding-top: 130px;
            padding-left: 10px;
            padding-right: 10px;
        }

        h1 {
            font-size: 1.6rem;
        }

        input[type="submit"] {
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

    <p style="text-align: center; margin-top: 20px; color: black;">
        Don't have an account yet?
    </p>
    <p style="text-align: center;">
        <a href="personal_info_reg.php" style="color: #E6BD37; text-decoration: underline; font-weight: bold;">
            Register Now
        </a>
    </p>
</main>

<?php include 'footer.php'; ?>
</div>

</body>
</html>