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
      padding-top: 70px; 
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
      padding: 15px 20px;
      font-size: 13px;
      background-color: #fff;
      border-bottom: 1px solid #eee;
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

    @media (max-width: 768px) {
      .top-bar {
        flex-direction: column;
        gap: 10px;
        text-align: center;
      }
      .top-bar-right {
        justify-content: center;
      }
    }
  </style>
</head>
<body>

<header>
  <div class="top-bar">
    <div class="top-bar-left">ETIER</div>
    <div class="top-bar-right">
      <a href="#">ABOUT US</a>
      <a href="#">SIGN IN</a>
    </div>
  </div>
</header>

</body>
</html>
