<?php
session_start(); // Start the session at the very beginning of product.php
include '../db.php';

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);

if (!isset($_GET['id'])) {
    die('Product ID missing.');
}

$id = intval($_GET['id']);
$view = $_GET['view'] ?? 'front';

$sql = "SELECT * FROM products WHERE id = $id LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die('Product not found.');
}

$product = $result->fetch_assoc();

$activeCategory = strtolower(str_replace(' ', '', $product['category']));
$imageToShow = ($view === 'back') ? $product['hover_image'] : $product['image'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= htmlspecialchars($product['name']) ?> | Etier Clothing</title>
    <?php include 'header.php'; ?>
    <style>
        /* Your existing CSS here */
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
            padding-top: 190px; /* default top padding for desktop */
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
            border-radius: 44px;
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
                width: 100%;
                height: auto;
            }

            .page-wrapper {
                padding-top: 260px;
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
                            <img src="../assets/<?= $product['image'] ?>" alt="Front">
                        </a>
                        <a href="?id=<?= $id ?>&view=back" class="<?= ($view === 'back') ? 'active' : '' ?>">
                            <img src="../assets/<?= $product['hover_image'] ?>" alt="Back">
                        </a>
                    </div>

                    <div class="main-image">
                        <img src="../assets/<?= $imageToShow ?>" alt="<?= htmlspecialchars($product['name']) ?>">
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

                    <form id="addToCartForm" action="cart.php" method="POST">
                        <input type="hidden" name="action" value="add_to_cart">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="size" id="selectedSize" value="">
                        <div class="sizes">
                            <strong>Size:</strong><br>
                            <?php foreach (['XS', 'S', 'M', 'L', 'XL'] as $size): ?>
                                <button type="button" class="size-btn" data-size="<?= $size ?>"><?= $size ?></button>
                            <?php endforeach; ?>
                        </div>

                        <div class="actions">
                            <button type="submit" id="addToBagBtn">Add to Bag</button>
                            <button type="button" id="buyNowBtn" class="buy-now">Buy Now</button>
                        </div>
                    </form>

                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="product-message <?= $_SESSION['message_type'] ?>">
                            <?= $_SESSION['message'] ?>
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

    <?php include 'footer.php'; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sizeButtons = document.querySelectorAll('.size-btn');
            const selectedSizeInput = document.getElementById('selectedSize');
            const addToBagBtn = document.getElementById('addToBagBtn');
            const buyNowBtn = document.getElementById('buyNowBtn'); // Get the Buy Now button

            const isUserLoggedIn = <?= json_encode($is_logged_in) ?>; // Pass PHP variable to JS

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

            // Handle Add to Bag button click
            addToBagBtn.addEventListener('click', function(event) {
                if (!isUserLoggedIn) {
                    event.preventDefault(); // Stop form submission
                    alert('Please sign in to add items to your bag.');
                    window.location.href = 'signin.php'; // Redirect to signin page
                } else if (selectedSizeInput.value === '') {
                    event.preventDefault(); // Stop form submission
                    alert('Please select a size before adding to bag.');
                }
            });

            // Handle Buy Now button click
            buyNowBtn.addEventListener('click', function(event) {
                event.preventDefault(); // Always prevent default for custom logic
                if (!isUserLoggedIn) {
                    alert('Please sign in to proceed with your purchase.');
                    window.location.href = 'signin.php'; // Redirect to signin page
                } else if (selectedSizeInput.value === '') {
                    alert('Please select a size before proceeding to checkout.');
                } else {
                    // If logged in and size is selected, submit the form to cart.php
                    // The cart.php will then handle adding the item and redirecting to payment.php
                    const form = document.getElementById('addToCartForm');
                    form.action = "cart.php?redirect_to_payment=true"; // Add a flag for cart.php
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>