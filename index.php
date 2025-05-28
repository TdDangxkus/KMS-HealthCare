<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Qickmed - Trang Blog Y Khoa</title>
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Animate.css CDN for animation -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <!-- Font Awesome 6 CDN for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- SwiperJS CSS for slider -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
  <!-- Custom CSS -->
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="assets/css/team.css">
  <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>

  <!-- Hero Section -->
  <section class="clinic-hero" style="background: url('/assets/images/main-slider-bg-1-1.png') center/cover no-repeat; min-height: 600px;">
    <div class="container position-relative">
      <div class="hero-header-wrapper" style="padding-top:0;margin-top:-50px;">
        <?php include 'includes/header.php'; ?>
      </div>
      <div class="row align-items-center pt-4 pt-lg-5">
        <div class="col-lg-7 col-12">
          <div class="mb-3 animate__animated animate__fadeInLeft animate__delay-1s" style="color:#1ec0f7;font-weight:700;letter-spacing:2px;font-size:1.08rem;background:#e3f6fd;display:inline-block;padding:6px 18px 6px 14px;border-radius:15px;box-shadow:0 2px 8px rgba(33,150,243,0.10);">DỊCH VỤ CẤP CỨU 24/7</div>
          <h1 class="clinic-hero-title mb-3 animate__animated animate__fadeInDown animate__faster" style="text-align:left;text-shadow:0 2px 12px rgba(33,150,243,0.10);font-size:2.4rem;">
            Chăm Sóc Sức Khỏe <span class="highlight">Tốt Nhất</span>
            <span class="ms-2 align-middle" style="display:inline-block;vertical-align:middle;">
              <span style="position:relative;display:inline-block;">
                <img src="https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=facearea&w=70&h=42" alt="video" style="width:70px;height:42px;border-radius:18px;object-fit:cover;">
                <span class="animate__animated animate__pulse animate__infinite" style="position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);">
                  <i class="fas fa-play-circle" style="font-size:1.7rem;color:#1ec0f7;opacity:0.85;"></i>
                </span>
              </span>
            </span>
          </h1>
          <div class="clinic-hero-desc mb-3 animate__animated animate__fadeInUp animate__delay-1s" style="text-align:left;max-width:470px;font-size:1.08rem;">Với đội ngũ y bác sĩ giàu kinh nghiệm và trang thiết bị hiện đại, chúng tôi cam kết mang đến dịch vụ chăm sóc sức khỏe chất lượng cao nhất cho bạn và gia đình.</div>
          <a href="#services" class="btn clinic-hero-btn animate__animated animate__fadeInUp animate__delay-2s" style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(90deg,#1976d2 0%,#1ec0f7 100%);font-size:1.08rem;padding:12px 32px;box-shadow:0 2px 8px rgba(33,150,243,0.13);">Xem Tất Cả Dịch Vụ <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="col-lg-5 d-none d-lg-block position-relative animate__animated animate__fadeInRight animate__slower" style="min-width:320px;">
          <img src="/assets/images/default-avatar.png" alt="Doctor" style="max-width:320px;max-height:420px;object-fit:contain;">
          <div style="position:absolute;bottom:18px;left:0;background:#fff;border-radius:15px;box-shadow:0 2px 12px rgba(33,150,243,0.10);padding:12px 22px;display:flex;align-items:center;gap:12px;min-width:170px;">
            <span style="font-size:1.4rem;color:#1ec0f7;"><i class="fas fa-star"></i></span>
            <div>
              <div style="font-size:1.08rem;font-weight:700;color:#1976d2;">100%</div>
              <div style="font-size:0.95rem;color:#888;">Bệnh Nhân Hài Lòng</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <main style="padding-top: 90px;">
    <!-- About Us -->
    <section id="about" class="section-bg py-5 position-relative overflow-hidden">
      <div class="about-bg"></div>
      <div class="container position-relative">
        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <div class="position-relative">
              <img src="/assets/images/about-hospital.jpg" alt="Bệnh viện" class="img-fluid rounded-4 shadow-lg" style="object-fit:cover;">
              <div class="position-absolute bottom-0 start-0 translate-middle-y" style="left:24px;bottom:-32px;">
                <div class="experience-box">
                  <div class="experience-number">25<span>+</span></div>
                  <div class="experience-text">Năm kinh nghiệm<br>trong lĩnh vực y tế</div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="section-badge animate__animated animate__fadeInDown">Về Chúng Tôi</div>
            <h2 class="section-title animate__animated animate__fadeInUp">Chăm Sóc Sức Khỏe Tốt Nhất<br>Cho Bạn Từ Năm 2002</h2>
            <div class="section-desc animate__animated animate__fadeInUp">Với hơn 20 năm kinh nghiệm trong lĩnh vực y tế, chúng tôi tự hào mang đến những dịch vụ chăm sóc sức khỏe chất lượng cao, cùng đội ngũ y bác sĩ giàu kinh nghiệm và trang thiết bị hiện đại.</div>
            <div class="row mb-4 g-3">
              <div class="col-6 col-md-4">
                <div class="stat-box text-center text-md-start animate__animated animate__fadeInLeft">
                  <div class="stat-number">89%</div>
                  <div class="stat-text">Dự án y tế<br>hàng đầu</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="stat-box text-center text-md-start animate__animated animate__fadeInRight">
                  <div class="stat-number">100%</div>
                  <div class="stat-text">Bệnh nhân<br>hài lòng</div>
                </div>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
              <a href="#" class="btn btn-primary btn-lg px-4 py-3 rounded-pill animate__animated animate__fadeInUp">
                <span>Tìm Hiểu Thêm</span>
                <i class="fa-solid fa-arrow-right ms-2"></i>
              </a>
              <div class="founder-box animate__animated animate__fadeInUp">
                <img src="/assets/images/founder.jpg" alt="Người sáng lập" class="rounded-circle">
                <div>
                  <div class="founder-name">Nguyễn Văn A</div>
                  <div class="founder-title">Đồng sáng lập</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Our Services -->
    <section id="services" class="py-5 position-relative overflow-hidden">
      <div class="services-bg"></div>
      <div class="container position-relative">
        <div class="text-center mb-5">
          <div class="section-header">
            <div class="section-badge animate__animated animate__fadeInDown">Dịch Vụ</div>
            <h2 class="section-title animate__animated animate__fadeInUp">Dịch Vụ Của Chúng Tôi</h2>
            <p class="section-desc animate__animated animate__fadeInUp">Cung cấp các dịch vụ y tế chất lượng cao với đội ngũ bác sĩ chuyên môn giàu kinh nghiệm</p>
          </div>
        </div>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="service-card animate__animated animate__fadeInLeft">
              <div class="service-icon">
                <i class="fa-solid fa-person-pregnant"></i>
              </div>
              <div class="service-content">
                <div class="service-header">
                  <h5>Sản Phụ Khoa</h5>
                  <span class="badge">05+ Bác sĩ</span>
                </div>
                <p>Chăm sóc sức khỏe toàn diện cho phụ nữ, đặc biệt là trong thời kỳ mang thai và sinh nở.</p>
                <ul class="service-features">
                  <li><i class="fas fa-check"></i> Khám thai định kỳ</li>
                  <li><i class="fas fa-check"></i> Siêu âm 4D</li>
                  <li><i class="fas fa-check"></i> Tư vấn dinh dưỡng</li>
                </ul>
                <a href="#" class="service-link">Tìm hiểu thêm <i class="fas fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="service-card animate__animated animate__fadeInUp">
              <div class="service-icon">
                <i class="fa-solid fa-bone"></i>
              </div>
              <div class="service-content">
                <div class="service-header">
                  <h5>Chỉnh Hình</h5>
                  <span class="badge">15+ Bác sĩ</span>
                </div>
                <p>Điều trị chuyên sâu về xương khớp, cột sống và các bệnh lý về cơ xương khớp.</p>
                <ul class="service-features">
                  <li><i class="fas fa-check"></i> Phẫu thuật nội soi</li>
                  <li><i class="fas fa-check"></i> Vật lý trị liệu</li>
                  <li><i class="fas fa-check"></i> Phục hồi chức năng</li>
                </ul>
                <a href="#" class="service-link">Tìm hiểu thêm <i class="fas fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="service-card animate__animated animate__fadeInRight">
              <div class="service-icon">
                <i class="fa-solid fa-heart-pulse"></i>
              </div>
              <div class="service-content">
                <div class="service-header">
                  <h5>Tim Mạch</h5>
                  <span class="badge">20+ Bác sĩ</span>
                </div>
                <p>Chăm sóc toàn diện cho các bệnh lý về tim mạch với trang thiết bị hiện đại.</p>
                <ul class="service-features">
                  <li><i class="fas fa-check"></i> Điện tâm đồ</li>
                  <li><i class="fas fa-check"></i> Siêu âm tim</li>
                  <li><i class="fas fa-check"></i> Thông tim can thiệp</li>
                </ul>
                <a href="#" class="service-link">Tìm hiểu thêm <i class="fas fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="text-center mt-5">
          <a href="#" class="btn btn-light btn-lg px-5 py-3 rounded-pill animate__animated animate__pulse animate__infinite" style="font-weight: 600; font-size: 1.1rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            Xem Thêm Dịch Vụ <i class="fa-solid fa-arrow-right ms-2"></i>
          </a>
        </div>
      </div>
    </section>
    <!-- Products -->
    <section id="products" class="py-5 position-relative overflow-hidden">
      <div class="products-bg"></div>
      <div class="container position-relative">
        <div class="text-center mb-5">
          <div class="section-header">
            <div class="section-badge animate__animated animate__fadeInDown">Sản Phẩm</div>
            <h2 class="section-title animate__animated animate__fadeInUp">Sản Phẩm Của Chúng Tôi</h2>
            <p class="section-desc animate__animated animate__fadeInUp">Cung cấp các sản phẩm chất lượng cao, an toàn và hiệu quả cho sức khỏe của bạn</p>
          </div>
        </div>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="product-card animate__animated animate__fadeInLeft">
              <div class="product-icon">
                <i class="fas fa-pills"></i>
              </div>
              <div class="product-image">
                <img src="/assets/images/thuc_pham_chuc_nang.jpg" alt="Thực phẩm chức năng">
                <div class="product-overlay">
                  <a href="#" class="btn btn-light btn-sm rounded-pill px-4">Chi tiết</a>
                </div>
              </div>
              <div class="product-content">
                <h4 class="product-title">Thực Phẩm Chức Năng</h4>
                <p class="product-description">Bổ sung dinh dưỡng, tăng cường sức khỏe với các sản phẩm được chứng nhận an toàn và hiệu quả.</p>
                <div class="product-features">
                  <span class="badge">Tăng cường miễn dịch</span>
                  <span class="badge">Bổ sung vitamin</span>
                  <span class="badge">Hỗ trợ tiêu hóa</span>
                </div>
                <a href="#" class="product-link">Tìm Hiểu Thêm <i class="fas fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="product-card animate__animated animate__fadeInUp">
              <div class="product-icon">
                <i class="fas fa-capsules"></i>
              </div>
              <div class="product-image">
                <img src="/assets/images/thuoc_1.1.jpg" alt="Thuốc">
                <div class="product-overlay">
                  <a href="#" class="btn btn-light btn-sm rounded-pill px-4">Chi tiết</a>
                </div>
              </div>
              <div class="product-content">
                <h4 class="product-title">Thuốc</h4>
                <p class="product-description">Cung cấp các loại thuốc chất lượng cao, được kiểm định nghiêm ngặt và đảm bảo nguồn gốc xuất xứ.</p>
                <div class="product-features">
                  <span class="badge">Thuốc kê đơn</span>
                  <span class="badge">Thuốc không kê đơn</span>
                  <span class="badge">Thuốc đặc trị</span>
                </div>
                <a href="#" class="product-link">Tìm Hiểu Thêm <i class="fas fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="product-card animate__animated animate__fadeInRight">
              <div class="product-icon">
                <i class="fas fa-stethoscope"></i>
              </div>
              <div class="product-image">
                <img src="/assets/images/thiet_bi_y_te.jpg" alt="Thiết bị y tế">
                <div class="product-overlay">
                  <a href="#" class="btn btn-light btn-sm rounded-pill px-4">Chi tiết</a>
                </div>
              </div>
              <div class="product-content">
                <h4 class="product-title">Thiết Bị Y Tế</h4>
                <p class="product-description">Các thiết bị y tế hiện đại, chính xác giúp theo dõi và chăm sóc sức khỏe tại nhà một cách hiệu quả.</p>
                <div class="product-features">
                  <span class="badge">Máy đo huyết áp</span>
                  <span class="badge">Máy đo đường huyết</span>
                  <span class="badge">Máy xông khí dung</span>
                </div>
                <a href="#" class="product-link">Tìm Hiểu Thêm <i class="fas fa-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Health Blog Section -->
    <section id="blog" class="py-5 bg-light">
      <div class="container">
        <div class="row g-4">
          <!-- Left Column: Banner, Tags, Featured -->
          <div class="col-lg-8">
            <div class="d-flex align-items-center mb-3">
              <i class="fas fa-book-medical fa-lg text-primary me-2"></i>
              <h2 class="section-title mb-0" style="font-size:2rem;">Góc sức khỏe</h2>
              <a href="/blog" class="ms-3 text-primary" style="font-weight:500;">Xem tất cả <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="mb-3">
              <span class="badge bg-secondary-subtle text-dark me-2 mb-2">Dinh dưỡng</span>
              <span class="badge bg-secondary-subtle text-dark me-2 mb-2">Phòng chữa bệnh</span>
              <span class="badge bg-secondary-subtle text-dark me-2 mb-2">Người cao tuổi</span>
              <span class="badge bg-secondary-subtle text-dark me-2 mb-2">Khỏe đẹp</span>
              <span class="badge bg-secondary-subtle text-dark me-2 mb-2">Mẹ và bé</span>
              <span class="badge bg-secondary-subtle text-dark me-2 mb-2">Giới tính</span>
              <span class="badge bg-secondary-subtle text-dark me-2 mb-2">Tin tức khuyến mại</span>
              <span class="badge bg-secondary-subtle text-dark me-2 mb-2">Tin tức sức khỏe</span>
            </div>
            <div class="row g-3">
              <div class="col-12">
                <div class="blog-banner position-relative rounded-4 overflow-hidden mb-3">
                  <img src="/assets/images/anh_ngau_nhien.jpg" class="w-100 h-100 object-fit-cover" style="min-height:220px;max-height:260px;object-fit:cover;" alt="Banner Blog">
                  <div class="position-absolute bottom-0 start-0 p-4 w-100" style="background: linear-gradient(0deg,rgba(0,0,0,0.55) 60%,rgba(0,0,0,0.01) 100%);">
                    <div class="text-white fw-bold" style="font-size:1.2rem;">Dự phòng viêm phổi do RSV cho trẻ sinh non - tim bẩm sinh</div>
                    <div class="text-white-50" style="font-size:0.98rem;">Thuốc hàng đầu thế giới đã có tại Long Châu</div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="featured-article bg-white rounded-4 shadow-sm p-4 mb-2">
                  <div class="mb-2 text-primary fw-bold" style="font-size:0.98rem;">Truyền thông</div>
                  <h3 class="mb-2" style="font-size:1.3rem;line-height:1.3;">Giải pháp bảo vệ trẻ sinh non, tim bẩm sinh trước nguy cơ viêm phổi do RSV chính thức có mặt ở Việt Nam</h3>
                  <p class="mb-2 text-muted" style="font-size:1rem;">Tìm hiểu về các giải pháp phòng ngừa viêm phổi do RSV cho trẻ sinh non, tim bẩm sinh và vai trò của thuốc mới trên thị trường Việt Nam...</p>
                  <a href="#" class="btn btn-link text-primary p-0">Đọc thêm <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
              </div>
            </div>
          </div>
          <!-- Right Column: List of Articles -->
          <div class="col-lg-4">
            <div class="d-flex flex-column gap-3">
              <div class="mini-article d-flex align-items-center bg-white rounded-4 shadow-sm p-2">
                <img src="/assets/images/anh_ngau_nhien.jpg" class="rounded-3 me-3" style="width:64px;height:64px;object-fit:cover;" alt="Bài viết 1">
                <div>
                  <div class="text-primary fw-bold small mb-1">Kiến thức y khoa</div>
                  <div class="fw-semibold" style="font-size:1rem;line-height:1.3;">Bà bầu bị tay chân miệng có sao không? Nguy hiểm tiềm ẩn và những điều cần biết</div>
                </div>
              </div>
              <div class="mini-article d-flex align-items-center bg-white rounded-4 shadow-sm p-2">
                <img src="/assets/images/anh_ngau_nhien.jpg" class="rounded-3 me-3" style="width:64px;height:64px;object-fit:cover;" alt="Bài viết 2">
                <div>
                  <div class="text-success fw-bold small mb-1">Truyền thông</div>
                  <div class="fw-semibold" style="font-size:1rem;line-height:1.3;">Cục Quản lý dược chi cách tra cứu thông tin thuốc, 'kỹ năng' tránh mua thuốc giả</div>
                </div>
              </div>
              <div class="mini-article d-flex align-items-center bg-white rounded-4 shadow-sm p-2">
                <img src="/assets/images/anh_ngau_nhien.jpg" class="rounded-3 me-3" style="width:64px;height:64px;object-fit:cover;" alt="Bài viết 3">
                <div>
                  <div class="text-primary fw-bold small mb-1">Kiến thức y khoa</div>
                  <div class="fw-semibold" style="font-size:1rem;line-height:1.3;">Sơ cứu đột quỵ tại nhà đúng cách giúp bạn thoát khỏi nguy hiểm!</div>
                </div>
              </div>
              <div class="mini-article d-flex align-items-center bg-white rounded-4 shadow-sm p-2">
                <img src="/assets/images/anh_ngau_nhien.jpg" class="rounded-3 me-3" style="width:64px;height:64px;object-fit:cover;" alt="Bài viết 4">
                <div>
                  <div class="text-success fw-bold small mb-1">Truyền thông</div>
                  <div class="fw-semibold" style="font-size:1rem;line-height:1.3;">FPT Long Châu lên tiếng về thông tin sai lệch liên quan sản phẩm Happy Mom</div>
                </div>
              </div>
              <div class="mini-article d-flex align-items-center bg-white rounded-4 shadow-sm p-2">
                <img src="/assets/images/anh_ngau_nhien.jpg" class="rounded-3 me-3" style="width:64px;height:64px;object-fit:cover;" alt="Bài viết 5">
                <div>
                  <div class="text-primary fw-bold small mb-1">Kiến thức y khoa</div>
                  <div class="fw-semibold" style="font-size:1rem;line-height:1.3;">Chất béo chuyển hóa là gì? Tác hại của chất béo chuyển hóa như thế nào?</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Why Choose Us -->
    <section id="whychoose" class="section-bg py-5">
      <div class="container section-content">
        <h2 class="section-title text-center mb-5">Vì Sao Chọn Chúng Tôi</h2>
        <div class="row g-4 justify-content-center">
          <div class="col-md-3 col-6">
            <div class="choose-box choose-card text-center p-4 h-100">
              <div class="choose-icon mb-3 bg-gradient-primary">
                <i class="fas fa-user-md"></i>
              </div>
              <h6 class="fw-bold mb-2">Bác sĩ giỏi</h6>
              <p class="text-muted mb-0">Đội ngũ chuyên gia đầu ngành</p>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="choose-box choose-card text-center p-4 h-100">
              <div class="choose-icon mb-3 bg-gradient-success">
                <i class="fas fa-stethoscope"></i>
              </div>
              <h6 class="fw-bold mb-2">Thiết bị hiện đại</h6>
              <p class="text-muted mb-0">Công nghệ tiên tiến, an toàn</p>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="choose-box choose-card text-center p-4 h-100">
              <div class="choose-icon mb-3 bg-gradient-warning">
                <i class="fas fa-calendar-check"></i>
              </div>
              <h6 class="fw-bold mb-2">Đặt lịch dễ dàng</h6>
              <p class="text-muted mb-0">Đặt lịch online 24/7</p>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="choose-box choose-card text-center p-4 h-100">
              <div class="choose-icon mb-3 bg-gradient-danger">
                <i class="fas fa-headset"></i>
              </div>
              <h6 class="fw-bold mb-2">Hỗ trợ tận tâm</h6>
              <p class="text-muted mb-0">Tư vấn miễn phí, nhiệt tình</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Book An Appointment -->
    <section id="book" class="py-5 book-section position-relative">
      <div class="container section-content text-center">
        <h2 class="section-title mb-4">Đặt Lịch Khám Ngay</h2>
        <p class="mb-4 text-muted" style="font-size:1.1rem;">Nhanh chóng, tiện lợi và hoàn toàn miễn phí. Đội ngũ chuyên gia của chúng tôi luôn sẵn sàng hỗ trợ bạn!</p>
        <a href="/booking.php" class="btn btn-primary btn-lg px-5 py-3 mt-2 shadow">Đặt lịch ngay <i class="fas fa-calendar-plus ms-2"></i></a>
        <div class="mt-4 d-flex justify-content-center align-items-center gap-2">
          <span class="text-primary" style="font-size:1.5rem;"><i class="fas fa-phone-volume"></i></span>
          <span class="fw-bold text-primary" style="font-size:1.2rem;">Hotline: <a href="tel:0123456789" class="fw-bold text-primary">0123 456 789</a></span>
        </div>
      </div>
    </section>
    <!-- We Are Skillful Health Care -->
    <section id="skillful" class="section-bg py-5">
      <div class="container section-content">
        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <div class="position-relative skillful-img-box rounded-4 overflow-hidden shadow-lg" style="transform: perspective(1000px) rotateY(-5deg);">
              <img src="/assets/images/anh_ngau_nhien.jpg" alt="Skillful Health Care" class="img-fluid w-100" style="object-fit:cover;min-height:450px;filter:brightness(0.95);">
              <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center" style="background:linear-gradient(135deg, rgba(25,118,210,0.4) 0%, rgba(30,192,247,0.4) 100%);">
                <div class="bg-white bg-opacity-95 rounded-circle d-flex align-items-center justify-content-center mb-4" style="width:90px;height:90px;box-shadow:0 8px 32px rgba(33,150,243,0.3);transform: rotate(-5deg);">
                  <i class="fas fa-heartbeat text-danger" style="font-size:2.5rem;"></i>
                </div>
                <div class="text-white fw-bold text-center" style="font-size:1.3rem;letter-spacing:2px;text-shadow: 0 2px 4px rgba(0,0,0,0.2);transform: rotate(-5deg);">Tận tâm - Chuyên nghiệp</div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <h2 class="section-title mb-4" style="font-size:2.8rem;background:linear-gradient(135deg,#1976d2,#1ec0f7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Chăm Sóc Sức Khỏe Tận Tâm</h2>
            <p class="mb-5 text-muted" style="font-size:1.2rem;line-height:1.8;max-width:550px;">Qickmed tự hào sở hữu đội ngũ y bác sĩ giàu kinh nghiệm, tận tâm và luôn cập nhật các phương pháp điều trị tiên tiến nhất. Chúng tôi cam kết mang lại dịch vụ y tế chất lượng cao, an toàn và hiệu quả cho mọi khách hàng.</p>
            <div class="row g-4">
              <div class="col-6">
                <div class="stat-card bg-gradient-primary text-white rounded-4 shadow-lg p-4 text-center h-100" style="transition: all 0.4s ease;transform-style:preserve-3d;">
                  <div class="mb-3" style="transform: translateZ(20px);"><i class="fas fa-award fa-2x"></i></div>
                  <div class="fw-bold" style="font-size:2.8rem;transform: translateZ(30px);">25+</div>
                  <div style="font-size:1.1rem;opacity:0.9;transform: translateZ(20px);">Năm kinh nghiệm</div>
                </div>
              </div>
              <div class="col-6">
                <div class="stat-card bg-gradient-success text-white rounded-4 shadow-lg p-4 text-center h-100" style="transition: all 0.4s ease;transform-style:preserve-3d;">
                  <div class="mb-3" style="transform: translateZ(20px);"><i class="fas fa-users fa-2x"></i></div>
                  <div class="fw-bold" style="font-size:2.8rem;transform: translateZ(30px);">10.000+</div>
                  <div style="font-size:1.1rem;opacity:0.9;transform: translateZ(20px);">Khách hàng hài lòng</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Our Expert Team 
     sau lam thêm
    -->
    
    <!-- FAQ'S -->
    <section id="faqs" class="py-5 bg-light">
      <div class="container section-content">
        <h2 class="section-title text-center mb-5" style="font-size:2.8rem;background:linear-gradient(135deg,#1976d2,#1ec0f7);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">Câu Hỏi Thường Gặp</h2>
        <div class="accordion modern-accordion" id="faqAccordion">
          <div class="accordion-item rounded-4 mb-4 shadow-lg border-0" style="transition: all 0.3s ease;">
            <h2 class="accordion-header" id="faq1">
              <button class="accordion-button rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1" style="font-size:1.2rem;padding:1.5rem;background:linear-gradient(135deg,#f8f9fa,#fff);">
                <i class="fas fa-question-circle text-primary me-3"></i> Làm sao để đặt lịch khám?
              </button>
            </h2>
            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
              <div class="accordion-body" style="font-size:1.1rem;line-height:1.8;padding:1.8rem;background:linear-gradient(135deg,#fff,#f8f9fa);">
                Bạn có thể đặt lịch trực tuyến trên website hoặc gọi hotline 0123 456 789.
              </div>
            </div>
          </div>
          <div class="accordion-item rounded-4 mb-4 shadow-lg border-0" style="transition: all 0.3s ease;">
            <h2 class="accordion-header" id="faq2">
              <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2" style="font-size:1.2rem;padding:1.5rem;background:linear-gradient(135deg,#f8f9fa,#fff);">
                <i class="fas fa-question-circle text-primary me-3"></i> Qickmed có làm việc cuối tuần không?
              </button>
            </h2>
            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
              <div class="accordion-body" style="font-size:1.1rem;line-height:1.8;padding:1.8rem;background:linear-gradient(135deg,#fff,#f8f9fa);">
                Qickmed làm việc tất cả các ngày trong tuần, kể cả thứ 7 và Chủ nhật.
              </div>
            </div>
          </div>
        </div>
        <div class="text-center mt-5">
          <button class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg" id="open-ai-chat" style="font-size:1.2rem;background:linear-gradient(135deg,#1976d2,#1ec0f7);border:none;transition:all 0.3s ease;">
            <i class="fas fa-robot me-2"></i>Tư vấn với AI
          </button>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  
  <?php include 'includes/floating_chat.php'; ?>
  <script src="assets/js/team.js"></script>
</body>
</html>


