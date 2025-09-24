<?php
session_start();
include("db.php");

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $code = trim($_POST['code']);

    // Kiểm tra mã trong bảng tương ứng
    if ($role == "Student") {
        $check = $conn->prepare("SELECT * FROM students_list WHERE student_code = ?");
    } else {
        $check = $conn->prepare("SELECT * FROM lecturers_list WHERE lecturer_code = ?");
    }
    $check->bind_param("s", $code);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows == 1) {
        if ($role == "Student") {
            $stmt = $conn->prepare("INSERT INTO users (username, password, email, full_name, role, student_code) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $username, $password, $email, $full_name, $role, $code);
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username, password, email, full_name, role, lecturer_code) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $username, $password, $email, $full_name, $role, $code);
        }

        if ($stmt->execute()) {
            $message = "✅ Đăng ký thành công! <a href='login.php'>Đăng nhập ngay</a>";
        } else {
            $message = "❌ Lỗi khi đăng ký: " . $conn->error;
        }
    } else {
        $message = "⚠️ Mã $role không tồn tại trong danh sách!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Đăng ký - Hệ thống Quản lý Phòng học</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Roboto', sans-serif;
    }

    html, body {
        height: 100%;
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: #333;
    }

    .container {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .register-box {
        width: 100%;
        max-width: 350px;
        background: #fff;
        padding: 35px 25px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
        font-weight: 700;
    }

    .message {
        margin-bottom: 15px;
        font-size: 14px;
        color: #e74c3c;
    }

    .form-group {
        margin-bottom: 15px;
        text-align: left;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    input.form-control, select.form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
        transition: border-color 0.3s;
    }

    input.form-control:focus, select.form-control:focus {
        border-color: #2575fc;
        outline: none;
        box-shadow: 0 0 5px rgba(37, 117, 252, 0.5);
    }

    .btn-primary {
        width: 100%;
        padding: 12px;
        background-color: #2575fc;
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn-primary:hover {
        background-color: #6a11cb;
    }

    .register-link {
        margin-top: 12px;
        font-size: 14px;
    }

    .register-link a {
        color: #2575fc;
        text-decoration: none;
    }

    .register-link a:hover {
        text-decoration: underline;
    }

    footer.footer {
        font-size: 12px;
        color: #fff;
        text-align: center;
        padding: 15px 0;
    }
</style>
</head>
<body>
<div class="container">
    <div class="register-box">
        <h2>📝 Đăng ký tài khoản</h2>

        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

        <form method="POST">
            <div class="form-group">
                <label>Vai trò:</label>
                <select name="role" class="form-control" required>
                    <option value="Student">🎓 Sinh viên</option>
                    <option value="Lecturer">👨‍🏫 Giảng viên</option>
                </select>
            </div>

            <div class="form-group">
                <label>Mã Sinh viên / Giảng viên:</label>
                <input type="text" name="code" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Họ tên:</label>
                <input type="text" name="full_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Tên đăng nhập:</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Mật khẩu:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn-primary">Đăng ký</button>
        </form>

        <p class="register-link">🔙 Đã có tài khoản? <a href="login.php">Quay lại đăng nhập</a></p>
        <p class="register-link"><a href="index.php">← Quay lại trang chủ</a></p>
    </div>
</div>

<footer class="footer">
    &copy; 2025 - Hệ thống Quản lý Phòng học | Đại Học Đại Nam
</footer>
</body>
</html>
