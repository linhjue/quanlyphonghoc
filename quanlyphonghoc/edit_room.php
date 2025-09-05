<?php
include("session.php");
include("config.php");

$role = strtolower($_SESSION['role']);
if($role !== 'admin'){
    header("Location: index.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: manage_rooms.php");
    exit();
}

$room_id = $_GET['id'];
$result = $conn->query("SELECT * FROM rooms WHERE room_id=$room_id");
$room = $result->fetch_assoc();

if(!$room){
    header("Location: manage_rooms.php");
    exit();
}

if(isset($_POST['update_room'])){
    $room_code = $_POST['room_code'];
    $building = $_POST['building'];
    $floor = $_POST['floor'];
    $capacity = $_POST['capacity'];
    $room_type = $_POST['room_type'];
    $status = $_POST['status'];
    $note = $_POST['note'];

    $stmt = $conn->prepare("UPDATE rooms SET room_code=?, building=?, floor=?, capacity=?, room_type=?, status=?, note=? WHERE room_id=?");
    $stmt->bind_param("ssiiissi", $room_code, $building, $floor, $capacity, $room_type, $status, $note, $room_id);
    if($stmt->execute()){
        $msg = "Cập nhật phòng học thành công!";
    } else {
        $msg = "Lỗi: Không thể cập nhật.";
    }
    $stmt->close();
    $result = $conn->query("SELECT * FROM rooms WHERE room_id=$room_id");
    $room = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa phòng học</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Sửa phòng học</h2>
    <a href="manage_rooms.php" class="btn btn-secondary mb-3">Quay lại</a>
    
    <?php if(isset($msg)) echo "<div class='alert alert-info'>$msg</div>"; ?>

    <form method="post">
        <div class="mb-2"><input type="text" name="room_code" class="form-control" value="<?= $room['room_code'] ?>" required></div>
        <div class="mb-2"><input type="text" name="building" class="form-control" value="<?= $room['building'] ?>" required></div>
        <div class="mb-2"><input type="number" name="floor" class="form-control" value="<?= $room['floor'] ?>" required></div>
        <div class="mb-2"><input type="number" name="capacity" class="form-control" value="<?= $room['capacity'] ?>" required></div>
        <div class="mb-2">
            <select name="room_type" class="form-control" required>
                <option value="Classroom" <?= $room['room_type']=='Classroom'?'selected':'' ?>>Classroom</option>
                <option value="Lab" <?= $room['room_type']=='Lab'?'selected':'' ?>>Lab</option>
                <option value="Meeting" <?= $room['room_type']=='Meeting'?'selected':'' ?>>Meeting</option>
                <option value="Lecture" <?= $room['room_type']=='Lecture'?'selected':'' ?>>Lecture</option>
            </select>
        </div>
        <div class="mb-2">
            <select name="status" class="form-control" required>
                <option value="Available" <?= $room['status']=='Available'?'selected':'' ?>>Available</option>
                <option value="Maintenance" <?= $room['status']=='Maintenance'?'selected':'' ?>>Maintenance</option>
                <option value="Reserved" <?= $room['status']=='Reserved'?'selected':'' ?>>Reserved</option>
            </select>
        </div>
        <div class="mb-2"><input type="text" name="note" class="form-control" value="<?= $room['note'] ?>"></div>
        <button type="submit" name="update_room" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
