<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dịch vụ - Qickmed Medical & Health Care</title>
    <meta name="description" content="Khám phá các dịch vụ y tế chất lượng cao tại Qickmed - từ khám tổng quát đến chuyên khoa, với trang thiết bị hiện đại và bác sĩ chuyên nghiệp.">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/services.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-overlay"></div>
            <div class="container">
                <div class="row align-items-center min-vh-100">
                    <div class="col-lg-8 mx-auto text-center">
                        <div class="hero-content">
                            <h1 class="hero-title">Dịch vụ y tế</h1>
                            <p class="hero-subtitle">
                                Chăm sóc sức khỏe toàn diện với các dịch vụ y tế chất lượng cao, 
                                từ khám tổng quát đến điều trị chuyên khoa
                            </p>
                            <div class="hero-buttons">
                                <a href="#services" class="btn btn-primary btn-lg me-3">Xem dịch vụ</a>
                                <a href="#contact" class="btn btn-outline-light btn-lg">Đặt lịch hẹn</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Grid -->
        <section class="services-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center mb-5">
                        <h2 class="section-title">Dịch vụ của chúng tôi</h2>
                        <p class="section-description">
                            Cung cấp đầy đủ các dịch vụ y tế từ cơ bản đến chuyên sâu với chất lượng quốc tế
                        </p>
                    </div>
                </div>
                <div class="row g-4">
                    <!-- General Checkup -->
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-stethoscope"></i>
                            </div>
                            <div class="service-content">
                                <h4>Khám tổng quát</h4>
                                <p>Khám sức khỏe định kỳ và tầm soát các bệnh lý thường gặp với quy trình chuyên nghiệp.</p>
                                <ul class="service-features">
                                    <li>Khám lâm sàng toàn diện</li>
                                    <li>Xét nghiệm máu cơ bản</li>
                                    <li>Đo huyết áp, nhịp tim</li>
                                    <li>Tư vấn dinh dưỡng</li>
                                </ul>
                                <div class="service-price">
                                    <span class="price">200.000đ - 500.000đ</span>
                                </div>
                                <a href="#" class="btn btn-primary btn-sm">Đặt lịch ngay</a>
                            </div>
                        </div>
                    </div>

                    <!-- Cardiology -->
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card featured">
                            <div class="featured-badge">Nổi bật</div>
                            <div class="service-icon">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            <div class="service-content">
                                <h4>Tim mạch</h4>
                                <p>Chẩn đoán và điều trị các bệnh lý tim mạch với trang thiết bị hiện đại nhất.</p>
                                <ul class="service-features">
                                    <li>Siêu âm tim</li>
                                    <li>Điện tim</li>
                                    <li>Holter 24h</li>
                                    <li>Thăm dò chức năng tim</li>
                                </ul>
                                <div class="service-price">
                                    <span class="price">300.000đ - 2.000.000đ</span>
                                </div>
                                <a href="#" class="btn btn-primary btn-sm">Đặt lịch ngay</a>
                            </div>
                        </div>
                    </div>

                    <!-- Gastroenterology -->
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-prescription-bottle-alt"></i>
                            </div>
                            <div class="service-content">
                                <h4>Tiêu hóa</h4>
                                <p>Chẩn đoán và điều trị các bệnh lý về đường tiêu hóa, gan mật tụy.</p>
                                <ul class="service-features">
                                    <li>Nội soi dạ dày</li>
                                    <li>Nội soi đại tràng</li>
                                    <li>Siêu âm bụng</li>
                                    <li>Xét nghiệm chức năng gan</li>
                                </ul>
                                <div class="service-price">
                                    <span class="price">250.000đ - 1.500.000đ</span>
                                </div>
                                <a href="#" class="btn btn-primary btn-sm">Đặt lịch ngay</a>
                            </div>
                        </div>
                    </div>

                    <!-- Neurology -->
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-brain"></i>
                            </div>
                            <div class="service-content">
                                <h4>Thần kinh</h4>
                                <p>Điều trị các bệnh lý thần kinh từ cơ bản đến phức tạp với đội ngũ chuyên gia.</p>
                                <ul class="service-features">
                                    <li>Điện não đồ</li>
                                    <li>MRI não</li>
                                    <li>Đo tốc độ dẫn truyền thần kinh</li>
                                    <li>Điều trị đau đầu, chóng mặt</li>
                                </ul>
                                <div class="service-price">
                                    <span class="price">400.000đ - 3.000.000đ</span>
                                </div>
                                <a href="#" class="btn btn-primary btn-sm">Đặt lịch ngay</a>
                            </div>
                        </div>
                    </div>

                    <!-- Orthopedics -->
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card">
                            <div class="service-icon">
                                <i class="fas fa-bone"></i>
                            </div>
                            <div class="service-content">
                                <h4>Chấn thương chỉnh hình</h4>
                                <p>Điều trị chấn thương và các bệnh lý về xương khớp, cột sống.</p>
                                <ul class="service-features">
                                    <li>X-quang, CT scan</li>
                                    <li>Điều trị gãy xương</li>
                                    <li>Phẫu thuật chỉnh hình</li>
                                    <li>Vật lý trị liệu</li>
                                </ul>
                                <div class="service-price">
                                    <span class="price">300.000đ - 5.000.000đ</span>
                                </div>
                                <a href="#" class="btn btn-primary btn-sm">Đặt lịch ngay</a>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency -->
                    <div class="col-lg-4 col-md-6">
                        <div class="service-card emergency">
                            <div class="emergency-badge">24/7</div>
                            <div class="service-icon">
                                <i class="fas fa-ambulance"></i>
                            </div>
                            <div class="service-content">
                                <h4>Cấp cứu</h4>
                                <p>Dịch vụ cấp cứu 24/7 với đội ngũ y bác sĩ luôn sẵn sàng.</p>
                                <ul class="service-features">
                                    <li>Cấp cứu nội khoa</li>
                                    <li>Cấp cứu ngoại khoa</li>
                                    <li>Hồi sức tích cực</li>
                                    <li>Xe cứu thương</li>
                                </ul>
                                <div class="service-price">
                                    <span class="price">Liên hệ</span>
                                </div>
                                <a href="tel:0123456789" class="btn btn-danger btn-sm">Gọi ngay: 0123456789</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center mb-5">
                        <h2 class="section-title">Tại sao chọn Qickmed?</h2>
                        <p class="section-description">
                            Những ưu điểm vượt trội làm nên sự khác biệt của chúng tôi
                        </p>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <h5>Đội ngũ chuyên gia</h5>
                            <p>Bác sĩ có trình độ cao, giàu kinh nghiệm và được đào tạo bài bản</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-microscope"></i>
                            </div>
                            <h5>Công nghệ hiện đại</h5>
                            <p>Trang thiết bị y tế tiên tiến nhất được nhập khẩu từ các nước phát triển</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h5>Phục vụ 24/7</h5>
                            <p>Sẵn sàng phục vụ bệnh nhân mọi lúc, mọi nơi với dịch vụ cấp cứu 24/7</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h5>An toàn tuyệt đối</h5>
                            <p>Tuân thủ nghiêm ngặt các quy trình an toàn y tế quốc tế</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section class="pricing-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center mb-5">
                        <h2 class="section-title">Gói khám sức khỏe</h2>
                        <p class="section-description">
                            Các gói khám sức khỏe toàn diện được thiết kế phù hợp với từng độ tuổi
                        </p>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="pricing-card">
                            <div class="pricing-header">
                                <h4>Gói cơ bản</h4>
                                <div class="price">
                                    <span class="amount">1.500.000đ</span>
                                    <span class="period">/lần</span>
                                </div>
                            </div>
                            <div class="pricing-body">
                                <ul class="pricing-features">
                                    <li><i class="fas fa-check"></i> Khám lâm sàng tổng quát</li>
                                    <li><i class="fas fa-check"></i> Xét nghiệm máu cơ bản</li>
                                    <li><i class="fas fa-check"></i> Xét nghiệm nước tiểu</li>
                                    <li><i class="fas fa-check"></i> X-quang phổi</li>
                                    <li><i class="fas fa-check"></i> Điện tim</li>
                                    <li><i class="fas fa-check"></i> Tư vấn kết quả</li>
                                </ul>
                            </div>
                            <div class="pricing-footer">
                                <a href="#" class="btn btn-outline-primary">Đặt lịch</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="pricing-card featured">
                            <div class="pricing-badge">Phổ biến</div>
                            <div class="pricing-header">
                                <h4>Gói nâng cao</h4>
                                <div class="price">
                                    <span class="amount">3.500.000đ</span>
                                    <span class="period">/lần</span>
                                </div>
                            </div>
                            <div class="pricing-body">
                                <ul class="pricing-features">
                                    <li><i class="fas fa-check"></i> Tất cả gói cơ bản</li>
                                    <li><i class="fas fa-check"></i> Siêu âm bụng tổng quát</li>
                                    <li><i class="fas fa-check"></i> Siêu âm tim</li>
                                    <li><i class="fas fa-check"></i> Xét nghiệm chức năng gan</li>
                                    <li><i class="fas fa-check"></i> Xét nghiệm chức năng thận</li>
                                    <li><i class="fas fa-check"></i> Đo mật độ xương</li>
                                    <li><i class="fas fa-check"></i> Tư vấn dinh dưỡng</li>
                                </ul>
                            </div>
                            <div class="pricing-footer">
                                <a href="#" class="btn btn-primary">Đặt lịch</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="pricing-card">
                            <div class="pricing-header">
                                <h4>Gói cao cấp</h4>
                                <div class="price">
                                    <span class="amount">6.500.000đ</span>
                                    <span class="period">/lần</span>
                                </div>
                            </div>
                            <div class="pricing-body">
                                <ul class="pricing-features">
                                    <li><i class="fas fa-check"></i> Tất cả gói nâng cao</li>
                                    <li><i class="fas fa-check"></i> MRI não</li>
                                    <li><i class="fas fa-check"></i> CT scan ngực</li>
                                    <li><i class="fas fa-check"></i> Nội soi dạ dày</li>
                                    <li><i class="fas fa-check"></i> Xét nghiệm ung thư</li>
                                    <li><i class="fas fa-check"></i> Khám mắt chuyên khoa</li>
                                    <li><i class="fas fa-check"></i> Khám răng hàm mặt</li>
                                    <li><i class="fas fa-check"></i> Tư vấn bác sĩ chuyên khoa</li>
                                </ul>
                            </div>
                            <div class="pricing-footer">
                                <a href="#" class="btn btn-outline-primary">Đặt lịch</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center">
                        <h2 class="cta-title">Sẵn sàng chăm sóc sức khỏe của bạn?</h2>
                        <p class="cta-description">
                            Đặt lịch hẹn ngay hôm nay để được tư vấn và khám bệnh với đội ngũ y bác sĩ chuyên nghiệp
                        </p>
                        <div class="cta-buttons">
                            <a href="tel:0123456789" class="btn btn-primary btn-lg me-3">
                                <i class="fas fa-phone me-2"></i>Gọi ngay: 0123 456 789
                            </a>
                            <a href="#" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-calendar-alt me-2"></i>Đặt lịch online
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="/assets/js/services.js"></script>
</body>
</html> 