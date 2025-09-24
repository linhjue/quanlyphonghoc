<?php
// Bắt đầu session nếu chưa có
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Phòng học</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="/classroom_management/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
       

        header {
            text-align: center;
            padding: 20px 0;
            background-color: #2575fc;
            color: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        header h2 {
            margin: 0;
            font-size: 1.8rem;
        }

      
       
    </style>
</head>
<body>

<?php if (isset($_SESSION['user_id'])): ?>
<header>
    <h2>🎓 Hệ thống Quản lý Phòng học - <?= ucfirst($_SESSION['role']) ?></h2>
</header>

<?php endif; ?>
