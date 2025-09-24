<?php
include("../includes/auth.php");
include("../includes/header.php");
include("../includes/navbar.php");
include("../db.php");

// Xử lý thêm phòng
if (isset($_POST['add_room'])) {
    $room_code = mysqli_real_escape_string($conn, $_POST['room_code']);
    $building = mysqli_real_escape_string($conn, $_POST['building']);
    $floor = intval($_POST['floor']);
    $capacity = intval($_POST['capacity']);
    $room_type = mysqli_real_escape_string($conn, $_POST['room_type']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);

    $sql = "INSERT INTO rooms (room_code, building, floor, capacity, room_type, status, note) 
            VALUES ('$room_code', '$building', '$floor', '$capacity', '$room_type', '$status', '$note')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Thêm phòng thành công!'); window.location='rooms.php';</script>";
    } else {
        echo "<script>alert('Lỗi: " . mysqli_error($conn) . "');</script>";
    }
}

// Xử lý xóa phòng
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if (mysqli_query($conn, "DELETE FROM rooms WHERE room_id=$id")) {
        echo "<script>alert('Xóa phòng thành công!'); window.location='rooms.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa phòng!');</script>";
    }
}

// Lấy danh sách phòng
$result = mysqli_query($conn, "SELECT * FROM rooms ORDER BY building, floor, room_code");
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white">🏢 Quản lý phòng học</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRoomModal">
            <i class="bi bi-plus-square"></i> Thêm phòng
        </button>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Mã phòng</th>
                        <th>Tòa nhà</th>
                        <th>Tầng</th>
                        <th>Sức chứa</th>
                        <th>Loại phòng</th>
                        <th>Trạng thái</th>
                        <th>Ghi chú</th>
                        <th width="120">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><span class="badge bg-secondary"><?= $row['room_id'] ?></span></td>
                        <td><strong><?= htmlspecialchars($row['room_code']) ?></strong></td>
                        <td><?= htmlspecialchars($row['building']) ?></td>
                        <td><span class="badge bg-info">Tầng <?= $row['floor'] ?></span></td>
                        <td><?= $row['capacity'] ?> chỗ</td>
                        <td>
                            <?php
                            $type_colors = [
                                'Lecture' => 'bg-primary',
                                'Lab' => 'bg-warning',
                                'Seminar' => 'bg-info',
                                'Other' => 'bg-secondary'
                            ];
                            $color = $type_colors[$row['room_type']] ?? 'bg-secondary';
                            ?>
                            <span class="badge <?= $color ?>"><?= $row['room_type'] ?></span>
                        </td>
                        <td>
                            <?php
                            $status_colors = [
                                'Available' => 'bg-success',
                                'Maintenance' => 'bg-warning',
                                'Inactive' => 'bg-danger'
                            ];
                            $color = $status_colors[$row['status']] ?? 'bg-secondary';
                            ?>
                            <span class="badge <?= $color ?>"><?= $row['status'] ?></span>
                        </td>
                        <td><?= htmlspecialchars($row['note']) ?></td>
                        <td>
                            <a href="rooms.php?delete=<?= $row['room_id'] ?>" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa phòng này?');" 
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

<!-- Modal thêm phòng -->
<div class="modal fade" id="addRoomModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm phòng học mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>Mã phòng *</label>
                                <input type="text" name="room_code" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>Tòa nhà</label>
                                <input type="text" name="building" class="form-control" placeholder="VD: A, B, C...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>Tầng</label>
                                <input type="number" name="floor" class="form-control" min="1" max="20">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>Sức chứa</label>
                                <input type="number" name="capacity" class="form-control" min="1" max="500">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>Loại phòng *</label>
                                <select name="room_type" class="form-control" required>
                                    <option value="Lecture">Phòng giảng</option>
                                    <option value="Lab">Phòng thí nghiệm</option>
                                    <option value="Seminar">Phòng seminar</option>
                                    <option value="Other">Khác</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>Trạng thái</label>
                                <select name="status" class="form-control">
                                    <option value="Available">Có thể sử dụng</option>
                                    <option value="Maintenance">Bảo trì</option>
                                    <option value="Inactive">Không hoạt động</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Ghi chú</label>
                        <textarea name="note" class="form-control" rows="3" placeholder="Mô tả thêm về phòng học..."></textarea>
                    </div>
                    <button type="submit" name="add_room" class="btn btn-primary">Thêm phòng</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>