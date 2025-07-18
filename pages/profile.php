<?php
session_start(); // Start the session at the very beginning


include '../db.php';

// Redirect to signin.php if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_data = null; // Initialize user data variable

// Fetch user details from the database
// Ensure your 'users' table columns match these names
$stmt = $conn->prepare("SELECT username, email, first_name, middle_name, last_name,
                               birthday, street_name, house_number, building,
                               barangay, city, region, province, postal_code, contact_number
                        FROM users WHERE id = ?");

if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user_data = $result->fetch_assoc();
    } else {
        // User ID not found in database, might be an old session or corrupted data
        // Force logout
        session_unset();
        session_destroy();
        header('Location: signin.php?error=user_not_found');
        exit();
    }
    $stmt->close();
} else {
    // Handle database prepare error
    error_log("Profile page database error: " . $conn->error);
    // You might want to redirect to an error page or show a generic error message
    die("A database error occurred. Please try again later.");
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Etier</title>
    <?php include 'header.php'; // Include your header.php which contains the styling ?>
    <style>
        body {
            font-family: 'Proxima Nova', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .page-content {
            flex: 1;
            padding-top: 180px; /* Adjust based on header height */
            padding-bottom: 90px;
        }
        .profile-container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .profile-header {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
            color: #333;
        }
        .profile-info-grid {
            display: grid;
            grid-template-columns: 1fr 2fr; /* Label on left, value on right */
            gap: 15px 20px; /* Row gap, column gap */
            margin-bottom: 30px;
        }
        .profile-info-label {
            font-weight: bold;
            color: #555;
            text-align: right; /* Align labels to the right */
        }
        .profile-info-value {
            color: #333;
            text-align: left; /* Align values to the left */
        }
        .profile-section-title {
            font-size: 20px;
            font-weight: bold;
            color: #E6BD37; /* Use your accent color */
            margin-top: 25px;
            margin-bottom: 15px;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
        }
        .logout-button-container {
            margin-top: 40px;
            text-align: center;
        }
        .logout-btn {
            background: #E6BD37;
            color: white;
            border: none;
            padding: 12px 25px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .logout-btn:hover {
            background-color: #dc2d3eff; /* Darker red on hover */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .page-content {
                padding-top: 220px; /* Adjust for mobile header height */
            }
            .profile-container {
                padding: 20px;
                margin: 0 15px;
            }
            .profile-info-grid {
                grid-template-columns: 1fr; /* Stack labels and values on small screens */
                gap: 10px;
            }
            .profile-info-label, .profile-info-value {
                text-align: left; /* Align everything to left when stacked */
            }
            .profile-info-label {
                padding-bottom: 0; /* Remove padding if stacking */
            }
            .profile-section-title {
                font-size: 18px;
            }
            .logout-btn {
                font-size: 14px;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="page-content">
        <div class="profile-container">
            <h1 class="profile-header">My Profile</h1>

            <?php if ($user_data): ?>
                <div class="profile-section-title">Account Information</div>
                <div class="profile-info-grid">
                    <div class="profile-info-label">Username:</div>
                    <div class="profile-info-value"><?= htmlspecialchars($user_data['username']) ?></div>

                    <div class="profile-info-label">Email:</div>
                    <div class="profile-info-value"><?= htmlspecialchars($user_data['email']) ?></div>

                    <div class="profile-info-label">Contact Number:</div>
                    <div class="profile-info-value"><?= htmlspecialchars($user_data['contact_number']) ?></div>
                </div>

                <div class="profile-section-title">Personal Details</div>
                <div class="profile-info-grid">
                    <div class="profile-info-label">First Name:</div>
                    <div class="profile-info-value"><?= htmlspecialchars($user_data['first_name']) ?></div>

                    <div class="profile-info-label">Middle Name:</div>
                    <div class="profile-info-value"><?= htmlspecialchars($user_data['middle_name'] ?? '') ?></div>

                    <div class="profile-info-label">Last Name:</div>
                    <div class="profile-info-value"><?= htmlspecialchars($user_data['last_name']) ?></div>

                    <div class="profile-info-label">Birthday:</div>
                    <div class="profile-info-value"><?= htmlspecialchars($user_data['birthday']) ?></div>
                </div>

                <div class="profile-section-title">Address Information</div>
                <div class="profile-info-grid">
                    <div class="profile-info-label">House/Unit No.:</div>
                    <div class="profile-info-value"><?= htmlspecialchars($user_data['house_number'] ?? 'N/A') ?></div>

                    <div class="profile-info-label">Building:</div>
                    <div class="profile-info-value"><?= htmlspecialchars($user_data['building'] ?? '-') ?></div>

                    <div class="profile-info-label">Street Name:</div>
                    <div class="profile-info-value"><?= htmlspecialchars($user_data['street_name']) ?></div>

                    <div class="profile-info-label">Barangay:</div>
                    <div class="profile-info-value"><?= htmlspecialchars($user_data['barangay']) ?></div>

                    <div class="profile-info-label">City:</div>
                    <div class="profile-info-value"><?= htmlspecialchars($user_data['city']) ?></div>

                    <div class="profile-info-label">Region:</div>
                    <div class="profile-info-value"><?= htmlspecialchars($user_data['region']) ?></div>

                    <div class="profile-info-label">Province:</div>
                    <div class="profile-info-value"><?= htmlspecialchars($user_data['province']) ?></div>

                    <div class="profile-info-label">Postal Code:</div>
                    <div class="profile-info-value"><?= htmlspecialchars($user_data['postal_code']) ?></div>
                </div>

                <div class="logout-button-container">
                    <form action="logout.php" method="POST">
                        <button type="submit" class="logout-btn">Log Out</button>
                    </form>
                </div>
            <?php else: ?>
                <p style="text-align: center; color: #777;">User data could not be loaded. Please try logging in again.</p>
                <div class="logout-button-container">
                    <form action="signin.php" method="GET">
                        <button type="submit" class="logout-btn" style="background-color: #E6BD37;">Go to Sign In</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; // Assuming you have a footer.php ?>
</body>
</html>