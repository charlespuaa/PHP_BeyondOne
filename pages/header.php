<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html, body {
      scroll-behavior: smooth;
      font-family: 'Proxima Nova', sans-serif;
      width: 100%;
      overflow-x: hidden;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .page-wrapper {
      flex: 1;
    }

    body {
      padding-top: 120px;
    }

    header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      background: #fff;
      z-index: 999;
      border-bottom: 1px solid #eee;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 7px 20px;
      font-size: 13px;
      background-color: #fff;
      border-bottom: 1px solid #eee;
      min-height: 7px;
    }

    .top-bar-left {
      color: #000;
      font-weight: 700;
      font-size: 16px;
    }

    .top-bar-right {
      display: flex;
      gap: 15px;
      margin-right: 15px;
      font-size: 15px;
    }

    .top-bar-right a {
      color: #000;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
    }

    .top-bar-right a:hover {
      color: #E6BD37;
    }

    .top-nav {
      display: grid;
      grid-template-columns: 1fr auto 1fr;
      align-items: center;
      padding: 5px 20px;
      min-height: 50px;
    }

    .logo {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .logo img {
      width: 60px;
      height: auto;
      max-width: 100%;
      object-fit: contain;
      display: block;
    }

    .top-right {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 20px;
      margin-right: 20px;
    }

    .top-right a {
      font-size: 22px;
      color: #000;
      text-decoration: none;
      transition: color 0.3s;
    }

    .top-right a:hover {
      color: #E6BD37;
    }

    .main-nav {
      display: flex;
      justify-content: center;
      gap: 20px;
      padding: 12px 0;
      border-top: 1px solid #eee;
    }

    .main-nav a,
    .main-nav span {
      text-decoration: none;
      color: #333;
      font-size: 13px;
      font-weight: bold;
      text-transform: uppercase;
      padding: 8px;
      letter-spacing: 0.5px;
      transition: 0.3s;
    }

    .main-nav a.active,
    .main-nav span.active {
      color: #E6BD37;
      border-bottom: 2px solid #E6BD37;
    }

    .main-nav span {
      cursor: default;
    }

    @media (max-width: 768px) {
      .top-bar, .top-nav {
        flex-direction: column;
        text-align: center;
      }

      .top-bar {
        gap: 10px;
      }

      .top-bar-right {
        justify-content: center;
      }

      .main-nav {
        flex-wrap: wrap;
        gap: 10px;
      }
    }
  </style>
</head>
<body>

<header>
  <!-- Top Info Bar -->
  <div class="top-bar">
    <div class="top-bar-left">ETIER</div>
    <div class="top-bar-right">
      <a href="about_us.php">ABOUT US</a>
      <a href="#">SIGN IN</a>
    </div>
  </div>

  <!-- Logo + Icons -->
  <div class="top-nav">
    <div></div>
    <div class="logo">
      <a href="store.php">
        <img src="../assets/etier_logo_transparent.png" alt="ETIER Logo">
      </a>
    </div>
    <div class="top-right">
      <a href="#"><i class="fas fa-shopping-bag"></i></a>
    </div>
  </div>

  <!-- Navigation Categories -->
  <nav class="main-nav">
    <?php
      $categories = [
        'hatsandcaps' => 'Hats and Caps',
        'eyewear' => 'Eyewear',
        'tops' => 'Top',
        'jackets' => 'Jackets',
        'bottoms' => 'Bottom',
        'accessories' => 'Accessories',
        'handbags' => 'Hand Bags',
        'shoes' => 'Shoes',
        'fragrance' => 'Fragrance'
      ];

      $isProductPage = basename($_SERVER['PHP_SELF']) === 'product.php';

      foreach ($categories as $key => $label) {
        if ($isProductPage && isset($activeCategory) && $activeCategory === $key) {
          echo "<span class='active'>$label</span>";
        } else {
          echo "<a href='#$key' " . (isset($activeCategory) && $activeCategory === $key ? "class='active'" : "") . ">$label</a>";
        }
      }
    ?>
  </nav>
</header>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const sections = [
      'hatsandcaps', 'eyewear', 'tops', 'jackets',
      'bottoms', 'accessories', 'handbags', 'shoes', 'fragrance'
    ];

    const navLinks = document.querySelectorAll('.main-nav a');

    // Manual click highlight (keep this)
    navLinks.forEach(link => {
      link.addEventListener('click', function () {
        navLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
      });
    });

    // Scroll-based highlight
    window.addEventListener('scroll', () => {
      let current = '';

      sections.forEach(section => {
        const el = document.getElementById(section);
        if (el) {
          const sectionTop = el.offsetTop - 150;
          if (scrollY >= sectionTop) {
            current = section;
          }
        }
      });

      navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === '#' + current) {
          link.classList.add('active');
        }
      });
    });
  });
</script>


</body>
</html>
