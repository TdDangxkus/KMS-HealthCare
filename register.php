<?php
// include 'includes/db.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = trim($_POST['full_name']);
    $role_id = 2; // 2 = patient (mặc định)
    if (!$username || !$email || !$password || !$confirm_password || !$full_name) {
        $err = 'Vui lòng nhập đầy đủ thông tin!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err = 'Email không hợp lệ!';
    } elseif (!preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username)) {
        $err = 'Tên đăng nhập chỉ được chứa chữ, số, và gạch dưới (3-30 ký tự)!';
    } elseif ($password !== $confirm_password) {
        $err = 'Mật khẩu không khớp!';
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, role_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('sssi', $username, $email, $password_hash, $role_id);
        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;
            $stmt2 = $conn->prepare("INSERT INTO users_info (user_id, full_name) VALUES (?, ?)");
            $stmt2->bind_param('is', $user_id, $full_name);
            $stmt2->execute();
            header('Location: login.php?registered=1');
            exit;
        } else {
            $err = 'Tên đăng nhập hoặc email đã tồn tại!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom css -->
    <link rel="stylesheet" type="text/css" href="/assets/css/auth.css">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="auth-box">
            <div class="heading">Đăng Ký</div>
            <form action="" class="form" method="post">
                <!-- <input required="" class="input" type="text" name="full_name" id="full_name" placeholder="Họ và tên"> -->
                <input required="" class="input" type="text" name="username" id="username" placeholder="Tên đăng nhập">
                <input required="" class="input" type="email" name="email" id="email" placeholder="Email">
                <input required="" class="input" type="password" name="password" id="password" placeholder="Mật khẩu">
                <input required="" class="input" type="password" name="confirm_password" id="confirm_password" placeholder="Xác nhận mật khẩu">
                <input class="cta-button" type="submit" value="Đăng Ký">
                <span class="switch-auth">Đã có tài khoản? <a href="login.php">Đăng nhập</a></span>
                <?php if ($err): ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <?php echo htmlspecialchars($err); ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>

</html>