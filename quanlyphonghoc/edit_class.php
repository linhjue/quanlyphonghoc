<?php
include("session.php");
include("config.php");

$id = (int)$_GET['id'];
$msg = "";

// Lấy dữ liệu lớp
$class = $conn->query("SELECT * FROM classes WHERE class_id=$id")->fetch_assoc();
$lecturers = $conn->query("SELECT user_id, fullname FROM users WHERE role='lecturer'");

if(isset($_POST['update_class'])){
    $class_code = trim($_POST['class_code']);
    $lecturer_id = (int)$_POST['lecturer_id'];
    $size = (int)$_POST['size'];
    $department = trim($_POST['department']);

    $stmt = $conn->prepare("UPDATE classes SET class_code=?, lecturer_id=?, size=?, department=? WHERE class_id=?");
    $stmt->bind_param("siisi", $class_code, $lecturer_id, $size, $department, $id);

    if($stmt->execute()){
        $msg = "Cập nhật lớp thành công!";
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
<title>Sửa lớp học</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<h2>Sửa lớp học</h2>
<a href="manage_classes.php" class="btn btn-secondary mb-3">Quay lại Danh sách</a>

<?php if($msg) echo "<div class='alert alert-info'>$msg</div>"; ?>

<form method="post">
<div class="mb-2">
<input type="text" name="class_code" class="form-control" value="<?= htmlspecialchars($class['class_code']) ?>" required>
</div>
<div class="mb-2">
<select name="lecturer_id" class="form-control" required>
<?php while($l = $lecturers->fetch_assoc()): ?>
<option value="<?= $l['user_id'] ?>" <?= $l['user_id']==$class['lecturer_id']?'selected':'' ?>><?= htmlspecialchars($l['fullname']) ?></option>
<?php endwhile; ?>
</select>
</div>
<div class="mb-2">
<input type="number" name="size" class="form-control" value="<?= htmlspecialchars($class['size']) ?>" required>
</div>
<div class="mb-2">
<input type="text" name="department" class="form-control" value="<?= htmlspecialchars($class['department']) ?>" required>
</div>
<button type="submit" name="update_class" class="btn btn-primary">Cập nhật lớp</button>
</form>
</div>
</body>
</html>
