<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us - Etier Clothing by BeyondONE</title>
  <meta name="description" content="Learn more about Etier Clothing by BeyondONE – the people behind timeless fashion pieces that empower bold expression."/>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"/>

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #fff9f9ff;
      color: #333;
      line-height: 1.6;
      padding-top: 100px;
      margin: 0;
    }

    .about-container {
      max-width: 900px;
      margin: 0 auto;
      padding: 60px 20px 10px;
    }

    .about-banner-image {
      width: 100%;
      height: 450px;
      object-fit: cover;
      display: block;
      margin-bottom: 50px;
      padding:10px;
      border-radius: 8px;
    }

    .section-title {
      font-size: 3em;
      font-weight: bold;
      color: #E6BD37;
      margin-bottom: 20px;
      margin-top: 10px;
    }

    .section-content p {
      font-size: 1.1em;
      margin-bottom: 20px;
      text-align: justify;
      line-height: 1.8;
      color: #555;
    }

    .team-section {
      margin-top: 60px;
    }

    .team-grid {
      display: grid;
      grid-template-columns: 2fr 3fr;
      gap: 30px;
      align-items: center;
      margin-bottom: 40px;
    }

    .team-member-name {
      font-size: 1.8em;
      font-weight: bold;
      color: #000;
      margin-bottom: 5px;
    }

    .team-member-role {
      font-size: 1.1em;
      color: #777;
    }

    .team-member-image {
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      border-radius: 2px;
      height: 250px;
    }

    .team-member-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transition: transform 0.3s ease, filter 0.3s ease;
    }

    .team-member-image img:hover {
      filter: brightness(1.2);
    }

    @media (min-width: 992px) and (max-width: 1199px) {
      .about-container {
        padding: 60px 15px 10px;
      }
      .about-banner-image {
        height: 350px;
        padding:10px
      }
      .section-title {
        font-size: 2.5em;
        margin-top: -10px;
      }
    }

    @media (min-width: 768px) and (max-width: 991px) {
      .about-container {
        max-width: 700px;
        padding: 40px 15px;
      }
      .about-banner-image {
        height: 300px;
        margin-bottom: 40px;
        padding:10px
      }
      .section-title {
        font-size: 2em;
        margin-top: -10px;
        text-align: center;
      }
      .team-grid {
        grid-template-columns: 1fr;
        text-align: center;
        margin-bottom: 30px;
      }
      .team-grid:nth-of-type(even) {
        grid-template-columns: 1fr;
      }
      .team-member-info {
        text-align: center;
      }
      .team-member-image {
        height: 220px;
      }
    }

    @media (max-width: 767px) {
      .about-container {
        padding: 30px 15px;
      }
      .about-banner-image {
        height: 200px;
        margin-bottom: 30px;
        padding:10px
      }
      .section-title {
        font-size: 1.8em;
        text-align: center;
        margin-top: -10px;
      }
      .team-grid {
        grid-template-columns: 1fr;
        text-align: center;
        margin-bottom: 25px;
      }
      .team-member-info {
        text-align: center;
      }
      .team-member-name {
        font-size: 1.4em;
      }
      .team-member-role {
        font-size: 0.9em;
      }
      .team-member-image {
        height: 180px;
      }
    }

    @media (max-width: 480px) {
      .about-container {
        padding: 20px 10px;
      }
      .about-banner-image {
        height: 160px;
        margin-bottom: 20px;
        padding:10px
      }
      .section-title {
        font-size: 1.5em;
      }
      .team-member-image {
        height: 150px;
      }
      .team-member-name {
        font-size: 1.2em;
      }
    }
  </style>
</head>

<body>


  <img src="../assets/about_etier_banner.png" alt="About Etier Banner" class="about-banner-image"/>

  <main class="about-container">

    <section class="who-we-are-section">
      <h2 class="section-title">Where Timeless Pieces Meet <br>Bold Expression</h2>
      <div class="section-content">
        <p>At Etier, we believe that fashion is more than just clothing — it's a statement of identity. Founded with a vision to empower individuals through curated style, Etier blends timeless essentials with bold, modern designs. Every piece in our collection is carefully crafted to inspire confidence, allowing you to express your unique story with effortless style.</p>
        <p>Whether it's your everyday look or a standout piece for special moments, we’re here to redefine how fashion fits into your life.</p>
      </div>
    </section>

    <section class="team-section">
      <h2 class="section-title">Meet the BeyondONE Team</h2>

      <div class="team-grid">
        <div class="team-member-info">
          <div class="team-member-name">Charles Michael Pua</div>
          <div class="team-member-role">Team Leader and Developer</div>
        </div>
        <div class="team-member-image">
          <img src="../assets/pua_about.jpg" alt="Charles Michael Pua" loading="lazy"/>
        </div>
      </div>

      <div class="team-grid">
        <div class="team-member-info">
          <div class="team-member-name">Alexa Joyce Cueto</div>
          <div class="team-member-role">Developer</div>
        </div>
        <div class="team-member-image">
          <img src="../assets/alexa_about.PNG" alt="Alexa Joyce Cueto" loading="lazy"/>
        </div>
      </div>

      <div class="team-grid">
        <div class="team-member-info">
          <div class="team-member-name">Paul Benedict Collo</div>
          <div class="team-member-role">Developer</div>
        </div>
        <div class="team-member-image">
          <img src="../assets/bene_about.PNG" alt="Paul Benedict Collo" loading="lazy"/>
        </div>
      </div>

      <div class="team-grid">
        <div class="team-member-info">
          <div class="team-member-name">Wenxuan Wei</div>
          <div class="team-member-role">Developer</div>
        </div>
        <div class="team-member-image">
          <img src="../assets/wei_about.PNG" alt="Wenxuan Wei" loading="lazy"/>
        </div>
      </div>

    </section>

  </main>

  <?php include 'footer.php'; ?>

</body>
</html>
