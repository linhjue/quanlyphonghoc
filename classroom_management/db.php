<?php
// db.php - kết nối MySQL

$host = "localhost";       // server MySQL
$user = "root";            // user MySQL (xampp mặc định là root)
$pass = "24102005";                // mật khẩu (xampp mặc định để trống)
$dbname = "classroom_management"; // tên database bạn đã tạo

// Tạo kết nối
$conn = new mysqli($host, $user, $pass, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Đặt charset UTF-8 để hỗ trợ tiếng Việt
$conn->set_charset("utf8");

?>
