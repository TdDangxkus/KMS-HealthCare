<?php
session_start();
include '../includes/db.php';

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../login.php');
    exit;
}

// Lấy thống kê
$stats = [];

// Tổng số bệnh nhân
$result = $conn->query("SELECT COUNT(*) as total FROM users WHERE role_id = 2");
$stats['patients'] = $result->fetch_assoc()['total'];

// Tổng số bác sĩ
$result = $conn->query("SELECT COUNT(*) as total FROM users WHERE role_id = 3");
$stats['doctors'] = $result->fetch_assoc()['total'];

// Tổng số lịch hẹn hôm nay
$today = date('Y-m-d');
$result = $conn->query("SELECT COUNT(*) as total FROM appointments WHERE DATE(appointment_date) = '$today'");
// $stats['appointments_today'] = $result->fetch_assoc()['total'];

// Tổng số lịch hẹn trong tháng
$this_month = date('Y-m');
$result = $conn->query("SELECT COUNT(*) as total FROM appointments WHERE DATE_FORMAT(appointment_date, '%Y-%m') = '$this_month'");
// $stats['appointments_month'] = $result->fetch_assoc()['total'];

// Lịch hẹn gần đây
$recent_appointments = $conn->query("
    SELECT a.*, ui.full_name as patient_name, ud.full_name as doctor_name,
           s.name as service_name
    FROM appointments a
    LEFT JOIN users_info ui ON a.patient_id = ui.user_id
    LEFT JOIN users_info ud ON a.doctor_id = ud.user_id
    LEFT JOIN services s ON a.service_id = s.service_id
    ORDER BY a.created_at DESC
    LIMIT 5
");

// Bệnh nhân mới đăng ký
$new_patients = $conn->query("
    SELECT u.*, ui.full_name, ui.phone
    FROM users u
    LEFT JOIN users_info ui ON u.user_id = ui.user_id
    WHERE u.role_id = 2
    ORDER BY u.created_at DESC
    LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - QickMed Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/admin.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/sidebar.php'; ?>

    <main class="main-content">
        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    <p class="mb-0 text-muted">Chào mừng trở lại, <?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username']) ?>!</p>
                </div>
                <div class="d-flex gap-2">
                    <span class="badge bg-success">Online</span>
                    <span class="text-muted"><?= date('d/m/Y H:i') ?></span>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Tổng bệnh nhân
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['patients']) ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Tổng bác sĩ
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['doctors']) ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-md fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Lịch hẹn hôm nay
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['appointments_today']) ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-day fa-2x text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Lịch hẹn tháng này
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($stats['appointments_month']) ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-alt fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- Recent Appointments -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-calendar-check me-2"></i>Lịch hẹn gần đây
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Bệnh nhân</th>
                                            <th>Bác sĩ</th>
                                            <th>Dịch vụ</th>
                                            <th>Ngày hẹn</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($recent_appointments && $recent_appointments->num_rows > 0): ?>
                                            <?php while ($appointment = $recent_appointments->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($appointment['patient_name'] ?? 'N/A') ?></td>
                                                    <td><?= htmlspecialchars($appointment['doctor_name'] ?? 'N/A') ?></td>
                                                    <td><?= htmlspecialchars($appointment['service_name'] ?? 'N/A') ?></td>
                                                    <td><?= date('d/m/Y H:i', strtotime($appointment['appointment_date'])) ?></td>
                                                    <td>
                                                        <?php
                                                        $status_class = '';
                                                        $status_text = '';
                                                        switch($appointment['status']) {
                                                            case 'pending':
                                                                $status_class = 'warning';
                                                                $status_text = 'Chờ xác nhận';
                                                                break;
                                                            case 'confirmed':
                                                                $status_class = 'success';
                                                                $status_text = 'Đã xác nhận';
                                                                break;
                                                            case 'completed':
                                                                $status_class = 'primary';
                                                                $status_text = 'Hoàn thành';
                                                                break;
                                                            case 'cancelled':
                                                                $status_class = 'danger';
                                                                $status_text = 'Đã hủy';
                                                                break;
                                                            default:
                                                                $status_class = 'secondary';
                                                                $status_text = 'Không xác định';
                                                        }
                                                        ?>
                                                        <span class="badge bg-<?= $status_class ?>"><?= $status_text ?></span>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Chưa có lịch hẹn nào</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center mt-3">
                                <a href="appointments.php" class="btn btn-primary">
                                    <i class="fas fa-eye me-2"></i>Xem tất cả
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Patients -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 font-weight-bold text-success">
                                <i class="fas fa-user-plus me-2"></i>Bệnh nhân mới
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if ($new_patients && $new_patients->num_rows > 0): ?>
                                <?php while ($patient = $new_patients->fetch_assoc()): ?>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-sm me-3">
                                            <div class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                <?= strtoupper(substr($patient['full_name'] ?? $patient['username'], 0, 1)) ?>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0"><?= htmlspecialchars($patient['full_name'] ?? $patient['username']) ?></h6>
                                            <p class="text-muted mb-0 small">
                                                <i class="fas fa-envelope me-1"></i><?= htmlspecialchars($patient['email']) ?>
                                            </p>
                                            <p class="text-muted mb-0 small">
                                                <i class="fas fa-clock me-1"></i><?= date('d/m/Y', strtotime($patient['created_at'])) ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p class="text-center text-muted">Chưa có bệnh nhân mới</p>
                            <?php endif; ?>
                            
                            <div class="text-center mt-3">
                                <a href="users.php?role=patient" class="btn btn-success btn-sm">
                                    <i class="fas fa-eye me-2"></i>Xem tất cả
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-bolt me-2"></i>Thao tác nhanh
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="users.php?action=add&role=doctor" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-user-md fa-2x mb-2 d-block"></i>
                                        Thêm bác sĩ
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="services.php?action=add" class="btn btn-outline-success w-100">
                                        <i class="fas fa-plus-circle fa-2x mb-2 d-block"></i>
                                        Thêm dịch vụ
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="appointments.php" class="btn btn-outline-info w-100">
                                        <i class="fas fa-calendar-alt fa-2x mb-2 d-block"></i>
                                        Quản lý lịch hẹn
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="reports.php" class="btn btn-outline-warning w-100">
                                        <i class="fas fa-chart-bar fa-2x mb-2 d-block"></i>
                                        Xem báo cáo
                                    </a>
                                </div>
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