<?php
include("session.php"); 
include("config.php"); 


if(strtolower($_SESSION['role']) != 'admin'){
    header("Location: index.php");
    exit();
}

$message = ""; 

if(isset($_POST['add_user'])){
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE user_name=? OR email=? LIMIT 1");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows > 0){
        $message = "Username hoặc Email đã tồn tại. Vui lòng thử lại.";
    } else {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO users (fullname, user_name, password, email, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fullname, $username, $password, $email, $role);
        if($stmt->execute()){
            $message = "Thêm user thành công!";
        } else {
            $message = "Không thể thêm user. Vui lòng thử lại.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Thêm người dùng mới</h2>
    <a href="manage_users.php" class="btn btn-secondary mb-3">Quay lại</a>

    <!-- Thông báo -->
    <?php if($message != ""): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="post">
                <div class="mb-2">
                    <input type="text" name="fullname" class="form-control" placeholder="Họ và tên" required>
                </div>
                <div class="mb-2">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-2">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-2">
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
                </div>
                <div class="mb-2">
                    <select name="role" class="form-control" required>
                        <option value="admin">Admin</option>
                        <option value="lecturer">Lecturer</option>
                        <option value="student">Student</option>
                    </select>
                </div>
                <button type="submit" name="add_user" class="btn btn-success">Thêm User</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
