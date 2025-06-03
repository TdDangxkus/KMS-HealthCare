<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa hàng - Qickmed Medical & Health Care</title>
    <meta name="description" content="Mua sắm các sản phẩm y tế chất lượng cao tại Qickmed - thuốc, thực phẩm chức năng, thiết bị y tế và dược phẩm.">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/shop.css">
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
                            <h1 class="hero-title">Cửa hàng Y tế</h1>
                            <p class="hero-subtitle">
                                Khám phá hàng ngàn sản phẩm y tế chất lượng cao từ các thương hiệu uy tín
                            </p>
                            <div class="hero-search">
                                <div class="search-box">
                                    <input type="text" placeholder="Tìm kiếm sản phẩm..." class="form-control">
                                    <button class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="categories-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center mb-5">
                        <h2 class="section-title">Danh mục sản phẩm</h2>
                        <p class="section-description">
                            Tìm kiếm sản phẩm theo danh mục phù hợp với nhu cầu của bạn
                        </p>
                    </div>
                </div>
                <div class="row g-4">
                    <!-- Supplements -->
                    <div class="col-lg-3 col-md-6">
                        <div class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-pills"></i>
                            </div>
                            <h4>Thực phẩm chức năng</h4>
                            <p>Vitamin, khoáng chất và các loại thực phẩm bổ sung sức khỏe</p>
                            <div class="category-count">120+ sản phẩm</div>
                            <a href="/shop/supplements/" class="btn btn-outline-primary">Xem ngay</a>
                        </div>
                    </div>

                    <!-- Medicine -->
                    <div class="col-lg-3 col-md-6">
                        <div class="category-card featured">
                            <div class="featured-badge">Bán chạy</div>
                            <div class="category-icon">
                                <i class="fas fa-prescription-bottle-alt"></i>
                            </div>
                            <h4>Thuốc</h4>
                            <p>Thuốc kê đơn và không kê đơn từ các nhà sản xuất uy tín</p>
                            <div class="category-count">300+ sản phẩm</div>
                            <a href="/shop/medicine/" class="btn btn-primary">Xem ngay</a>
                        </div>
                    </div>

                    <!-- Medical Devices -->
                    <div class="col-lg-3 col-md-6">
                        <div class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-stethoscope"></i>
                            </div>
                            <h4>Thiết bị y tế</h4>
                            <p>Máy đo huyết áp, nhiệt kế và các thiết bị y tế gia đình</p>
                            <div class="category-count">80+ sản phẩm</div>
                            <a href="/shop/devices/" class="btn btn-outline-primary">Xem ngay</a>
                        </div>
                    </div>

                    <!-- Pharmaceuticals -->
                    <div class="col-lg-3 col-md-6">
                        <div class="category-card">
                            <div class="category-icon">
                                <i class="fas fa-flask"></i>
                            </div>
                            <h4>Dược phẩm</h4>
                            <p>Các sản phẩm dược phẩm chuyên dụng và thuốc đặc trị</p>
                            <div class="category-count">200+ sản phẩm</div>
                            <a href="/shop/pharma/" class="btn btn-outline-primary">Xem ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="products-section py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center mb-5">
                        <h2 class="section-title">Sản phẩm nổi bật</h2>
                        <p class="section-description">
                            Những sản phẩm được yêu thích và đánh giá cao nhất
                        </p>
                    </div>
                </div>
                <div class="row g-4">
                    <!-- Product 1 -->
                    <div class="col-lg-3 col-md-6">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="/assets/images/product-1.jpg" alt="Vitamin C 1000mg" class="img-fluid">
                                <div class="product-badge sale">-20%</div>
                                <div class="product-actions">
                                    <button class="btn btn-sm btn-primary add-to-cart" data-id="1">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="product-content">
                                <h5>Vitamin C 1000mg</h5>
                                <p class="product-brand">Nature's Way</p>
                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span class="rating-count">(128)</span>
                                </div>
                                <div class="product-price">
                                    <span class="current-price">320.000đ</span>
                                    <span class="original-price">400.000đ</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product 2 -->
                    <div class="col-lg-3 col-md-6">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="/assets/images/product-2.jpg" alt="Máy đo huyết áp" class="img-fluid">
                                <div class="product-badge new">Mới</div>
                                <div class="product-actions">
                                    <button class="btn btn-sm btn-primary add-to-cart" data-id="2">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="product-content">
                                <h5>Máy đo huyết áp Omron</h5>
                                <p class="product-brand">Omron</p>
                                <div class="product-rating">
                                    <span class="stars">★★★★☆</span>
                                    <span class="rating-count">(89)</span>
                                </div>
                                <div class="product-price">
                                    <span class="current-price">1.250.000đ</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="col-lg-3 col-md-6">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="/assets/images/product-3.jpg" alt="Paracetamol 500mg" class="img-fluid">
                                <div class="product-actions">
                                    <button class="btn btn-sm btn-primary add-to-cart" data-id="3">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="product-content">
                                <h5>Paracetamol 500mg</h5>
                                <p class="product-brand">Taisho</p>
                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span class="rating-count">(256)</span>
                                </div>
                                <div class="product-price">
                                    <span class="current-price">25.000đ</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product 4 -->
                    <div class="col-lg-3 col-md-6">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="/assets/images/product-4.jpg" alt="Omega 3" class="img-fluid">
                                <div class="product-badge hot">Hot</div>
                                <div class="product-actions">
                                    <button class="btn btn-sm btn-primary add-to-cart" data-id="4">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="product-content">
                                <h5>Omega 3 Fish Oil</h5>
                                <p class="product-brand">Kirkland</p>
                                <div class="product-rating">
                                    <span class="stars">★★★★★</span>
                                    <span class="rating-count">(342)</span>
                                </div>
                                <div class="product-price">
                                    <span class="current-price">580.000đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-primary btn-lg">Xem tất cả sản phẩm</a>
                </div>
            </div>
        </section>

        <!-- Why Choose Us -->
        <section class="features-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center mb-5">
                        <h2 class="section-title">Tại sao mua sắm tại Qickmed?</h2>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h5>Chính hãng 100%</h5>
                            <p>Cam kết sản phẩm chính hãng từ các nhà sản xuất uy tín</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <h5>Giao hàng nhanh</h5>
                            <p>Giao hàng trong 24h tại TP.HCM và 2-3 ngày toàn quốc</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <h5>Tư vấn 24/7</h5>
                            <p>Dược sĩ chuyên nghiệp tư vấn sử dụng thuốc mọi lúc</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-undo-alt"></i>
                            </div>
                            <h5>Đổi trả dễ dàng</h5>
                            <p>Chính sách đổi trả linh hoạt trong vòng 30 ngày</p>
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
    <script src="/assets/js/shop.js"></script>
</body>
</html> 