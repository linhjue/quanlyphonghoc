<?php
include("../includes/auth.php"); // Kiểm tra đăng nhập và phân quyền
include("../includes/header.php"); // Phần đầu HTML
include("../includes/navbar.php"); // Menu
include("../db.php"); // Kết nối cơ sở dữ liệu

// Xử lý thêm người dùng
if (isset($_POST['add_user'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $role = mysqli_real_escape_string($conn, trim($_POST['role']));
    $student_code = mysqli_real_escape_string($conn, trim($_POST['student_code'] ?? ''));
    $lecturer_code = mysqli_real_escape_string($conn, trim($_POST['lecturer_code'] ?? ''));

    error_log("Add User: username=$username, full_name=$full_name, email=$email, role=$role, student_code=$student_code, lecturer_code=$lecturer_code");

    if (empty($username) || empty($full_name) || empty($email) || empty($password)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!'); window.location='users.php';</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email không hợp lệ!'); window.location='users.php';</script>";
    } elseif (strlen($password) < 6) {
        echo "<script>alert('Mật khẩu phải có ít nhất 6 ký tự!'); window.location='users.php';</script>";
    } else {
        $check_query = "SELECT * FROM users WHERE username = '$username'";
        $check_result = mysqli_query($conn, $check_query);
        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('Username đã tồn tại!'); window.location='users.php';</script>";
        } else {
            if ($role === 'Student' && empty($student_code)) {
                echo "<script>alert('Vui lòng nhập mã số sinh viên!'); window.location='users.php';</script>";
            } elseif ($role === 'Lecturer' && empty($lecturer_code)) {
                echo "<script>alert('Vui lòng nhập mã số giảng viên!'); window.location='users.php';</script>";
            } else {
                $check_code_query = "";
                if ($role === 'Student') {
                    $check_code_query = "SELECT * FROM users WHERE student_code = '$student_code'";
                } elseif ($role === 'Lecturer') {
                    $check_code_query = "SELECT * FROM users WHERE lecturer_code = '$lecturer_code'";
                }
                if ($check_code_query) {
                    $code_result = mysqli_query($conn, $check_code_query);
                    if (mysqli_num_rows($code_result) > 0) {
                        echo "<script>alert('Mã số đã tồn tại!'); window.location='users.php';</script>";
                    } else {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $sql = "INSERT INTO users (username, full_name, email, password, role, student_code, lecturer_code) 
                                VALUES ('$username', '$full_name', '$email', '$hashed_password', '$role', ";
                        $sql .= ($role === 'Student') ? "'$student_code', NULL" : "NULL, '$lecturer_code'";
                        $sql .= ")";
                        error_log("SQL: $sql");
                        if (mysqli_query($conn, $sql)) {
                            echo "<script>alert('Thêm người dùng thành công!'); window.location='users.php';</script>";
                        } else {
                            $error = mysqli_error($conn);
                            error_log("Error: $error");
                            echo "<script>alert('Lỗi khi thêm người dùng: $error'); window.location='users.php';</script>";
                        }
                    }
                }
            }
        }
    }
}

// Xử lý sửa người dùng
if (isset($_POST['edit_user'])) {
    $id = intval($_POST['user_id']);
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);
    $role = mysqli_real_escape_string($conn, trim($_POST['role']));
    $student_code = mysqli_real_escape_string($conn, trim($_POST['student_code'] ?? ''));
    $lecturer_code = mysqli_real_escape_string($conn, trim($_POST['lecturer_code'] ?? ''));

    error_log("Edit User: id=$id, username=$username, full_name=$full_name, email=$email, role=$role, student_code=$student_code, lecturer_code=$lecturer_code");

    if (empty($username) || empty($full_name) || empty($email)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!'); window.location='users.php';</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email không hợp lệ!'); window.location='users.php';</script>";
    } else {
        $update_fields = "username='$username', full_name='$full_name', email='$email', role='$role'";
        if (!empty($password)) {
            if (strlen($password) < 6) {
                echo "<script>alert('Mật khẩu phải có ít nhất 6 ký tự!'); window.location='users.php';</script>";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $update_fields .= ", password='$hashed_password'";
            }
        }
        if ($role === 'Student') {
            if (empty($student_code)) {
                echo "<script>alert('Vui lòng nhập mã số sinh viên!'); window.location='users.php';</script>";
            } else {
                $check_code_query = "SELECT * FROM users WHERE student_code = '$student_code' AND user_id != $id";
                $update_fields .= ", student_code='$student_code', lecturer_code=NULL";
            }
        } elseif ($role === 'Lecturer') {
            if (empty($lecturer_code)) {
                echo "<script>alert('Vui lòng nhập mã số giảng viên!'); window.location='users.php';</script>";
            } else {
                $check_code_query = "SELECT * FROM users WHERE lecturer_code = '$lecturer_code' AND user_id != $id";
                $update_fields .= ", student_code=NULL, lecturer_code='$lecturer_code'";
            }
        } else {
            $update_fields .= ", student_code=NULL, lecturer_code=NULL";
        }

        if (isset($check_code_query)) {
            $code_result = mysqli_query($conn, $check_code_query);
            if (mysqli_num_rows($code_result) > 0) {
                echo "<script>alert('Mã số đã tồn tại!'); window.location='users.php';</script>";
            } else {
                $sql = "UPDATE users SET $update_fields WHERE user_id=$id";
                error_log("SQL: $sql");
                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Cập nhật người dùng thành công!'); window.location='users.php';</script>";
                } else {
                    $error = mysqli_error($conn);
                    error_log("Error: $error");
                    echo "<script>alert('Lỗi khi cập nhật người dùng: $error'); window.location='users.php';</script>";
                }
            }
        } else {
            $sql = "UPDATE users SET $update_fields WHERE user_id=$id";
            error_log("SQL: $sql");
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Cập nhật người dùng thành công!'); window.location='users.php';</script>";
            } else {
                $error = mysqli_error($conn);
                error_log("Error: $error");
                echo "<script>alert('Lỗi khi cập nhật người dùng: $error'); window.location='users.php';</script>";
            }
        }
    }
}

// Xử lý xóa người dùng
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    mysqli_begin_transaction($conn);
    
    try {
        mysqli_query($conn, "DELETE FROM booking_requests WHERE user_id=$id");
        mysqli_query($conn, "DELETE FROM enrollments WHERE student_id=$id");
        if (mysqli_query($conn, "DELETE FROM users WHERE user_id=$id")) {
            mysqli_commit($conn);
            echo "<script>alert('Xóa người dùng thành công!'); window.location='users.php';</script>";
        } else {
            throw new Exception("Lỗi khi xóa người dùng!");
        }
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script>alert('Lỗi: " . $e->getMessage() . "');</script>";
    }
}

// Xử lý tìm kiếm
$search_query = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $search_query = "WHERE username LIKE '%$search%' OR full_name LIKE '%$search%' OR email LIKE '%$search%' OR student_code LIKE '%$search%' OR lecturer_code LIKE '%$search%'";
}

$result = mysqli_query($conn, "SELECT * FROM users $search_query ORDER BY user_id DESC");
?>

<div class="container mt-4">
    <div class="mb-4">
        <h2 class="text-white">👥 Quản lý người dùng</h2>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="input-group w-50">
            <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm..." 
                   onkeyup="searchUsers()">
            <button class="btn btn-outline-secondary" type="button">
                <i class="bi bi-search"></i>
            </button>
        </div>
        <a href="add_user.php" class="btn btn-success">
            <i class="bi bi-person-plus"></i> Thêm người dùng
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0" id="usersTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Mã số sinh viên</th>
                        <th>Mã số giảng viên</th>
                        <th>Vai trò</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><span class="badge bg-secondary"><?= $row['user_id'] ?></span></td>
                        <td><strong><?= htmlspecialchars($row['username']) ?></strong></td>
                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['student_code'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['lecturer_code'] ?? '-') ?></td>
                        <td>
                            <?php
                            $role_colors = [
                                'Admin' => 'bg-danger',
                                'Lecturer' => 'bg-primary', 
                                'Student' => 'bg-success'
                            ];
                            $color = $role_colors[$row['role']] ?? 'bg-secondary';
                            ?>
                            <span class="badge <?= $color ?>"><?= $row['role'] ?></span>
                        </td>
                        <td>
                            <a href="edit_user.php?id=<?= $row['user_id'] ?>" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $row['user_id'] ?>">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="users.php?delete=<?= $row['user_id'] ?>" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');" 
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

<script>
function searchUsers() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let table = document.getElementById("usersTable");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let tdUsername = tr[i].getElementsByTagName("td")[1];
        let tdFullName = tr[i].getElementsByTagName("td")[2];
        let tdEmail = tr[i].getElementsByTagName("td")[3];
        let tdStudentCode = tr[i].getElementsByTagName("td")[4];
        let tdLecturerCode = tr[i].getElementsByTagName("td")[5];
        if (tdUsername || tdFullName || tdEmail || tdStudentCode || tdLecturerCode) {
            let txtUsername = tdUsername.textContent.toLowerCase() || "";
            let txtFullName = tdFullName.textContent.toLowerCase() || "";
            let txtEmail = tdEmail.textContent.toLowerCase() || "";
            let txtStudentCode = tdStudentCode.textContent.toLowerCase() || "";
            let txtLecturerCode = tdLecturerCode.textContent.toLowerCase() || "";
            if (txtUsername.indexOf(input) > -1 || txtFullName.indexOf(input) > -1 || txtEmail.indexOf(input) > -1 || txtStudentCode.indexOf(input) > -1 || txtLecturerCode.indexOf(input) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>

<?php include("../includes/footer.php"); ?>