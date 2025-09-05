<?php
include("session.php");
include("config.php"); // Kết nối database

$role = strtolower($_SESSION['role']);
if($role !== 'admin'){
    header("Location: index.php");
    exit();
}

// Xử lý xóa phòng
if(isset($_GET['delete'])){
    $room_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM rooms WHERE room_id=?");
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_rooms.php");
    exit();
}

// Lấy danh sách phòng học
$result = $conn->query("SELECT * FROM rooms ORDER BY building, floor, room_code");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Rooms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Quản lý Phòng học</h2>
    <a href="index.php" class="btn btn-secondary mb-3">Quay lại Dashboard</a>

    <?php if(isset($msg)) echo "<div class='alert alert-info'>$msg</div>"; ?>
    <a href="add_room.php" class="btn btn-success mb-3">Thêm Phòng Mới</a>

    <h4>Danh sách Phòng học</h4>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Room Code</th>
                <th>Building</th>
                <th>Floor</th>
                <th>Capacity</th>
                <th>Type</th>
                <th>Status</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['room_id'] ?></td>
                <td><?= $row['room_code'] ?></td>
                <td><?= $row['building'] ?></td>
                <td><?= $row['floor'] ?></td>
                <td><?= $row['capacity'] ?></td>
                <td><?= $row['room_type'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><?= $row['note'] ?></td>
                <td>
                    <a href="edit_room.php?id=<?= $row['room_id'] ?>" class="btn btn-primary btn-sm">Sửa</a>
                    <a href="manage_rooms.php?delete=<?= $row['room_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa phòng này?');">Xóa</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
