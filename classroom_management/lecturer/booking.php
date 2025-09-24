<?php
include '../includes/header.php';
include '../includes/navbar.php';
include '../db.php';
include '../includes/auth.php';

// Lấy danh sách lớp do giảng viên đang login phụ trách
$user_id = $_SESSION['user_id'];
$classes = mysqli_query($conn, "SELECT * FROM classes WHERE lecturer_id = $user_id");

// Lấy danh sách phòng
$rooms = mysqli_query($conn, "SELECT * FROM rooms WHERE status='Available'");

// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_id = intval($_POST['class_id']);
    $room_id = intval($_POST['room_id']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $start_datetime = $date . ' ' . $start_time;
    $end_datetime = $date . ' ' . $end_time;

    $sql = "INSERT INTO booking_requests (user_id, room_id, purpose, start_time, end_time, status) 
            VALUES ($user_id, $room_id, '$purpose', '$start_datetime', '$end_datetime', 'Pending')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Yêu cầu mượn phòng đã gửi!'); window.location='booking.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi gửi yêu cầu!');</script>";
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Yêu cầu mượn phòng</h2>

    <form method="POST" class="p-4 border rounded bg-light">
        <div class="mb-3">
            <label for="class_id" class="form-label">Chọn lớp học</label>
            <select name="class_id" id="class_id" class="form-select" required>
                <?php while ($c = mysqli_fetch_assoc($classes)) { ?>
                    <option value="<?= $c['class_id'] ?>">
                        <?= $c['class_code'] ?> - <?= $c['department'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="room_id" class="form-label">Chọn phòng</label>
            <select name="room_id" id="room_id" class="form-select" required>
                <?php while ($r = mysqli_fetch_assoc($rooms)) { ?>
                    <option value="<?= $r['room_id'] ?>">
                        <?= $r['room_code'] ?> (<?= $r['building'] ?> - Tầng <?= $r['floor'] ?>)
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="purpose" class="form-label">Mục đích</label>
            <input type="text" name="purpose" id="purpose" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Ngày mượn</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Thời gian bắt đầu</label>
            <input type="time" name="start_time" id="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">Thời gian kết thúc</label>
            <input type="time" name="end_time" id="end_time" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
