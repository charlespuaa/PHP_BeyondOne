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
    }

    body {
      padding-top: 120px; /* Adjust this if header height changes further */
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

    /* --- TOP BAR --- */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 20px;
      font-size: 13px;
      background-color: #fff;
      border-bottom: 1px solid #eee;
    }

    .top-bar-left {
      color: #000;
      font-weight: 500;
    }

    .top-bar-right {
      display: flex;
      gap: 15px;
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

    /* --- MAIN HEADER SECTION --- */
    .top-nav {
      display: grid;
      grid-template-columns: 1fr auto 1fr;
      align-items: center;
      padding: 5px 20px;         /* reduced vertical padding */
      min-height: 80px;          /* ensures proper height */
    }

    .logo {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .logo img {
      width: 180px;              /* you can increase/decrease this */
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

    /* --- NAVIGATION --- */
    .main-nav {
      display: flex;
      justify-content: center;
      gap: 20px;
      padding: 12px 0;
      border-top: 1px solid #eee;
    }

    .main-nav a {
      text-decoration: none;
      color: #333;
      font-size: 13px;
      font-weight: bold;
      text-transform: uppercase;
      padding: 8px;
      letter-spacing: 0.5px;
      transition: 0.3s;
    }

    .main-nav a.active {
      color: #E6BD37;
      border-bottom: 2px solid #E6BD37;
    }

    /* --- RESPONSIVE --- */
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
      <a href="#">About Us</a>
      <a href="#">Sign In</a>
    </div>
  </div>

  <!-- Logo + Icons -->
  <div class="top-nav">
    <div></div>
    <div class="logo">
      <img src="../assets/EITER_logo_png.png" alt="ETIER Logo">
    </div>
    <div class="top-right">
      <a href="#"><i class="fas fa-search"></i></a>
      <a href="#"><i class="far fa-heart"></i></a>
      <a href="#"><i class="fas fa-shopping-bag"></i></a>
    </div>
  </div>

  <!-- Navigation Categories -->
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
