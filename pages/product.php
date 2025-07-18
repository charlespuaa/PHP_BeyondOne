<?php
session_start(); // Start the session at the very beginning of product.php
include '../db.php'; // Ensure this path is correct for your setup

if (!isset($_GET['id'])) {
    die('Product ID missing.');
}

$id = intval($_GET['id']);
$view = $_GET['view'] ?? 'front';

$sql = "SELECT id, name, price, description, image, hover_image FROM products WHERE id = $id LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die('Product not found.');
}

$product = $result->fetch_assoc();

$imageToShow = ($view === 'back' && !empty($product['hover_image'])) ? $product['hover_image'] : $product['image'];

// --- Handle Add to Cart / Buy Now form submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    if (!isset($_SESSION['user_id'])) {
        // Store current product page URL to redirect back after sign-in
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        header('Location: signin.php');
        exit();
    }
    
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);
    $size = htmlspecialchars($_POST['size']);
    $quantity = intval($_POST['quantity']);
    $is_buy_now = isset($_POST['buy_now']) && $_POST['buy_now'] === '1'; // Check for the 'buy_now' flag

    // Basic validation for quantity
    if ($quantity <= 0) {
        $quantity = 1;
    }

    // Basic validation for size
    if (empty($size)) {
        $_SESSION['message'] = "Please select a size before adding to bag or buying.";
        $_SESSION['message_type'] = "error";
        header("Location: product.php?id=$id");
        exit();
    }

    // --- Special handling for "Buy Now" ---
    if ($is_buy_now) {
        // Store the single item in a dedicated session variable for direct checkout
        $_SESSION['buy_now_item'] = [
            'product_id' => $product_id,
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'hover_image' => $product['hover_image'], // Include if needed, though 'image' is usually sufficient for checkout display
            'quantity' => $quantity,
            'size' => $size
        ];
        header('Location: payment.php'); // Redirect directly to payment page
        exit();
    } else {
        // --- Existing "Add to Bag" logic ---
        // Check if product already exists in cart for this user and size
        $stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ? AND size = ?");
        $stmt->bind_param("iis", $user_id, $product_id, $size);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Update quantity if item already exists
            $stmt->bind_result($cart_item_id, $current_quantity);
            $stmt->fetch();
            $new_quantity = $current_quantity + $quantity;
            $update_stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $update_stmt->bind_param("ii", $new_quantity, $cart_item_id);
            $update_stmt->execute();
            $update_stmt->close();
        } else {
            // Insert new item into cart
            $insert_stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, size) VALUES (?, ?, ?, ?)");
            $insert_stmt->bind_param("iiis", $user_id, $product_id, $quantity, $size);
            $insert_stmt->execute();
            $insert_stmt->close();
        }
        $stmt->close();

        $_SESSION['message'] = "Item added to bag successfully! ✅";
        $_SESSION['message_type'] = "success";
        header("Location: product.php?id=$id"); // Redirect back to product page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($product['name']) ?> | Etier Clothing</title>
    <?php include 'header.php'; // Ensure header.php is correctly linked ?>
    <style>
        /* Your existing CSS (no changes needed here for functionality) */
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
        }

        .page-wrapper {
            padding-top: 200px; /* default top padding for desktop */
            padding-bottom: 90px;
        }

        .product-page {
            margin: 0 auto;
            max-width: 1200px;
            display: flex;
            gap: 40px;
            padding: 0 20px;
        }

        .gallery-section {
            display: flex;
            gap: 20px;
            flex: 1;
        }

        .thumbnails {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .thumbnails a img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border: 2px solid transparent;
            border-radius: 4px;
            background: white;
            transition: border-color 0.3s ease;
        }

        .thumbnails a.active img {
            border-color: black;
        }

        .main-image img {
            width: 500px;
            max-width: 500px;
            height: 500px;
            border-radius: 8px;
            background: white;
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-brand {
            font-size: 16px;
            color: #888;
            margin-bottom: 20px;
        }

        .product-price {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .product-description {
            margin-bottom: 30px;
        }

        .sizes, .colors {
            margin-bottom: 30px;
        }

        .sizes button, .colors button {
            padding: 10px 15px;
            margin-right: 10px;
            border: 1px solid #ccc;
            background: white;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        /* Added styling for selected size */
        .sizes button.selected {
            border-color: black;
            background-color: black;
            color: white;
        }

        .sizes button:hover:not(.selected),
        .colors button:hover:not(.selected) {
            border-color: #000000;
            background-color: #000000;
            color: white;
        }

        .actions {
            display: flex;
            gap: 20px;
        }

        .actions button {
            background: black;
            color: white;
            border: none;
            padding: 15px 40px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .actions button:hover:not(.buy-now) {
            background-color: #E6BD37;
        }

        .actions .buy-now {
            background: white;
            color: black;
            border: 2px solid black;
        }

        .actions .buy-now:hover {
            background-color: #000000;
            color: white;
        }

        /* Message styling */
        .product-message {
            margin-top: 15px;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .product-message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .product-message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .product-page {
                flex-direction: column;
            }

            .gallery-section {
                flex-direction: column;
                align-items: center;
            }

            .thumbnails {
                flex-direction: row;
                justify-content: center;
            }

            .main-image img {
                margin-left: 50px;
                width: 70%;
                height: auto;
            }

            .page-wrapper {
                padding-top: 130px;
            }
        }
    </style>
</head>
<body>
    <div class="page-content">
        <div class="page-wrapper">
            <div class="product-page">
                <div class="gallery-section">
                    <div class="thumbnails">
                        <a href="?id=<?= $id ?>&view=front" class="<?= ($view === 'front') ? 'active' : '' ?>">
                            <img src="../assets/<?= htmlspecialchars($product['image']) ?>" alt="Front">
                        </a>
                        <?php if (!empty($product['hover_image'])): ?>
                        <a href="?id=<?= $id ?>&view=back" class="<?= ($view === 'back') ? 'active' : '' ?>">
                            <img src="../assets/<?= htmlspecialchars($product['hover_image']) ?>" alt="Back">
                        </a>
                        <?php endif; ?>
                    </div>

                    <div class="main-image">
                        <img src="../assets/<?= htmlspecialchars($imageToShow) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    </div>
                </div>

                <div class="product-details">
                    <div class="product-name"><?= htmlspecialchars($product['name']) ?></div>
                    <div class="product-brand">Etier</div>
                    <div class="product-price">₱<?= number_format($product['price'], 2) ?></div>

                    <div class="product-description">
                        <strong>Description:</strong>
                        <p style="margin-top: 10px; line-height: 1.6; color: #444;">
                            <?= nl2br(htmlspecialchars($product['description'])) ?>
                        </p>
                    </div>

                    <form id="addToCartForm" action="product.php?id=<?= $id ?>" method="POST">
                        <input type="hidden" name="action" value="add_to_cart">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="size" id="selectedSize" value="">
                        
                        <div class="sizes">
                            <strong>Size:</strong><br>
                            <?php
                
                            $available_sizes = ['XS', 'S', 'M', 'L', 'XL']; // Example fixed sizes

               
                            ?>
                            <?php if (!empty($available_sizes)): ?>
                                <?php foreach ($available_sizes as $size): ?>
                                    <button type="button" class="size-btn" data-size="<?= htmlspecialchars($size) ?>"><?= htmlspecialchars($size) ?></button>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span style="color: #777;">No sizes available for this product.</span>
                            <?php endif; ?>
                        </div>

                        <div class="actions">
                            <button type="submit" id="addToBagBtn">Add to Bag</button>
                            <button type="button" id="buyNowBtn" class="buy-now">Buy Now</button>
                        </div>
                    </form>

                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="product-message <?= htmlspecialchars($_SESSION['message_type']) ?>">
                            <?= htmlspecialchars($_SESSION['message']) ?>
                        </div>
                        <?php
                        unset($_SESSION['message']); // Clear the message after displaying
                        unset($_SESSION['message_type']);
                        ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; // Ensure footer.php is correctly linked ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sizeButtons = document.querySelectorAll('.size-btn');
            const selectedSizeInput = document.getElementById('selectedSize');
            const addToBagBtn = document.getElementById('addToBagBtn');
            const buyNowBtn = document.getElementById('buyNowBtn');
            const addToCartForm = document.getElementById('addToCartForm');

            sizeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove 'selected' class from all buttons
                    sizeButtons.forEach(btn => btn.classList.remove('selected'));
                    // Add 'selected' class to the clicked button
                    this.classList.add('selected');
                    // Set the value of the hidden input
                    selectedSizeInput.value = this.dataset.size;
                });
            });

            // Prevent form submission if no size is selected for Add to Bag
            addToBagBtn.addEventListener('click', function(event) {
                if (selectedSizeInput.value === '') {
                    event.preventDefault(); // Stop form submission
                    alert('Please select a size before adding to bag.');
                }
            });

            // Handle Buy Now button click
            buyNowBtn.addEventListener('click', function(event) {
                if (selectedSizeInput.value === '') {
                    alert('Please select a size before proceeding.');
                    return; // Stop the process
                }
                
                // Create a hidden input to signal this is a "Buy Now" action
                const buyNowInput = document.createElement('input');
                buyNowInput.type = 'hidden';
                buyNowInput.name = 'buy_now';
                buyNowInput.value = '1';
                addToCartForm.appendChild(buyNowInput);
                
                // Submit the form
                addToCartForm.submit();
            });
        });
    </script>
</body>
</html>
<?php
// Close the database connection ONLY after all database operations are complete.
$conn->close();
?>