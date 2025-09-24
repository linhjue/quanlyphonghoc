<?php
session_start();
include("../db.php");
include '../includes/header.php';
include '../includes/navbar.php';
include '../db.php';
include '../includes/auth.php';
// Kiểm tra đăng nhập + đúng role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Student') {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['user_id'];

// Lấy thông tin sinh viên
$query = "SELECT full_name FROM users WHERE user_id = '$student_id'";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);

// Lấy 5 lịch học gần nhất
$sql_schedules = "
    SELECT c.class_code AS class_name, s.start_time, s.end_time, s.day_of_week, r.room_id
    FROM enrollments e
    JOIN classes c ON e.class_id = c.class_id
    JOIN schedules s ON s.class_id = c.class_id
    JOIN rooms r ON s.room_id = r.room_id
    WHERE e.student_id = '$student_id'
      AND s.start_time >= NOW()
    ORDER BY s.start_time ASC
    LIMIT 5
";
$result_schedules = mysqli_query($conn, $sql_schedules);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Sinh viên</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Xin chào, <?php echo htmlspecialchars($student['full_name']); ?> 👋</h2>

    <h3>Lịch học sắp tới</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Môn học</th>
            <th>Ngày giờ bắt đầu</th>
            <th>Ngày giờ kết thúc</th>
            <th>Thứ</th>
            <th>Phòng</th>
        </tr>
        <?php if ($result_schedules && mysqli_num_rows($result_schedules) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result_schedules)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['start_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['end_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['day_of_week']); ?></td>
                    <td><?php echo htmlspecialchars($row['room_id']); ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="5">Không có lịch học sắp tới</td>
            </tr>
        <?php } ?>
    </table>

    <br>
    <a href="schedules.php">Xem toàn bộ lịch học</a> |
    <a href="../logout.php">Đăng xuất</a>
</body>
</html>
