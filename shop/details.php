<?php
// Start session trước khi có bất kỳ output nào
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions/product_functions.php';

// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy thông tin sản phẩm
$product = getProductDetails($product_id);

// Nếu không tìm thấy sản phẩm, chuyển hướng về trang shop
if (!$product) {
    header('Location: /shop.php');  
    exit;   
}

// Lấy sản phẩm liên quan
$relatedProducts = getRelatedProducts($product['category_id'], $product_id, 4);

// Lấy đánh giá sản phẩm
$reviews = getProductReviews($product_id);

// Tính số sao trung bình
$avgRating = 0;
$totalReviews = count($reviews);
if ($totalReviews > 0) {
    $totalStars = array_sum(array_column($reviews, 'rating'));
    $avgRating = round($totalStars / $totalReviews, 1);
}

// Tính giá hiển thị
$displayPrice = $product['discount_price'] ?? $product['price'];
$originalPrice = $product['price'];
$discountPercent = $product['discount_price'] ? round((($originalPrice - $displayPrice) / $originalPrice) * 100) : 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - QickMed</title>
    <meta name="description" content="<?php echo htmlspecialchars($product['description']); ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/product-details.css">
    
    <style>
        /* Notification Override CSS - Same as shop.php */
        .cart-notification {
            position: fixed !important;
            z-index: 999999 !important;
            top: 100px !important;
            right: 20px !important;
            min-width: 300px !important;
            max-width: 400px !important;
            box-shadow: 0 8px 24px rgba(0,0,0,0.25) !important;
            border-radius: 12px !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255,255,255,0.2) !important;
            font-weight: 500 !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        .cart-notification.alert {
            position: fixed !important;
            z-index: 999999 !important;
            margin: 0 !important;
        }
        
        @media (max-width: 768px) {
            .cart-notification {
                top: 80px !important;
                left: 10px !important;
                right: 10px !important;
                min-width: auto !important;
                max-width: none !important;
            }
        }
        
        /* Force notification to be on top of everything */
        .cart-notification,
        .cart-notification.position-fixed,
        .cart-notification.alert,
        .cart-notification.alert.position-fixed {
            position: fixed !important;
            z-index: 999999 !important;
        }
        
        /* Minimal inline styles - main styles are in product-details.css */
        .product-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .rating-stars {
            color: #ffd700;
            font-size: 1.1rem;
        }
        
        .rating-count {
            color: #666;
            font-size: 0.9rem;
        }
        
        .product-price-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            color: white;
        }
        
        .current-price {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .original-price {   
            font-size: 1.2rem;
            opacity: 0.8;
            text-decoration: line-through;
            margin-right: 1rem;
        }
        
        .price-save {
            background: rgba(255,255,255,0.2);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .product-stock {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            padding: 1rem;
            background: #e8f5e8;
            border-radius: 12px;
            color: #2d5a27;
            font-weight: 500;
        }
        
        .product-stock.out-of-stock {
            background: #fdeaea;
            color: #c53030;
        }
        
        .quantity-section {
            margin-bottom: 2rem;
        }
        
        .quantity-label {
            font-weight: 600;
            margin-bottom: 0.8rem;
            color: #2c3e50;
        }
        
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .quantity-wrapper {
            display: flex;
            align-items: center;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }
        
        .quantity-btn {
            width: 45px;
            height: 45px;
            border: none;
            background: #3498db;
            color: white;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .quantity-btn:hover {
            background: #2980b9;
        }
        
        .quantity-btn:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
        }
        
        .quantity-input {
            width: 80px;
            height: 45px;
            border: none;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 600;
            background: #f8f9fa;
        }
        
        .quantity-input:focus {
            outline: none;
            background: white;
        }
        
        .action-buttons {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .btn-buy-now {
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-buy-now:hover {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(46, 204, 113, 0.3);
        }
        
        .btn-add-cart {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-add-cart:hover {
            background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
        }
        
        .btn-wishlist {
            background: white;
            color: #e74c3c;
            border: 2px solid #e74c3c;
            padding: 1rem;
            border-radius: 12px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-wishlist:hover {
            background: #e74c3c;
            color: white;
            transform: translateY(-2px);
        }
        
        .product-description {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
        }
        
        .description-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
        }
        
        .description-text {
            color: #5a6c7d;
            line-height: 1.8;
        }
        
        .product-specs {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }
        
        .specs-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }
        
        .specs-table {
            width: 100%;
        }
        
        .specs-table tr {
            border-bottom: 1px solid #eee;
        }
        
        .specs-table td {
            padding: 0.8rem 0;
            vertical-align: top;
        }
        
        .specs-table td:first-child {
            font-weight: 600;
            color: #2c3e50;
            width: 30%;
        }
        
        .specs-table td:last-child {
            color: #5a6c7d;
        }
        
        .related-products {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        
        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .related-product-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            height: 100%;
        }
        
        .related-product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
            color: inherit;
            text-decoration: none;
        }
        
        .related-product-image {
            height: 200px;
            overflow: hidden;
            position: relative;
        }
        
        .related-product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .related-product-card:hover .related-product-image img {
            transform: scale(1.1);
        }
        
        .related-product-info {
            padding: 1.5rem;
        }
        
        .related-product-name {
            font-weight: 600;
            margin-bottom: 0.8rem;
            color: #2c3e50;
            line-height: 1.4;
        }
        
        .related-product-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: #e74c3c;
            margin-bottom: 0.5rem;
        }
        
        .breadcrumb {
            background: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .breadcrumb-item a {
            color: #3498db;
            text-decoration: none;
        }
        
        .breadcrumb-item a:hover {
            color: #2980b9;
        }
        
        @media (max-width: 768px) {
            .product-container {
                padding: 0 0.5rem;
            }
            
            .product-info-section {
                padding: 2rem 1.5rem;
            }
            
            .product-title {
                font-size: 1.8rem;
            }
            
            .current-price {
                font-size: 2rem;
            }
            
            .action-buttons {
                grid-template-columns: 1fr;
                gap: 0.8rem;
            }
            
            .main-product-image {
                height: 300px;
            }
        }
        
        .loading {
            opacity: 0.7;
            pointer-events: none;
            position: relative;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);    
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <div class="product-container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="/shop.php">Cửa hàng</a></li>
                <li class="breadcrumb-item">
                    <a href="/shop/products.php?category=<?php echo $product['category_id']; ?>">
                        <?php echo htmlspecialchars($product['category_name'] ?? 'Sản phẩm'); ?>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php echo htmlspecialchars($product['name']); ?>
                </li>
            </ol>
        </nav>

        <!-- Product Details -->
        <div class="product-detail-card">
            <div class="row g-0">
                <!-- Product Image -->
                <div class="col-lg-6">
                    <div class="product-image-section">
                        <?php if ($discountPercent > 0): ?>
                        <div class="discount-badge">
                            <i class="fas fa-fire"></i> -<?php echo $discountPercent; ?>%
                        </div>
                        <?php endif; ?>
                        
                        <div class="text-center">
                            <img src="<?php echo htmlspecialchars($product['display_image'] ?? $product['image_url'] ?? '/assets/images/default-product.jpg'); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>"
                                 class="main-product-image">
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-6">
                    <div class="product-info-section">
                        <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                        
                        <!-- Rating -->
                        <div class="product-rating">
                            <div class="rating-stars">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $avgRating): ?>
                                        <i class="fas fa-star"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <span class="rating-count">(<?php echo $totalReviews; ?> đánh giá)</span>
                        </div>

                        <!-- Price -->
                        <div class="product-price-section">
                            <span class="current-price"><?php echo number_format($displayPrice, 0, ',', '.'); ?>đ</span>
                            <?php if ($discountPercent > 0): ?>
                                <div>
                                    <span class="original-price"><?php echo number_format($originalPrice, 0, ',', '.'); ?>đ</span>
                                    <span class="price-save">Tiết kiệm <?php echo number_format($originalPrice - $displayPrice, 0, ',', '.'); ?>đ</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Stock Status -->
                        <div class="product-stock <?php echo $product['stock'] > 0 ? '' : 'out-of-stock'; ?>">
                            <?php if ($product['stock'] > 0): ?>
                                <i class="fas fa-check-circle"></i>
                                <span>Còn <strong><?php echo $product['stock']; ?></strong> sản phẩm</span>
                            <?php else: ?>
                                <i class="fas fa-times-circle"></i>
                                <span>Tạm hết hàng</span>
                            <?php endif; ?>
                        </div>

                        <?php if ($product['stock'] > 0): ?>
                        <!-- Quantity -->
                        <div class="quantity-section">
                            <div class="quantity-label">Số lượng:</div>
                            <div class="quantity-controls">
                                <div class="quantity-wrapper">
                                    <button class="quantity-btn minus" onclick="changeQuantity(-1)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" value="1" min="1" max="<?php echo $product['stock']; ?>" 
                                           class="quantity-input" id="quantityInput">
                                    <button class="quantity-btn plus" onclick="changeQuantity(1)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Tối đa <?php echo $product['stock']; ?> sản phẩm</small>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button class="btn-buy-now" data-id="<?php echo $product['product_id']; ?>">
                                <i class="fas fa-lightning-bolt"></i>
                                Mua ngay
                            </button>
                            
                            <button class="btn-add-cart add-to-cart" data-id="<?php echo $product['product_id']; ?>">
                                <i class="fas fa-cart-plus"></i>
                            </button>
                            
                            <button class="btn-wishlist add-to-wishlist" data-id="<?php echo $product['product_id']; ?>">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <?php endif; ?>

                        <!-- Description -->
                        <div class="product-description">
                            <div class="description-title">Mô tả sản phẩm</div>
                            <div class="description-text">
                                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Specifications -->
        <?php if (!empty($product['active_ingredient']) || !empty($product['dosage_form'])): ?>
        <div class="product-specs">
            <h3 class="specs-title">Thông tin chi tiết</h3>
            <table class="specs-table">
                <?php if (!empty($product['active_ingredient'])): ?>
                <tr>
                    <td>Hoạt chất:</td>
                    <td><?php echo htmlspecialchars($product['active_ingredient']); ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($product['dosage_form'])): ?>
                <tr>
                    <td>Dạng bào chế:</td>
                    <td><?php echo htmlspecialchars($product['dosage_form']); ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($product['unit'])): ?>
                <tr>
                    <td>Đơn vị:</td>
                    <td><?php echo htmlspecialchars($product['unit']); ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($product['usage_instructions'])): ?>
                <tr>
                    <td>Hướng dẫn sử dụng:</td>
                    <td><?php echo nl2br(htmlspecialchars($product['usage_instructions'])); ?></td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
        <?php endif; ?>

        <!-- Related Products -->
        <?php if (!empty($relatedProducts)): ?>
        <div class="related-products">
            <h3 class="section-title">Sản phẩm liên quan</h3>
            <div class="row g-4">
                <?php foreach ($relatedProducts as $relatedProduct): ?>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="/shop/details.php?id=<?php echo $relatedProduct['product_id']; ?>" 
                       class="related-product-card">
                        <div class="related-product-image">
                            <img src="<?php echo htmlspecialchars($relatedProduct['display_image'] ?? $relatedProduct['image_url'] ?? '/assets/images/default-product.jpg'); ?>" 
                                 alt="<?php echo htmlspecialchars($relatedProduct['name']); ?>">
                            
                            <?php if (isset($relatedProduct['discount_percent']) && $relatedProduct['discount_percent'] > 0): ?>
                            <div class="discount-badge">
                                -<?php echo $relatedProduct['discount_percent']; ?>%
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="related-product-info">
                            <h4 class="related-product-name">
                                <?php echo htmlspecialchars($relatedProduct['name']); ?>
                            </h4>
                            
                            <div class="related-product-price">
                                <?php if (isset($relatedProduct['discount_price']) && $relatedProduct['discount_price']): ?>
                                    <?php echo number_format($relatedProduct['discount_price'], 0, ',', '.'); ?>đ
                                    <small style="text-decoration: line-through; color: #999; margin-left: 8px;">
                                        <?php echo number_format($relatedProduct['price'], 0, ',', '.'); ?>đ
                                    </small>
                                <?php else: ?>
                                    <?php echo number_format($relatedProduct['price'], 0, ',', '.'); ?>đ
                                <?php endif; ?>
                            </div>

                            <div class="product-status">
                                <?php if ($relatedProduct['stock'] > 0): ?>
                                <span class="badge bg-success">Còn hàng</span>
                                <?php else: ?>
                                <span class="badge bg-danger">Hết hàng</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/cart-new.js"></script>
    <script>
        // Quantity Controls
        function changeQuantity(delta) {
            const input = document.getElementById('quantityInput');
            const current = parseInt(input.value);
            const max = parseInt(input.getAttribute('max'));
            const min = parseInt(input.getAttribute('min'));
            
            const newValue = current + delta;
            
            if (newValue >= min && newValue <= max) {
                input.value = newValue;
                updateButtons();
            }
        }
        
        function updateButtons() {
            const input = document.getElementById('quantityInput');
            const minusBtn = document.querySelector('.quantity-btn.minus');
            const plusBtn = document.querySelector('.quantity-btn.plus');
            const current = parseInt(input.value);
            const max = parseInt(input.getAttribute('max'));
            const min = parseInt(input.getAttribute('min'));
            
            minusBtn.disabled = current <= min;
            plusBtn.disabled = current >= max;
        }
        
        // Event listeners
        document.getElementById('quantityInput').addEventListener('input', function() {
            const max = parseInt(this.getAttribute('max'));
            const min = parseInt(this.getAttribute('min'));
            let value = parseInt(this.value);
            
            if (value > max) this.value = max;
            if (value < min) this.value = min;
            
            updateButtons();
        });
        
        // Buy Now functionality
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-buy-now')) {
                e.preventDefault();
                const buyBtn = e.target.closest('.btn-buy-now');
                const productId = buyBtn.dataset.id;
                
                if (!productId) return;
                
                // Get quantity
                const quantityInput = document.querySelector('.quantity-input');
                const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;
                
                // Add loading state
                const originalHtml = buyBtn.innerHTML;
                buyBtn.disabled = true;
                buyBtn.classList.add('loading');
                buyBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
                
                // Add to cart first, then redirect to checkout
                fetch('/api/cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        product_id: parseInt(productId),
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update cart count if cartManager exists
                        if (window.cartManager) {
                            window.cartManager.updateCartCount(data.cart_count);
                        }
                        
                        // Redirect to checkout
                        window.location.href = '/checkout.php';
                    } else {
                        // Show error notification
                        if (window.cartManager) {
                            window.cartManager.showNotification(data.message || 'Có lỗi xảy ra', 'error');
                        } else {
                            alert(data.message || 'Có lỗi xảy ra');
                        }
                        
                        // Restore button
                        buyBtn.disabled = false;
                        buyBtn.classList.remove('loading');
                        buyBtn.innerHTML = originalHtml;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    
                    // Show error notification
                    if (window.cartManager) {
                        window.cartManager.showNotification('Có lỗi xảy ra khi thêm sản phẩm', 'error');
                    } else {
                        alert('Có lỗi xảy ra');
                    }
                    
                    // Restore button
                    buyBtn.disabled = false;
                    buyBtn.classList.remove('loading');
                    buyBtn.innerHTML = originalHtml;
                });
            }
        });
        
        // Cart functionality is handled by cart-new.js
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateButtons();
        });
    </script>
</body>
</html> 