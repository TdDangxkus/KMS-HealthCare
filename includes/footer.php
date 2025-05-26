<footer class="footer pt-5 pb-3 mt-5 position-relative" style="background: linear-gradient(120deg, #1976d2 0%, #1ec0f7 100%); color: #fff; overflow: hidden;">
  <div class="footer-bg-img position-absolute top-0 start-0 w-100 h-100" style="background: url('/assets/img/footer_bgk.jpg') center/cover no-repeat; opacity:0.18; z-index:1;"></div>
  <div class="container position-relative" style="z-index:2;">
    <div class="row justify-content-center mb-4">
      <div class="col-12 text-center">
        <img src="/assets/img/logo-white.png" alt="Qickmed Logo" style="height: 52px; margin-bottom: 10px;">
        <div class="small text-white-50 mb-2" style="font-size:1.08rem;">Phòng khám y khoa hiện đại &bull; Chăm sóc sức khỏe toàn diện</div>
      </div>
    </div>
    <div class="row justify-content-center align-items-center mb-3 g-3">
      <div class="col-auto d-flex align-items-center gap-2">
        <i class="fas fa-phone-alt text-info"></i>
        <a href="tel:0123456789" class="text-white fw-bold text-decoration-none">0123 456 789</a>
      </div>
      <div class="col-auto d-flex align-items-center gap-2">
        <i class="fas fa-envelope text-info"></i>
        <a href="mailto:info@qickmed.vn" class="text-white text-decoration-none">info@qickmed.vn</a>
      </div>
      <div class="col-auto d-flex align-items-center gap-2">
        <i class="fas fa-map-marker-alt text-info"></i>
        <span class="text-white-50">123 Đường Sức Khỏe, Quận 1, TP.HCM</span>
      </div>
      <div class="col-auto d-flex align-items-center gap-2">
        <a href="#" class="footer-social-blue"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="footer-social-blue"><i class="fab fa-instagram"></i></a>
        <a href="#" class="footer-social-blue"><i class="fab fa-youtube"></i></a>
        <a href="#" class="footer-social-blue"><i class="fab fa-twitter"></i></a>
      </div>
    </div>
    <hr class="border-light my-3" style="opacity:0.13;">
    <div class="row">
      <div class="col text-center small text-white-50">
        &copy; 2024 <span class="fw-bold text-white">Qickmed</span>. All rights reserved.
      </div>
    </div>
  </div>
  <style>
    .footer {
      background: linear-gradient(120deg, #1976d2 0%, #1ec0f7 100%) !important;
      color: #fff;
      font-size: 1.05rem;
      letter-spacing: 0.01em;
      position: relative;
      overflow: hidden;
    }
    .footer-bg-img {
      pointer-events: none;
      opacity: 0.18;
      filter: blur(1.5px);
    }
    .footer-social-blue {
      color: #e3f6fd;
      font-size: 1.18rem;
      margin: 0 2px;
      transition: color 0.2s, background 0.2s;
      text-decoration: none;
      border-radius: 50%;
      padding: 7px 0 0 0;
      width: 32px;
      height: 32px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: rgba(255,255,255,0.08);
    }
    .footer-social-blue:hover {
      color: #1976d2;
      background: #fff;
    }
    .footer a {
      color: #fff;
      text-decoration: none;
      transition: color 0.2s;
    }
    .footer a:hover {
      color: #0056b3;
      text-decoration: underline;
    }
    @media (max-width: 767px) {
      .footer .row.justify-content-center.align-items-center.mb-3.g-3 > div {
        flex: 0 0 100%;
        justify-content: center !important;
        margin-bottom: 0.7rem;
      }
      .footer {
        font-size: 0.98rem;
      }
    }
  </style>
</footer>
