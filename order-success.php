<?php
session_start();
require_once 'includes/db.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    header('Location: /shop.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = (int)$_GET['order_id'];

// Lấy thông tin đơn hàng
$stmt = $conn->prepare("
    SELECT 
        o.order_id, o.total, o.payment_method, o.order_date, o.shipping_address,
        COUNT(oi.item_id) as item_count
    FROM orders o 
    LEFT JOIN order_items oi ON o.order_id = oi.order_id 
    WHERE o.order_id = ? AND o.user_id = ? AND o.status != 'cart'
    GROUP BY o.order_id
");
$stmt->bind_param('ii', $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    header('Location: /shop.php');
    exit();
}

$shipping_address = json_decode($order['shipping_address'], true);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công - Qickmed</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }
        
        .success-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .success-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        
        .success-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
        }
        
        .success-content {
            padding: 2rem;
        }
        
        .order-info {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .btn-outline-custom {
            border: 2px solid #667eea;
            color: #667eea;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-outline-custom:hover {
            background: #667eea;
            color: white;
        }
        
        .timeline {
            padding: 1rem 0;
        }
        
        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .timeline-icon {
            width: 40px;
            height: 40px;
            background: #28a745;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }
        
        .timeline-icon.pending {
            background: #ffc107;
        }
        
        .timeline-icon.inactive {
            background: #dee2e6;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="success-container">
        <div class="success-card">
            <div class="success-header">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h1 class="mb-3">Đặt hàng thành công!</h1>
                <p class="mb-0">Cảm ơn bạn đã tin tưởng và mua sắm tại Qickmed</p>
            </div>
            
            <div class="success-content">
                <div class="order-info">
                    <h5 class="mb-3">
                        <i class="fas fa-receipt me-2"></i>
                        Thông tin đơn hàng
                    </h5>
                    
                    <div class="info-row">
                        <span>Mã đơn hàng:</span>
                        <strong>#QM<?php echo str_pad($order['order_id'], 6, '0', STR_PAD_LEFT); ?></strong>
                    </div>
                    
                    <div class="info-row">
                        <span>Ngày đặt:</span>
                        <span><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></span>
                    </div>
                    
                    <div class="info-row">
                        <span>Số lượng sản phẩm:</span>
                        <span><?php echo $order['item_count']; ?> sản phẩm</span>
                    </div>
                    
                    <div class="info-row">
                        <span>Tổng tiền:</span>
                        <strong class="text-primary fs-5"><?php echo number_format($order['total'], 0, ',', '.'); ?>đ</strong>
                    </div>
                    
                    <div class="info-row">
                        <span>Phương thức thanh toán:</span>
                        <span>
                            <?php 
                            switch($order['payment_method']) {
                                case 'cod': echo 'Thanh toán khi nhận hàng'; break;
                                case 'vnpay': echo 'VNPay'; break;
                                case 'momo': echo 'MoMo'; break;
                                default: echo 'Không xác định';
                            }
                            ?>
                        </span>
                    </div>
                </div>
                
                <?php if ($shipping_address): ?>
                <div class="order-info">
                    <h5 class="mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        Địa chỉ giao hàng
                    </h5>
                    
                    <div class="info-row">
                        <span>Người nhận:</span>
                        <span><?php echo htmlspecialchars($shipping_address['name']); ?></span>
                    </div>
                    
                    <div class="info-row">
                        <span>Số điện thoại:</span>
                        <span><?php echo htmlspecialchars($shipping_address['phone']); ?></span>
                    </div>
                    
                    <div class="info-row">
                        <span>Địa chỉ:</span>
                        <span>
                            <?php 
                            echo htmlspecialchars($shipping_address['address_line']) . ', ' .
                                 htmlspecialchars($shipping_address['ward']) . ', ' .
                                 htmlspecialchars($shipping_address['district']) . ', ' .
                                 htmlspecialchars($shipping_address['city']);
                            ?>
                        </span>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="order-info">
                    <h5 class="mb-3">
                        <i class="fas fa-truck me-2"></i>
                        Trạng thái đơn hàng
                    </h5>
                    
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <strong>Đặt hàng thành công</strong>
                                <div class="text-muted small"><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon pending">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <strong>Đang xử lý</strong>
                                <div class="text-muted small">Chúng tôi đang chuẩn bị đơn hàng của bạn</div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon inactive">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div>
                                <strong>Đang giao hàng</strong>
                                <div class="text-muted small">Đơn hàng sẽ được giao trong 1-3 ngày</div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon inactive">
                                <i class="fas fa-box"></i>
                            </div>
                            <div>
                                <strong>Đã giao</strong>
                                <div class="text-muted small">Bạn đã nhận được đơn hàng</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="action-buttons">
                    <a href="/profile.php?tab=orders" class="btn-primary-custom">
                        <i class="fas fa-list me-2"></i>
                        Xem đơn hàng của tôi
                    </a>
                    
                    <a href="/shop.php" class="btn-outline-custom">
                        <i class="fas fa-shopping-bag me-2"></i>
                        Tiếp tục mua sắm
                    </a>
                </div>
                
                <div class="text-center mt-4">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Lưu ý:</strong> Chúng tôi sẽ gửi email xác nhận và cập nhật trạng thái đơn hàng qua email và SMS.
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Confetti animation
        function createConfetti() {
            const colors = ['#667eea', '#764ba2', '#28a745', '#ffc107', '#dc3545'];
            
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.style.cssText = `
                    position: fixed;
                    width: 8px;
                    height: 8px;
                    background: ${colors[Math.floor(Math.random() * colors.length)]};
                    left: ${Math.random() * 100}vw;
                    top: -10px;
                    z-index: 9999;
                    border-radius: 2px;
                    animation: fall ${2 + Math.random() * 3}s linear forwards;
                `;
                
                document.body.appendChild(confetti);
                
                setTimeout(() => {
                    confetti.remove();
                }, 5000);
            }
        }
        
        // Add confetti animation CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fall {
                0% {
                    transform: translateY(-10px) rotate(0deg);
                    opacity: 1;
                }
                100% {
                    transform: translateY(100vh) rotate(360deg);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
        
        // Trigger confetti on page load
        window.addEventListener('load', createConfetti);
    </script>
</body>
</html> 