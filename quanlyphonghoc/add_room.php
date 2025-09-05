<?php
include("session.php");
include("config.php");

$role = strtolower($_SESSION['role']);
if($role !== 'admin'){
    header("Location: index.php");
    exit();
}

$msg = "";

// Danh sách giá trị hợp lệ
$allowed_types  = ['Lecture','Lab','Seminar','Other'];
$allowed_status = ['Available','Maintenance','Inactive'];

if(isset($_POST['add_room'])){
    $room_code = trim($_POST['room_code']);
    $building  = trim($_POST['building']);
    $floor     = (int)$_POST['floor'];
    $capacity  = (int)$_POST['capacity'];
    $room_type = trim($_POST['room_type']);
    $status    = trim($_POST['status']);
    $note      = trim($_POST['note']);

    // Kiểm tra giá trị hợp lệ
    if(!in_array($room_type, $allowed_types)){
        $msg = "Loại phòng không hợp lệ!";
    } elseif(!in_array($status, $allowed_status)){
        $msg = "Trạng thái phòng không hợp lệ!";
    } else {
        $stmt = $conn->prepare("INSERT INTO rooms (room_code, building, floor, capacity, room_type, status, note) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $room_code, $building, $floor, $capacity, $room_type, $status, $note);

        if($stmt->execute()){
            $msg = "Thêm phòng học thành công!";
        } else {
            // Hiển thị lỗi chi tiết nếu có
            $msg = "Lỗi: Không thể thêm phòng học. " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm phòng học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Thêm phòng học mới</h2>
    <a href="manage_rooms.php" class="btn btn-secondary mb-3">Quay lại Quản lý Phòng</a>

    <?php if($msg) echo "<div class='alert alert-info'>$msg</div>"; ?>

    <form method="post">
        <div class="mb-2">
            <input type="text" name="room_code" class="form-control" placeholder="Room Code" required>
        </div>
        <div class="mb-2">
            <input type="text" name="building" class="form-control" placeholder="Building" required>
        </div>
        <div class="mb-2">
            <input type="number" name="floor" class="form-control" placeholder="Floor" required>
        </div>
        <div class="mb-2">
            <input type="number" name="capacity" class="form-control" placeholder="Capacity" required>
        </div>
        <div class="mb-2">
            <select name="room_type" class="form-control" required>
                <?php foreach($allowed_types as $type): ?>
                    <option value="<?= $type ?>"><?= $type ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-2">
            <select name="status" class="form-control" required>
                <?php foreach($allowed_status as $st): ?>
                    <option value="<?= $st ?>"><?= $st ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-2">
            <input type="text" name="note" class="form-control" placeholder="Note">
        </div>
        <button type="submit" name="add_room" class="btn btn-success">Thêm Phòng</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
