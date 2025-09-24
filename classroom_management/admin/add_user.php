<?php
include("../includes/auth.php");
include("../includes/header.php");
include("../includes/navbar.php");
include("../db.php");
?>

<div class="container mt-4">
    <div class="mb-4">
        <h2 class="text-white">👤 Thêm người dùng mới</h2>
    </div>
    <div class="card p-4">
        <div class="card-body">
            <form method="POST" action="users.php" id="addUserForm">
                <div class="form-group mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="full_name" class="form-label">Họ tên</label>
                    <input type="text" name="full_name" id="full_name" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="form-group mb-4">
                    <label for="role" class="form-label">Vai trò</label>
                    <select name="role" id="role" class="form-select" required onchange="toggleCodeFields()">
                        <option value="Admin">Admin</option>
                        <option value="Lecturer">Giảng viên</option>
                        <option value="Student">Sinh viên</option>
                    </select>
                </div>
                <div class="form-group mb-3 student-field" style="display: none;">
                    <label for="student_code" class="form-label">Mã số sinh viên</label>
                    <input type="text" name="student_code" id="student_code" class="form-control">
                </div>
                <div class="form-group mb-4 lecturer-field" style="display: none;">
                    <label for="lecturer_code" class="form-label">Mã số giảng viên</label>
                    <input type="text" name="lecturer_code" id="lecturer_code" class="form-control">
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="users.php" class="btn btn-secondary" onclick="return confirm('Bạn có chắc chắn muốn quay lại? Dữ liệu sẽ không được lưu.');">Quay lại</a>
                    <button type="submit" name="add_user" class="btn btn-primary">Thêm người dùng</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleCodeFields() {
    const role = document.getElementById("role").value;
    const studentField = document.querySelector(".student-field");
    const lecturerField = document.querySelector(".lecturer-field");

    if (role === "Student") {
        studentField.style.display = "block";
        lecturerField.style.display = "none";
        document.getElementById("student_code").setAttribute("required", "required");
        document.getElementById("lecturer_code").removeAttribute("required");
    } else if (role === "Lecturer") {
        studentField.style.display = "none";
        lecturerField.style.display = "block";
        document.getElementById("student_code").removeAttribute("required");
        document.getElementById("lecturer_code").setAttribute("required", "required");
    } else {
        studentField.style.display = "none";
        lecturerField.style.display = "none";
        document.getElementById("student_code").removeAttribute("required");
        document.getElementById("lecturer_code").removeAttribute("required");
    }
}

document.addEventListener("DOMContentLoaded", function() {
    toggleCodeFields();
});
</script>

<?php include("../includes/footer.php"); ?>