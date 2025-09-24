<?php
include("../includes/auth.php");
include("../includes/header.php");
include("../includes/navbar.php");
include("../db.php");

// Xử lý thêm lớp
if (isset($_POST['add_class'])) {
    $class_code = mysqli_real_escape_string($conn, $_POST['class_code']);
    $lecturer_id = intval($_POST['lecturer_id']);
    $size = intval($_POST['size']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);

    $sql = "INSERT INTO classes (class_code, lecturer_id, size, department) 
            VALUES ('$class_code', '$lecturer_id', '$size', '$department')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Thêm lớp học thành công!'); window.location='classes.php';</script>";
    } else {
        echo "<script>alert('Lỗi: " . mysqli_error($conn) . "');</script>";
    }
}

// Xử lý xóa lớp
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if (mysqli_query($conn, "DELETE FROM classes WHERE class_id=$id")) {
        echo "<script>alert('Xóa lớp học thành công!'); window.location='classes.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa lớp học!');</script>";
    }
}

// Lấy danh sách lớp + giảng viên
$result = mysqli_query($conn, "
    SELECT c.*, u.full_name AS lecturer_name 
    FROM classes c 
    LEFT JOIN users u ON c.lecturer_id = u.user_id
    ORDER BY c.class_id DESC
");

// Lấy danh sách giảng viên để chọn khi thêm lớp
$lecturers = mysqli_query($conn, "SELECT user_id, full_name FROM users WHERE role='Lecturer'");
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white">📚 Quản lý lớp học</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addClassModal">
            <i class="bi bi-journal-plus"></i> Thêm lớp học
        </button>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Mã lớp</th>
                        <th>Giảng viên</th>
                        <th>Sĩ số</th>
                        <th>Khoa/Bộ môn</th>
                        <th width="120">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><span class="badge bg-secondary"><?= $row['class_id'] ?></span></td>
                        <td><strong><?= htmlspecialchars($row['class_code']) ?></strong></td>
                        <td>
                            <?php if($row['lecturer_name']): ?>
                                <i class="bi bi-person-check text-success"></i>
                                <?= htmlspecialchars($row['lecturer_name']) ?>
                            <?php else: ?>
                                <i class="bi bi-person-x text-warning"></i>
                                <em class="text-muted">Chưa phân công</em>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($row['size']): ?>
                                <span class="badge bg-info"><?= $row['size'] ?> SV</span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['department']) ?></td>
                        <td>
                            <a href="classes.php?delete=<?= $row['class_id'] ?>" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa lớp học này?');" 
                               class="btn btn-danger btn-sm">
                               <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal thêm lớp -->
<div class="modal fade" id="addClassModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm lớp học mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group mb-3">
                        <label>Mã lớp *</label>
                        <input type="text" name="class_code" class="form-control" 
                               placeholder="VD: IT101, MAT201..." required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Giảng viên phụ trách</label>
                        <select name="lecturer_id" class="form-control">
                            <option value="">-- Chọn giảng viên --</option>
                            <?php 
                            mysqli_data_seek($lecturers, 0); // Reset pointer
                            while ($lec = mysqli_fetch_assoc($lecturers)) { 
                            ?>
                                <option value="<?= $lec['user_id'] ?>"><?= htmlspecialchars($lec['full_name']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Sĩ số</label>
                        <input type="number" name="size" class="form-control" 
                               placeholder="Số sinh viên dự kiến" min="1" max="200">
                    </div>
                    <div class="form-group mb-3">
                        <label>Khoa/Bộ môn</label>
                        <input type="text" name="department" class="form-control" 
                               placeholder="VD: Công nghệ thông tin, Toán học...">
                    </div>
                    <button type="submit" name="add_class" class="btn btn-primary">Thêm lớp học</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>