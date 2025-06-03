<?php
include 'includes/db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); exit;
}
$user_id = $_SESSION['user_id'];
$err = $msg = '';

// Lấy thông tin user
$stmt = $conn->prepare("SELECT u.username, u.email, ui.full_name, ui.profile_picture FROM users u JOIN users_info ui ON u.user_id=ui.user_id WHERE u.user_id=?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Cập nhật thông tin
if (isset($_POST['update_info'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    if ($full_name && $email) {
        $stmt1 = $conn->prepare("UPDATE users_info SET full_name=? WHERE user_id=?");
        $stmt1->bind_param('si', $full_name, $user_id);
        $stmt1->execute();
        $stmt2 = $conn->prepare("UPDATE users SET email=? WHERE user_id=?");
        $stmt2->bind_param('si', $email, $user_id);
        $stmt2->execute();
        $msg = 'Cập nhật thành công!';
        
        // Update session data
        $_SESSION['full_name'] = $full_name;
    } else {
        $err = 'Vui lòng nhập đầy đủ thông tin!';
    }
}

// Đổi mật khẩu
if (isset($_POST['change_pass'])) {
    $old = $_POST['old_pass'];
    $new = $_POST['new_pass'];
    $confirm = $_POST['confirm_pass'];
    
    if ($new !== $confirm) {
        $err = 'Mật khẩu xác nhận không khớp!';
    } else {
        $stmt = $conn->prepare("SELECT password FROM users WHERE user_id=?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $pw = $stmt->get_result()->fetch_assoc();
        if ($old === $pw['password']) {
            $stmt = $conn->prepare("UPDATE users SET password=? WHERE user_id=?");
            $stmt->bind_param('si', $new, $user_id);
        $stmt->execute();
        $msg = 'Đổi mật khẩu thành công!';
    } else {
        $err = 'Mật khẩu cũ không đúng!';
    }
}
}

// Upload ảnh đại diện
if (isset($_POST['upload_avatar']) && isset($_FILES['avatar']['name']) && $_FILES['avatar']['name']) {
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    $file_type = $_FILES['avatar']['type'];
    $file_size = $_FILES['avatar']['size'];
    
    if (!in_array($file_type, $allowed_types)) {
        $err = 'Chỉ cho phép upload file ảnh (JPG, PNG, GIF)!';
    } elseif ($file_size > 5000000) { // 5MB
        $err = 'Kích thước file không được vượt quá 5MB!';
    } else {
        $file_extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $target = 'assets/images/avatar_' . $user_id . '_' . time() . '.' . $file_extension;
        
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
            // Delete old avatar if exists
            if ($user['profile_picture'] && file_exists($user['profile_picture'])) {
                unlink($user['profile_picture']);
            }
            
        $stmt = $conn->prepare("UPDATE users_info SET profile_picture=? WHERE user_id=?");
        $stmt->bind_param('si', $target, $user_id);
        $stmt->execute();
        $msg = 'Cập nhật ảnh đại diện thành công!';
    } else {
        $err = 'Tải ảnh thất bại!';
    }
}
}

// Reload lại thông tin mới nhất
$stmt = $conn->prepare("SELECT u.username, u.email, ui.full_name, ui.profile_picture FROM users u JOIN users_info ui ON u.user_id=ui.user_id WHERE u.user_id=?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Get user role
$role_names = [1 => 'Quản trị viên', 2 => 'Bệnh nhân', 3 => 'Bác sĩ'];
$user_role = $role_names[$_SESSION['role_id']] ?? 'Người dùng';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ cá nhân - Qickmed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .profile-wrapper {
            min-height: 100vh;
            padding: 2rem 0;
        }

        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 2rem;
            padding: 0 1rem;
        }

        /* Sidebar Profile */
        .profile-sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            height: fit-content;
            position: sticky;
            top: 2rem;
        }

        .profile-avatar-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .avatar-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
        }

        .avatar-edit {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 35px;
            height: 35px;
            background: #667eea;
            border: 3px solid #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: white;
            font-size: 14px;
        }

        .avatar-edit:hover {
            background: #5a6fd8;
            transform: scale(1.1);
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .profile-role {
            display: inline-block;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .profile-username {
            color: #718096;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 2rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 12px;
            transition: transform 0.2s ease;
        }

        .stat-item:hover {
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
            display: block;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #718096;
            font-weight: 500;
        }

        /* Main Content */
        .profile-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .content-header {
            margin-bottom: 2rem;
        }

        .content-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .content-subtitle {
            color: #718096;
            font-size: 1rem;
        }

        /* Tabs */
        .custom-tabs {
            display: flex;
            background: #f7fafc;
            border-radius: 15px;
            padding: 0.5rem;
            margin-bottom: 2rem;
        }

        .tab-btn {
            flex: 1;
            padding: 0.75rem 1rem;
            background: transparent;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            color: #718096;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .tab-btn:hover:not(.active) {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        /* Tab Content */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Forms */
        .form-section {
            background: #f7fafc;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .form-input:disabled {
            background: #f7fafc;
            color: #a0aec0;
            cursor: not-allowed;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #4a5568;
        }

        .btn-secondary:hover {
            background: #cbd5e0;
            transform: translateY(-1px);
        }

        /* Upload Area */
        .upload-area {
            border: 3px dashed #e2e8f0;
            border-radius: 15px;
            padding: 3rem 2rem;
            text-align: center;
            background: #f7fafc;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .upload-area:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .upload-area.dragover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
            transform: scale(1.02);
        }

        .upload-icon {
            font-size: 3rem;
            color: #a0aec0;
            margin-bottom: 1rem;
        }

        .upload-text {
            color: #4a5568;
            font-size: 1rem;
            font-weight: 500;
        }

        .upload-hint {
            color: #a0aec0;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        /* Preview */
        .image-preview {
            text-align: center;
            padding: 2rem;
        }

        .preview-img {
            max-width: 300px;
            max-height: 300px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(72, 187, 120, 0.1), rgba(72, 187, 120, 0.05));
            color: #2f855a;
            border-left: 4px solid #48bb78;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(245, 101, 101, 0.1), rgba(245, 101, 101, 0.05));
            color: #c53030;
            border-left: 4px solid #f56565;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-container {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding: 0 1rem;
            }

            .profile-sidebar {
                position: static;
                order: 2;
            }

            .profile-content {
                order: 1;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .custom-tabs {
                flex-direction: column;
                gap: 0.5rem;
            }

            .tab-btn {
                justify-content: flex-start;
            }
        }

        /* Hidden file input */
        .hidden-input {
            display: none;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="profile-wrapper">
        <div class="profile-container">
            <!-- Sidebar -->
            <div class="profile-sidebar">
                <!-- Alerts -->
                <?php if($err): ?>
                    <div class="alert alert-danger">
                        <i class="fa-solid fa-exclamation-triangle"></i>
                        <?= htmlspecialchars($err) ?>
                    </div>
                <?php endif; ?>
                
                <?php if($msg): ?>
                    <div class="alert alert-success">
                        <i class="fa-solid fa-check-circle"></i>
                        <?= htmlspecialchars($msg) ?>
                    </div>
                <?php endif; ?>

                <div class="profile-avatar-section">
                    <div class="avatar-wrapper">
                        <img src="<?= $user['profile_picture'] ? htmlspecialchars($user['profile_picture']) : '/assets/images/default-avatar.png' ?>" 
                             alt="Avatar" class="profile-avatar" id="currentAvatar">
                        <div class="avatar-edit" onclick="document.getElementById('avatarInput').click()">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                    </div>
                    
                    <div class="profile-name"><?= htmlspecialchars($user['full_name']) ?></div>
                    <div class="profile-role">
                        <i class="fa-solid fa-user-tag me-1"></i>
                        <?= htmlspecialchars($user_role) ?>
                    </div>
                    <div class="profile-username">
                        <i class="fa-solid fa-at me-1"></i>
                        <?= htmlspecialchars($user['username']) ?>
                    </div>
                </div>

                <div class="profile-stats">
                    <div class="stat-item">
                        <span class="stat-number">12</span>
                        <span class="stat-label">Lịch hẹn</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">8</span>
                        <span class="stat-label">Hồ sơ</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">24</span>
                        <span class="stat-label">Tin nhắn</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">5</span>
                        <span class="stat-label">Đánh giá</span>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="profile-content">
                <div class="content-header">
                    <h1 class="content-title">Hồ sơ cá nhân</h1>
                    <p class="content-subtitle">Quản lý thông tin cá nhân và cài đặt tài khoản của bạn</p>
                </div>

                <!-- Custom Tabs -->
                <div class="custom-tabs">
                    <button class="tab-btn active" onclick="showTab('info')">
                        <i class="fa-solid fa-user"></i>
                        Thông tin cá nhân
                    </button>
                    <button class="tab-btn" onclick="showTab('password')">
                        <i class="fa-solid fa-lock"></i>
                        Đổi mật khẩu
                    </button>
                    <button class="tab-btn" onclick="showTab('avatar')">
                        <i class="fa-solid fa-image"></i>
                        Ảnh đại diện
                    </button>
                </div>

                <!-- Tab Contents -->
                <div id="info" class="tab-content active">
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fa-solid fa-user"></i>
                            Cập nhật thông tin cá nhân
                        </h3>
                        
                        <form method="post" id="updateInfoForm">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fa-solid fa-signature me-1"></i>Họ và tên
                                    </label>
                                    <input type="text" name="full_name" class="form-input" 
                                           value="<?= htmlspecialchars($user['full_name']) ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fa-solid fa-envelope me-1"></i>Email
                                    </label>
                                    <input type="email" name="email" class="form-input" 
                                           value="<?= htmlspecialchars($user['email']) ?>" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-solid fa-user-circle me-1"></i>Tên đăng nhập
                                </label>
                                <input type="text" class="form-input" 
                                       value="<?= htmlspecialchars($user['username']) ?>" disabled>
                                <small style="color: #a0aec0; font-size: 0.85rem;">Tên đăng nhập không thể thay đổi</small>
                            </div>
                            
                            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                                <button type="submit" name="update_info" class="btn btn-primary">
                                    <i class="fa-solid fa-save"></i>Lưu thay đổi
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fa-solid fa-undo"></i>Hủy bỏ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="password" class="tab-content">
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fa-solid fa-lock"></i>
                            Đổi mật khẩu
                        </h3>
                        
                        <form method="post" id="changePasswordForm">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fa-solid fa-key me-1"></i>Mật khẩu hiện tại
                                </label>
                                <input type="password" name="old_pass" class="form-input" required>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fa-solid fa-lock me-1"></i>Mật khẩu mới
                                    </label>
                                    <input type="password" name="new_pass" class="form-input" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fa-solid fa-check-double me-1"></i>Xác nhận mật khẩu
                                    </label>
                                    <input type="password" name="confirm_pass" class="form-input" required>
                                </div>
                            </div>
                            
                            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                                <button type="submit" name="change_pass" class="btn btn-primary">
                                    <i class="fa-solid fa-key"></i>Đổi mật khẩu
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fa-solid fa-undo"></i>Hủy bỏ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="avatar" class="tab-content">
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fa-solid fa-image"></i>
                            Cập nhật ảnh đại diện
                        </h3>
                        
                        <form method="post" enctype="multipart/form-data" id="avatarForm">
                            <div class="upload-area" id="uploadArea">
                                <div class="upload-icon">
                                    <i class="fa-solid fa-cloud-upload-alt"></i>
                                </div>
                                <div class="upload-text">
                                    <strong>Kéo thả ảnh vào đây</strong> hoặc <strong>click để chọn file</strong>
                                </div>
                                <div class="upload-hint">
                                    Hỗ trợ: JPG, PNG, GIF (tối đa 5MB)
                                </div>
                                <input type="file" name="avatar" id="avatarInput" accept="image/*" class="hidden-input">
                            </div>
                            
                            <div class="image-preview" id="imagePreview" style="display: none;">
                                <img id="previewImage" class="preview-img">
                                <div style="margin-top: 1.5rem; display: flex; gap: 1rem; justify-content: center;">
                                    <button type="button" class="btn btn-secondary" onclick="clearPreview()">
                                        <i class="fa-solid fa-times"></i>Hủy
                                    </button>
                                    <button type="submit" name="upload_avatar" class="btn btn-primary">
                                        <i class="fa-solid fa-upload"></i>Tải lên
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tab functionality
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab content
            document.getElementById(tabName).classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }

        // File Upload Functionality
        const uploadArea = document.getElementById('uploadArea');
        const avatarInput = document.getElementById('avatarInput');
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const currentAvatar = document.getElementById('currentAvatar');

        uploadArea.addEventListener('click', () => avatarInput.click());

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                avatarInput.files = files;
                handleFileSelect();
            }
        });

        avatarInput.addEventListener('change', handleFileSelect);

        function handleFileSelect() {
            const file = avatarInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImage.src = e.target.result;
                    uploadArea.style.display = 'none';
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        function clearPreview() {
            avatarInput.value = '';
            uploadArea.style.display = 'block';
            imagePreview.style.display = 'none';
        }

        // Form Validation
        document.getElementById('updateInfoForm').addEventListener('submit', function(e) {
            const fullName = this.full_name.value.trim();
            const email = this.email.value.trim();

            if (fullName.length < 2) {
                e.preventDefault();
                alert('Họ tên phải có ít nhất 2 ký tự!');
                return;
            }

            if (!email.includes('@')) {
                e.preventDefault();
                alert('Email không hợp lệ!');
                return;
            }
        });

        document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
            const oldPass = this.old_pass.value;
            const newPass = this.new_pass.value;
            const confirmPass = this.confirm_pass.value;

            if (newPass.length < 6) {
                e.preventDefault();
                alert('Mật khẩu mới phải có ít nhất 6 ký tự!');
                return;
            }

            if (newPass !== confirmPass) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không khớp!');
                return;
            }
        });

        // Auto-hide alerts
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => alert.remove(), 300);
                });
            }, 5000);
        });
    </script>

    <?php include 'includes/footer.php'; ?>
</body>
</html> 