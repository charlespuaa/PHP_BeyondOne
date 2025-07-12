<?php
include '../db.php';
include 'header.php'; 

$sql = "SELECT * FROM products ORDER BY category, id";
$result = $conn->query($sql);

$categories = [
  'Hats and Caps' => [],
  'Eyewear' => [],
  'Hand Bags' => [],
  'Fragrance' => []
];

while ($row = $result->fetch_assoc()) {
  if (isset($categories[$row['category']])) {
    $categories[$row['category']][] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Etier Clothing by BeyondONE</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: Proxima Nova, sans-serif;
    }
    body {
      margin: 0;
      padding: 20px;
      background: #F1F1F1;
    }
    .store-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    .category-section {
      margin-bottom: 40px;
    }
    h2.category-title {
      font-size: 24px;
      text-transform: uppercase;
      border-bottom: 2px solid #E6BD37;
      padding-bottom: 10px;
      margin-bottom: 30px;
      color: #E6BD37;
    }
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 30px;
    }
    .product-card {
      background: #e9e9e9;
      position: relative;
      text-align: center;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-radius: 8px;
      padding-bottom: 50px;
      min-height: 480px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .product-card:hover {
      transform: none;
      box-shadow: 0 4px 20px rgba(227, 195, 97, 0.34);
    }
    .image-container {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      height: 300px;
      overflow: hidden;
      background-color: white;
    }
    .image-container img {
      position: absolute;
      margin-right: 0px;
      width: 100%;
      height: 100%;
      object-fit: contain;
      transition: opacity 0.4s ease;
    }
    .hover-img {
      opacity: 0;
    }
    .image-container:hover .hover-img {
      opacity: 1;
    }
    .image-container:hover .main-img {
      opacity: 0;
    }
    .product-name {
      font-weight: bold;
      font-size: 15px;
      color: #000000;
      margin: 10px 0 3px;
      padding-left: 10px;
      padding-right: 10px;
    }
    .product-brand {
      color: #888F92;
      font-size: 13px;
      margin-bottom: 5px;
      padding-left: 10px;
      padding-right: 10px;
    }
    .product-price {
      font-weight: bold;
      font-size: 16px;
      color: #000000;
      padding-left: 10px;
      padding-right: 10px;
      margin-bottom: 30px;
    }
    .quickshop-container {
      background: #ffffff;
      padding: 20px 0;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
      width: 100%;
      position: absolute;
      bottom: 0;
      left: 0;
      z-index: 10;
    }
    .product-card:hover .quickshop-container {
      opacity: 1;
      visibility: visible;
    }
    .quickshop-button {
      background-color: transparent;
      border: 2px solid #E6BD37;
      color: #E6BD37;
      font-weight: bold;
      padding: 8px 30px;
      border-radius: 4px;
      transition: 0.3s;
      cursor: pointer;
    }
    .quickshop-button:hover {
      background-color: #E6BD37;
      color: #ffffff;
    }
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>
<body>
  <?php foreach ($categories as $categoryName => $products): ?>
    <div class="category-section" id="<?= strtolower(str_replace([' ', '&'], '', $categoryName)) ?>">
      <h2 class="category-title"><?=$categoryName?></h2>

      <div class="product-grid">
        <?php foreach ($products as $product): ?>
          <div class="product-card">
            <div class="image-container">
              <img src="../assets/<?=$product['image']?>" class="main-img" alt="<?=$product['name']?>">
              <img src="../assets/<?=$product['hover_image']?>" class="hover-img" alt="<?=$product['name']?>">
            </div>
            <div class="product-name"><?=$product['name']?></div>
            <div class="product-brand">Etier</div>
            <div class="product-price">₱<?= number_format($product['price'], 2) ?></div>
            <div class="quickshop-container">
             <a href="product.php?id=<?=$product['id']?>" class="quickshop-button">QuickShop</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

</body>
</html>