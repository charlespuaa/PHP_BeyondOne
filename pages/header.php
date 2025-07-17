<?php
  $currentPage = basename($_SERVER['PHP_SELF']);
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
      padding: 7px 20px;
      font-size: 13px;
      border-bottom: 1px solid #eee;
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
      grid-template-columns: auto 1fr auto;
      align-items: center;
      padding: 10px 20px;
      border-top: 1px solid #eee;
    }

    .etier-header .menu-toggle {
      font-size: 24px;
      cursor: pointer;
      color: #000;
      display: none;
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

    <?php if ($currentPage === 'signin.php'): ?>
      .etier-header .top-bar-right a[href="signin.php"] {
        color: #e6bd37;
        font-weight: bold;
        text-decoration: underline;
      }
    <?php endif; ?>

    @media (max-width: 992px) {
      .etier-header .main-nav {
        gap: 10px;
        padding: 10px;
      }

      .etier-header .main-nav a,
      .etier-header .main-nav span {
        font-size: 12px;
        padding: 6px;
      }
    }

    @media (max-width: 768px) {
      .etier-header .top-bar {
        flex-direction: column;
        gap: 8px;
        padding: 10px;
      }

      .etier-header .menu-toggle {
        display: block;
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
      .etier-header .top-bar-right {
        flex-direction: column;
        gap: 5px;
      }

      .etier-header .top-bar-left {
        font-size: 14px;
      }

      .etier-header .top-right a {
        font-size: 18px;
      }

      .etier-header .logo img {
        width: 60px;
      }
    }
  </style>

  <div class="top-bar">
    <div class="top-bar-left">ETIER</div>
    <div class="top-bar-right">
      <a href="about_us.php">ABOUT US</a>
      <a href="signin.php">SIGN IN</a>
    </div>
  </div>

  <div class="top-nav">
    <div class="menu-toggle" id="menuToggle">
      <i class="fas fa-bars"></i>
    </div>
    <div class="logo">
      <a href="store.php">
        <img src="../assets/etier_logo_transparent.png" alt="etier logo" />
      </a>
    </div>
    <div class="top-right">
      <a href="#"><i class="fas fa-shopping-bag"></i></a>
    </div>
  </div>

  <?php if ($currentPage !== 'about_us.php' && $currentPage !== 'signin.php'): ?>
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
  });
</script>
<?php endif; ?>
