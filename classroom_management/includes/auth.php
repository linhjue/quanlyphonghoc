<?php
// includes/auth.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra nếu chưa đăng nhập thì quay lại login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
