<?php
session_start();

$host = 'localhost';
$db   = 'etierreg';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;


if ($user_id) {

    $sql = "SELECT product_id, quantity FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $db_cart = [];
    while ($row = $result->fetch_assoc()) {
        $db_cart[$row['product_id']] = $row['quantity'];
    }
    
  
    foreach ($_SESSION['cart'] as $id => $quantity) {
        if (isset($db_cart[$id])) {
            $new_quantity = $db_cart[$id] + $quantity;
            $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $new_quantity, $user_id, $id);
            $stmt->execute();
        } else {
            $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $user_id, $id, $quantity);
            $stmt->execute();
        }
    }
    
    $sql = "SELECT p.id, p.name, p.price, p.image, c.quantity 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $cart = [];
    $total = 0;
    while ($row = $result->fetch_assoc()) {
        $cart[$row['id']] = [
            'name' => $row['name'],
            'price' => $row['price'],
            'image' => $row['image'],
            'quantity' => $row['quantity'],
            'subtotal' => $row['price'] * $row['quantity']
        ];
        $total += $cart[$row['id']]['subtotal'];
        $_SESSION['cart'][$row['id']] = $row['quantity']; // 更新会话
    }
} else {
    $cart = [];
    $total = 0;
    
    if (!empty($_SESSION['cart'])) {
        $ids = implode(',', array_keys($_SESSION['cart']));
        $sql = "SELECT id, name, price, image FROM products WHERE id IN ($ids)";
        $result = $conn->query($sql);
        
        while ($row = $result->fetch_assoc()) {
            $quantity = $_SESSION['cart'][$row['id']];
            $cart[$row['id']] = [
                'name' => $row['name'],
                'price' => $row['price'],
                'image' => $row['image'],
                'quantity' => $quantity,
                'subtotal' => $row['price'] * $quantity
            ];
            $total += $cart[$row['id']]['subtotal'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $id => $quantity) {
            $id = intval($id);
            $quantity = intval($quantity);
            
            if ($quantity > 0) {
                $_SESSION['cart'][$id] = $quantity;
                
                if ($user_id) {
                    $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("iii", $quantity, $user_id, $id);
                    $stmt->execute();
                    
                    if ($stmt->affected_rows === 0) {
                        $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("iii", $user_id, $id, $quantity);
                        $stmt->execute();
                    }
                }
            } else {
                unset($_SESSION['cart'][$id]);
                
                if ($user_id) {
                    $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $user_id, $id);
                    $stmt->execute();
                }
            }
        }
        
        header("Location: cart.php");
        exit;
    } elseif (isset($_POST['apply_coupon'])) {
        $coupon_code = trim($_POST['coupon_code']);
        if ($coupon_code === 'ETIER10') {
            $_SESSION['coupon'] = 0.10; // 10%折扣
        } else {
            $_SESSION['coupon_error'] = "Invalid coupon code";
        }
        
        header("Location: cart.php");
        exit;
    }
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    if ($_GET['action'] === 'remove') {
        unset($_SESSION['cart'][$id]);
        
        if ($user_id) {
            $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $user_id, $id);
            $stmt->execute();
        }
        
        header("Location: cart.php");
        exit;
    } elseif ($_GET['action'] === 'clear') {
        $_SESSION['cart'] = [];
        
        if ($user_id) {
            $sql = "DELETE FROM cart WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
        }
        
        header("Location: cart.php");
        exit;
    }
}

$subtotal = $total;
$shipping = 0;
$tax_rate = 0.12;
$tax = $subtotal * $tax_rate;
$coupon_discount = isset($_SESSION['coupon']) ? $subtotal * $_SESSION['coupon'] : 0;
$grand_total = $subtotal + $shipping + $tax - $coupon_discount;

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart | Etier</title>
    <style>
        body {
            font-family: 'Proxima Nova', sans-serif;
            background: #fff9f9ff;
            color: #333;
            padding-top: 200px;
        }

        .cart-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .cart-title {
            font-size: 2.5em;
            font-weight: bold;
            color: #E6BD37;
        }

        .clear-cart {
            background: transparent;
            border: none;
            color: #777;
            font-size: 1em;
            cursor: pointer;
            padding: 5px 10px;
            transition: color 0.3s;
        }

        .clear-cart:hover {
            color: #d9534f;
        }

        .cart-items {
            margin-bottom: 40px;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 120px 2fr 1fr 1fr 1fr;
            gap: 20px;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }

        .item-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
        }

        .item-details {
            padding-right: 20px;
        }

        .item-name {
            font-weight: bold;
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        .item-brand {
            color: #888F92;
            font-size: 0.9em;
        }

        .item-price {
            font-weight: bold;
            color: #000;
            font-size: 1.1em;
        }

        .item-quantity {
            display: flex;
            align-items: center;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            background: #f1f1f1;
            border: none;
            font-size: 1.2em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-input {
            width: 50px;
            height: 30px;
            text-align: center;
            border: 1px solid #ddd;
            margin: 0 5px;
        }

        .item-subtotal {
            font-weight: bold;
            font-size: 1.1em;
        }

        .item-remove {
            color: #777;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2em;
        }

        .cart-summary {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-top: 40px;
        }

        .summary-box {
            background: #fff;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .summary-title {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .summary-label {
            color: #555;
        }

        .summary-value {
            font-weight: bold;
        }

        .summary-total {
            font-size: 1.3em;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .btn {
            display: inline-block;
            padding: 15px 30px;
            text-align: center;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            font-size: 1.1em;
            width: 100%;
            margin-top: 20px;
        }

        .btn-continue {
            background: transparent;
            color: #333;
            border: 2px solid #333;
        }

        .btn-continue:hover {
            background: #333;
            color: #fff;
        }

        .btn-checkout {
            background: #E6BD37;
            color: #000;
            border: none;
        }

        .btn-checkout:hover {
            background: #d9aa2f;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 0;
        }

        .empty-cart-icon {
            font-size: 5em;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-cart-message {
            font-size: 1.5em;
            margin-bottom: 30px;
            color: #777;
        }

        .btn-shopping {
            background: #E6BD37;
            color: #000;
            padding: 15px 40px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }

        .btn-shopping:hover {
            background: #d9aa2f;
        }

        form {
            margin: 0;
        }

        .update-cart-btn {
            background: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background 0.3s;
            display: inline-block;
            margin-top: 10px;
        }

        .update-cart-btn:hover {
            background: #555;
        }

        .coupon-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .coupon-form {
            display: flex;
            gap: 10px;
        }

        .coupon-input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .coupon-btn {
            background: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .coupon-error {
            color: #d9534f;
            margin-top: 10px;
            font-size: 0.9em;
        }

        .coupon-success {
            color: #5cb85c;
            margin-top: 10px;
            font-size: 0.9em;
        }

        .discount-row {
            color: #5cb85c;
        }

        @media (max-width: 768px) {
            .cart-item {
                grid-template-columns: 80px 1fr;
                grid-template-areas: 
                    "image details"
                    "price price"
                    "quantity quantity"
                    "subtotal remove";
                gap: 15px;
            }

            .item-image {
                grid-area: image;
                width: 80px;
                height: 80px;
            }

            .item-details {
                grid-area: details;
            }

            .item-price {
                grid-area: price;
            }

            .item-quantity {
                grid-area: quantity;
            }

            .item-subtotal {
                grid-area: subtotal;
            }

            .item-remove {
                grid-area: remove;
                text-align: right;
            }

            .cart-summary {
                grid-template-columns: 1fr;
            }
            
            .coupon-form {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <div class="cart-header">
            <h1 class="cart-title">Your Shopping Cart</h1>
            <?php if (!empty($cart)): ?>
                <button class="clear-cart" onclick="if(confirm('Are you sure you want to clear your cart?')) location.href='cart.php?action=clear'">
                    Clear Cart
                </button>
            <?php endif; ?>
        </div>

        <?php if (!empty($cart)): ?>
            <form method="post" action="cart.php">
                <div class="cart-items">
                    <?php foreach ($cart as $id => $item): ?>
                        <div class="cart-item">
                            <img src="../assets/<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="item-image">
                            <div class="item-details">
                                <div class="item-name"><?= $item['name'] ?></div>
                                <div class="item-brand">Etier</div>
                            </div>
                            <div class="item-price">₱<?= number_format($item['price'], 2) ?></div>
                            <div class="item-quantity">
                                <button type="button" class="quantity-btn minus" data-id="<?= $id ?>">-</button>
                                <input type="number" name="quantity[<?= $id ?>]" class="quantity-input" value="<?= $item['quantity'] ?>" min="1">
                                <button type="button" class="quantity-btn plus" data-id="<?= $id ?>">+</button>
                            </div>
                            <div class="item-subtotal">₱<?= number_format($item['subtotal'], 2) ?></div>
                            <button type="button" class="item-remove" onclick="location.href='cart.php?action=remove&id=<?= $id ?>'">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <button type="submit" name="update_cart" class="update-cart-btn">Update Cart</button>
            </form>

            <div class="coupon-section">
                <form method="post" class="coupon-form">
                    <input type="text" name="coupon_code" class="coupon-input" placeholder="Enter coupon code" required>
                    <button type="submit" name="apply_coupon" class="coupon-btn">Apply Coupon</button>
                </form>
                <?php if (isset($_SESSION['coupon_error'])): ?>
                    <div class="coupon-error"><?= $_SESSION['coupon_error'] ?></div>
                    <?php unset($_SESSION['coupon_error']); ?>
                <?php endif; ?>
                <?php if (isset($_SESSION['coupon'])): ?>
                    <div class="coupon-success">10% discount applied!</div>
                <?php endif; ?>
            </div>

            <div class="cart-summary">
                <div class="summary-box">
                    <h3 class="summary-title">Order Summary</h3>
                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value">₱<?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Shipping</span>
                        <span class="summary-value">Free</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Tax (12%)</span>
                        <span class="summary-value">₱<?= number_format($tax, 2) ?></span>
                    </div>
                    <?php if (isset($_SESSION['coupon'])): ?>
                        <div class="summary-row discount-row">
                            <span class="summary-label">Discount (10%)</span>
                            <span class="summary-value">-₱<?= number_format($coupon_discount, 2) ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="summary-row summary-total">
                        <span class="summary-label">Total</span>
                        <span class="summary-value">₱<?= number_format($grand_total, 2) ?></span>
                    </div>
                </div>
                
                <div class="summary-box">
                    <h3 class="summary-title">Checkout</h3>
                    <a href="store.php" class="btn btn-continue">Continue Shopping</a>
                    <a href="payment.php" class="btn btn-checkout">Proceed to Checkout</a>
                    <div style="margin-top: 20px; font-size: 0.9em; color: #777; text-align: center;">
                        <?php if ($user_id): ?>
                            <i class="fas fa-check-circle"></i> Your cart is saved to your account
                        <?php else: ?>
                            <i class="fas fa-info-circle"></i> <a href="signin.php">Sign in</a> to save your cart
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="empty-cart-message">Your cart is empty</div>
                <a href="store.php" class="btn-shopping">Continue Shopping</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.quantity-btn.minus').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const input = this.nextElementSibling;
                    if (parseInt(input.value) > 1) {
                        input.value = parseInt(input.value) - 1;
                    }
                });
            });

            document.querySelectorAll('.quantity-btn.plus').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const input = this.previousElementSibling;
                    input.value = parseInt(input.value) + 1;
                });
            });
        });
    </script>
</body>
<footer><?php include 'footer.php'; ?></footer>
</html>