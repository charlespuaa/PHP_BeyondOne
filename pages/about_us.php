<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us - Etier Clothing by BeyondONE</title>
  <meta name="description" content="Learn more about Etier Clothing by BeyondONE – the people behind timeless fashion pieces that empower bold expression."/>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"/>

  <style>
    .about-container {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: #fff9f9ff;
      color: #333;
      line-height: 1.6;
      padding-top: 150px; /* Adjusted padding for header */
    }

    .about-container {
      max-width: 900px;
      margin: 0 auto;
      padding: 60px 4px 10px;
    }

    .hero-image {
      width: 100%;
      height: 400px;
      background: url('../assets/about-us-hero.jpg') no-repeat center center/cover;
      border-radius: 8px;
      margin-bottom: 50px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .section-title {
      font-size: 3em;
      margin-right: 10px;
      font-weight: bold;
      color: #E6BD37;
      margin-bottom: 20px;
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

    .team-member-info {
      text-align: left;
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
      width: 100%;
      height: 250px;
      overflow: hidden;
      border-radius: 2px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
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

  </style>
</head>
<body>
  <?php include 'header.php'; ?>
  

  <img 
    src="../assets/about_etier_banner.png" 
    alt="Smart Casual Banner" 
    style="width: 100%; display: block; margin: 0; padding: 0;"
  />

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
          <img src="../assets/pua_about.jpg" alt="Charles Michael Pua" loading="lazy" />
        </div>
      </div>

      <div class="team-grid">
        <div class="team-member-info">
          <div class="team-member-name">Alexa Joyce Cueto</div>
          <div class="team-member-role">Developer</div>
        </div>
        <div class="team-member-image">
          <img src="../assets/alexa_about.PNG" alt="Alexa Joyce Cueto" loading="lazy" />
        </div>
      </div>

      <div class="team-grid">
        <div class="team-member-info">
          <div class="team-member-name">Paul Benedict Collo</div>
          <div class="team-member-role">Developer</div>
        </div>
        <div class="team-member-image">
          <img src="../assets/bene_about.PNG" alt="Paul Benedict Collo" loading="lazy" />
        </div>
      </div>

      <div class="team-grid">
        <div class="team-member-info">
          <div class="team-member-name">Wenxuan Wei</div>
          <div class="team-member-role">Developer</div>
        </div>
        <div class="team-member-image">
          <img src="../assets/wei_about.PNG" alt="Wenxuan Wei" loading="lazy" />
        </div>
      </div>
    </section>
  </main>

</body>
<?php include 'footer.php'; ?>
</html>
