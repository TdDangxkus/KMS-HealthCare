<?php
include 'includes/db.php';
session_start();
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT user_id, username, password_hash, role_id FROM users WHERE username=? OR email=?");
    $stmt->bind_param('ss', $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role_id'] = $row['role_id'];
            header('Location: index.php'); exit;
        } else {
            $err = 'Sai mật khẩu!';
        }
    } else {
        $err = 'Tài khoản không tồn tại!';
    }
}
?>
<?php include 'includes/header.php'; ?>
<div class="container my-5" style="max-width:400px;">
    <h2 class="mb-4 text-center">Đăng nhập</h2>
    <?php if(isset($_GET['registered'])): ?><div class="alert alert-success">Đăng ký thành công! Vui lòng đăng nhập.</div><?php endif; ?>
    <?php if($err): ?><div class="alert alert-danger"><?= $err ?></div><?php endif; ?>
    <form method="post">
        <div class="form-group mb-3">
            <label>Tên đăng nhập hoặc Email</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        <div class="mt-3 text-center">
            Chưa có tài khoản? <a href="register.php">Đăng ký</a>
        </div>
    </form>
</div>
<?php include 'includes/footer.php'; ?> 