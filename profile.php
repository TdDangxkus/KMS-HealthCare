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
    } else {
        $err = 'Vui lòng nhập đầy đủ thông tin!';
    }
}
// Đổi mật khẩu
if (isset($_POST['change_pass'])) {
    $old = $_POST['old_pass'];
    $new = $_POST['new_pass'];
    $stmt = $conn->prepare("SELECT password_hash FROM users WHERE user_id=?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $pw = $stmt->get_result()->fetch_assoc();
    if (password_verify($old, $pw['password_hash'])) {
        $new_hash = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password_hash=? WHERE user_id=?");
        $stmt->bind_param('si', $new_hash, $user_id);
        $stmt->execute();
        $msg = 'Đổi mật khẩu thành công!';
    } else {
        $err = 'Mật khẩu cũ không đúng!';
    }
}
// Upload ảnh đại diện
if (isset($_POST['upload_avatar']) && isset($_FILES['avatar']['name']) && $_FILES['avatar']['name']) {
    $target = 'assets/images/avatar_' . $user_id . '_' . time() . '.jpg';
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
        $stmt = $conn->prepare("UPDATE users_info SET profile_picture=? WHERE user_id=?");
        $stmt->bind_param('si', $target, $user_id);
        $stmt->execute();
        $msg = 'Cập nhật ảnh đại diện thành công!';
    } else {
        $err = 'Tải ảnh thất bại!';
    }
}
// Reload lại thông tin mới nhất
$stmt = $conn->prepare("SELECT u.username, u.email, ui.full_name, ui.profile_picture FROM users u JOIN users_info ui ON u.user_id=ui.user_id WHERE u.user_id=?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>
<?php include 'includes/header.php'; ?>
<div class="container my-5" style="max-width:600px;">
    <h2 class="mb-4 text-center">Hồ sơ cá nhân</h2>
    <?php if($err): ?><div class="alert alert-danger"><?= $err ?></div><?php endif; ?>
    <?php if($msg): ?><div class="alert alert-success"><?= $msg ?></div><?php endif; ?>
    <div class="card mb-4">
        <div class="card-body text-center">
            <img src="<?= $user['profile_picture'] ? $user['profile_picture'] : '/assets/images/default-avatar.png' ?>" class="rounded-circle mb-3" width="120" height="120" style="object-fit:cover;">
            <form method="post" enctype="multipart/form-data" class="mb-2">
                <input type="file" name="avatar" accept="image/*" required>
                <button type="submit" name="upload_avatar" class="btn btn-sm btn-outline-primary">Cập nhật ảnh</button>
            </form>
            <h4><?= htmlspecialchars($user['full_name']) ?></h4>
            <p class="mb-1">Tên đăng nhập: <b><?= htmlspecialchars($user['username']) ?></b></p>
            <p>Email: <b><?= htmlspecialchars($user['email']) ?></b></p>
        </div>
    </div>
    <form method="post" class="mb-4">
        <h5>Cập nhật thông tin</h5>
        <div class="form-group mb-2">
            <label>Họ tên</label>
            <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required>
        </div>
        <div class="form-group mb-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <button type="submit" name="update_info" class="btn btn-primary">Lưu thay đổi</button>
    </form>
    <form method="post">
        <h5>Đổi mật khẩu</h5>
        <div class="form-group mb-2">
            <label>Mật khẩu cũ</label>
            <input type="password" name="old_pass" class="form-control" required>
        </div>
        <div class="form-group mb-2">
            <label>Mật khẩu mới</label>
            <input type="password" name="new_pass" class="form-control" required>
        </div>
        <button type="submit" name="change_pass" class="btn btn-warning">Đổi mật khẩu</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?> 