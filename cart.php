<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - Qickmed Medical & Health Care</title>
    <meta name="description" content="Xem và quản lý giỏ hàng của bạn tại Qickmed. Thanh toán an toàn và giao hàng nhanh chóng.">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/cart.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <!-- Breadcrumb -->
        <section class="breadcrumb-section py-3 bg-light">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="/shop.php">Cửa hàng</a></li>
                        <li class="breadcrumb-item active">Giỏ hàng</li>
                    </ol>
                </nav>
            </div>
        </section>

        <!-- Cart Section -->
        <section class="cart-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 class="page-title">Giỏ hàng của bạn</h1>
                        <p class="page-subtitle">Kiểm tra và cập nhật đơn hàng trước khi thanh toán</p>
                    </div>
                </div>

                <div class="row g-5" id="cartContainer">
                    <!-- Cart Items -->
                    <div class="col-lg-8">
                        <div class="cart-items">
                            <!-- Cart Item 1 -->
                            <div class="cart-item" data-id="1">
                                <div class="item-image">
                                    <img src="/assets/images/product-1.jpg" alt="Vitamin C 1000mg" class="img-fluid">
                                </div>
                                <div class="item-details">
                                    <h5 class="item-name">Vitamin C 1000mg</h5>
                                    <p class="item-brand">Nature's Way</p>
                                    <p class="item-description">Tăng cường hệ miễn dịch, chống oxy hóa</p>
                                    <div class="item-rating">
                                        <span class="stars">★★★★★</span>
                                        <span class="rating-count">(128)</span>
                                    </div>
                                </div>
                                <div class="item-quantity">
                                    <label>Số lượng:</label>
                                    <div class="quantity-controls">
                                        <button class="quantity-btn minus" onclick="updateQuantity(1, -1)">-</button>
                                        <input type="number" value="2" min="1" class="quantity-input" onchange="updateQuantity(1, this.value, true)">
                                        <button class="quantity-btn plus" onclick="updateQuantity(1, 1)">+</button>
                                    </div>
                                </div>
                                <div class="item-price">
                                    <div class="current-price">320.000đ</div>
                                    <div class="original-price">400.000đ</div>
                                    <div class="total-price">640.000đ</div>
                                </div>
                                <div class="item-actions">
                                    <button class="btn btn-sm btn-outline-danger" onclick="removeItem(1)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Cart Item 2 -->
                            <div class="cart-item" data-id="2">
                                <div class="item-image">
                                    <img src="/assets/images/product-2.jpg" alt="Máy đo huyết áp" class="img-fluid">
                                </div>
                                <div class="item-details">
                                    <h5 class="item-name">Máy đo huyết áp Omron</h5>
                                    <p class="item-brand">Omron</p>
                                    <p class="item-description">Máy đo huyết áp tự động, chính xác cao</p>
                                    <div class="item-rating">
                                        <span class="stars">★★★★☆</span>
                                        <span class="rating-count">(89)</span>
                                    </div>
                                </div>
                                <div class="item-quantity">
                                    <label>Số lượng:</label>
                                    <div class="quantity-controls">
                                        <button class="quantity-btn minus" onclick="updateQuantity(2, -1)">-</button>
                                        <input type="number" value="1" min="1" class="quantity-input" onchange="updateQuantity(2, this.value, true)">
                                        <button class="quantity-btn plus" onclick="updateQuantity(2, 1)">+</button>
                                    </div>
                                </div>
                                <div class="item-price">
                                    <div class="current-price">1.250.000đ</div>
                                    <div class="total-price">1.250.000đ</div>
                                </div>
                                <div class="item-actions">
                                    <button class="btn btn-sm btn-outline-danger" onclick="removeItem(2)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Empty Cart Message (hidden by default) -->
                            <div class="empty-cart" id="emptyCart" style="display: none;">
                                <div class="text-center py-5">
                                    <i class="fas fa-shopping-cart empty-icon"></i>
                                    <h3>Giỏ hàng trống</h3>
                                    <p>Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
                                    <a href="/shop.php" class="btn btn-primary">Tiếp tục mua sắm</a>
                                </div>
                            </div>
                        </div>

                        <!-- Continue Shopping -->
                        <div class="continue-shopping mt-4">
                            <a href="/shop.php" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                            </a>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h4>Tóm tắt đơn hàng</h4>
                            
                            <div class="summary-item">
                                <span>Tạm tính:</span>
                                <span id="subtotal">1.890.000đ</span>
                            </div>
                            
                            <div class="summary-item">
                                <span>Giảm giá:</span>
                                <span class="text-success" id="discount">-160.000đ</span>
                            </div>
                            
                            <div class="summary-item">
                                <span>Phí vận chuyển:</span>
                                <span id="shipping">Miễn phí</span>
                            </div>
                            
                            <hr>
                            
                            <div class="summary-total">
                                <span>Tổng cộng:</span>
                                <span id="total">1.890.000đ</span>
                            </div>

                            <!-- Coupon Code -->
                            <div class="coupon-section mt-4">
                                <h6>Mã giảm giá</h6>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Nhập mã giảm giá" id="couponCode">
                                    <button class="btn btn-outline-primary" onclick="applyCoupon()">Áp dụng</button>
                                </div>
                            </div>

                            <!-- Payment Methods -->
                            <div class="payment-methods mt-4">
                                <h6>Phương thức thanh toán</h6>
                                <div class="payment-options">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment" id="cod" value="cod" checked>
                                        <label class="form-check-label" for="cod">
                                            <i class="fas fa-money-bill-wave me-2"></i>Thanh toán khi nhận hàng
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment" id="vnpay" value="vnpay">
                                        <label class="form-check-label" for="vnpay">
                                            <i class="fab fa-cc-visa me-2"></i>VNPay
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment" id="momo" value="momo">
                                        <label class="form-check-label" for="momo">
                                            <i class="fas fa-mobile-alt me-2"></i>MoMo
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <button class="btn btn-primary btn-lg w-100 mt-4" onclick="proceedToCheckout()">
                                <i class="fas fa-lock me-2"></i>Thanh toán an toàn
                            </button>

                            <!-- Security Info -->
                            <div class="security-info mt-3">
                                <div class="security-item">
                                    <i class="fas fa-shield-alt text-success me-2"></i>
                                    <span>Thanh toán an toàn 100%</span>
                                </div>
                                <div class="security-item">
                                    <i class="fas fa-truck text-primary me-2"></i>
                                    <span>Miễn phí vận chuyển từ 500.000đ</span>
                                </div>
                                <div class="security-item">
                                    <i class="fas fa-undo-alt text-info me-2"></i>
                                    <span>Đổi trả trong 30 ngày</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Products -->
        <section class="related-products py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="section-title">Sản phẩm liên quan</h2>
                        <p class="section-description">Những sản phẩm bạn có thể quan tâm</p>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="/assets/images/product-3.jpg" alt="Paracetamol" class="img-fluid">
                            </div>
                            <div class="product-content">
                                <h6>Paracetamol 500mg</h6>
                                <div class="product-price">25.000đ</div>
                                <button class="btn btn-primary btn-sm w-100 mt-2" onclick="addToCart(3)">
                                    <i class="fas fa-cart-plus me-1"></i>Thêm vào giỏ
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="/assets/images/product-4.jpg" alt="Omega 3" class="img-fluid">
                            </div>
                            <div class="product-content">
                                <h6>Omega 3 Fish Oil</h6>
                                <div class="product-price">580.000đ</div>
                                <button class="btn btn-primary btn-sm w-100 mt-2" onclick="addToCart(4)">
                                    <i class="fas fa-cart-plus me-1"></i>Thêm vào giỏ
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="/assets/images/product-5.jpg" alt="Nhiệt kế" class="img-fluid">
                            </div>
                            <div class="product-content">
                                <h6>Nhiệt kế điện tử</h6>
                                <div class="product-price">150.000đ</div>
                                <button class="btn btn-primary btn-sm w-100 mt-2" onclick="addToCart(5)">
                                    <i class="fas fa-cart-plus me-1"></i>Thêm vào giỏ
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="/assets/images/product-6.jpg" alt="Khẩu trang" class="img-fluid">
                            </div>
                            <div class="product-content">
                                <h6>Khẩu trang y tế 3 lớp</h6>
                                <div class="product-price">45.000đ</div>
                                <button class="btn btn-primary btn-sm w-100 mt-2" onclick="addToCart(6)">
                                    <i class="fas fa-cart-plus me-1"></i>Thêm vào giỏ
                                </button>
                            </div>
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
    <script src="/assets/js/cart.js"></script>
</body>
</html> 