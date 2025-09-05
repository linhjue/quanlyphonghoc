<?php
include("session.php"); 
include("config.php"); 

if(strtolower($_SESSION['role']) != 'admin'){
    header("Location: index.php");
    exit();
}

if(isset($_GET['delete'])){
    $userid = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id=?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_users.php");
    exit();
}

$result = $conn->query("SELECT user_id, fullname, user_name, email, role FROM users");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Quản lý Users</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Quay lại</a>
    <a href="add_user.php" class="btn btn-success mb-3">Thêm User mới</a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>UserId</th>
                <th>FullName</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['fullname']; ?></td>
                <td><?php echo $row['user_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-primary btn-sm">Sửa</a>
                    <a href="manage_users.php?delete=<?php echo $row['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">Xóa</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
