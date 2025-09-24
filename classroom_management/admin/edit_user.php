<?php
include("../includes/auth.php");
include("../includes/header.php");
include("../includes/navbar.php");
include("../db.php");

$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$row = null;

if ($user_id > 0) {
    $result = mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id");
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['edit_user'])) {
    $id = intval($_POST['user_id']);
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);
    $role = mysqli_real_escape_string($conn, trim($_POST['role']));
    $student_code = mysqli_real_escape_string($conn, trim($_POST['student_code'] ?? ''));
    $lecturer_code = mysqli_real_escape_string($conn, trim($_POST['lecturer_code'] ?? ''));

    if (empty($username) || empty($full_name) || empty($email)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!'); window.location='edit_user.php?id=$id';</script>";
        exit;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email không hợp lệ!'); window.location='edit_user.php?id=$id';</script>";
        exit;
    } elseif (!empty($password) && strlen($password) < 6) {
        echo "<script>alert('Mật khẩu phải có ít nhất 6 ký tự!'); window.location='edit_user.php?id=$id';</script>";
        exit;
    }

    $check_username = mysqli_query($conn, "SELECT user_id FROM users WHERE username = '$username' AND user_id != $id");
    if (mysqli_num_rows($check_username) > 0) {
        echo "<script>alert('Username đã tồn tại!'); window.location='edit_user.php?id=$id';</script>";
        exit;
    }

    $check_email = mysqli_query($conn, "SELECT user_id FROM users WHERE email = '$email' AND user_id != $id");
    if (mysqli_num_rows($check_email) > 0) {
        echo "<script>alert('Email đã tồn tại!'); window.location='edit_user.php?id=$id';</script>";
        exit;
    }

    $update_fields = "username='$username', full_name='$full_name', email='$email', role='$role'";
    
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_fields .= ", password='$hashed_password'";
    }

    if ($role === 'Student') {
        if (empty($student_code)) {
            echo "<script>alert('Vui lòng nhập mã số sinh viên!'); window.location='edit_user.php?id=$id';</script>";
            exit;
        }
        $check_student_code = mysqli_query($conn, "SELECT user_id FROM users WHERE student_code = '$student_code' AND user_id != $id");
        if (mysqli_num_rows($check_student_code) > 0) {
            echo "<script>alert('Mã số sinh viên đã tồn tại!'); window.location='edit_user.php?id=$id';</script>";
            exit;
        }
        $update_fields .= ", student_code='$student_code', lecturer_code=NULL";
    } elseif ($role === 'Lecturer') {
        if (empty($lecturer_code)) {
            echo "<script>alert('Vui lòng nhập mã số giảng viên!'); window.location='edit_user.php?id=$id';</script>";
            exit;
        }
        $check_lecturer_code = mysqli_query($conn, "SELECT user_id FROM users WHERE lecturer_code = '$lecturer_code' AND user_id != $id");
        if (mysqli_num_rows($check_lecturer_code) > 0) {
            echo "<script>alert('Mã số giảng viên đã tồn tại!'); window.location='edit_user.php?id=$id';</script>";
            exit;
        }
        $update_fields .= ", student_code=NULL, lecturer_code='$lecturer_code'";
    } else { 
        $update_fields .= ", student_code=NULL, lecturer_code=NULL";
    }

    $sql = "UPDATE users SET $update_fields WHERE user_id=$id";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Cập nhật người dùng thành công!'); window.location='users.php';</script>";
    } else {
        $error = mysqli_error($conn);
        echo "<script>alert('Lỗi khi cập nhật người dùng: $error'); window.location='edit_user.php?id=$id';</script>";
    }
}
?>

<div class="container mt-4">
    <div class="mb-4">
        <h2 class="text-white">👤 Sửa thông tin người dùng</h2>
    </div>
    
    <div class="card">
        <div class="card-body">
            <?php if ($row) { ?>
                <form method="POST" class="needs-validation" novalidate>
                    <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Username *</label>
                                <input type="text" name="username" id="username" class="form-control" 
                                       value="<?= htmlspecialchars($row['username']) ?>" required>
                                <div class="invalid-feedback">Vui lòng nhập username.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="full_name" class="form-label">Họ tên *</label>
                                <input type="text" name="full_name" id="full_name" class="form-control" 
                                       value="<?= htmlspecialchars($row['full_name']) ?>" required>
                                <div class="invalid-feedback">Vui lòng nhập họ tên.</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" name="email" id="email" class="form-control" 
                                       value="<?= htmlspecialchars($row['email']) ?>" required>
                                <div class="invalid-feedback">Vui lòng nhập email hợp lệ.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Mật khẩu mới</label>
                                <input type="password" name="password" id="password" class="form-control" 
                                       placeholder="Để trống nếu không đổi">
                                <div class="form-text">Nhập mật khẩu mới (tối thiểu 6 ký tự nếu thay đổi).</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="role" class="form-label">Vai trò *</label>
                                <select name="role" id="role" class="form-select" required onchange="toggleCodeFields()">
                                    <option value="Admin" <?= $row['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="Lecturer" <?= $row['role'] == 'Lecturer' ? 'selected' : '' ?>>Giảng viên</option>
                                    <option value="Student" <?= $row['role'] == 'Student' ? 'selected' : '' ?>>Sinh viên</option>
                                </select>
                                <div class="invalid-feedback">Vui lòng chọn vai trò.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3 student-field" style="display: <?= $row['role'] === 'Student' ? 'block' : 'none' ?>;">
                                <label for="student_code" class="form-label">Mã số sinh viên *</label>
                                <input type="text" name="student_code" id="student_code" class="form-control" 
                                       value="<?= htmlspecialchars($row['student_code'] ?? '') ?>" 
                                       <?= $row['role'] === 'Student' ? 'required' : '' ?>>
                                <div class="invalid-feedback">Vui lòng nhập mã số sinh viên.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3 lecturer-field" style="display: <?= $row['role'] === 'Lecturer' ? 'block' : 'none' ?>;">
                                <label for="lecturer_code" class="form-label">Mã số giảng viên *</label>
                                <input type="text" name="lecturer_code" id="lecturer_code" class="form-control" 
                                       value="<?= htmlspecialchars($row['lecturer_code'] ?? '') ?>" 
                                       <?= $row['role'] === 'Lecturer' ? 'required' : '' ?>>
                                <div class="invalid-feedback">Vui lòng nhập mã số giảng viên.</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="users.php" class="btn btn-secondary">Hủy</a>
                        <button type="submit" name="edit_user" class="btn btn-primary">
                            <i class="bi bi-save"></i> Cập nhật
                        </button>
                    </div>
                </form>
            <?php } else { ?>
                <div class="text-center py-5">
                    <i class="bi bi-exclamation-triangle display-1 text-warning"></i>
                    <h3 class="mt-3">Không tìm thấy người dùng</h3>
                    <p class="text-muted">Người dùng có thể đã bị xóa hoặc ID không hợp lệ.</p>
                    <a href="users.php" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script>
function toggleCodeFields() {
    const role = document.getElementById("role").value;
    const studentField = document.querySelector(".student-field");
    const lecturerField = document.querySelector(".lecturer-field");
    const studentCodeInput = document.getElementById("student_code");
    const lecturerCodeInput = document.getElementById("lecturer_code");

    studentField.style.display = "none";
    lecturerField.style.display = "none";
    studentCodeInput.removeAttribute("required");
    lecturerCodeInput.removeAttribute("required");

    if (role === "Student") {
        studentField.style.display = "block";
        studentCodeInput.setAttribute("required", "required");
    } else if (role === "Lecturer") {
        lecturerField.style.display = "block";
        lecturerCodeInput.setAttribute("required", "required");
    }
}

document.addEventListener("DOMContentLoaded", function() {
    toggleCodeFields();
    
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});
</script>

<?php include("../includes/footer.php"); ?>