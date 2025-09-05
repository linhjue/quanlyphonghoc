<?php
session_start();
include("config.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; 
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE user_name = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            $_SESSION['login_user'] = $row['user_name'];
            $_SESSION['role'] = $row['role'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Sai mật khẩu!";
        }
    } else {
        $error = "Không tìm thấy tài khoản!";
    }
}
?>



<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập hệ thống</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icon (Bootstrap Icons) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .login-card {
      width: 100%;
      max-width: 420px;
      padding: 30px;
      border-radius: 20px;
      background: #fff;
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
      animation: fadeIn 0.8s ease;
    }
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(-20px);}
      to {opacity: 1; transform: translateY(0);}
    }
    .login-title {
      text-align: center;
      font-weight: bold;
      margin-bottom: 25px;
      color: #333;
    }
    .input-group-text {
      background: #f1f1f1;
      border-right: none;
    }
    .form-control {
      border-left: none;
    }
    .btn-login {
      background: linear-gradient(45deg, #667eea, #764ba2);
      border: none;
      color: white;
      font-weight: bold;
      transition: 0.3s;
    }
    .btn-login:hover {
      opacity: 0.9;
    }
    .extra-links {
      text-align: center;
      margin-top: 15px;
    }
    .extra-links a {
      text-decoration: none;
      color: #667eea;
      font-weight: 500;
      margin: 0 8px;
    }
    .extra-links a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <h3 class="login-title"><i class="bi bi-person-circle"></i> Đăng nhập</h3>
    
    <?php if ($error != ""): ?>
      <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post" action="">
      <div class="mb-3 input-group">
        <span class="input-group-text"><i class="bi bi-person"></i></span>
        <input type="text" name="username" class="form-control" placeholder="Tên đăng nhập" required>
      </div>
      <div class="mb-3 input-group">
        <span class="input-group-text"><i class="bi bi-lock"></i></span>
        <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
      </div>
      <button type="submit" class="btn btn-login w-100 py-2">Đăng nhập</button>
    </form>

    <div class="extra-links">
      <a href="register.php">Đăng ký</a> |
      <a href="forgot_password.php">Quên mật khẩu?</a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
