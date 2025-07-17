<?php
include '../db.php';
include 'header.php'; 

$sql = "SELECT * FROM products ORDER BY category, id";
$result = $conn->query($sql);

$categories = [
  'Hats and Caps' => [],
  'Eyewear' => [],
  'Tops' => [],
  'Jackets' => [],
  'Bottoms' => [],
  'Accessories' => [],
  'Hand Bags' => [],
  'Shoes' => [],
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
    .store-container { /*kailangan to para sa footer na di mag ka padding okay  */
      padding: 20px;
      margin: 0;
      background: #fff9f9ff;
      flex: 1;
      margin-top: 40px; /* Adjusted for header height */
    }

    
    .hero-banners-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      max-width: 1200px;
      margin: 150px auto 60px auto;
      padding: 0 20px;
    }
    .hero-banner {
      position: relative;
      height: 400px;
      overflow: hidden;
      border-radius: 4px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .hero-banner:hover {
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    .hero-banner img {
      width: 100%;
      height: 100%;
      object-fit: cover; 
      filter: brightness(0.7); 
      transition: filter 0.3s ease;
    }
    .hero-banner:hover img {
      filter: brightness(0.95);
    }
    .hero-banner-text {
      position: absolute;
      color: #fff;
      font-size: 30px;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 2px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
      text-align: center;
      padding: 20px;
    }
    
    .category-section {
      margin-bottom: 40px;
      scroll-margin-top: 140px;
    }
    .category-section:first-of-type {
      margin-top: 200px;
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
      background: #f9f2f2f7;
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
    #jackets .product-card {
        min-height: 550px; 
        padding-bottom: 60px; 
    }
    #jackets .image-container {
        height: 350px; 
    }
    #bottoms .product-card {
        min-height: 550px; 
        padding-bottom: 60px; 
    }
    #bottoms .image-container {
        height: 500px; 
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
      border-radius: 30px;
      transition: 0.3s;
      cursor: pointer;
      text-decoration: none;
    }
    .quickshop-button:hover {
      background-color: #E6BD37;
      color: #ffffff;
      text-decoration: none;
    }
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>
<body>

<div class="store-container">
  <!-- Hero Banners -->
 <div class="hero-banners-container">
        <a href="#tops" class="hero-banner">
            <img src="../assets/accessories_look.jpg" alt="Smart Casual">
            <span class="hero-banner-text">SMART CASUAL</span>
        </a>
        <a href="#accessories" class="hero-banner">
            <img src="../assets/casual_look.jpg" alt="Casual">
            <span class="hero-banner-text">CASUAL</span>
        </a>
        <a href="#bottoms" class="hero-banner">
            <img src="../assets/jacket_look.jpg" alt="StreetWear">
            <span class="hero-banner-text">STREETWEAR</span>
        </a>
  </div>


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
</div>
</body>
<?php include 'footer.php'; ?>
</html>

