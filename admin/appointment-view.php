<?php
session_start();
require_once '../includes/db.php';

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../login.php');
    exit();
}

$appointment_id = (int)($_GET['id'] ?? 0);
if (!$appointment_id) {
    header('Location: appointments.php?error=invalid_id');
    exit();
}

// Lấy thông tin lịch hẹn với simple queries
$appointment = null;
$patient_info = null;
$guest_info = null;
$doctor_info = null;
$clinic_info = null;

// Query 1: Basic appointment info
try {
    $result = $conn->query("SELECT * FROM appointments WHERE appointment_id = $appointment_id");
    if ($result && $result->num_rows > 0) {
        $appointment = $result->fetch_assoc();
    } else {
        header('Location: appointments.php?error=not_found');
        exit();
    }
} catch (Exception $e) {
    header('Location: appointments.php?error=database_error');
    exit();
}

// Query 2: Patient info (if user_id exists)
if ($appointment['user_id']) {
    try {
        $result = $conn->query("SELECT u.*, ui.full_name, ui.date_of_birth, ui.address 
                               FROM users u 
                               LEFT JOIN users_info ui ON u.user_id = ui.user_id 
                               WHERE u.user_id = " . $appointment['user_id']);
        if ($result && $result->num_rows > 0) {
            $patient_info = $result->fetch_assoc();
        }
    } catch (Exception $e) {
        // Ignore error
    }
}

// Query 3: Guest info (if guest_id exists)
if ($appointment['guest_id']) {
    try {
        $result = $conn->query("SELECT * FROM guest_users WHERE guest_id = " . $appointment['guest_id']);
        if ($result && $result->num_rows > 0) {
            $guest_info = $result->fetch_assoc();
        }
    } catch (Exception $e) {
        // Ignore error
    }
}

// Query 4: Doctor info
try {
    $result = $conn->query("SELECT u.*, ui.full_name 
                           FROM users u 
                           LEFT JOIN users_info ui ON u.user_id = ui.user_id 
                           WHERE u.user_id = " . $appointment['doctor_id']);
    if ($result && $result->num_rows > 0) {
        $doctor_info = $result->fetch_assoc();
    }
} catch (Exception $e) {
    // Ignore error
}

// Query 5: Clinic info (if clinic_id exists)
if ($appointment['clinic_id']) {
    try {
        $result = $conn->query("SELECT * FROM clinics WHERE clinic_id = " . $appointment['clinic_id']);
        if ($result && $result->num_rows > 0) {
            $clinic_info = $result->fetch_assoc();
        }
    } catch (Exception $e) {
        // Ignore error
    }
}

// Prepare display data
$patient_name = '';
$patient_email = '';
$patient_phone = '';
$patient_dob = '';
$patient_address = '';

if ($patient_info) {
    $patient_name = ($patient_info['full_name'] ?? null) ?: $patient_info['username'];
    $patient_email = $patient_info['email'];
    $patient_phone = $patient_info['phone_number'];
    $patient_dob = $patient_info['date_of_birth'] ?? null;
    $patient_address = $patient_info['address'] ?? null;
} elseif ($guest_info) {
    $patient_name = $guest_info['full_name'];
    $patient_email = $guest_info['email'];
    $patient_phone = $guest_info['phone'];
    $patient_dob = $guest_info['date_of_birth'] ?? null;
    $patient_address = $guest_info['address'] ?? null;
}

$doctor_name = '';
$doctor_email = '';
$doctor_phone = '';

if ($doctor_info) {
    $doctor_name = ($doctor_info['full_name'] ?? null) ?: $doctor_info['username'];
    $doctor_email = $doctor_info['email'];
    $doctor_phone = $doctor_info['phone_number'];
}

$clinic_name = $clinic_info['name'] ?? null;
$clinic_address = $clinic_info['address'] ?? null;
$clinic_phone = $clinic_info['phone'] ?? null;

// Xử lý cập nhật trạng thái
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $new_status = $_POST['status'];
    $allowed_statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
    
    if (in_array($new_status, $allowed_statuses)) {
        $update_sql = "UPDATE appointments SET status = ?, updated_at = NOW() WHERE appointment_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        
        if ($update_stmt) {
            $update_stmt->bind_param("si", $new_status, $appointment_id);
            
            if ($update_stmt->execute()) {
                $appointment['status'] = $new_status;
                $success_message = "Cập nhật trạng thái thành công!";
            } else {
                $error_message = "Cập nhật trạng thái thất bại!";
            }
        } else {
            $error_message = "Lỗi chuẩn bị câu lệnh SQL!";
        }
    }
}

$status_configs = [
    'pending' => ['class' => 'warning', 'text' => 'Chờ xác nhận', 'icon' => 'clock'],
    'confirmed' => ['class' => 'success', 'text' => 'Đã xác nhận', 'icon' => 'check-circle'],
    'completed' => ['class' => 'primary', 'text' => 'Hoàn thành', 'icon' => 'check-double'],
    'cancelled' => ['class' => 'danger', 'text' => 'Đã hủy', 'icon' => 'times-circle']
];
$current_status = $status_configs[$appointment['status']] ?? ['class' => 'secondary', 'text' => 'Không xác định', 'icon' => 'question'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết lịch hẹn #<?= $appointment_id ?> - QickMed Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/admin.css" rel="stylesheet">
    <link href="assets/css/sidebar.css" rel="stylesheet">
    <link href="assets/css/header.css" rel="stylesheet">
    <style>
        .info-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .status-badge {
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
        }
        .timeline-item {
            border-left: 3px solid #e9ecef;
            padding-left: 1.5rem;
            margin-bottom: 1.5rem;
            position: relative;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 0;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            background: #6c757d;
        }
        .timeline-item.active::before {
            background: #0d6efd;
        }
        .timeline-item.completed::before {
            background: #198754;
        }
        .timeline-item.cancelled::before {
            background: #dc3545;
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
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="appointments.php">Lịch hẹn</a></li>
                            <li class="breadcrumb-item active">Chi tiết #<?= $appointment_id ?></li>
                        </ol>
                    </nav>
                    <h1 class="h3 mb-0 text-gray-800">Chi tiết lịch hẹn #<?= $appointment_id ?></h1>
                </div>
                <div>
                    <a href="appointments.php" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                    <a href="appointment-edit.php?id=<?= $appointment_id ?>" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Chỉnh sửa
                    </a>
                </div>
            </div>

            <!-- Alerts -->
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $success_message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $error_message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <!-- Thông tin chính -->
                <div class="col-lg-8">
                    <!-- Thông tin lịch hẹn -->
                    <div class="card info-card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-calendar-alt me-2"></i>Thông tin lịch hẹn
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Ngày giờ hẹn</label>
                                        <div class="h5 text-primary">
                                            <i class="fas fa-calendar me-2"></i>
                                            <?= date('d/m/Y', strtotime($appointment['appointment_time'])) ?>
                                            <span class="ms-2">
                                                <i class="fas fa-clock me-1"></i>
                                                <?= date('H:i', strtotime($appointment['appointment_time'])) ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Trạng thái</label>
                                        <div>
                                            <span class="badge bg-<?= $current_status['class'] ?> status-badge">
                                                <i class="fas fa-<?= $current_status['icon'] ?> me-2"></i>
                                                <?= $current_status['text'] ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if ($appointment['reason']): ?>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Lý do khám</label>
                                    <div class="p-3 bg-light rounded">
                                        <?= nl2br(htmlspecialchars($appointment['reason'])) ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-plus me-1"></i>
                                        Tạo lúc: <?= date('d/m/Y H:i', strtotime($appointment['created_at'])) ?>
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-edit me-1"></i>
                                        Cập nhật: <?= date('d/m/Y H:i', strtotime($appointment['updated_at'])) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin bệnh nhân -->
                    <div class="card info-card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user me-2"></i>Thông tin bệnh nhân
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Họ tên</label>
                                        <div class="h6"><?= htmlspecialchars($patient_name ?: 'Chưa có') ?></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Email</label>
                                        <div>
                                            <?php if ($patient_email): ?>
                                                <a href="mailto:<?= htmlspecialchars($patient_email) ?>">
                                                    <?= htmlspecialchars($patient_email) ?>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa có</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Số điện thoại</label>
                                        <div>
                                            <?php if ($patient_phone): ?>
                                                <a href="tel:<?= htmlspecialchars($patient_phone) ?>">
                                                    <?= htmlspecialchars($patient_phone) ?>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa có</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Ngày sinh</label>
                                        <div>
                                            <?php if ($patient_dob): ?>
                                                <?= date('d/m/Y', strtotime($patient_dob)) ?>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa có</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if ($patient_address): ?>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Địa chỉ</label>
                                    <div><?= htmlspecialchars($patient_address) ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Thông tin bác sĩ -->
                    <div class="card info-card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user-md me-2"></i>Thông tin bác sĩ
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Họ tên</label>
                                        <div class="h6"><?= htmlspecialchars($doctor_name ?: 'Chưa có') ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Email</label>
                                        <div>
                                            <?php if ($doctor_email): ?>
                                                <a href="mailto:<?= htmlspecialchars($doctor_email) ?>">
                                                    <?= htmlspecialchars($doctor_email) ?>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa có</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if ($doctor_phone): ?>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Số điện thoại</label>
                                    <div>
                                        <a href="tel:<?= htmlspecialchars($doctor_phone) ?>">
                                            <?= htmlspecialchars($doctor_phone) ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Thông tin phòng khám -->
                    <?php if ($clinic_name): ?>
                        <div class="card info-card mb-4">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0">
                                    <i class="fas fa-hospital me-2"></i>Thông tin phòng khám
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Tên phòng khám</label>
                                            <div class="h6"><?= htmlspecialchars($clinic_name) ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <?php if ($clinic_phone): ?>
                                            <div class="mb-3">
                                                <label class="form-label text-muted">Số điện thoại</label>
                                                <div>
                                                    <a href="tel:<?= htmlspecialchars($clinic_phone) ?>">
                                                        <?= htmlspecialchars($clinic_phone) ?>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <?php if ($clinic_address): ?>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Địa chỉ</label>
                                        <div><?= htmlspecialchars($clinic_address) ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Cập nhật trạng thái -->
                    <div class="card info-card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-edit me-2"></i>Cập nhật trạng thái
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Trạng thái mới</label>
                                    <select class="form-select" name="status" required>
                                        <option value="pending" <?= $appointment['status'] == 'pending' ? 'selected' : '' ?>>
                                            Chờ xác nhận
                                        </option>
                                        <option value="confirmed" <?= $appointment['status'] == 'confirmed' ? 'selected' : '' ?>>
                                            Đã xác nhận
                                        </option>
                                        <option value="completed" <?= $appointment['status'] == 'completed' ? 'selected' : '' ?>>
                                            Hoàn thành
                                        </option>
                                        <option value="cancelled" <?= $appointment['status'] == 'cancelled' ? 'selected' : '' ?>>
                                            Đã hủy
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" name="update_status" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>Cập nhật
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Timeline trạng thái -->
                    <div class="card info-card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-history me-2"></i>Tiến trình
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="timeline-item <?= in_array($appointment['status'], ['pending', 'confirmed', 'completed']) ? 'completed' : '' ?>">
                                <h6 class="mb-1">Tạo lịch hẹn</h6>
                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($appointment['created_at'])) ?></small>
                            </div>
                            
                            <div class="timeline-item <?= in_array($appointment['status'], ['confirmed', 'completed']) ? 'completed' : ($appointment['status'] == 'pending' ? 'active' : '') ?>">
                                <h6 class="mb-1">Chờ xác nhận</h6>
                                <small class="text-muted">Đang chờ xác nhận từ bác sĩ</small>
                            </div>
                            
                            <div class="timeline-item <?= $appointment['status'] == 'completed' ? 'completed' : ($appointment['status'] == 'confirmed' ? 'active' : '') ?>">
                                <h6 class="mb-1">Đã xác nhận</h6>
                                <small class="text-muted">Lịch hẹn đã được xác nhận</small>
                            </div>
                            
                            <div class="timeline-item <?= $appointment['status'] == 'completed' ? 'completed active' : '' ?>">
                                <h6 class="mb-1">Hoàn thành</h6>
                                <small class="text-muted">Cuộc hẹn đã hoàn thành</small>
                            </div>
                            
                            <?php if ($appointment['status'] == 'cancelled'): ?>
                                <div class="timeline-item cancelled active">
                                    <h6 class="mb-1 text-danger">Đã hủy</h6>
                                    <small class="text-muted">Lịch hẹn đã bị hủy</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Thao tác nhanh -->
                    <div class="card info-card">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-tools me-2"></i>Thao tác nhanh
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="appointment-edit.php?id=<?= $appointment_id ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-2"></i>Chỉnh sửa
                                </a>
                                <button class="btn btn-outline-info" onclick="window.print()">
                                    <i class="fas fa-print me-2"></i>In thông tin
                                </button>
                                <a href="appointments.php?action=delete&id=<?= $appointment_id ?>" 
                                   class="btn btn-outline-danger"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa lịch hẹn này?')">
                                    <i class="fas fa-trash me-2"></i>Xóa lịch hẹn
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/admin.js"></script>
</body>
</html> 