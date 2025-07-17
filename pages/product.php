<?php
include '../db.php';

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

    .sizes button:hover,
    .colors button:hover {
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

      /* added responsive fix for header overlapping */
      .page-wrapper {
        padding-top: 260px; /* increased top padding for smaller screens */
      }
    }
  </style>
</head>
<body>
  <div class="page-content">
    <div class="page-wrapper">
      <div class="product-page">
        <!-- image gallery -->
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
    </div>
  </div>

  <?php include 'footer.php'; ?>
</body>
</html>
