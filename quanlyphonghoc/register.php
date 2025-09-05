<?php
include("config.php");
session_start();

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']); 
    $password = $_POST['password'];
    $role = "student"; 

 
    if (empty($fullname) || empty($email) || empty($username) || empty($password)) {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    } elseif (!preg_match("/@gmail\.com$/", $email)) {
        $error = "Email phải có đuôi @gmail.com!";
    } elseif (strlen($password) < 6) {
        $error = "Mật khẩu phải có ít nhất 6 ký tự!";
    } else {
        $sql = "INSERT INTO users (fullname, email, user_name, password, role) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $fullname, $email, $username, $password, $role);

        if ($stmt->execute()) {
            $_SESSION['login_user'] = $username; 
            $_SESSION['role'] = $role; 
            header("Location: index.php");
            exit();
        }
        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng ký tài khoản</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #74ebd5, #ACB6E5);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .register-container {
      background: #fff;
      padding: 35px;
      border-radius: 12px;
      width: 420px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      animation: fadeIn 0.8s ease-in-out;
    }
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(-20px);}
      to {opacity: 1; transform: translateY(0);}
    }
    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }
    label {
      font-weight: bold;
      display: block;
      margin-top: 12px;
      color: #444;
    }
    input {
      width: 100%;
      padding: 12px;
      margin-top: 6px;
      border: 1px solid #ccc;
      border-radius: 6px;
      transition: border 0.3s;
    }
    input:focus {
      border-color: #007bff;
      outline: none;
    }
    input[type="submit"] {
      background: #28a745;
      color: white;
      border: none;
      margin-top: 20px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.3s;
    }
    input[type="submit"]:hover {
      background: #218838;
    }
    .message {
      text-align: center;
      margin-top: 12px;
    }
    .error { color: red; font-size: 14px; }
    .success { color: green; font-size: 14px; }
    .back-link {
      text-align: center;
      margin-top: 15px;
    }
    .back-link a {
      text-decoration: none;
      color: #007bff;
      font-size: 14px;
    }
    .back-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Đăng ký tài khoản</h2>
    <form method="post" action="">
      <label>Họ và tên:</label>
      <input type="text" name="fullname" placeholder="Nhập họ tên đầy đủ" required>

      <label>Email:</label>
      <input type="email" name="email" placeholder="Nhập email" required>

      <label>Tên đăng nhập:</label>
      <input type="text" name="username" placeholder="Tên đăng nhập" required>

      <label>Mật khẩu:</label>
      <input type="password" name="password" placeholder="Mật khẩu" required>

      <input type="submit" value="Đăng ký">
    </form>

    <div class="message">
      <?php if($error) echo "<p class='error'>$error</p>"; ?>
      <?php if($success) echo "<p class='success'>$success</p>"; ?>
    </div>

    <div class="back-link">
      <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
    </div>
  </div>
</body>
</html>
