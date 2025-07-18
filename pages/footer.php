<!-- updated footer with responsive and sticky behavior -->
<footer class="etier-footer">
  <div class="footer-logo">
    <img src="../assets/bj_logo_transparent.png" alt="BeyondOne Logo">
  </div>
  <div class="footer-text">
    &copy; <?= date('Y') ?> <strong>BeyondOne</strong> | ETIER Clothing
  </div>
  <div class="footer-subtext">
    this website is for <strong>educational purposes only</strong> and is a final project requirement.
  </div>
</footer>

<!-- responsiveness and sticky footer styles -->
<style>
  .etier-footer {
    background: #fff;
    border-top: 1px solid #eee;
    text-align: center;
    font-family: 'Proxima Nova', sans-serif;
    color: #888F92;
    padding: 20px 10px;
    flex-shrink: 0;
  }

  .etier-footer img {
    width: 110px;
    height: auto;
    margin-bottom: 15px;
  }

  .etier-footer .footer-text {
    font-size: 14px;
    margin-bottom: 5px;
    color: #888F92;
  }

  .etier-footer .footer-subtext {
    font-size: 13px;
    color: #888F92;
  }

  .etier-footer strong {
    color: #56585aff;
  }

  @media (max-width: 600px) {
    .etier-footer .footer-text,
    .etier-footer .footer-subtext {
      font-size: 12px;
      padding: 0 10px;
    }

    .etier-footer img {
      width: 90px;
    }
  }
</style>
