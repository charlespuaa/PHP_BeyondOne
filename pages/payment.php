<?php include 'header.php';
?>
<?php
// No need for session_start() here, as it's handled by header.php
include '../db.php'; // Include your database connection (still needed for cart items)

// Redirect to signin.php if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_items = [];
$total_price = 0;

// Fetch cart items for the current user to display in the order summary
$sql = "SELECT c.id as cart_item_id, p.id as product_id, p.name, p.price, p.image, p.hover_image, c.quantity, c.size
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ? ORDER BY c.added_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total_price += $row['price'] * $row['quantity'];
}
$stmt->close();

// If cart is empty, redirect back to cart page or store
if (empty($cart_items)) { 
    header('Location: cart.php');
    exit();
}

// --- Handle Payment Submission (Form Processing) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'process_payment') {
    // Get form data
    $shipping_address = htmlspecialchars($_POST['shipping_address'] ?? '');
    $phone_number = htmlspecialchars($_POST['phone_number'] ?? '');
    $email_address_for_invoice = htmlspecialchars($_POST['email'] ?? '');
    $payment_method = htmlspecialchars($_POST['payment_method'] ?? 'Credit Card');

    // In this simplified version, we just proceed to email sending and confirmation.
    // No database transactions for orders or stock management.

    // --- Send Invoice Email ---
    $to = $email_address_for_invoice;
    $subject = "Etier Clothing - Order Confirmation"; // No order ID from DB in this simplified version

    $message = "Dear Customer,\n\n";
    $message .= "Thank you for your order with Etier Clothing! Your order details are below.\n\n";
    $message .= "Order Summary:\n";
    $message .= "Total Amount: ₱" . number_format($total_price, 2) . "\n";
    $message .= "Payment Method: " . $payment_method . "\n";
    $message .= "Shipping Address: " . $shipping_address . "\n";
    $message .= "Phone Number: " . $phone_number . "\n\n";

    $message .= "Items Ordered:\n";
    foreach ($cart_items as $item) {
        $message .= "- " . $item['name'] . " (Size: " . $item['size'] . ", Qty: " . $item['quantity'] . ") - ₱" . number_format($item['price'] * $item['quantity'], 2) . "\n";
    }
    $message .= "\nWe will process your order shortly and send further updates.\n\n";
    $message .= "Thank you for shopping with Etier!\n";
    $message .= "Etier Clothing Team\n";

    $headers = "From: no-reply@etier-apparel.my-style.in\r\n"; // IMPORTANT: Replace with your actual domain's email address
    $headers .= "Reply-To: no-reply@etier-apparel.my-style.in\r\n"; // IMPORTANT: Replace with your actual domain's email address
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Attempt to send the email
    // Note: Free hosting providers like InfinityFree may have restrictions or disable PHP's mail() function.
    // For reliable email delivery in a production environment, consider using an SMTP service (e.g., SendGrid, Mailgun)
    // with a library like PHPMailer.
    if (!mail($to, $subject, $message, $headers)) {
        error_log("Failed to send order confirmation email to " . $to);
        // You might want to display a message to the user that email sending failed
        // For this simplified version, we'll proceed to the confirmation page regardless.
    }

    // Optionally, clear the cart after "successful" order placement
    $clear_cart_stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $clear_cart_stmt->bind_param("i", $user_id);
    $clear_cart_stmt->execute();
    $clear_cart_stmt->close();

    // Redirect to order placed confirmation page
    header('Location: order_placed.php'); // You'll need to create this page
    exit();
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
            padding-top: 130px; /* Adjust based on header height */
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
            margin-bottom: 30px;
            text-align: center;
            color: #333;
        }
        .order-summary-section, .payment-details-section {
            flex: 1;
            min-width: 300px; /* Ensures columns don't get too narrow */
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
            box-sizing: border-box; /* Include padding in width */
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
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
        .error-message {
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
            font-weight: normal; /* Override bold from label */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .page-content {
                padding-top: 220px; /* Adjust for mobile header height */
            }
            .checkout-container {
                flex-direction: column;
                padding: 20px;
                margin: 0 15px;
            }
            .order-summary-section, .payment-details-section {
                min-width: unset; /* Remove min-width on small screens */
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

            <?php if (isset($_GET['error']) && $_GET['error'] === 'payment_failed'): ?>
                <p class="error-message">Payment failed. Please try again or choose a different method.</p>
            <?php endif; ?>

            <div class="order-summary-section">
                <h2 class="section-title">Order Summary</h2>
                <?php if (empty($cart_items)): ?>
                    <p class="empty-cart-message" style="text-align: left; font-size: 1em; color: #555;">Your cart is empty. Please add items to proceed.</p>
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

                    <div class="form-group">
                        <label for="shipping_address">Shipping Address:</label>
                        <textarea id="shipping_address" name="shipping_address" rows="3" required placeholder="Enter your full shipping address"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Phone Number:</label>
                        <input type="tel" id="phone_number" name="phone_number" required placeholder="e.g., +639123456789">
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" required placeholder="your.email@example.com">
                        <small class="email-invoice-note">Your invoice and order updates will be sent to this email address.</small>
                    </div>

                    <div class="form-group">
                        <label for="payment_method_select">Payment Method:</label>
                        <select id="payment_method_select" name="payment_method" required>
                            <option value="">Select a method</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="PayPal">PayPal</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Cash on Delivery">Cash on Delivery (COD)</option>
                        </select>
                    </div>

                    <button type="submit" class="place-order-btn">Place Order</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
