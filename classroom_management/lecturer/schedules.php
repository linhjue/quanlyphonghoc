<?php
include '../includes/header.php';
include '../includes/navbar.php';
include '../db.php';
include '../includes/auth.php';

// Lấy ID giảng viên đang đăng nhập
$lecturer_id = $_SESSION['user_id'];

// Truy vấn lịch giảng dạy
$sql = "SELECT s.schedule_id, c.class_code, r.room_code, r.building, r.floor,
               s.start_time, s.end_time, s.day_of_week
        FROM schedules s
        JOIN classes c ON s.class_id = c.class_id
        JOIN rooms r ON s.room_id = r.room_id
        WHERE s.lecturer_id = $lecturer_id
        ORDER BY s.start_time ASC";
$result = mysqli_query($conn, $sql);
?>

<div class="container mt-5">
    <h2 class="mb-4">📅 Lịch giảng dạy</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Mã lớp</th>
                <th>Phòng</th>
                <th>Tòa - Tầng</th>
                <th>Ngày trong tuần</th>
                <th>Bắt đầu</th>
                <th>Kết thúc</th>
            </tr>
        </thead>
        <tbody>
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $row['class_code'] ?></td>
                    <td><?= $row['room_code'] ?></td>
                    <td><?= $row['building'] ?> - Tầng <?= $row['floor'] ?></td>
                    <td>
                        <?php
                        $days = [
                            'Mon' => 'Thứ 2',
                            'Tue' => 'Thứ 3',
                            'Wed' => 'Thứ 4',
                            'Thu' => 'Thứ 5',
                            'Fri' => 'Thứ 6',
                            'Sat' => 'Thứ 7',
                            'Sun' => 'Chủ nhật'
                        ];
                        echo $days[$row['day_of_week']];
                        ?>
                    </td>
                    <td><?= date("H:i", strtotime($row['start_time'])) ?></td>
                    <td><?= date("H:i", strtotime($row['end_time'])) ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6" class="text-center text-muted">Không có lịch dạy nào</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
