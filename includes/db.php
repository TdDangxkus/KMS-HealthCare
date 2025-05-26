<?php
$host = 'localhost';
$db   = 'qickmed'; // Đổi tên DB nếu khác
$user = 'root';   // Đổi user nếu khác
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Kết nối CSDL thất bại: ' . $conn->connect_error);
}
?> 