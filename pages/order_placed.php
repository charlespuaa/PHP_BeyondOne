<?php
session_start(); // Start the session to access session variables
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed! | Etier</title>
    <style>
        /* Basic styling for the confirmation page */
        body {
            font-family: 'Proxima Nova', sans-serif; /* Consistent with your header */
            background-color: #ffffffff; /* Consistent background */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            text-align: center; /* Center content */
        }

        .page-content {
            flex: 1;
            padding-top: 150px; /* Adjust based on header height, giving space below fixed header */
            padding-bottom: 90px; /* Space for footer */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .confirmation-message {
            max-width: 600px;
            margin: 50px auto; /* Centered with vertical margin */
            padding: 40px;
            background: #fff;
            border-radius: 12px; /* Rounded corners */
            box-shadow: 0 5px 15px rgba(0,0,0,0.1); /* Soft shadow */
            text-align: center;
        }

        h1 {
            color: #E6BD37; /* Your brand accent color */
            font-size: 2.5em;
            margin-bottom: 20px;
            font-weight: bold;
        }

        p {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .back-to-store {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background-color: black;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-weight: bold;
            font-size: 1.05em;
        }

        .back-to-store:hover {
            background-color: #E6BD37; /* Hover effect for button */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .page-content {
                padding-top: 220px; /* Adjust for mobile header height */
            }
            .confirmation-message {
                padding: 30px 20px;
                margin: 30px 15px;
            }
            h1 {
                font-size: 2em;
            }
            p {
                font-size: 1em;
            }
            .back-to-store {
                padding: 10px 20px;
                font-size: 0.95em;
            }
        }

        @media (max-width: 480px) {
            .confirmation-message {
                padding: 20px 15px;
                margin: 20px 10px;
            }
            h1 {
                font-size: 1.8em;
            }
            p {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <div class="page-content">
        <div class="confirmation-message">
            <h1>Order Placed!</h1>
            <p>Thank you for your purchase from Etier Clothing. Your order has been successfully received.</p>
            <p>An invoice and further updates regarding your order will be sent to the email address you provided shortly.</p>
            <a href="store.php" class="back-to-store">Continue Shopping</a>
        </div>
    </div>

    <?php
    include 'footer.php';
    ?>
</body>
</html>
