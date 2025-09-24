<?php
session_start();

if (isset($_SESSION['user_id'])) {
    switch ($_SESSION['role']) {
        case 'Admin':
            header("Location: admin/dashboard.php");
            exit();
        case 'Lecturer':
            header("Location: lecturer/dashboard.php");
            exit();
        case 'Student':
            header("Location: student/dashboard.php");
            exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Phòng học</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Override cho trang chủ không có sidebar */
        body {
            padding-left: 0 !important;
            padding-bottom: 0 !important;
        }
        
        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        
        .footer {
            position: static !important;
            left: 0 !important;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <main class="container">
            <div class="logo-box">
                <img src="assets/img/logo_index1.jpg" alt="Logo Đại học Đại Nam">
            </div>

            <section class="hero">
                <h1>🎓 Hệ thống Quản lý Phòng học</h1>
                <p class="subtitle">
                    Quản lý lớp học, lịch giảng dạy và đặt phòng hiện đại – tất cả trong một nền tảng.
                </p>
            </section>

            <section class="actions-box">
                <a href="login.php" class="btn btn-primary">Đăng nhập</a>
                <a href="register.php" class="btn btn-secondary">Đăng ký</a>
            </section>
        </main>

        <footer class="footer">
            <p>&copy; 2025 - Hệ thống Quản lý Phòng học | Đại Học Đại Nam</p>
        </footer>
    </div>
</body>
</html>