<?php

$currentPage = basename($_SERVER['PHP_SELF']);

// Assume you have a way to determine if a user is logged in, e.g., a session variable
$isLoggedIn = isset($_SESSION['user_id']); // Check if a 'user_id' session variable exists
?>

<header class="etier-header">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    .etier-header *, .etier-header *::before, .etier-header *::after {
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
      padding: 8px 20px;
      font-size: 13px;
      background: #000;
      border-bottom: 1px solid #333;
      flex-wrap: nowrap;
      overflow: hidden;
      position: relative;
    }

    .etier-header .top-bar-left {
      font-weight: 700;
      font-size: 16px;
      color: #FFF;
      flex-shrink: 1;
      z-index: 10;
      padding-left: 10px;
    }

    .etier-header .top-bar-left a {
      color: #FFF;
      text-decoration: none;
      font-weight: bold;
    }

    .etier-header .rotating-text-container {
        position: absolute;
        left: 0;
        right: 0;
        text-align: center;
        overflow: hidden;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
        z-index: 5;
    }

    .etier-header .rotating-text-item {
        color: #FFF;
        font-size: 14px;
        font-weight: 500;
        opacity: 0;
        position: absolute;
        transition: opacity 0.5s ease-in-out;
        white-space: nowrap;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    .etier-header .rotating-text-item.active {
        opacity: 1;
    }

    .etier-header .top-bar-right {
      display: flex;
      gap: 12px;
      font-size: 15px;
      flex-shrink: 1;
      z-index: 10;
      padding-right: 10px;
    }

    .etier-header .top-bar-right a {
      color: #FFF;
      font-weight: 600;
      text-decoration: none;
    }

    .etier-header .top-bar-right a:hover {
      color: #e6bd37;
    }

    .etier-header .top-nav {
      display: grid;
      grid-template-columns: auto 1fr auto;
      align-items: center;
      padding: 10px 20px;
      border-top: 1px solid #eee;
    }

    .etier-header .menu-toggle {
      font-size: 24px;
      cursor: pointer;
      color: #000;
      display: none; /* Hidden by default on desktop, shown by media query */
      grid-column: 1;
      justify-self: start;
    }

    .etier-header .logo {
      grid-column: 2;
      justify-self: center;
      text-align: center;
    }

    .etier-header .logo img {
      width: 80px;
      max-width: 100%;
      object-fit: contain;
      transition: filter 0.3s ease-in-out;
    }

    .etier-header .logo img:hover {
      filter: brightness(1.1);
    }

    .etier-header .top-right {
      display: flex;
      align-items: center;
      gap: 20px;
      grid-column: 3;
      justify-self: end;
    }

    .etier-header .top-right a {
      font-size: 22px;
      color: #000;
      text-decoration: none;
      padding-right: 10px;
    }

    .etier-header .top-right a:hover {
      color: #e6bd37;
    }

    .etier-header .main-nav {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 15px;
      padding: 12px 10px;
      border-top: 1px solid #eee;
      transition: max-height 0.4s ease, padding 0.4s ease;
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
      transition: all 0.3s ease;
      white-space: nowrap;
    }

    .etier-header .main-nav a:hover {
      color: #749469ff;
    }

    .etier-header .main-nav a.active,
    .etier-header .main-nav span.active {
      color: #e6bd37;
      border-bottom: 2px solid #e6bd37;
    }

    .etier-header .main-nav span {
      cursor: default;
    }

    <?php if ($currentPage === 'signin.php' && !$isLoggedIn): // Apply only if on signin.php and not logged in ?>
      .etier-header .top-bar-right a[href="signin.php"] {
        color: #e6bd37;
        font-weight: bold;
        text-decoration: underline;
      }
    <?php elseif ($isLoggedIn && $currentPage === 'my_profile.php'): // Apply if logged in and on my_profile.php ?>
      .etier-header .top-bar-right a[href="my_profile.php"] {
        color: #e6bd37;
        font-weight: bold;
        text-decoration: underline;
      }
    <?php endif; ?>

    /* responsive styles */
    @media (max-width: 768px) {
      .etier-header .top-bar {
        padding: 7px 10px;
        gap: 8px;
      }

      .etier-header .top-bar-left {
        font-size: 14px;
        flex-shrink: 0;
      }

      .etier-header .top-bar-right {
        gap: 8px;
        font-size: 14px;
        flex-shrink: 0;
      }
      .etier-header .top-bar-right a {
          font-size: 12px;
      }

      .etier-header .rotating-text-item {
          font-size: 11px;
          letter-spacing: 0.3px;
          white-space: normal;
          line-height: 1.3;
          text-overflow: ellipsis;
          overflow: hidden;
          max-height: 100%;
      }

      /* This rule will only apply if menu-toggle is present in HTML */
      .etier-header .menu-toggle {
        display: block; /* Shown on mobile */
      }

      .etier-header .logo img {
        width: 70px;
      }

      .etier-header .main-nav {
        flex-direction: column;
        align-items: flex-start;
        gap: 0;
        padding: 0 20px;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: #fff;
        border-top: 1px solid #eee;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        max-height: 0;
        overflow: hidden;
        visibility: hidden;
        opacity: 0;
        transition: max-height 0.4s ease, padding 0.4s ease, opacity 0.3s ease, visibility 0.3s ease;
      }

      .etier-header .main-nav.active {
        max-height: 400px;
        padding: 10px 20px;
        opacity: 1;
        visibility: visible;
      }

      .etier-header .main-nav a,
      .etier-header .main-nav span {
        width: 100%;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
      }

      .etier-header .main-nav a:last-child,
      .etier-header .main-nav span:last-child {
        border-bottom: none;
      }
    }

    @media (max-width: 480px) {
      .etier-header .top-bar {
        padding: 5px 8px;
        gap: 5px;
      }

      .etier-header .top-bar-left {
        font-size: 12px;
      }

      .etier-header .top-bar-right {
        gap: 5px;
      }
      .etier-header .top-bar-right a {
          font-size: 10px;
      }

      .etier-header .rotating-text-item {
          font-size: 9px;
          letter-spacing: 0.1px;
      }

      .etier-header .logo img {
        width: 60px;
      }

      .etier-header .top-right a {
        font-size: 18px;
      }
    }
  </style>

  <div class="top-bar">
    <div class="top-bar-left">
        <a href="store.php">ETIER</a>
    </div>

    <div class="rotating-text-container" id="rotatingTextContainer">
      <div class="rotating-text-item">FREE SHIPPING FOR ETIER MEMBERS</div>
      <div class="rotating-text-item">GET 10% OFF YOUR FIRST ORDER</div>
      <div class="rotating-text-item">LUXURY YOU CAN AFFORD</div>
      <div class="rotating-text-item">NEW ARRIVALS EVERY FRIDAY</div>
    </div>

    <div class="top-bar-right">
      <a href="about_us.php">ABOUT US</a>
      <?php if ($isLoggedIn): ?>
        <a href="profile.php">MY PROFILE</a>
      <?php else: ?>
        <a href="signin.php">SIGN IN</a>
      <?php endif; ?>
    </div>
  </div>

  <div class="top-nav">
    <?php
    // Define pages where menu-toggle and main-nav should NOT appear
    $noNavPages = ['about_us.php', 'signin.php', 'account_info_reg.php', 'personal_info_reg.php', 'address_info_reg.php', 'payment.php', 'my_profile.php']; // Add 'my_profile.php' here
    $showNavAndHamburger = !in_array($currentPage, $noNavPages);
    ?>

    <?php if ($showNavAndHamburger): // Only show menu toggle if navigation is needed ?>
      <div class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
      </div>
    <?php endif; ?>

    <div class="logo">
      <a href="store.php">
        <img src="../assets/etier_logo_transparent.png" alt="etier logo" />
      </a>
    </div>
    <div class="top-right">
      <a href="cart.php"><i class="fas fa-shopping-bag"></i></a> </div>
  </div>

  <?php if ($showNavAndHamburger): // Only show main navigation if needed ?>
    <nav class="main-nav" id="mainNav">
      <?php
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

        $isProductPage = $currentPage === 'product.php';

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

<?php if ($currentPage === 'store.php'): ?>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const sections = [
      'hatsandcaps', 'eyewear', 'tops', 'jackets',
      'bottoms', 'accessories', 'handbags', 'shoes', 'fragrance'
    ];

    const navLinks = document.querySelectorAll('.main-nav a');
    const menuToggle = document.getElementById('menuToggle');
    const mainNav = document.getElementById('mainNav');

    // Only add event listener if menuToggle and mainNav exist (i.e., not on pages where they are removed by PHP)
    if (menuToggle && mainNav) {
      menuToggle.addEventListener('click', () => {
        mainNav.classList.toggle('active');
        const icon = menuToggle.querySelector('i');
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-times');
      });
    }

    navLinks.forEach(link => {
      link.addEventListener('click', function () {
        navLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        if (mainNav && mainNav.classList.contains('active')) {
          mainNav.classList.remove('active');
          const icon = menuToggle.querySelector('i');
          icon.classList.add('fa-bars');
          icon.classList.remove('fa-times');
        }
      });
    });

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

    // New: JavaScript for Rotating Text
    const rotatingTextItems = document.querySelectorAll('.rotating-text-item');
    let currentTextIndex = 0;

    function showNextText() {
        rotatingTextItems[currentTextIndex].classList.remove('active');
        currentTextIndex = (currentTextIndex + 1) % rotatingTextItems.length;
        rotatingTextItems[currentTextIndex].classList.add('active');
    }

    // Initialize: show the first text
    if (rotatingTextItems.length > 0) {
        rotatingTextItems[0].classList.add('active');
    }

    // Start rotation
    setInterval(showNextText, 2000);
  });
</script>
<?php endif; ?>