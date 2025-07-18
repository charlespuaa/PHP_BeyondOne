<?php
session_start();

include 'header.php';
include '../db.php'; // Include your database connection

// Redirect to signin.php if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_items = []; // This will hold either the cart items or the single buy-now item
$total_price = 0;

// Initialize form variables to prevent "Undefined variable" warnings on first load
$shipping_address = '';
$phone_number = '';
$email_address_for_invoice = '';
$payment_method = '';

// --- Determine if this is a "Buy Now" checkout or regular cart checkout ---
if (isset($_SESSION['buy_now_item']) && !empty($_SESSION['buy_now_item'])) {
    // This is a "Buy Now" transaction
    $buy_now_item = $_SESSION['buy_now_item'];
    $cart_items[] = $buy_now_item; // Add the single item to the list
    $total_price = $buy_now_item['price'] * $buy_now_item['quantity'];
} else {
    // This is a regular cart checkout
    // Fetch cart items for the current user to display in the order summary
    $sql = "SELECT c.id as cart_item_id, p.id as product_id, p.name, p.price, p.image, p.hover_image, c.quantity, c.size
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ? ORDER BY c.added_at DESC";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        error_log("Payment Page: Prepare failed: (" . $conn->errno . ") " . $conn->error);
        header('Location: error_page.php?msg=db_error');
        exit();
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
        $total_price += $row['price'] * $row['quantity'];
    }
    $stmt->close();
}

// If no items (neither buy now nor cart), redirect back to cart page or store
if (empty($cart_items)) {
    header('Location: cart.php?empty_checkout=true');
    exit();
}

// Initialize error messages for specific fields
$general_error_message = '';
$shipping_address_error = '';
$phone_number_error = '';
$email_error = '';
$payment_method_error = '';


// --- Handle Payment Submission (Form Processing) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'process_payment') {
    // Get form data
    $shipping_address = htmlspecialchars(trim($_POST['shipping_address'] ?? ''));
    $phone_number = htmlspecialchars(trim($_POST['phone_number'] ?? ''));
    $email_address_for_invoice = htmlspecialchars(trim($_POST['email'] ?? ''));
    $payment_method = htmlspecialchars(trim($_POST['payment_method'] ?? '')); // Ensure this is initialized from POST data

    // Flag to track overall validation status
    $is_valid = true;

    // Validate Shipping Address
    if (empty($shipping_address)) {
        $shipping_address_error = 'Shipping address is required. ';
        $is_valid = false;
    }

    // Validate Phone Number with Regex for Philippines
    $cleaned_phone_number = preg_replace('/[^0-9+]/', '', $phone_number); // Remove non-numeric chars except '+'
    $ph_phone_regex = '/^(09|\+639)\d{9}$/'; // Regex for 09xxxxxxxxx or +639xxxxxxxxx

    if (empty($phone_number)) {
        $phone_number_error = 'Phone number is required. ';
        $is_valid = false;
    } elseif (!preg_match($ph_phone_regex, $cleaned_phone_number)) {
        $phone_number_error = 'Invalid Philippine phone number format. Use 09xxxxxxxxx or +639xxxxxxxxx. ';
        $is_valid = false;
    }

    // Validate Email
    if (empty($email_address_for_invoice)) {
        $email_error = 'Email address is required. 📧';
        $is_valid = false;
    } elseif (!filter_var($email_address_for_invoice, FILTER_VALIDATE_EMAIL)) {
        $email_error = 'Invalid email address format. ';
        $is_valid = false;
    }

    // Validate Payment Method
    if (empty($payment_method)) {
        $payment_method_error = 'Please select a payment method. ';
        $is_valid = false;
    }

    if ($is_valid) {
        // If validation passes, proceed with email and order processing

        // --- Send Invoice Email ---
        $to = $email_address_for_invoice;
        $subject = "Etier Clothing - Order Confirmation";
        $message = "Dear Customer,\n\n";
        $message .= "Thank you for your order with Etier Clothing! Your order details are below.\n\n";
        $message .= "Order Summary:\n";
        $message .= "Total Amount: ₱" . number_format($total_price, 2) . "\n";
        $message .= "Payment Method: " . $payment_method . "\n";
        $message .= "Shipping Address: " . $shipping_address . "\n";
        $message .= "Phone Number: " . $phone_number . "\n\n"; // Use original $phone_number for email

        $message .= "Items Ordered:\n";
        foreach ($cart_items as $item) {
            $message .= "- " . htmlspecialchars($item['name']) . " (Size: " . htmlspecialchars($item['size']) . ", Qty: " . $item['quantity'] . ") - ₱" . number_format($item['price'] * $item['quantity'], 2) . "\n";
        }
        $message .= "\nWe will process your order shortly and send further updates.\n\n";
        $message .= "Thank you for shopping with Etier!\n";
        $message .= "Etier Clothing Team\n";

        $headers = "From: no-reply@etier-apparel.my-style.in\r\n";
        $headers .= "Reply-To: no-reply@etier-apparel.my-style.in\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Attempt to send the email
        if (!mail($to, $subject, $message, $headers)) {
            error_log("Failed to send order confirmation email to " . $to . " for user " . $user_id);
        }

        // --- Clear cart items or buy_now_item after "successful" order placement ---
        if (isset($_SESSION['buy_now_item'])) {
            unset($_SESSION['buy_now_item']);
        } else {
            $clear_cart_stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
            if ($clear_cart_stmt === false) {
                error_log("Payment Page: Clear cart prepare failed: (" . $conn->errno . ") " . $conn->error);
            } else {
                $clear_cart_stmt->bind_param("i", $user_id);
                $clear_cart_stmt->execute();
                $clear_cart_stmt->close();
            }
        }

        // Redirect to order_placed.php
        if (headers_sent()) {
            echo '<script>window.location.href = "order_placed.php";</script>';
        } else {
            header('Location: order_placed.php');
        }
        exit();
    } 
    
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Etier</title>
    <style>
        /* Your existing CSS */
        body {
            font-family: 'Proxima Nova', sans-serif;
            background-color: #ffffffff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .page-content {
            flex: 1;
            padding-top: 130px;
            padding-bottom: 90px;
        }
        .checkout-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }
        .checkout-header {
            width: 100%;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
            color: #333;
        }
        .order-summary-section, .payment-details-section {
            flex: 1;
            min-width: 300px;
        }
        .section-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #E6BD37;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        .order-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #eee;
        }
        .order-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .order-item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .order-item-info {
            flex-grow: 1;
        }
        .order-item-name {
            font-weight: bold;
            font-size: 16px;
        }
        .order-item-details {
            font-size: 13px;
            color: #666;
        }
        .order-total-summary {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #E6BD37;
            font-size: 20px;
            font-weight: bold;
            text-align: right;
        }
        .form-group {
            margin-bottom: 20px;
            position: relative; /* Needed for absolute positioning of error message */
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="tel"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s ease; /* Smooth transition for border color */
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        /* New CSS for error styling */
        .form-group.error input,
        .form-group.error textarea,
        .form-group.error select {
            border-color: #dc3545; /* Red border for invalid fields */
        }
        .input-error-message {
            color: #dc3545;
            font-size: 0.85em;
            margin-top: 5px;
            display: block; /* Ensures it takes its own line */
            font-weight: normal;
        }

        .payment-options {
            margin-top: 20px;
            margin-bottom: 30px;
        }
        .payment-option {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .payment-option input[type="radio"] {
            margin-right: 10px;
        }
        .place-order-btn {
            background: black;
            color: white;
            border: none;
            padding: 15px 30px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            font-size: 18px;
        }
        .place-order-btn:hover {
            background-color: #E6BD37;
        }
        .general-error-message { /* Renamed for clarity */
            color: #dc3545;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .email-invoice-note {
            font-size: 0.9em;
            color: #888;
            margin-top: 5px;
            display: block;
            font-weight: normal;
        }

        @media (max-width: 768px) {
            .page-content {
                padding-top: 100px;
            }
            .checkout-container {
                flex-direction: column;
                padding: 20px; /* Adjusted padding for better spacing */
                margin: 0 15px;
            }
            .order-summary-section, .payment-details-section {
                min-width: unset;
                width: 100%;
            }
            .section-title {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="page-content">
        <div class="checkout-container">
            <h1 class="checkout-header">Checkout</h1>

            <?php
            // Display general error message if set
            if (!empty($general_error_message)) {
                echo '<p class="general-error-message">' . htmlspecialchars($general_error_message) . '</p>';
            }
            ?>

            <div class="order-summary-section">
                <h2 class="section-title">Order Summary</h2>
                <?php if (empty($cart_items)): ?>
                    <p class="empty-cart-message" style="text-align: left; font-size: 1em; color: #555;">No items to display for checkout.</p>
                <?php else: ?>
                    <?php foreach ($cart_items as $item): ?>
                        <div class="order-item">
                            <img src="../assets/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="order-item-image">
                            <div class="order-item-info">
                                <div class="order-item-name"><?= htmlspecialchars($item['name']) ?></div>
                                <div class="order-item-details">
                                    Quantity: <?= $item['quantity'] ?> | Size: <?= htmlspecialchars($item['size']) ?> | ₱<?= number_format($item['price'], 2) ?> each
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="order-total-summary">
                        Total: ₱<?= number_format($total_price, 2) ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="payment-details-section">
                <h2 class="section-title">Shipping & Payment</h2>
                <form action="payment.php" method="POST">
                    <input type="hidden" name="action" value="process_payment">

                    <div class="form-group <?= !empty($shipping_address_error) ? 'error' : '' ?>">
                        <label for="shipping_address">Shipping Address:</label>
                        <textarea id="shipping_address" name="shipping_address" rows="3" required placeholder="Enter your full shipping address"><?= htmlspecialchars($shipping_address) ?></textarea>
                        <?php if (!empty($shipping_address_error)): ?>
                            <span class="input-error-message"><?= $shipping_address_error ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group <?= !empty($phone_number_error) ? 'error' : '' ?>">
                        <label for="phone_number">Phone Number:</label>
                        <input type="tel" id="phone_number" name="phone_number" value="<?= htmlspecialchars($phone_number) ?>" required placeholder="+639xxxxxxxxx or 09xxxxxxxxx">
                        <?php if (!empty($phone_number_error)): ?>
                            <span class="input-error-message"><?= $phone_number_error ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group <?= !empty($email_error) ? 'error' : '' ?>">
                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email_address_for_invoice) ?>" required placeholder="your.email@example.com">
                        <small class="email-invoice-note">Your invoice and order updates will be sent to this email address.</small>
                        <?php if (!empty($email_error)): ?>
                            <span class="input-error-message"><?= $email_error ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group <?= !empty($payment_method_error) ? 'error' : '' ?>">
                        <label for="payment_method_select">Payment Method:</label>
                        <select id="payment_method_select" name="payment_method" required>
                            <option value="">Select a method</option>
                            <option value="Credit Card" <?= ($payment_method === 'Credit Card' ? 'selected' : '') ?>>Credit Card</option>
                            <option value="GCash" <?= ($payment_method === 'GCash' ? 'selected' : '') ?>>GCash</option>
                            <option value="Bank Transfer" <?= ($payment_method === 'Bank Transfer' ? 'selected' : '') ?>>Bank Transfer</option>
                            <option value="Cash on Delivery" <?= ($payment_method === 'Cash on Delivery' ? 'selected' : '') ?>>Cash on Delivery (COD)</option>
                        </select>
                        <?php if (!empty($payment_method_error)): ?>
                            <span class="input-error-message"><?= $payment_method_error ?></span>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="place-order-btn">Place Order</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>