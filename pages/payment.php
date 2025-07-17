<?php
session_start();

if (empty($_SESSION['cart'])) {
    header("Location: store.php");
    exit;
}

$host = 'localhost';
$db   = 'etierreg';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$cart = $_SESSION['cart'];
$total = 0;
$subtotal = 0;
$tax = 0;
$grand_total = 0;

foreach ($cart as $id => $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$tax = $subtotal * 0.12;
$grand_total = $subtotal + $tax;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card_name = $_POST['card_name'];
    $card_number = $_POST['card_number'];
    $expiry = $_POST['expiry'];
    $cvv = $_POST['cvv'];
    $email = $_POST['email'];
    
    $stmt = $conn->prepare("INSERT INTO orders (card_name, card_number, expiry, cvv, email, amount) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssd", $card_name, $card_number, $expiry, $cvv, $email, $grand_total);
    
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        foreach ($cart as $id => $item) {
            $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param("iiid", $order_id, $id, $item['quantity'], $item['price']);
            $stmt2->execute();
            $stmt2->close();
        }
        
        // 完全复制自 account_info_reg.php 的邮件发送逻辑
        $to = $email;
        $subject = "Etier Order Confirmation #$order_id";
        $body = "<html><body>";
        $body .= "<h3>Hello $card_name!</h3>";
        $body .= "<p>Thank you for your order at Etier! Your order number is <strong>#$order_id</strong>.</p>";
        $body .= "<p>Order Details:</p>";
        $body .= "<ul>";
        foreach ($cart as $id => $item) {
            $body .= "<li>{$item['name']} - Quantity: {$item['quantity']} - Price: ₱".number_format($item['price']*$item['quantity'],2)."</li>";
        }
        $body .= "</ul>";
        $body .= "<p><strong>Total Amount: ₱".number_format($grand_total,2)."</strong></p>";
        $body .= "<p>We will process your order shortly. If you have any questions, please contact us at etiercustomerservice@gmail.com.</p>";
        $body .= "</body></html>";
        
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8\r\n";
        $headers .= "From: Etier <no-reply@etier.com>\r\n";

        if (mail($to, $subject, $body, $headers)) {
            $_SESSION['order_email'] = true;
        } else {
            $_SESSION['order_email'] = false;
        }
        
        $_SESSION['cart'] = [];
        $_SESSION['order_id'] = $order_id;
        header("Location: confirmation.php");
        exit;
    }
    $stmt->close();
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment | Etier</title>
    <style>
        body {
            font-family: 'Proxima Nova', sans-serif;
            background: #fff9f9ff;
            color: #333;
            padding-top: 200px;
        }

        .payment-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        @media (max-width: 768px) {
            .payment-container {
                grid-template-columns: 1fr;
            }
        }

        .payment-section {
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            font-size: 1.8em;
            font-weight: bold;
            color: #E6BD37;
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .payment-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .payment-form input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }

        .card-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .order-summary-item {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .order-summary-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 4px;
        }

        .item-details {
            flex: 1;
            padding: 0 15px;
        }

        .item-name {
            font-weight: bold;
            font-size: 1em;
            margin-bottom: 5px;
        }

        .item-price {
            color: #555;
        }

        .item-quantity {
            color: #777;
        }

        .order-totals {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .total-label {
            color: #555;
        }

        .total-value {
            font-weight: bold;
        }

        .grand-total {
            font-size: 1.2em;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .btn-pay {
            background: #E6BD37;
            color: #000;
            border: none;
            padding: 15px;
            font-size: 1.1em;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: background 0.3s;
        }

        .btn-pay:hover {
            background: #d9aa2f;
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 20px;
        }

        .payment-method {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .payment-method.active {
            border-color: #E6BD37;
            background: rgba(230, 189, 55, 0.1);
        }

        .payment-method img {
            max-width: 50px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="payment-section">
            <h2 class="section-title">Payment Information</h2>
            <form method="post" class="payment-form">
                <div class="card-group">
                    <div>
                        <label for="card_name">Cardholder Name</label>
                        <input type="text" id="card_name" name="card_name" required>
                    </div>
                    <div>
                        <label for="card_number">Card Number</label>
                        <input type="text" id="card_number" name="card_number" placeholder="XXXX XXXX XXXX XXXX" required>
                    </div>
                </div>
                
                <div class="card-group">
                    <div>
                        <label for="expiry">Expiry Date</label>
                        <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
                    </div>
                    <div>
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" placeholder="123" required>
                    </div>
                </div>
                
                <label for="email">Email for Order Confirmation</label>
                <input type="email" id="email" name="email" required value="<?= isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '' ?>">
                
                <h3 style="margin-top: 20px; margin-bottom: 15px;">Payment Method</h3>
                <div class="payment-methods">
                    <div class="payment-method active">
                        <img src="../assets/visa.png" alt="Visa">
                    </div>
                    <div class="payment-method">
                        <img src="../assets/mastercard.png" alt="Mastercard">
                    </div>
                    <div class="payment-method">
                        <img src="../assets/amex.png" alt="American Express">
                    </div>
                    <div class="payment-method">
                        <img src="../assets/paypal.png" alt="PayPal">
                    </div>
                </div>
                
                <button type="submit" class="btn-pay">Pay ₱<?= number_format($grand_total, 2) ?></button>
            </form>
        </div>
        
        <div class="payment-section">
            <h2 class="section-title">Order Summary</h2>
            
            <?php foreach ($cart as $id => $item): ?>
                <div class="order-summary-item">
                    <img src="../assets/<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="item-image">
                    <div class="item-details">
                        <div class="item-name"><?= $item['name'] ?></div>
                        <div class="item-price">₱<?= number_format($item['price'], 2) ?></div>
                    </div>
                    <div class="item-quantity">
                        x <?= $item['quantity'] ?>
                    </div>
                    <div class="item-subtotal">
                        ₱<?= number_format($item['subtotal'], 2) ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div class="order-totals">
                <div class="total-row">
                    <span class="total-label">Subtotal</span>
                    <span class="total-value">₱<?= number_format($subtotal, 2) ?></span>
                </div>
                <div class="total-row">
                    <span class="total-label">Shipping</span>
                    <span class="total-value">Free</span>
                </div>
                <div class="total-row">
                    <span class="total-label">Tax (12%)</span>
                    <span class="total-value">₱<?= number_format($tax, 2) ?></span>
                </div>
                <div class="total-row grand-total">
                    <span class="total-label">Total</span>
                    <span class="total-value">₱<?= number_format($grand_total, 2) ?></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethods = document.querySelectorAll('.payment-method');
            paymentMethods.forEach(method => {
                method.addEventListener('click', function() {
                    paymentMethods.forEach(m => m.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            document.getElementById('card_number').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                let formatted = '';
                
                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) formatted += ' ';
                    formatted += value[i];
                }
                
                e.target.value = formatted;
            });
            
            document.getElementById('expiry').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                let formatted = '';
                
                for (let i = 0; i < value.length; i++) {
                    if (i === 2) formatted += '/';
                    formatted += value[i];
                }
                
                e.target.value = formatted;
            });
        });
    </script>
</body>
<footer><?php include 'footer.php'; ?></footer>
</html>