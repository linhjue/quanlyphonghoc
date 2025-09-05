<?php
include("session.php");
include("config.php");

if(strtolower($_SESSION['role']) != 'admin'){
    header("Location: index.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: manage_users.php");
    exit();
}

$userid = $_GET['id'];

$stmt = $conn->prepare("SELECT fullname, user_name, email, role FROM users WHERE user_id=?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if(isset($_POST['update_user'])){
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET fullname=?, user_name=?, email=?, role=? WHERE user_id=?");
    $stmt->bind_param("ssssi", $fullname, $username, $email, $role, $userid);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Sửa User</h2>
    <a href="manage_users.php" class="btn btn-secondary mb-3">Quay lại</a>

    <form method="post">
        <div class="mb-2">
            <input type="text" name="fullname" class="form-control" placeholder="Họ và tên" value="<?php echo $user['fullname']; ?>" required>
        </div>
        <div class="mb-2">
            <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $user['user_name']; ?>" required>
        </div>
        <div class="mb-2">
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $user['email']; ?>" required>
        </div>
        <div class="mb-2">
            <select name="role" class="form-control" required>
                <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
                <option value="lecturer" <?php if($user['role']=='lecturer') echo 'selected'; ?>>Lecturer</option>
                <option value="student" <?php if($user['role']=='student') echo 'selected'; ?>>Student</option>
            </select>
        </div>
        <button type="submit" name="update_user" class="btn btn-primary">Cập nhật User</button>
    </form>
</div>
</body>
</html>
