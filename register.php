<?php
include 'includes/db.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $full_name = trim($_POST['full_name']);
    $role_id = 2; // 2 = patient (mặc định)
    if (!$username || !$email || !$password || !$full_name) {
        $err = 'Vui lòng nhập đầy đủ thông tin!';
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, role_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('sssi', $username, $email, $password_hash, $role_id);
        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;
            $stmt2 = $conn->prepare("INSERT INTO users_info (user_id, full_name) VALUES (?, ?)");
            $stmt2->bind_param('is', $user_id, $full_name);
            $stmt2->execute();
            header('Location: login.php?registered=1'); exit;
        } else {
            $err = 'Tên đăng nhập hoặc email đã tồn tại!';
        }
    }
}
?>
<?php include 'includes/header.php'; ?>
<div class="container my-5" style="max-width:500px;">
    <h2 class="mb-4 text-center">Đăng ký tài khoản</h2>
    <?php if($err): ?><div class="alert alert-danger"><?= $err ?></div><?php endif; ?>
    <form method="post">
        <div class="form-group mb-3">
            <label>Họ tên</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label>Tên đăng nhập</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
        <div class="mt-3 text-center">
            Đã có tài khoản? <a href="login.php">Đăng nhập</a>
        </div>
    </form>
</div>
<?php include 'includes/footer.php'; ?> 