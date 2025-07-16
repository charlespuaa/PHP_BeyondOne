<?php
include '../db.php';
include 'header.php';

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

$activeCategory = strtolower(str_replace(' ', '', $product['category'])); // for header nav highlighting
$imageToShow = ($view === 'back') ? $product['hover_image'] : $product['image'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($product['name']) ?> | Etier Clothing</title>
  <style>
    body {
      font-family: 'Proxima Nova', sans-serif;
      margin: 0;
      padding: 40px, 0px;
      background-color: #F9F9F9;
      overflow: hidden;
      margin: 0;
    }

    .product-page {
      margin: 100px auto  auto; /* top center bottom center */
      max-width: 1200px;
      display: flex;
      gap: 40px;
      padding: 0 20px; /* optional horizontal padding */
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

    /* Hover effect for size and color buttons */
    .sizes button:hover,
    .colors button:hover {
      border-color: #ffffffff;
      background-color: #000000ff;
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

    /* Hover for Add to Bag button */
    .actions button:hover:not(.buy-now) {
      background-color: #E6BD37;
    }
    

    /* Buy Now button */
    .actions .buy-now {
      background: white;
      color: black;
      border: 2px solid black;
    }

    /* Hover for Buy Now button */
    .actions .buy-now:hover {
      background-color: #000000;
      color: white;
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
    }
  </style>
</head>
<body>
  <div class="product-page">
    <!-- img gallery -->
    <div class="gallery-section">
      <!-- thumbnails -->
      <div class="thumbnails">
        <a href="?id=<?= $id ?>&view=front" class="<?= ($view === 'front') ? 'active' : '' ?>">
          <img src="../assets/<?= $product['image'] ?>" alt="Front">
        </a>
        <a href="?id=<?= $id ?>&view=back" class="<?= ($view === 'back') ? 'active' : '' ?>">
          <img src="../assets/<?= $product['hover_image'] ?>" alt="Back">
        </a>
      </div>

      <!-- main image -->
      <div class="main-image">
        <img src="../assets/<?= $imageToShow ?>" alt="<?= htmlspecialchars($product['name']) ?>">
      </div>
    </div>

    <!-- product info -->
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

      <div class="sizes">
        <strong>Size:</strong><br>
        <?php foreach (['XS', 'S', 'M', 'L', 'XL'] as $size): ?>
          <button><?= $size ?></button>
        <?php endforeach; ?>
      </div>

      <div class="actions">
        <button>Add to Bag</button>
        <button class="buy-now">Buy Now</button>
      </div>
    </div>
  </div>

</body>
<?php include 'footer.php'; ?>
</html>
