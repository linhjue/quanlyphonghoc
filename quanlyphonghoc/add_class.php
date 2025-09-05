<?php
include("session.php");
include("config.php");

$msg = "";

// Lấy danh sách giảng viên
$lecturers = $conn->query("SELECT user_id, fullname FROM users WHERE role='lecturer' ORDER BY fullname");

if(isset($_POST['add_class'])){
    $class_code = trim($_POST['class_code']);
    $lecturer_id = (int)$_POST['lecturer_id'];
    $size = (int)$_POST['size'];
    $department = trim($_POST['department']);

    $stmt = $conn->prepare("INSERT INTO classes (class_code, lecturer_id, size, department) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siis", $class_code, $lecturer_id, $size, $department);

    if($stmt->execute()){
        $msg = "Thêm lớp thành công!";
    } else {
        $msg = "Lỗi: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm lớp học</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<h2>Thêm lớp học mới</h2>
<a href="manage_classes.php" class="btn btn-secondary mb-3">Quay lại Danh sách</a>

<?php if($msg) echo "<div class='alert alert-info'>$msg</div>"; ?>

<form method="post">
<div class="mb-2">
<input type="text" name="class_code" class="form-control" placeholder="Class Code" required>
</div>
<div class="mb-2">
<select name="lecturer_id" class="form-control" required>
<option value="">-- Chọn giảng viên --</option>
<?php while($l = $lecturers->fetch_assoc()): ?>
<option value="<?= $l['user_id'] ?>"><?= htmlspecialchars($l['fullname']) ?></option>
<?php endwhile; ?>
</select>
</div>
<div class="mb-2">
<input type="number" name="size" class="form-control" placeholder="Size" required>
</div>
<div class="mb-2">
<input type="text" name="department" class="form-control" placeholder="Department" required>
</div>
<button type="submit" name="add_class" class="btn btn-success">Thêm lớp</button>
</form>
</div>
</body>
</html>
