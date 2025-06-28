<?php
session_start();
require_once '../../includes/db.php';

header('Content-Type: application/json');

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập', 'count' => 0]);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // Tìm giỏ hàng hiện tại
    $stmt = $conn->prepare("SELECT order_id FROM orders WHERE user_id = ? AND status = 'cart' LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $cart = $result->fetch_assoc();
        $order_id = $cart['order_id'];
        
        // Đếm số lượng sản phẩm trong giỏ hàng
        $stmt = $conn->prepare("SELECT SUM(quantity) as cart_count FROM order_items WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $cart_count = $stmt->get_result()->fetch_assoc()['cart_count'] ?? 0;
        
        echo json_encode([
            'success' => true, 
            'count' => (int)$cart_count
        ]);
    } else {
        echo json_encode([
            'success' => true, 
            'count' => 0
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
        'count' => 0
    ]);
}
?> 