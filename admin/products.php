<?php
session_start();
include '../includes/db.php';

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../login.php');
    exit;
}

// Xử lý các action
$action = $_GET['action'] ?? 'list';
$message = $_GET['message'] ?? '';
$error = '';

// Xử lý thêm/sửa sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $category_id = (int)$_POST['category_id'];
    $stock = (int)$_POST['stock'];
    $is_active = $_POST['is_active'] == 'active' ? 1 : 0;
    $product_id = $_POST['product_id'] ?? null;
    
    // Xử lý ảnh (upload hoặc URL)
    $image_path = '';
    $image_type = $_POST['image_type'] ?? 'upload';
    
    if ($image_type === 'url' && !empty($_POST['image_url'])) {
        // Sử dụng URL ảnh
        $image_path = trim($_POST['image_url']);
        
        // Validate URL
        if (!filter_var($image_path, FILTER_VALIDATE_URL)) {
            $error = 'URL ảnh không hợp lệ';
        }
    } elseif ($image_type === 'upload' && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Upload file ảnh
        $upload_dir = '../assets/images/products/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Kiểm tra loại file
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $file_type = $_FILES['image']['type'];
        
        if (!in_array($file_type, $allowed_types)) {
            $error = 'Chỉ chấp nhận file ảnh (JPG, PNG, GIF, WebP)';
        } elseif ($_FILES['image']['size'] > 5 * 1024 * 1024) { // 5MB
            $error = 'File ảnh quá lớn (tối đa 5MB)';
        } else {
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $file_name = 'product_' . time() . '_' . uniqid() . '.' . $file_extension;
            $target_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                $image_path = 'assets/images/products/' . $file_name;
            } else {
                $error = 'Không thể upload ảnh';
            }
        }
    }
    
    if (!$error) {
        try {
            if ($product_id) {
                // Cập nhật sản phẩm
                if ($image_path) {
                    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, category_id = ?, stock = ?, is_active = ?, image_url = ?, updated_at = NOW() WHERE product_id = ?");
                    $stmt->bind_param("ssdiissi", $name, $description, $price, $category_id, $stock, $is_active, $image_path, $product_id);
                } else {
                    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, category_id = ?, stock = ?, is_active = ?, updated_at = NOW() WHERE product_id = ?");
                    $stmt->bind_param("ssdiiii", $name, $description, $price, $category_id, $stock, $is_active, $product_id);
                }
                $message = 'Cập nhật sản phẩm thành công!';
            } else {
                // Thêm sản phẩm mới
                $stmt = $conn->prepare("INSERT INTO products (name, description, price, category_id, stock, is_active, image_url, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
                $stmt->bind_param("ssdiiss", $name, $description, $price, $category_id, $stock, $is_active, $image_path);
                $message = 'Thêm sản phẩm thành công!';
            }
            
            if ($stmt->execute()) {
                $action = 'list';
            } else {
                $error = 'Có lỗi xảy ra khi lưu sản phẩm';
            }
        } catch (Exception $e) {
            $error = 'Lỗi: ' . $e->getMessage();
        }
    }
}

// Xử lý xóa sản phẩm
if ($action === 'delete' && isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    $redirect_page = $_GET['page'] ?? 1;
    $redirect_search = $_GET['search'] ?? '';
    $redirect_category = $_GET['category'] ?? '';
    $redirect_status = $_GET['status'] ?? '';
    
    try {
        $stmt = $conn->prepare("UPDATE products SET is_active = 0, updated_at = NOW() WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        if ($stmt->execute()) {
            $redirect_url = "?page=" . $redirect_page . 
                           "&search=" . urlencode($redirect_search) . 
                           "&category=" . urlencode($redirect_category) . 
                           "&status=" . urlencode($redirect_status) . 
                           "&message=" . urlencode('Xóa sản phẩm thành công!');
            header('Location: ' . $redirect_url);
            exit;
        } else {
            $error = 'Không thể xóa sản phẩm';
        }
    } catch (Exception $e) {
        $error = 'Lỗi: ' . $e->getMessage();
    }
    $action = 'list';
}

// Lấy danh sách danh mục
$categories_result = $conn->query("SELECT * FROM product_categories ORDER BY name");
$categories = [];
if ($categories_result) {
    while ($cat = $categories_result->fetch_assoc()) {
        $categories[] = $cat;
    }
}

// Lấy thông tin sản phẩm để sửa
$product = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    $result = $conn->query("SELECT * FROM products WHERE product_id = $product_id");
    $product = $result->fetch_assoc();
    if (!$product) {
        $action = 'list';
        $error = 'Không tìm thấy sản phẩm';
    }
}

// Lấy danh sách sản phẩm với pagination
$search = $_GET['search'] ?? '';
$category_filter = $_GET['category'] ?? '';
$status_filter = $_GET['status'] ?? '';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$per_page = 10; // Số sản phẩm mỗi trang
$offset = ($page - 1) * $per_page;

$where_conditions = [];
$params = [];
$types = '';

if ($search) {
    $where_conditions[] = "(p.name LIKE ? OR p.description LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= 'ss';
}

if ($category_filter) {
    $where_conditions[] = "p.category_id = ?";
    $params[] = $category_filter;
    $types .= 'i';
}

if ($status_filter) {
    if ($status_filter === 'active') {
        $where_conditions[] = "p.is_active = ?";
        $params[] = 1;
    } else {
        $where_conditions[] = "p.is_active = ?";
        $params[] = 0;
    }
    $types .= 'i';
} else {
    // Mặc định chỉ hiển thị sản phẩm active
    $where_conditions[] = "p.is_active = ?";
    $params[] = 1;
    $types .= 'i';
}

$where_clause = empty($where_conditions) ? '1=1' : implode(' AND ', $where_conditions);

// Đếm tổng số sản phẩm để tính pagination
$count_sql = "SELECT COUNT(*) as total 
              FROM products p 
              LEFT JOIN product_categories pc ON p.category_id = pc.category_id 
              WHERE $where_clause";

$count_stmt = $conn->prepare($count_sql);
if (!$count_stmt) {
    die('Lỗi SQL prepare (count): ' . $conn->error);
}

if ($params) {
    $count_stmt->bind_param($types, ...$params);
}

if (!$count_stmt->execute()) {
    die('Lỗi SQL execute (count): ' . $count_stmt->error);
}

$total_products = $count_stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_products / $per_page);

// Lấy sản phẩm cho trang hiện tại
$sql = "SELECT p.*, pc.name as category_name 
        FROM products p 
        LEFT JOIN product_categories pc ON p.category_id = pc.category_id 
        WHERE $where_clause 
        ORDER BY p.created_at DESC
        LIMIT $per_page OFFSET $offset";

// Thêm debug và kiểm tra lỗi
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('Lỗi SQL prepare: ' . $conn->error . '<br>SQL: ' . $sql);
}

if ($params) {
    $stmt->bind_param($types, ...$params);
}

if (!$stmt->execute()) {
    die('Lỗi SQL execute: ' . $stmt->error);
}

$products = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm - MediSync Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/admin.css" rel="stylesheet">
    <link href="assets/css/sidebar.css" rel="stylesheet">
    <link href="assets/css/header.css" rel="stylesheet">
    <style>
        .form-check-inline {
            margin-right: 1rem;
        }
        
        #image_preview {
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .img-thumbnail {
            border: 2px dashed #dee2e6;
            transition: all 0.3s ease;
        }
        
        .img-thumbnail:hover {
            border-color: #007bff;
            transform: scale(1.05);
        }
        
        .image-input-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .drag-drop-area {
            border: 2px dashed #ccc;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .drag-drop-area:hover,
        .drag-drop-area.dragover {
            border-color: #007bff;
            background-color: #f8f9ff;
        }
        
        .preview-container {
            position: relative;
            display: inline-block;
        }
        
        .preview-actions {
            position: absolute;
            top: -10px;
            right: -10px;
        }
        
        .product-image-placeholder {
            width: 50px;
            height: 50px;
            background: linear-gradient(45deg, #f0f0f0 25%, transparent 25%), 
                        linear-gradient(-45deg, #f0f0f0 25%, transparent 25%), 
                        linear-gradient(45deg, transparent 75%, #f0f0f0 75%), 
                        linear-gradient(-45deg, transparent 75%, #f0f0f0 75%);
            background-size: 10px 10px;
            background-position: 0 0, 0 5px, 5px -5px, -5px 0px;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 12px;
        }
        
        .product-image {
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }
        
        .product-image:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .pagination .page-link {
            color: #007bff;
            border: 1px solid #dee2e6;
            margin: 0 2px;
            border-radius: 6px;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }
        
        .pagination .page-link:hover {
            color: #0056b3;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }
    </style>
</head>
<body>
<?php include 'includes/headeradmin.php'; ?>
<?php include 'includes/sidebaradmin.php'; ?>

    <main class="main-content">
        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-pills me-2"></i>Quản lý sản phẩm
                    </h1>
                    <p class="mb-0 text-muted">Quản lý danh sách sản phẩm y tế</p>
                </div>
                <?php if ($action === 'list'): ?>
                <a href="?action=add" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Thêm sản phẩm
                </a>
                <?php else: ?>
                <a href="?" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
                <?php endif; ?>
            </div>

            <!-- Messages -->
            <?php if ($message): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if ($action === 'list'): ?>
                <!-- Filters -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <form method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tìm kiếm</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Tên sản phẩm..." value="<?= htmlspecialchars($search) ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Danh mục</label>
                                <select name="category" class="form-select">
                                    <option value="">Tất cả danh mục</option>
                                    <?php if (!empty($categories)): ?>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?= $cat['category_id'] ?>" 
                                                    <?= $category_filter == $cat['category_id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($cat['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Trạng thái</label>
                                <select name="status" class="form-select">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="active" <?= $status_filter === 'active' ? 'selected' : '' ?>>Hoạt động</option>
                                    <option value="inactive" <?= $status_filter === 'inactive' ? 'selected' : '' ?>>Không hoạt động</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Tìm kiếm
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Products List -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-list me-2"></i>Danh sách sản phẩm
                        </h6>
                        <small class="text-muted">
                            Hiển thị <?= ($offset + 1) ?>-<?= min($offset + $per_page, $total_products) ?> 
                            trong tổng số <?= $total_products ?> sản phẩm
                        </small>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">Ảnh</th>
                                        <th class="border-0">Tên sản phẩm</th>
                                        <th class="border-0">Danh mục</th>
                                        <th class="border-0">Giá</th>
                                        <th class="border-0">Tồn kho</th>
                                        <th class="border-0">Trạng thái</th>
                                        <th class="border-0">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($products && $products->num_rows > 0): ?>
                                        <?php while ($prod = $products->fetch_assoc()): ?>
                                            <tr>
                                                <td>
                                                    <?php 
                                                    $image_src = $prod['image_url'];
                                                    if (empty($image_src)) {
                                                        $image_src = '../assets/images/thuoc_icon.jpg';
                                                    } else {
                                                        // Nếu image_url không bắt đầu bằng http/https, thêm ../ 
                                                        if (!filter_var($image_src, FILTER_VALIDATE_URL) && substr($image_src, 0, 3) !== '../') {
                                                            $image_src = '../' . $image_src;
                                                        }
                                                    }
                                                    ?>
                                                    <img src="<?= htmlspecialchars($image_src) ?>" 
                                                         alt="<?= htmlspecialchars($prod['name']) ?>" 
                                                         class="rounded product-image" 
                                                         style="width: 50px; height: 50px; object-fit: cover;"
                                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                                         onload="this.style.display='block'; this.nextElementSibling.style.display='none';">
                                                    <div class="product-image-placeholder" style="display: none;">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <h6 class="mb-0"><?= htmlspecialchars($prod['name']) ?></h6>
                                                        <small class="text-muted"><?= htmlspecialchars(substr($prod['description'], 0, 50)) ?>...</small>
                                                    </div>
                                                </td>
                                                <td><?= htmlspecialchars($prod['category_name'] ?? 'N/A') ?></td>
                                                <td class="fw-bold text-primary"><?= number_format($prod['price']) ?>đ</td>
                                                <td>
                                                    <span class="badge bg-<?= $prod['stock'] > 10 ? 'success' : ($prod['stock'] > 0 ? 'warning' : 'danger') ?>">
                                                        <?= $prod['stock'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $prod['is_active'] == 1 ? 'success' : 'secondary' ?>">
                                                        <?= $prod['is_active'] == 1 ? 'Hoạt động' : 'Không hoạt động' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="?action=edit&id=<?= $prod['product_id'] ?>" 
                                                           class="btn btn-outline-primary" title="Sửa">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-outline-danger" 
                                                                onclick="deleteProduct(<?= $prod['product_id'] ?>, <?= $page ?>)" title="Xóa">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                <i class="fas fa-box-open fa-2x mb-2 d-block"></i>
                                                Không có sản phẩm nào
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                        <div class="card-footer bg-white">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center mb-0">
                                    <!-- Previous Button -->
                                    <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category_filter) ?>&status=<?= urlencode($status_filter) ?>">
                                            <i class="fas fa-chevron-left"></i> Trước
                                        </a>
                                    </li>
                                    <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="fas fa-chevron-left"></i> Trước</span>
                                    </li>
                                    <?php endif; ?>
                                    
                                    <!-- Page Numbers -->
                                    <?php
                                    $start_page = max(1, $page - 2);
                                    $end_page = min($total_pages, $page + 2);
                                    
                                    if ($start_page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=1&search=<?= urlencode($search) ?>&category=<?= urlencode($category_filter) ?>&status=<?= urlencode($status_filter) ?>">1</a>
                                        </li>
                                        <?php if ($start_page > 2): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category_filter) ?>&status=<?= urlencode($status_filter) ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                    <?php endfor; ?>
                                    
                                    <?php if ($end_page < $total_pages): ?>
                                        <?php if ($end_page < $total_pages - 1): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">...</span>
                                        </li>
                                        <?php endif; ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?= $total_pages ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category_filter) ?>&status=<?= urlencode($status_filter) ?>"><?= $total_pages ?></a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <!-- Next Button -->
                                    <?php if ($page < $total_pages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category_filter) ?>&status=<?= urlencode($status_filter) ?>">
                                            Tiếp <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                    <?php else: ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">Tiếp <i class="fas fa-chevron-right"></i></span>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php else: ?>
                <!-- Add/Edit Form -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-<?= $action === 'add' ? 'plus' : 'edit' ?> me-2"></i>
                            <?= $action === 'add' ? 'Thêm sản phẩm mới' : 'Sửa sản phẩm' ?>
                        </h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <?php if ($product): ?>
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                            <?php endif; ?>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" required
                                               value="<?= htmlspecialchars($product['name'] ?? '') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Mô tả</label>
                                        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Giá <span class="text-danger">*</span></label>
                                                <input type="number" name="price" class="form-control" required min="0" step="0.01"
                                                       value="<?= $product['price'] ?? '' ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Số lượng tồn kho</label>
                                                <input type="number" name="stock" class="form-control" min="0"
                                                       value="<?= $product['stock'] ?? 0 ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Danh mục</label>
                                                <select name="category_id" class="form-select">
                                                    <option value="">Chọn danh mục</option>
                                                    <?php foreach ($categories as $cat): ?>
                                                        <option value="<?= $cat['category_id'] ?>" 
                                                                <?= ($product['category_id'] ?? '') == $cat['category_id'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($cat['name']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Trạng thái</label>
                                                <select name="is_active" class="form-select">
                                                    <option value="active" <?= ($product['is_active'] ?? 1) == 1 ? 'selected' : '' ?>>Hoạt động</option>
                                                    <option value="inactive" <?= ($product['is_active'] ?? 1) == 0 ? 'selected' : '' ?>>Không hoạt động</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Ảnh sản phẩm</label>
                                        
                                        <!-- Image Type Selection -->
                                        <div class="mb-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="image_type" id="image_upload" value="upload" checked>
                                                <label class="form-check-label" for="image_upload">
                                                    <i class="fas fa-upload me-1"></i>Upload từ máy
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="image_type" id="image_url" value="url">
                                                <label class="form-check-label" for="image_url">
                                                    <i class="fas fa-link me-1"></i>Dùng URL
                                                </label>
                                            </div>
                                        </div>

                                        <!-- File Upload -->
                                        <div id="upload_section">
                                            <div class="drag-drop-area" id="drag_drop_area" onclick="document.getElementById('image_file').click()">
                                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                                <p class="mb-1">Kéo thả ảnh vào đây hoặc <strong>click để chọn</strong></p>
                                                <small class="text-muted">Hỗ trợ JPG, PNG, GIF, WebP. Tối đa 5MB.</small>
                                            </div>
                                            <input type="file" name="image" id="image_file" class="d-none" accept="image/*" onchange="previewImage(this)">
                                        </div>

                                        <!-- URL Input -->
                                        <div id="url_section" style="display: none;">
                                            <input type="url" name="image_url" id="image_url_input" class="form-control" placeholder="https://example.com/image.jpg" onchange="previewImageFromUrl(this)">
                                            <small class="text-muted">Nhập URL ảnh từ internet</small>
                                        </div>

                                        <!-- Image Preview -->
                                        <div id="image_preview" class="mt-3" style="display: none;">
                                            <label class="form-label">Xem trước:</label>
                                            <div class="border rounded p-2 text-center">
                                                <img id="preview_img" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removePreview()">
                                                        <i class="fas fa-times me-1"></i>Xóa
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Current Image (for edit mode) -->
                                        <?php if ($product && $product['image_url']): ?>
                                            <div class="mt-3">
                                                <label class="form-label">Ảnh hiện tại:</label>
                                                <div class="border rounded p-2 text-center">
                                                    <?php 
                                                    $current_image = $product['image_url'];
                                                    if (!filter_var($current_image, FILTER_VALIDATE_URL) && substr($current_image, 0, 3) !== '../') {
                                                        $current_image = '../' . $current_image;
                                                    }
                                                    ?>
                                                    <img src="<?= htmlspecialchars($current_image) ?>" 
                                                         alt="Current image" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 200px; max-height: 200px;"
                                                         onerror="this.src='../assets/images/thuoc_icon.jpg'">
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    <?= $action === 'add' ? 'Thêm sản phẩm' : 'Cập nhật' ?>
                                </button>
                                <a href="?" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
    <script>
        function deleteProduct(productId, currentPage) {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
                const urlParams = new URLSearchParams(window.location.search);
                const search = urlParams.get('search') || '';
                const category = urlParams.get('category') || '';
                const status = urlParams.get('status') || '';
                
                window.location.href = '?action=delete&id=' + productId + 
                                     '&page=' + currentPage +
                                     '&search=' + encodeURIComponent(search) +
                                     '&category=' + encodeURIComponent(category) +
                                     '&status=' + encodeURIComponent(status);
            }
        }

        // Toggle between upload and URL input
        document.addEventListener('DOMContentLoaded', function() {
            const uploadRadio = document.getElementById('image_upload');
            const urlRadio = document.getElementById('image_url');
            const uploadSection = document.getElementById('upload_section');
            const urlSection = document.getElementById('url_section');
            const dragDropArea = document.getElementById('drag_drop_area');

            function toggleImageInput() {
                if (uploadRadio.checked) {
                    uploadSection.style.display = 'block';
                    urlSection.style.display = 'none';
                    document.getElementById('image_url_input').value = '';
                } else {
                    uploadSection.style.display = 'none';
                    urlSection.style.display = 'block';
                    document.getElementById('image_file').value = '';
                }
                removePreview();
            }

            uploadRadio.addEventListener('change', toggleImageInput);
            urlRadio.addEventListener('change', toggleImageInput);

            // Drag and Drop functionality
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dragDropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dragDropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dragDropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dragDropArea.classList.add('dragover');
            }

            function unhighlight(e) {
                dragDropArea.classList.remove('dragover');
            }

            dragDropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    const file = files[0];
                    document.getElementById('image_file').files = files;
                    previewImage(document.getElementById('image_file'));
                }
            }
        });

        // Preview image from file upload
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Check file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File quá lớn! Vui lòng chọn file nhỏ hơn 5MB.');
                    input.value = '';
                    return;
                }

                // Check file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Chỉ chấp nhận file ảnh (JPG, PNG, GIF, WebP)!');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    showPreview(e.target.result);
                };
                reader.readAsDataURL(file);
            }
        }

        // Preview image from URL
        function previewImageFromUrl(input) {
            const url = input.value.trim();
            if (url) {
                // Simple URL validation
                try {
                    new URL(url);
                    
                    // Test if image loads
                    const img = new Image();
                    img.onload = function() {
                        showPreview(url);
                    };
                    img.onerror = function() {
                        alert('Không thể tải ảnh từ URL này!');
                        input.value = '';
                    };
                    img.src = url;
                } catch (e) {
                    alert('URL không hợp lệ!');
                    input.value = '';
                }
            }
        }

        // Show image preview
        function showPreview(src) {
            const previewDiv = document.getElementById('image_preview');
            const previewImg = document.getElementById('preview_img');
            
            previewImg.src = src;
            previewDiv.style.display = 'block';
        }

        // Remove preview
        function removePreview() {
            const previewDiv = document.getElementById('image_preview');
            const previewImg = document.getElementById('preview_img');
            const fileInput = document.getElementById('image_file');
            const urlInput = document.getElementById('image_url_input');
            
            previewDiv.style.display = 'none';
            previewImg.src = '';
            fileInput.value = '';
            urlInput.value = '';
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const name = document.querySelector('input[name="name"]').value.trim();
            const price = document.querySelector('input[name="price"]').value;
            
            if (!name) {
                alert('Vui lòng nhập tên sản phẩm!');
                e.preventDefault();
                return;
            }
            
            if (!price || price <= 0) {
                alert('Vui lòng nhập giá hợp lệ!');
                e.preventDefault();
                return;
            }
        });
    </script>
</body>
</html> 