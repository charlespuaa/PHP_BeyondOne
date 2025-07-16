<?php
  // get current page name to apply conditional logic
  $currentPage = basename($_SERVER['PHP_SELF']);
?>

<!-- header start -->
<header class="etier-header">

  <!-- scoped styles for the header only -->
  <style>
    .etier-header *,
    .etier-header *::before,
    .etier-header *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    .etier-header {
      font-family: 'Proxima Nova', sans-serif;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 999;
      background: #fff;
      border-bottom: 1px solid #eee;
    }

    .etier-header .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 7px 20px;
      font-size: 13px;
      border-bottom: 1px solid #eee;
      height: 32px;
    }

    .etier-header .top-bar-left {
      font-weight: 700;
      font-size: 16px;
      color: #000;
    }

    .etier-header .top-bar-right {
      display: flex;
      gap: 15px;
      font-size: 15px;
    }

    .etier-header .top-bar-right a {
      color: #000;
      text-decoration: none;
      font-weight: 500;
    }

    .etier-header .top-bar-right a:hover {
      color: #e6bd37;
    }

    .etier-header .top-nav {
      display: grid;
      grid-template-columns: 1fr auto 1fr;
      align-items: center;
      padding: 5px 20px;
      border-top: 1px solid #eee;
    }

    .etier-header .logo img {
      width: 60px;
      object-fit: contain;
      display: block;
    }

    .etier-header .top-right {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 20px;
    }

    .etier-header .top-right a {
      font-size: 22px;
      color: #000;
      text-decoration: none;
    }

    .etier-header .top-right a:hover {
      color: #e6bd37;
    }

    .etier-header .main-nav {
      display: flex;
      justify-content: center;
      gap: 20px;
      padding: 12px 0;
      border-top: 1px solid #eee;
      height: 50px;
    }

    .etier-header .main-nav a,
    .etier-header .main-nav span {
      text-decoration: none;
      color: #333;
      font-size: 13px;
      font-weight: bold;
      text-transform: uppercase;
      padding: 8px;
      letter-spacing: 0.5px;
    }

    .etier-header .main-nav a.active,
    .etier-header .main-nav span.active {
      color: #e6bd37;
      border-bottom: 2px solid #e6bd37;
    }

    .etier-header .main-nav span {
      cursor: default;
    }

    /* responsive styling */
    @media (max-width: 768px) {
      .etier-header .top-bar,
      .etier-header .top-nav {
        flex-direction: column;
        text-align: center;
      }

      .etier-header .top-bar {
        gap: 10px;
      }

      .etier-header .top-bar-right {
        justify-content: center;
      }

      .etier-header .main-nav {
        flex-wrap: wrap;
        gap: 10px;
      }
    }
  </style>

  <!-- top bar with site name and links -->
  <div class="top-bar">
    <div class="top-bar-left">ETIER</div>
    <div class="top-bar-right">
      <a href="about_us.php">ABOUT US</a>
      <a href="#">SIGN IN</a>
    </div>
  </div>

  <!-- logo and icons section -->
  <div class="top-nav">
    <div></div>
    <div class="logo">
      <a href="store.php">
        <img src="../assets/etier_logo_transparent.png" alt="etier logo" />
      </a>
    </div>
    <div class="top-right">
      <a href="#"><i class="fas fa-shopping-bag"></i></a>
    </div>
  </div>

  <!-- conditional: only show nav if not on about page -->
  <?php if ($currentPage !== 'about_us.php'): ?>
    <nav class="main-nav">
      <?php
        // list of categories
        $categories = [
          'hatsandcaps' => 'hats and caps',
          'eyewear' => 'eyewear',
          'tops' => 'top',
          'jackets' => 'jackets',
          'bottoms' => 'bottom',
          'accessories' => 'accessories',
          'handbags' => 'hand bags',
          'shoes' => 'shoes',
          'fragrance' => 'fragrance'
        ];

        // check if this is the product page
        $isProductPage = $currentPage === 'product.php';

        // render nav links or span depending on active category
        foreach ($categories as $key => $label) {
          if ($isProductPage && isset($activeCategory) && $activeCategory === $key) {
            echo "<span class='active'>$label</span>";
          } else {
            echo "<a href='#$key' " . (isset($activeCategory) && $activeCategory === $key ? "class='active'" : "") . ">$label</a>";
          }
        }
      ?>
    </nav>
  <?php endif; ?>
</header>
<!-- header end -->
