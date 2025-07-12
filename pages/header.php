<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Font Awesome icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    /* Reset and base styling */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html, body {
      margin: 0;
      padding: 0;
      width: 100%;
      overflow-x: hidden;
    }

    body {
      font-family: 'Proxima Nova', sans-serif;
      padding-top: 120px; /* Prevent content from hiding under fixed header */
    }

    /* Fixed full-width header */
    header {
      width: 100vw;
      background: #fff;
      border-bottom: 1px solid #eee;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 999;
    }

    /* Grid layout for top nav */
    .top-nav {
      display: grid;
      grid-template-columns: 1fr auto 1fr;
      align-items: center;
      padding: 10px 20px;
    }

    /* Logo centered via grid */
    .logo {
      justify-self: center;
      font-size: 24px;
      font-weight: bold;
      letter-spacing: 1px;
      color: #000;
    }

    /* Top-right icons */
    .top-right {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 15px;
    }

    .top-right a {
      font-size: 18px;
      color: #000;
      text-decoration: none;
      transition: color 0.3s;
    }

    .top-right a:hover {
      color: #E6BD37;
    }

    /* Main category navigation */
    .main-nav {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 0;
      padding-bottom: 10px;
    }

    .main-nav a {
      text-decoration: none;
      color: #333;
      font-size: 14px;
      font-weight: bold;
      text-transform: uppercase;
      padding: 8px 10px;
      letter-spacing: 0.5px;
      transition: 0.3s;
    }

    .main-nav a.active {
      color: #E6BD37;
      border-bottom: 2px solid #E6BD37;
    }

    html {
      scroll-behavior: smooth;
    }

    /* Responsive layout for mobile */
    @media (max-width: 768px) {
      .top-nav {
        grid-template-columns: 1fr;
        text-align: center;
      }

      .top-right {
        justify-content: center;
        margin-top: 10px;
      }

      .logo {
        justify-self: center;
        margin: 10px 0;
      }

      .main-nav {
        gap: 12px;
        font-size: 13px;
        flex-wrap: wrap;
      }
    }
  </style>
</head>
<body>

<header>
  <!-- Top bar with logo and right icons -->
  <div class="top-nav">
    <div></div> <!-- left empty for spacing -->
    <div class="logo">ETIER</div>
    <div class="top-right">
      <a href="#"><i class="fas fa-search"></i></a>
      <a href="#"><i class="far fa-heart"></i></a>
      <a href="#"><i class="fas fa-shopping-bag"></i></a>
    </div>
  </div>

  <!-- Main nav links -->
  <nav class="main-nav">
    <a href="#hatsandcaps">Hats and Caps</a>
    <a href="#eyewear">Eyewear</a>
    <a href="#top">Top</a>
    <a href="#bottom">Bottom</a>
    <a href="#accessories">Accessories</a>
    <a href="#handbags">Hand Bags</a>
    <a href="#shoes">Shoes</a>
    <a href="#fragrance">Fragrance</a>
  </nav>
</header>

<!-- Script to toggle active class -->
<script>
  const navLinks = document.querySelectorAll('.main-nav a');
  navLinks.forEach(link => {
    link.addEventListener('click', function () {
      navLinks.forEach(l => l.classList.remove('active'));
      this.classList.add('active');
    });
  });
</script>

</body>
</html>
