<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/functions/format_helpers.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header('Location: login.php?message=Vui lòng đăng nhập để tiếp tục thanh toán');
    exit();
}

$user_id = $_SESSION['user_id'];
$error_message = '';
$success_message = '';

// Lấy thông tin giỏ hàng
$stmt = $conn->prepare("
    SELECT 
        o.order_id, o.total,
        oi.product_id, oi.quantity, oi.unit_price,
        p.name, p.image_url as display_image, p.stock
    FROM orders o 
    JOIN order_items oi ON o.order_id = oi.order_id 
    JOIN products p ON oi.product_id = p.product_id 
    WHERE o.user_id = ? AND o.status = 'cart'
");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$cart_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if (empty($cart_items)) {
    header('Location: cart.php');
    exit();
}

$cart_total = $cart_items[0]['total'];

// Xử lý ảnh mặc định cho cart items
foreach ($cart_items as $index => $item) {
    if (empty($item['display_image'])) {
        $cart_items[$index]['display_image'] = '/assets/images/product-placeholder.jpg';
    }
}

// Unset any lingering references
unset($item);

// Lấy thông tin user
$stmt = $conn->prepare("
    SELECT u.username, u.email, u.phone_number, ui.full_name 
    FROM users u 
    LEFT JOIN users_info ui ON u.user_id = ui.user_id 
    WHERE u.user_id = ?
");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user_info = $stmt->get_result()->fetch_assoc();

// Xử lý đặt hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    try {
        $conn->begin_transaction();
        
        $payment_method = $_POST['payment_method'] ?? 'cod';
        $order_note = $_POST['order_note'] ?? '';
        
        // Xử lý địa chỉ giao hàng
        $recipient_name = $_POST['recipient_name'] ?? '';
        $recipient_phone = $_POST['recipient_phone'] ?? '';
        $address_line = $_POST['address_line'] ?? '';
        $ward = $_POST['ward_text'] ?? '';
        $district = $_POST['district_text'] ?? '';
        $city = $_POST['city_text'] ?? '';
        
        $shipping_address = $recipient_name . "\n" . 
                           $recipient_phone . "\n" . 
                           $address_line . "\n" . 
                           $ward . ", " . $district . ", " . $city;
        
        // Tạo đơn hàng
        $stmt = $conn->prepare("INSERT INTO orders (user_id, shipping_address, total, payment_method, status, order_note) VALUES (?, ?, ?, ?, 'pending', ?)");
        $stmt->bind_param("isdss", $user_id, $shipping_address, $cart_total, $payment_method, $order_note);
        $stmt->execute();
        
        $order_id = $conn->insert_id;
        
        // Thêm chi tiết đơn hàng
        foreach ($cart_items as $item) {
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['unit_price']);
            $stmt->execute();
            
            // Cập nhật tồn kho
            $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE product_id = ?");
            $stmt->bind_param("ii", $item['quantity'], $item['product_id']);
            $stmt->execute();
        }
        
        // Xóa giỏ hàng cũ
        $stmt = $conn->prepare("DELETE FROM orders WHERE user_id = ? AND status = 'cart'");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        
        $conn->commit();
        
        // Chuyển hướng đến trang xác nhận
        header("Location: order-success.php?order_id=" . $order_id);
        exit();
        
    } catch (Exception $e) {
        $conn->rollback();
        $error_message = "Có lỗi xảy ra khi đặt hàng: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - QickMed</title>
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --glass-bg: rgba(255, 255, 255, 0.95);
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --border-color: #e2e8f0;
            --success-color: #48bb78;
            --warning-color: #ed8936;
            --radius: 16px;
        }

        body {
            background: var(--primary-gradient);
            background-attachment: fixed;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            padding-top: 120px;
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(118, 75, 162, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .checkout-container {
            padding: 2rem 0;
        }

        .checkout-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.2);
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-title {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control, .form-select {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
        }

        .payment-method {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            position: relative;
        }

        .payment-method:hover {
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        }

        .payment-method.selected {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.2);
        }

        .payment-method.selected::after {
            content: '✓';
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 24px;
            height: 24px;
            background: #667eea;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        .order-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            background: white;
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }

        .item-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 1rem;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .item-price {
            color: #667eea;
            font-weight: 600;
        }

        .order-summary {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .summary-row.total {
            font-size: 1.25rem;
            font-weight: 700;
            color: #667eea;
            border-top: 2px solid var(--border-color);
            padding-top: 0.75rem;
            margin-top: 1rem;
        }

        .btn-place-order {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-place-order:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-place-order:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .select2-container--default .select2-selection--single {
            height: 45px !important;
            border: 2px solid var(--border-color) !important;
            border-radius: 12px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 41px !important;
            padding-left: 1rem !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #667eea !important;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
        }

        .address-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        @media (max-width: 768px) {
            body {
                padding-top: 100px;
            }
            
            .page-title {
                font-size: 2rem;
            }
            
            .checkout-card {
                padding: 1.5rem;
            }
            
            .address-grid {
                grid-template-columns: 1fr;
            }
        }

        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(102, 126, 234, 0.3);
            border-radius: 50%;
            border-top-color: #667eea;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="checkout-container">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-shopping-cart me-3"></i>
                    Thanh toán
                </h1>
                <p class="page-subtitle">Hoàn tất đơn hàng của bạn</p>
            </div>

            <?php if ($error_message): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" id="checkoutForm">
                <div class="row">
                    <!-- Left Column - Checkout Form -->
                    <div class="col-lg-8">
                        <!-- Shipping Address -->
                        <div class="checkout-card">
                            <h3 class="section-title">
                                <i class="fas fa-map-marker-alt"></i>
                                Thông tin giao hàng
                            </h3>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user"></i>
                                            Họ tên người nhận *
                                        </label>
                                        <input type="text" class="form-control" name="recipient_name" 
                                               value="<?php echo htmlspecialchars($user_info['full_name'] ?: $user_info['username']); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-phone"></i>
                                            Số điện thoại *
                                        </label>
                                        <input type="tel" class="form-control" name="recipient_phone" 
                                               value="<?php echo htmlspecialchars($user_info['phone_number']); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-home"></i>
                                    Địa chỉ cụ thể *
                                </label>
                                <input type="text" class="form-control" name="address_line" 
                                       placeholder="Số nhà, tên đường, khu vực..." required>
                            </div>

                            <div class="address-grid">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-map"></i>
                                        Tỉnh/Thành phố *
                                    </label>
                                    <select name="city" id="citySelect" class="form-select select2" required>
                                        <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                    </select>
                                    <input type="hidden" name="city_text" id="cityText">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-building"></i>
                                        Quận/Huyện *
                                    </label>
                                    <select name="district" id="districtSelect" class="form-select select2" required disabled>
                                        <option value="">-- Chọn Quận/Huyện --</option>
                                    </select>
                                    <input type="hidden" name="district_text" id="districtText">
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-map-pin"></i>
                                        Phường/Xã *
                                    </label>
                                    <select name="ward" id="wardSelect" class="form-select select2" required disabled>
                                        <option value="">-- Chọn Phường/Xã --</option>
                                    </select>
                                    <input type="hidden" name="ward_text" id="wardText">
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="checkout-card">
                            <h3 class="section-title">
                                <i class="fas fa-credit-card"></i>
                                Phương thức thanh toán
                            </h3>
                            
                            <div class="payment-method selected" data-method="cod">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="payment_method" value="cod" checked class="form-check-input me-3">
                                    <div>
                                        <div class="fw-bold">
                                            <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                            Thanh toán khi nhận hàng (COD)
                                        </div>
                                        <small class="text-muted">Thanh toán bằng tiền mặt khi nhận hàng</small>
                                    </div>
                                </div>
                            </div>

                            <div class="payment-method" data-method="vnpay">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="payment_method" value="vnpay" class="form-check-input me-3">
                                    <div>
                                        <div class="fw-bold">
                                            <i class="fab fa-cc-visa me-2 text-primary"></i>
                                            VNPay
                                        </div>
                                        <small class="text-muted">Thanh toán qua thẻ ATM, Visa, MasterCard</small>
                                    </div>
                                </div>
                            </div>

                            <div class="payment-method" data-method="momo">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="payment_method" value="momo" class="form-check-input me-3">
                                    <div>
                                        <div class="fw-bold">
                                            <i class="fas fa-mobile-alt me-2 text-warning"></i>
                                            MoMo
                                        </div>
                                        <small class="text-muted">Thanh toán qua ví điện tử MoMo</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Note -->
                        <div class="checkout-card">
                            <h3 class="section-title">
                                <i class="fas fa-sticky-note"></i>
                                Ghi chú đơn hàng
                            </h3>
                            <textarea name="order_note" class="form-control" rows="3" 
                                      placeholder="Ghi chú cho người bán (tùy chọn)"></textarea>
                        </div>
                    </div>

                    <!-- Right Column - Order Summary -->
                    <div class="col-lg-4">
                        <div class="checkout-card">
                            <h3 class="section-title">
                                <i class="fas fa-receipt"></i>
                                Tóm tắt đơn hàng
                            </h3>

                            <!-- Order Items -->
                            <div class="order-items mb-4">
                                <?php foreach ($cart_items as $item): ?>
                                    <div class="order-item">
                                        <img src="<?php echo htmlspecialchars($item['display_image']); ?>" 
                                             alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                             class="item-image">
                                        <div class="item-info">
                                            <div class="item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                                            <div class="text-muted">SL: <?php echo $item['quantity']; ?></div>
                                        </div>
                                        <div class="item-price">
                                            <?php echo number_format($item['unit_price'] * $item['quantity'], 0, ',', '.'); ?>đ
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Order Summary -->
                            <div class="order-summary">
                                <div class="summary-row">
                                    <span>Tạm tính:</span>
                                    <span><?php echo number_format($cart_total, 0, ',', '.'); ?>đ</span>
                                </div>
                                <div class="summary-row">
                                    <span>Phí vận chuyển:</span>
                                    <span class="text-success">Miễn phí</span>
                                </div>
                                <div class="summary-row total">
                                    <span>Tổng cộng:</span>
                                    <span><?php echo number_format($cart_total, 0, ',', '.'); ?>đ</span>
                                </div>
                            </div>

                            <!-- Place Order Button -->
                            <button type="submit" name="place_order" class="btn-place-order" id="placeOrderBtn">
                                <i class="fas fa-lock me-2"></i>Đặt hàng ngay
                            </button>

                            <!-- Security Info -->
                            <div class="mt-3 text-center">
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt text-success me-1"></i>
                                    Thanh toán an toàn & bảo mật
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Appointment Modal -->
    <?php include 'includes/appointment-modal.php'; ?>

    <?php include 'includes/footer.php'; ?>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                placeholder: 'Chọn...',
                allowClear: true,
                width: '100%'
            });

            let provincesData = [];

            // Load provinces from Vietnam API
            function loadProvinces() {
                $('#citySelect').html('<option value="">Đang tải...</option>');
                
                $.ajax({
                    url: 'https://provinces.open-api.vn/api/?depth=3',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        provincesData = data;
                        populateProvinces(data);
                    },
                    error: function() {
                        $('#citySelect').html('<option value="">Lỗi tải dữ liệu</option>');
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi',
                            text: 'Không thể tải danh sách tỉnh/thành phố'
                        });
                    }
                });
            }

            function populateProvinces(provinces) {
                const $citySelect = $('#citySelect');
                $citySelect.empty().append('<option value="">-- Chọn Tỉnh/Thành phố --</option>');
                
                provinces.forEach(province => {
                    $citySelect.append(`<option value="${province.code}">${province.name}</option>`);
                });
            }

            function populateDistricts(districts) {
                const $districtSelect = $('#districtSelect');
                $districtSelect.empty().append('<option value="">-- Chọn Quận/Huyện --</option>');
                
                districts.forEach(district => {
                    $districtSelect.append(`<option value="${district.code}">${district.name}</option>`);
                });
                
                $districtSelect.prop('disabled', false);
            }

            function populateWards(wards) {
                const $wardSelect = $('#wardSelect');
                $wardSelect.empty().append('<option value="">-- Chọn Phường/Xã --</option>');
                
                wards.forEach(ward => {
                    $wardSelect.append(`<option value="${ward.code}">${ward.name}</option>`);
                });
                
                $wardSelect.prop('disabled', false);
            }

            // Event handlers
            $('#citySelect').change(function() {
                const provinceCode = $(this).val();
                const provinceName = $(this).find('option:selected').text();
                $('#cityText').val(provinceName);
                
                if (provinceCode) {
                    const province = provincesData.find(p => p.code == provinceCode);
                    if (province) {
                        populateDistricts(province.districts);
                        $('#wardSelect').html('<option value="">-- Chọn Phường/Xã --</option>').prop('disabled', true);
                        $('#wardText').val('');
                    }
                } else {
                    $('#districtSelect').html('<option value="">-- Chọn Quận/Huyện --</option>').prop('disabled', true);
                    $('#wardSelect').html('<option value="">-- Chọn Phường/Xã --</option>').prop('disabled', true);
                    $('#districtText').val('');
                    $('#wardText').val('');
                }
            });

            $('#districtSelect').change(function() {
                const districtCode = $(this).val();
                const districtName = $(this).find('option:selected').text();
                $('#districtText').val(districtName);
                
                if (districtCode) {
                    const provinceCode = $('#citySelect').val();
                    const province = provincesData.find(p => p.code == provinceCode);
                    if (province) {
                        const district = province.districts.find(d => d.code == districtCode);
                        if (district) {
                            populateWards(district.wards);
                        }
                    }
                } else {
                    $('#wardSelect').html('<option value="">-- Chọn Phường/Xã --</option>').prop('disabled', true);
                    $('#wardText').val('');
                }
            });

            $('#wardSelect').change(function() {
                const wardName = $(this).find('option:selected').text();
                $('#wardText').val(wardName);
            });

            // Payment method selection
            $('.payment-method').click(function() {
                $('.payment-method').removeClass('selected');
                $(this).addClass('selected');
                $(this).find('input[type="radio"]').prop('checked', true);
            });

            // Form submission
            $('#checkoutForm').submit(function(e) {
                e.preventDefault();
                
                // Validation
                if (!$('#citySelect').val()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thiếu thông tin',
                        text: 'Vui lòng chọn Tỉnh/Thành phố'
                    });
                    return;
                }
                
                if (!$('#districtSelect').val()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thiếu thông tin',
                        text: 'Vui lòng chọn Quận/Huyện'
                    });
                    return;
                }
                
                if (!$('#wardSelect').val()) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Thiếu thông tin',
                        text: 'Vui lòng chọn Phường/Xã'
                    });
                    return;
                }
                
                // Show loading
                const $submitBtn = $('#placeOrderBtn');
                const originalText = $submitBtn.html();
                $submitBtn.html('<span class="loading-spinner me-2"></span>Đang xử lý...').prop('disabled', true);
                
                // Submit form
                this.submit();
            });

            // Load provinces on page load
            loadProvinces();
        });
    </script>
</body>
</html> 