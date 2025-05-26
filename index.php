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
          <div class="mb-3 animate__animated animate__fadeInLeft animate__delay-1s" style="color:#1ec0f7;font-weight:700;letter-spacing:2px;font-size:1.08rem;background:#e3f6fd;display:inline-block;padding:6px 18px 6px 14px;border-radius:15px;box-shadow:0 2px 8px rgba(33,150,243,0.10);">24/7 EMERGENCY SERVICE</div>
          <h1 class="clinic-hero-title mb-3 animate__animated animate__fadeInDown animate__faster" style="text-align:left;text-shadow:0 2px 12px rgba(33,150,243,0.10);font-size:2.4rem;">
            Best Dental <span class="highlight">Care In Town</span>
            <span class="ms-2 align-middle" style="display:inline-block;vertical-align:middle;">
              <span style="position:relative;display:inline-block;">
                <img src="https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=facearea&w=70&h=42" alt="video" style="width:70px;height:42px;border-radius:18px;object-fit:cover;">
                <span class="animate__animated animate__pulse animate__infinite" style="position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);">
                  <i class="fas fa-play-circle" style="font-size:1.7rem;color:#1ec0f7;opacity:0.85;"></i>
                </span>
              </span>
            </span>
          </h1>
          <div class="clinic-hero-desc mb-3 animate__animated animate__fadeInUp animate__delay-1s" style="text-align:left;max-width:470px;font-size:1.08rem;">Nail it down come up with something buzzworthy going forward c-suite. Hire the best. We need to socialize the comms with the wider stakeholder</div>
          <a href="#services" class="btn clinic-hero-btn animate__animated animate__fadeInUp animate__delay-2s" style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(90deg,#1976d2 0%,#1ec0f7 100%);font-size:1.08rem;padding:12px 32px;box-shadow:0 2px 8px rgba(33,150,243,0.13);">View All Service <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="col-lg-5 d-none d-lg-block position-relative animate__animated animate__fadeInRight animate__slower" style="min-width:320px;">
          <img src="/assets/images/default-avatar.png" alt="Doctor" style="max-width:320px;max-height:420px;object-fit:contain;">
          <div style="position:absolute;bottom:18px;left:0;background:#fff;border-radius:15px;box-shadow:0 2px 12px rgba(33,150,243,0.10);padding:12px 22px;display:flex;align-items:center;gap:12px;min-width:170px;">
            <span style="font-size:1.4rem;color:#1ec0f7;"><i class="fas fa-star"></i></span>
            <div>
              <div style="font-size:1.08rem;font-weight:700;color:#1976d2;">100%</div>
              <div style="font-size:0.95rem;color:#888;">Loved & Satisfied Patients</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <main style="padding-top: 90px;">
    <!-- About Us -->
    <section id="about" class="section-bg py-5">
      <div class="container">
        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <div class="position-relative">
              <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=facearea&w=600&h=400" alt="Hospital" class="img-fluid rounded-4 shadow" style="object-fit:cover;">
              <div class="position-absolute bottom-0 start-0 translate-middle-y" style="left:24px;bottom:-32px;">
                <div style="background:rgba(33,118,210,0.85);color:#fff;padding:28px 32px 18px 32px;border-radius:32px;box-shadow:0 4px 24px rgba(33,150,243,0.13);text-align:center;min-width:140px;">
                  <div style="font-size:2.2rem;font-weight:900;line-height:1;">25<span style="font-size:1.3rem;">+</span></div>
                  <div style="font-size:1.1rem;font-weight:500;">Experience in<br>Medical Service</div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="mb-2" style="display:inline-block;background:#e3f6fd;color:#1976d2;font-weight:700;padding:7px 22px 7px 18px;border-radius:18px;box-shadow:0 2px 8px rgba(33,150,243,0.10);font-size:1.1rem;">About Us</div>
            <h2 class="fw-bold mb-3" style="font-size:2.5rem;line-height:1.15;">Best Healthcare For You<br>Since 2002.</h2>
            <div class="mb-4" style="color:#555;font-size:1.1rem;max-width:520px;">Lorem ipsum dolor sit amet consectetur adipiscing elit Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit a sapien fringilla, mattis ligula consectetur, ultrices mauris. Maecenas vitae mattis tellus.</div>
            <div class="row mb-4 g-3">
              <div class="col-6 col-md-4">
                <div class="text-center text-md-start">
                  <div style="font-size:2rem;font-weight:800;color:#1ec0f7;">89%</div>
                  <div style="font-size:1rem;color:#222;">Top Medical<br>Project</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="text-center text-md-start">
                  <div style="font-size:2rem;font-weight:800;color:#1ec0f7;">100%</div>
                  <div style="font-size:1rem;color:#222;">Satisfied<br>Patient</div>
                </div>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3 flex-wrap">
              <a href="#" class="btn btn-primary btn-lg px-4 py-2" style="border-radius:24px;background:linear-gradient(90deg,#1ec0f7 0%,#1976d2 100%);font-weight:700;display:inline-flex;align-items:center;gap:8px;">Know More <i class="fa-solid fa-arrow-right"></i></a>
              <div class="d-flex align-items-center gap-2 bg-white px-3 py-2 rounded-4 shadow-sm" style="min-width:180px;">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Founder" class="rounded-circle" style="width:48px;height:48px;object-fit:cover;">
                <div>
                  <div class="fw-bold" style="color:#1976d2;">Dalzel</div>
                  <div style="font-size:0.98rem;color:#888;">Co. Founder</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Our Services -->
    <section id="services" class="py-5 position-relative" style="background: linear-gradient(135deg, #1976d2 0%, #2196f3 100%);">
      <div class="container position-relative">
        <div class="text-center mb-5">
          <!-- <span class="badge bg-white text-primary mb-3 px-4 py-2 rounded-pill" style="font-size: 1rem; font-weight: 600;">Dịch Vụ</span> -->
          <h2 class="section-title text-white mb-3">Dịch Vụ Của Chúng Tôi</h2>
          <p class="text-white-50" style="max-width: 600px; margin: 0 auto;">Cung cấp các dịch vụ y tế chất lượng cao với đội ngũ bác sĩ chuyên môn giàu kinh nghiệm</p>
        </div>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="service-card">
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
            <div class="service-card">
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
            <div class="service-card">
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
          <a href="#" class="btn btn-light btn-lg px-5 py-3 rounded-pill" style="font-weight: 600; font-size: 1.1rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            Xem Thêm Dịch Vụ <i class="fa-solid fa-arrow-right ms-2"></i>
          </a>
        </div>
      </div>
    </section>
    <!-- Products -->
    <section id="products" class="section-bg py-5">
      <div class="container section-content">
        <div class="text-center mb-5">
          <!-- <span class="badge bg-primary-subtle text-primary mb-2 px-3 py-2 rounded-pill" style="font-size: 1rem;">Sản Phẩm</span> -->
          <h2 class="section-title">Sản Phẩm Của Chúng Tôi</h2>
          <p class="text-muted">Cung cấp các sản phẩm chất lượng cao, an toàn và hiệu quả cho sức khỏe của bạn</p>
        </div>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="product-card">
              <div class="product-icon">
                <i class="fas fa-pills fa-3x text-primary"></i>
              </div>
              <div class="product-image">
                <img src="/assets/images/thuc_pham_chuc_nang.jpg" class="img-fluid rounded" alt="Thực phẩm chức năng">
                <div class="product-overlay">
                  <a href="#" class="btn btn-light btn-sm rounded-pill px-4">Chi tiết</a>
                </div>
              </div>
              <div class="product-content p-4">
                <h4 class="product-title mb-3">Thực Phẩm Chức Năng</h4>
                <p class="product-description">Bổ sung dinh dưỡng, tăng cường sức khỏe với các sản phẩm được chứng nhận an toàn và hiệu quả.</p>
                <div class="product-features mt-3">
                  <span class="badge bg-light text-primary me-2">Tăng cường miễn dịch</span>
                  <span class="badge bg-light text-primary me-2">Bổ sung vitamin</span>
                  <span class="badge bg-light text-primary">Hỗ trợ tiêu hóa</span>
                </div>
                <a href="#" class="btn btn-primary mt-4 w-100">Tìm Hiểu Thêm</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="product-card">
              <div class="product-icon">
                <i class="fas fa-capsules fa-3x text-primary"></i>
              </div>
              <div class="product-image">
                <img src="/assets/images/thuoc_1.1.jpg" class="img-fluid rounded" alt="Thuốc">
                <div class="product-overlay">
                  <a href="#" class="btn btn-light btn-sm rounded-pill px-4">Chi tiết</a>
                </div>
              </div>
              <div class="product-content p-4">
                <h4 class="product-title mb-3">Thuốc</h4>
                <p class="product-description">Cung cấp các loại thuốc chất lượng cao, được kiểm định nghiêm ngặt và đảm bảo nguồn gốc xuất xứ.</p>
                <div class="product-features mt-3">
                  <span class="badge bg-light text-primary me-2">Thuốc kê đơn</span>
                  <span class="badge bg-light text-primary me-2">Thuốc không kê đơn</span>
                  <span class="badge bg-light text-primary">Thuốc đặc trị</span>
                </div>
                <a href="#" class="btn btn-primary mt-4 w-100">Tìm Hiểu Thêm</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="product-card">
              <div class="product-icon">
                <i class="fas fa-stethoscope fa-3x text-primary"></i>
              </div>
              <div class="product-image">
                <img src="/assets/images/thiet_bi_y_te.jpg" class="img-fluid rounded" alt="Thiết bị y tế">
                <div class="product-overlay">
                  <a href="#" class="btn btn-light btn-sm rounded-pill px-4">Chi tiết</a>
                </div>
              </div>
              <div class="product-content p-4">
                <h4 class="product-title mb-3">Thiết Bị Y Tế</h4>
                <p class="product-description">Các thiết bị y tế hiện đại, chính xác giúp theo dõi và chăm sóc sức khỏe tại nhà một cách hiệu quả.</p>
                <div class="product-features mt-3">
                  <span class="badge bg-light text-primary me-2">Máy đo huyết áp</span>
                  <span class="badge bg-light text-primary me-2">Máy đo đường huyết</span>
                  <span class="badge bg-light text-primary">Máy xông khí dung</span>
                </div>
                <a href="#" class="btn btn-primary mt-4 w-100">Tìm Hiểu Thêm</a>
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
            <div class="position-relative skillful-img-box rounded-4 overflow-hidden shadow-lg">
              <img src="/assets/images/anh_ngau_nhien.jpg" alt="Skillful Health Care" class="img-fluid w-100" style="object-fit:cover;min-height:300px;filter:brightness(0.92);">
              <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center" style="background:rgba(25,118,210,0.13);">
                <div class="bg-white bg-opacity-75 rounded-circle d-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px;box-shadow:0 2px 12px rgba(33,150,243,0.13);">
                  <i class="fas fa-heartbeat text-danger" style="font-size:2rem;"></i>
                </div>
                <div class="text-primary fw-bold text-center" style="font-size:1.1rem;letter-spacing:1px;">Tận tâm - Chuyên nghiệp</div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <h2 class="section-title mb-3">Chăm Sóc Sức Khỏe Tận Tâm</h2>
            <p class="mb-4 text-muted" style="font-size:1.15rem;max-width:500px;">Qickmed tự hào sở hữu đội ngũ y bác sĩ giàu kinh nghiệm, tận tâm và luôn cập nhật các phương pháp điều trị tiên tiến nhất. Chúng tôi cam kết mang lại dịch vụ y tế chất lượng cao, an toàn và hiệu quả cho mọi khách hàng.</p>
            <div class="row g-3">
              <div class="col-6">
                <div class="stat-card bg-gradient-primary text-white rounded-4 shadow-sm p-4 text-center">
                  <div class="mb-2"><i class="fas fa-award fa-lg"></i></div>
                  <div class="fw-bold" style="font-size:2rem;">25+</div>
                  <div style="font-size:1.05rem;">Năm kinh nghiệm</div>
                </div>
              </div>
              <div class="col-6">
                <div class="stat-card bg-gradient-success text-white rounded-4 shadow-sm p-4 text-center">
                  <div class="mb-2"><i class="fas fa-users fa-lg"></i></div>
                  <div class="fw-bold" style="font-size:2rem;">10.000+</div>
                  <div style="font-size:1.05rem;">Khách hàng hài lòng</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Our Expert Team -->
    <section id="team" class="py-5 bg-light">
      <div class="container section-content">
        <h2 class="section-title text-center mb-5">Đội Ngũ Chuyên Gia</h2>
        <div class="row g-4 justify-content-center">
          <div class="col-md-3 col-6">
            <div class="card border-0 shadow team-card text-center p-3 h-100">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" class="card-img-top rounded-circle mx-auto mt-3 border border-3 border-primary" style="width:110px;height:110px;object-fit:cover;">
              <div class="card-body">
                <h6 class="card-title mb-1 fw-bold">BS. Nguyễn Văn A</h6>
                <p class="card-text text-muted mb-0">Chuyên khoa Nội</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="card border-0 shadow team-card text-center p-3 h-100">
              <img src="https://randomuser.me/api/portraits/women/44.jpg" class="card-img-top rounded-circle mx-auto mt-3 border border-3 border-success" style="width:110px;height:110px;object-fit:cover;">
              <div class="card-body">
                <h6 class="card-title mb-1 fw-bold">BS. Trần Thị B</h6>
                <p class="card-text text-muted mb-0">Chuyên khoa Nhi</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="card border-0 shadow team-card text-center p-3 h-100">
              <img src="https://randomuser.me/api/portraits/men/65.jpg" class="card-img-top rounded-circle mx-auto mt-3 border border-3 border-warning" style="width:110px;height:110px;object-fit:cover;">
              <div class="card-body">
                <h6 class="card-title mb-1 fw-bold">BS. Lê Văn C</h6>
                <p class="card-text text-muted mb-0">Chuyên khoa Tim mạch</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="card border-0 shadow team-card text-center p-3 h-100">
              <img src="https://randomuser.me/api/portraits/women/68.jpg" class="card-img-top rounded-circle mx-auto mt-3 border border-3 border-danger" style="width:110px;height:110px;object-fit:cover;">
              <div class="card-body">
                <h6 class="card-title mb-1 fw-bold">BS. Phạm Thị D</h6>
                <p class="card-text text-muted mb-0">Chuyên khoa Răng hàm mặt</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Our Work Process -->
    <section id="process" class="section-bg py-5">
      <div class="container section-content">
        <h2 class="section-title text-center mb-5">Quy Trình Làm Việc</h2>
        <div class="row justify-content-center g-4">
          <div class="col-md-3 col-6">
            <div class="process-step text-center p-4 rounded-4 shadow-sm h-100">
              <div class="process-icon mb-3 bg-gradient-primary"><i class="fas fa-calendar-plus"></i></div>
              <div class="process-number mb-2">1</div>
              <h6 class="fw-bold mb-2">Đặt lịch</h6>
              <p class="text-muted mb-0">Khách hàng đặt lịch online hoặc qua hotline.</p>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="process-step text-center p-4 rounded-4 shadow-sm h-100">
              <div class="process-icon mb-3 bg-gradient-success"><i class="fas fa-user-check"></i></div>
              <div class="process-number mb-2">2</div>
              <h6 class="fw-bold mb-2">Tiếp nhận</h6>
              <p class="text-muted mb-0">Nhân viên xác nhận và hướng dẫn khách hàng.</p>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="process-step text-center p-4 rounded-4 shadow-sm h-100">
              <div class="process-icon mb-3 bg-gradient-warning"><i class="fas fa-user-md"></i></div>
              <div class="process-number mb-2">3</div>
              <h6 class="fw-bold mb-2">Khám & tư vấn</h6>
              <p class="text-muted mb-0">Bác sĩ thăm khám, tư vấn và chỉ định điều trị.</p>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="process-step text-center p-4 rounded-4 shadow-sm h-100">
              <div class="process-icon mb-3 bg-gradient-danger"><i class="fas fa-heartbeat"></i></div>
              <div class="process-number mb-2">4</div>
              <h6 class="fw-bold mb-2">Điều trị & theo dõi</h6>
              <p class="text-muted mb-0">Thực hiện điều trị và theo dõi kết quả.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- FAQ'S -->
    <section id="faqs" class="py-5 bg-light">
      <div class="container section-content">
        <h2 class="section-title text-center mb-5">Câu Hỏi Thường Gặp</h2>
        <div class="accordion modern-accordion" id="faqAccordion">
          <div class="accordion-item rounded-4 mb-3 shadow-sm border-0">
            <h2 class="accordion-header" id="faq1">
              <button class="accordion-button rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                <i class="fas fa-question-circle text-primary me-2"></i> Làm sao để đặt lịch khám?
              </button>
            </h2>
            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
              <div class="accordion-body">Bạn có thể đặt lịch trực tuyến trên website hoặc gọi hotline 0123 456 789.</div>
            </div>
          </div>
          <div class="accordion-item rounded-4 mb-3 shadow-sm border-0">
            <h2 class="accordion-header" id="faq2">
              <button class="accordion-button collapsed rounded-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                <i class="fas fa-question-circle text-primary me-2"></i> Qickmed có làm việc cuối tuần không?
              </button>
            </h2>
            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
              <div class="accordion-body">Qickmed làm việc tất cả các ngày trong tuần, kể cả thứ 7 và Chủ nhật.</div>
            </div>
          </div>
        </div>
        <div class="text-center mt-4">
          <button class="btn btn-primary btn-lg px-4 py-2" id="open-ai-chat"><i class="fas fa-robot me-2"></i>Tư vấn với AI</button>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <?php include 'includes/footer.php'; ?>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <style>
  .service-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    height: 100%;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
  }

  .service-card:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.3);
  }

  .service-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
  }

  .service-icon i {
    font-size: 2.5rem;
    color: #fff;
  }

  .service-card:hover .service-icon {
    background: rgba(255, 255, 255, 0.3);
    transform: rotateY(180deg);
  }

  .service-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
  }

  .service-header h5 {
    color: #fff;
    font-size: 1.4rem;
    font-weight: 600;
    margin: 0;
  }

  .badge {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 500;
  }

  .service-content p {
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 1.5rem;
    line-height: 1.6;
  }

  .service-features {
    list-style: none;
    padding: 0;
    margin: 0 0 1.5rem 0;
  }

  .service-features li {
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
  }

  .service-features li i {
    color: #fff;
    margin-right: 0.5rem;
    font-size: 0.9rem;
  }

  .service-link {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
  }

  .service-link i {
    margin-left: 0.5rem;
    transition: transform 0.3s ease;
  }

  .service-link:hover {
    color: #fff;
    text-decoration: none;
  }

  .service-link:hover i {
    transform: translateX(5px);
  }

  .section-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
  }

  .btn-light {
    background: #fff;
    color: #1976d2;
    border: none;
    transition: all 0.3s ease;
  }

  .btn-light:hover {
    background: #f8f9fa;
    color: #1976d2;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
  }

  .product-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    overflow: hidden;
    height: 100%;
    position: relative;
  }

  .product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.12);
  }

  .product-icon {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 70px;
    height: 70px;
    background: rgba(255,255,255,0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  }

  .product-image {
    position: relative;
    overflow: hidden;
  }

  .product-image img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.5s ease;
  }

  .product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
  }

  .product-card:hover .product-overlay {
    opacity: 1;
  }

  .product-card:hover .product-image img {
    transform: scale(1.1);
  }

  .product-content {
    padding: 1.5rem;
  }

  .product-title {
    color: #333;
    font-weight: 700;
    font-size: 1.4rem;
    margin-bottom: 1rem;
  }

  .product-description {
    color: #666;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 1rem;
  }

  .product-features {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
  }

  .badge {
    font-weight: 500;
    padding: 0.5rem 1rem;
  }

  .btn-primary {
    background: linear-gradient(45deg, #1976d2, #2196f3);
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-primary:hover {
    background: linear-gradient(45deg, #1565c0, #1976d2);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(33,150,243,0.3);
  }

  .bg-primary-subtle {
    background-color: rgba(33,150,243,0.1);
  }

  .blog-card {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
  }

  .blog-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
  }

  .blog-image {
    position: relative;
    overflow: hidden;
  }

  .blog-image img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.5s ease;
  }

  .blog-card:hover .blog-image img {
    transform: scale(1.1);
  }

  .blog-date {
    position: absolute;
    top: 20px;
    right: 20px;
    background: #fff;
    padding: 10px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  }

  .blog-date .day {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1976d2;
    line-height: 1;
  }

  .blog-date .month {
    display: block;
    font-size: 0.9rem;
    color: #666;
    text-transform: uppercase;
  }

  .blog-content {
    padding: 1.5rem;
  }

  .blog-meta {
    font-size: 0.9rem;
  }

  .blog-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin: 1rem 0;
    line-height: 1.4;
  }

  .blog-excerpt {
    color: #666;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1rem;
  }

  .btn-link {
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
  }

  .btn-link:hover {
    color: #1565c0 !important;
  }

  .btn-link i {
    transition: transform 0.3s ease;
  }

  .btn-link:hover i {
    transform: translateX(5px);
  }

  #blog .section-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
  }

  #blog .badge {
    font-size: 1rem;
    font-weight: 500;
    padding: 0.5rem 1.2rem;
    border-radius: 20px;
  }

  .blog-banner {
    min-height: 220px;
    max-height: 260px;
    box-shadow: 0 5px 15px rgba(33,150,243,0.08);
  }

  .featured-article {
    transition: box-shadow 0.3s;
  }

  .featured-article:hover {
    box-shadow: 0 8px 25px rgba(33,150,243,0.13);
  }

  .mini-article {
    transition: box-shadow 0.3s, transform 0.3s;
    cursor: pointer;
  }

  .mini-article:hover {
    box-shadow: 0 8px 25px rgba(33,150,243,0.13);
    transform: translateY(-3px);
  }

  .choose-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(33,150,243,0.07);
    transition: all 0.3s;
    border: none;
    position: relative;
  }
  .choose-card:hover {
    box-shadow: 0 10px 32px rgba(33,150,243,0.13);
    transform: translateY(-6px) scale(1.03);
  }
  .choose-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 2rem;
    margin: 0 auto 1rem auto;
    color: #fff;
    box-shadow: 0 2px 8px rgba(33,150,243,0.10);
  }
  .bg-gradient-primary {
    background: linear-gradient(135deg,#1976d2 0%,#1ec0f7 100%);
  }
  .bg-gradient-success {
    background: linear-gradient(135deg,#43e97b 0%,#38f9d7 100%);
  }
  .bg-gradient-warning {
    background: linear-gradient(135deg,#f7971e 0%,#ffd200 100%);
  }
  .bg-gradient-danger {
    background: linear-gradient(135deg,#f857a6 0%,#ff5858 100%);
  }
  .book-section {
    background: linear-gradient(90deg,#e3f6fd 0%,#fff 100%);
    position: relative;
    z-index: 1;
  }
  .book-section:before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: url('/assets/images/anh_ngau_nhien.jpg') center/cover no-repeat;
    opacity: 0.08;
    z-index: 0;
  }
  .book-section .section-content {
    position: relative;
    z-index: 2;
  }
  .skillful-img-box {
    min-height: 300px;
    background: #f8f9fa;
    border-radius: 30px;
    box-shadow: 0 8px 32px rgba(33,150,243,0.10);
    overflow: hidden;
  }
  .team-card {
    border-radius: 20px;
    transition: all 0.3s;
    background: #fff;
  }
  .team-card:hover {
    box-shadow: 0 10px 32px rgba(33,150,243,0.13);
    transform: translateY(-6px) scale(1.03);
  }
  .section-title {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 1.2rem;
    position: relative;
    display: inline-block;
  }
  .section-title:after {
    content: '';
    display: block;
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg,#1976d2 0%,#1ec0f7 100%);
    margin: 10px auto 0 auto;
    border-radius: 2px;
  }
  .process-step {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(33,150,243,0.07);
    transition: all 0.3s;
    border: none;
    position: relative;
  }
  .process-step:hover {
    box-shadow: 0 10px 32px rgba(33,150,243,0.13);
    transform: translateY(-6px) scale(1.03);
  }
  .process-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 1.7rem;
    margin: 0 auto 0.7rem auto;
    color: #fff;
    box-shadow: 0 2px 8px rgba(33,150,243,0.10);
  }
  .process-number {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1976d2;
    margin-bottom: 0.2rem;
  }
  .modern-accordion .accordion-item {
    border-radius: 20px !important;
    overflow: hidden;
    border: none;
  }
  .modern-accordion .accordion-button {
    background: #f8f9fa;
    border-radius: 20px !important;
    font-weight: 600;
    font-size: 1.1rem;
    box-shadow: none;
    outline: none;
    transition: background 0.2s;
  }
  .modern-accordion .accordion-button:focus {
    box-shadow: 0 0 0 2px #1976d233;
  }
  .modern-accordion .accordion-button:not(.collapsed) {
    background: linear-gradient(90deg,#e3f6fd 0%,#fff 100%);
    color: #1976d2;
  }
  .modern-accordion .accordion-body {
    background: #fff;
    border-radius: 0 0 20px 20px;
    font-size: 1.05rem;
    color: #444;
  }
  </style>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('open-ai-chat');
    if(btn) btn.onclick = function() {
      window.dispatchEvent(new Event('open-ai-chatbox'));
    };
  });
  </script>
  <!-- Floating AI Chat Icon -->
  <div id="ai-chat-float" style="position:fixed;bottom:32px;right:32px;z-index:9999;">
    <button id="ai-chat-float-btn" style="background:linear-gradient(135deg,#1976d2 0%,#1ec0f7 100%);border:none;border-radius:50%;width:60px;height:60px;box-shadow:0 4px 18px rgba(30,192,247,0.18);display:flex;align-items:center;justify-content:center;transition:box-shadow 0.2s;cursor:pointer;">
      <i class="fas fa-robot" style="font-size:2rem;color:#fff;"></i>
    </button>
  </div>
  <script>
  document.getElementById('ai-chat-float-btn').onclick = function() {
    window.dispatchEvent(new Event('open-ai-chatbox'));
  };
  </script>
  <style>
  #ai-chat-float-btn:hover {
    box-shadow:0 8px 32px rgba(25,118,210,0.25);
    background:linear-gradient(135deg,#1ec0f7 0%,#1976d2 100%);
  }
  @media (max-width: 600px) {
    #ai-chat-float { right: 12px; bottom: 12px; }
    #ai-chat-float-btn { width:48px;height:48px; }
    #ai-chat-float-btn i { font-size:1.4rem; }
  }
  </style>
  <?php include 'includes/floating_chat.php'; ?>
</body>
</html>
