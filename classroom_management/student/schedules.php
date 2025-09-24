<?php
session_start();
include("../db.php");

// Kiểm tra đăng nhập + đúng role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Student') {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['user_id'];

// Lấy toàn bộ lịch học của sinh viên
$sql = "
    SELECT c.class_code AS class_name, s.start_time, s.end_time, s.day_of_week, r.room_id
    FROM enrollments e
    JOIN classes c ON e.class_id = c.class_id
    JOIN schedules s ON s.class_id = c.class_id
    JOIN rooms r ON s.room_id = r.room_id
    WHERE e.student_id = '$student_id'
    ORDER BY s.start_time ASC
";

$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch học của tôi</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Lịch học của bạn</h2>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Môn học</th>
            <th>Ngày giờ bắt đầu</th>
            <th>Ngày giờ kết thúc</th>
            <th>Thứ</th>
            <th>Phòng</th>
        </tr>
        <?php if ($result && mysqli_num_rows($result) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
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
                <td colspan="5">Bạn chưa có lịch học nào</td>
            </tr>
        <?php } ?>
    </table>

    <br>
    <a href="dashboard.php">⬅ Quay lại Dashboard</a> |
    <a href="../logout.php">Đăng xuất</a>
</body>
</html>
