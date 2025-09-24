<?php
include("../includes/auth.php");
include("../includes/header.php");
include("../includes/navbar.php");
include("../db.php");

// Xử lý thêm lịch học
if (isset($_POST['add_schedule'])) {
    $class_id = intval($_POST['class_id']);
    $room_id = intval($_POST['room_id']);
    $lecturer_id = intval($_POST['lecturer_id']);
    $start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($conn, $_POST['end_time']);
    $day_of_week = mysqli_real_escape_string($conn, $_POST['day_of_week']);

    $sql = "INSERT INTO schedules (class_id, room_id, lecturer_id, start_time, end_time, day_of_week) 
            VALUES ('$class_id', '$room_id', '$lecturer_id', '$start_time', '$end_time', '$day_of_week')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Thêm lịch học thành công!'); window.location='schedules.php';</script>";
    } else {
        echo "<script>alert('Lỗi: " . mysqli_error($conn) . "');</script>";
    }
}

// Xử lý xóa lịch
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if (mysqli_query($conn, "DELETE FROM schedules WHERE schedule_id=$id")) {
        echo "<script>alert('Xóa lịch học thành công!'); window.location='schedules.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa lịch học!');</script>";
    }
}

// Lấy danh sách lịch học (join bảng)
$result = mysqli_query($conn, "
    SELECT s.*, c.class_code, r.room_code, r.building, r.floor, u.full_name AS lecturer_name 
    FROM schedules s
    LEFT JOIN classes c ON s.class_id = c.class_id
    LEFT JOIN rooms r ON s.room_id = r.room_id
    LEFT JOIN users u ON s.lecturer_id = u.user_id
    ORDER BY s.day_of_week, s.start_time
");

// Lấy danh sách lớp, phòng, giảng viên
$classes = mysqli_query($conn, "SELECT class_id, class_code FROM classes ORDER BY class_code");
$rooms = mysqli_query($conn, "SELECT room_id, room_code, building, floor FROM rooms WHERE status='Available' ORDER BY building, floor, room_code");
$lecturers = mysqli_query($conn, "SELECT user_id, full_name FROM users WHERE role='Lecturer' ORDER BY full_name");
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white">📅 Quản lý lịch học</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
            <i class="bi bi-calendar-plus"></i> Thêm lịch học
        </button>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Mã lớp</th>
                        <th>Phòng học</th>
                        <th>Giảng viên</th>
                        <th>Ngày</th>
                        <th>Thời gian</th>
                        <th width="120">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $day_names = [
                        'Mon' => 'Thứ 2',
                        'Tue' => 'Thứ 3', 
                        'Wed' => 'Thứ 4',
                        'Thu' => 'Thứ 5',
                        'Fri' => 'Thứ 6',
                        'Sat' => 'Thứ 7',
                        'Sun' => 'CN'
                    ];
                    
                    while ($row = mysqli_fetch_assoc($result)) { 
                    ?>
                    <tr>
                        <td><span class="badge bg-secondary"><?= $row['schedule_id'] ?></span></td>
                        <td><strong><?= htmlspecialchars($row['class_code'] ?? 'N/A') ?></strong></td>
                        <td>
                            <?php if($row['room_code']): ?>
                                <strong><?= htmlspecialchars($row['room_code']) ?></strong>
                                <br><small class="text-muted"><?= htmlspecialchars($row['building']) ?> - Tầng <?= $row['floor'] ?></small>
                            <?php else: ?>
                                <span class="text-muted">N/A</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['lecturer_name'] ?? 'Chưa phân công') ?></td>
                        <td>
                            <span class="badge bg-primary"><?= $day_names[$row['day_of_week']] ?? $row['day_of_week'] ?></span>
                        </td>
                        <td>
                            <strong><?= date("H:i", strtotime($row['start_time'])) ?></strong>
                            - 
                            <strong><?= date("H:i", strtotime($row['end_time'])) ?></strong>
                        </td>
                        <td>
                            <a href="schedules.php?delete=<?= $row['schedule_id'] ?>" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa lịch học này?');" 
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

<!-- Modal thêm lịch -->
<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm lịch học mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group mb-3">
                        <label>Lớp học *</label>
                        <select name="class_id" class="form-control" required>
                            <option value="">-- Chọn lớp học --</option>
                            <?php 
                            mysqli_data_seek($classes, 0);
                            while ($c = mysqli_fetch_assoc($classes)) { 
                            ?>
                                <option value="<?= $c['class_id'] ?>"><?= htmlspecialchars($c['class_code']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Phòng học *</label>
                        <select name="room_id" class="form-control" required>
                            <option value="">-- Chọn phòng --</option>
                            <?php 
                            mysqli_data_seek($rooms, 0);
                            while ($r = mysqli_fetch_assoc($rooms)) { 
                            ?>
                                <option value="<?= $r['room_id'] ?>">
                                    <?= htmlspecialchars($r['room_code']) ?> - <?= htmlspecialchars($r['building']) ?> T<?= $r['floor'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Giảng viên *</label>
                        <select name="lecturer_id" class="form-control" required>
                            <option value="">-- Chọn giảng viên --</option>
                            <?php 
                            mysqli_data_seek($lecturers, 0);
                            while ($lec = mysqli_fetch_assoc($lecturers)) { 
                            ?>
                                <option value="<?= $lec['user_id'] ?>"><?= htmlspecialchars($lec['full_name']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Ngày trong tuần *</label>
                        <select name="day_of_week" class="form-control" required>
                            <option value="Mon">Thứ 2</option>
                            <option value="Tue">Thứ 3</option>
                            <option value="Wed">Thứ 4</option>
                            <option value="Thu">Thứ 5</option>
                            <option value="Fri">Thứ 6</option>
                            <option value="Sat">Thứ 7</option>
                            <option value="Sun">Chủ nhật</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Thời gian bắt đầu *</label>
                                <input type="time" name="start_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Thời gian kết thúc *</label>
                                <input type="time" name="end_time" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="add_schedule" class="btn btn-primary">Thêm lịch học</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>