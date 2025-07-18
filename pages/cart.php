<?php
session_start();
include '../db.php';

$user_id = null; // Initialize user_id as null

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);

if ($is_logged_in) {
    $user_id = $_SESSION['user_id'];

    // Handle adding to cart (only if logged in)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
        $product_id = intval($_POST['product_id']);
        $size = htmlspecialchars($_POST['size']);
        $quantity = intval($_POST['quantity']);

        if ($quantity <= 0) $quantity = 1;

        $stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ? AND size = ?");
        $stmt->bind_param("iis", $user_id, $product_id, $size);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($cart_item_id, $current_quantity);
            $stmt->fetch();
            $new_quantity = $current_quantity + $quantity;
            $update_stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $update_stmt->bind_param("ii", $new_quantity, $cart_item_id);
            $update_stmt->execute();
            $update_stmt->close();
        } else {
            $insert_stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, size) VALUES (?, ?, ?, ?)");
            $insert_stmt->bind_param("iiis", $user_id, $product_id, $quantity, $size);
            $insert_stmt->execute();
            $insert_stmt->close();
        }
        $stmt->close();
        header('Location: cart.php');
        exit();
    }

    // Handle updating quantity (only if logged in)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_quantity') {
        $cart_item_id = intval($_POST['cart_item_id']);
        $new_quantity = intval($_POST['quantity']);

        if ($new_quantity <= 0) {
            $delete_stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
            $delete_stmt->bind_param("ii", $cart_item_id, $user_id);
            $delete_stmt->execute();
            $delete_stmt->close();
        } else {
            $update_stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
            $update_stmt->bind_param("iii", $new_quantity, $cart_item_id, $user_id);
            $update_stmt->execute();
            $update_stmt->close();
        }
        header('Location: cart.php');
        exit();
    }

    // Handle removing item (only if logged in)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove_item') {
        $cart_item_id = intval($_POST['cart_item_id']);
        $delete_stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $delete_stmt->bind_param("ii", $cart_item_id, $user_id);
        $delete_stmt->execute();
        $delete_stmt->close();
        header('Location: cart.php');
        exit();
    }

    // Handle checkout (only if logged in)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'checkout') {
        // Verify cart is not empty
        $check_cart = $conn->prepare("SELECT COUNT(*) FROM cart WHERE user_id = ?");
        $check_cart->bind_param("i", $user_id);
        $check_cart->execute();
        $check_cart->bind_result($cart_count);
        $check_cart->fetch();
        $check_cart->close();

        if ($cart_count == 0) {
            $_SESSION['error'] = "Your cart is empty. Please add items before checkout.";
            header('Location: cart.php');
            exit();
        }
        
        // Redirect to payment page
        header('Location: payment.php');
        exit();
    }

    // Fetch cart items (only if logged in)
    $cart_items = [];
    $total_price = 0;

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
} else {
    // If not logged in, ensure cart_items and total_price are empty/zero
    $cart_items = [];
    $total_price = 0;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart | Etier</title>
    <?php include 'header.php'; ?>
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
            padding-top: 180px;
            padding-bottom: 90px;
        }
        .cart-container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .cart-header {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
            color: #333;
        }
        /* New styles for the sign-in prompt */
        .signin-prompt {
            text-align: center;
            padding: 50px 20px;
            border: 1px dashed #E6BD37;
            border-radius: 8px;
            background-color: #fffaf0; /* Light gold background */
            margin-top: 30px;
        }
        .signin-prompt h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
        }
        .signin-prompt p {
            font-size: 16px;
            color: #555;
            margin-bottom: 25px;
            line-height: 1.6;
        }
        .signin-link {
            display: inline-block;
            background: black;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .signin-link:hover {
            background-color: #E6BD37;
        }
        /* Existing cart styles below */
        .cart-item {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding: 20px 0;
            gap: 20px;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-item-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .cart-item-details {
            flex-grow: 1;
        }
        .cart-item-name {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .cart-item-size, .cart-item-price {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .cart-item-quantity input {
            width: 50px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
            font-size: 14px;
        }
        .cart-item-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            text-align: right;
        }
        .cart-item-remove-btn {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 14px;
            text-decoration: underline;
            padding: 0;
        }
        .cart-item-remove-btn:hover {
            color: #c82333;
        }
        .cart-summary {
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 20px;
            text-align: right;
            font-size: 20px;
            font-weight: bold;
        }
        .cart-total {
            margin-bottom: 20px;
        }
        .checkout-btn {
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
        .checkout-btn:hover {
            background-color: #E6BD37;
        }
        .empty-cart-message {
            text-align: center;
            font-size: 18px;
            color: #777;
            padding: 50px 0;
        }
        .error-message {
            color: #dc3545;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .page-content {
                padding-top: 220px;
            }
            .cart-container {
                padding: 20px;
                margin: 0 15px;
            }
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }
            .cart-item-image {
                width: 80px;
                height: 80px;
                margin-bottom: 10px;
            }
            .cart-item-details {
                width: 100%;
                margin-bottom: 10px;
            }
            .cart-item-quantity {
                justify-content: flex-start;
                width: 100%;
                margin-bottom: 10px;
            }
            .cart-item-actions {
                width: 100%;
                flex-direction: row;
                justify-content: space-between;
            }
            .cart-summary {
                text-align: center;
            }
            .checkout-btn {
                font-size: 16px;
                padding: 12px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="page-content">
        <div class="cart-container">
            <h1 class="cart-header">Your Shopping Cart</h1>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-message"><?= $_SESSION['error'] ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (!$is_logged_in): ?>
                <div class="signin-prompt">
                    <h2>Unlock Your Style Journey! ✨</h2>
                    <p>
                        Sign in to Etier to seamlessly manage your cart, track your orders,<br>
                        and enjoy exclusive access to our latest collections and personalized recommendations.
                    </p>
                    <a href="signin.php" class="signin-link">Sign In to Etier</a>
                </div>
            <?php elseif (empty($cart_items)): ?>
                <p class="empty-cart-message">Your cart is empty. Start shopping!</p>
            <?php else: ?>
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item">
                        <img src="../assets/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="cart-item-image">
                        <div class="cart-item-details">
                            <div class="cart-item-name"><?= htmlspecialchars($item['name']) ?></div>
                            <div class="cart-item-size">Size: <?= htmlspecialchars($item['size']) ?></div>
                            <div class="cart-item-price">₱<?= number_format($item['price'], 2) ?></div>
                            <form action="cart.php" method="POST" class="cart-item-quantity">
                                <input type="hidden" name="action" value="update_quantity">
                                <input type="hidden" name="cart_item_id" value="<?= $item['cart_item_id'] ?>">
                                Quantity:
                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="0" onchange="this.form.submit()">
                            </form>
                        </div>
                        <div class="cart-item-actions">
                            <form action="cart.php" method="POST">
                                <input type="hidden" name="action" value="remove_item">
                                <input type="hidden" name="cart_item_id" value="<?= $item['cart_item_id'] ?>">
                                <button type="submit" class="cart-item-remove-btn">Remove</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="cart-summary">
                    <div class="cart-total">Total: ₱<?= number_format($total_price, 2) ?></div>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="action" value="checkout">
                        <button type="submit" class="checkout-btn">Proceed to Checkout</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>