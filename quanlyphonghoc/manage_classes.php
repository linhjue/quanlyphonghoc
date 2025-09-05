<?php
include("session.php");
include("config.php");

$role = strtolower($_SESSION['role']);
$username = htmlspecialchars($_SESSION['login_user']);

// Xử lý xóa
if(isset($_GET['delete'])){
    $class_id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM classes WHERE class_id=?");
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_classes.php");
    exit();
}

// Lấy danh sách lớp học kèm tên giảng viên
$query = "SELECT c.class_id, c.class_code, c.size, c.department, u.fullname AS lecturer_name
          FROM classes c
          LEFT JOIN users u ON c.lecturer_id = u.user_id
          ORDER BY c.class_code";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý Classes</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<h2>Danh sách Classes</h2>
<a href="add_class.php" class="btn btn-success mb-3">Thêm lớp mới</a>
<a href="index.php" class="btn btn-secondary mb-3">Quay lại Dashboard</a>

<table class="table table-bordered">
<thead class="table-light">
<tr>
<th>ID</th>
<th>Class Code</th>
<th>Lecturer</th>
<th>Size</th>
<th>Department</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php if($result->num_rows > 0): ?>
    <?php while($class = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $class['class_id'] ?></td>
        <td><?= htmlspecialchars($class['class_code']) ?></td>
        <td><?= htmlspecialchars($class['lecturer_name']) ?></td>
        <td><?= htmlspecialchars($class['size']) ?></td>
        <td><?= htmlspecialchars($class['department']) ?></td>
        <td>
            <a href="edit_class.php?id=<?= $class['class_id'] ?>" class="btn btn-primary btn-sm">Sửa</a>
            <a href="manage_classes.php?delete=<?= $class['class_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa lớp này?');">Xóa</a>
        </td>
    </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr><td colspan="6" class="text-center">Chưa có lớp học nào.</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
</body>
</html>
