<?php
include("../includes/auth.php");
include("../includes/header.php");
include("../includes/navbar.php");
include("../db.php");

// Lấy danh sách booking requests
$sql = "SELECT br.booking_id, br.purpose, br.status, br.created_at, br.start_time, br.end_time, 
               u.username, u.full_name, u.role, 
               r.room_code, r.building, r.floor
        FROM booking_requests br
        JOIN users u ON br.user_id = u.user_id
        JOIN rooms r ON br.room_id = r.room_id
        ORDER BY br.created_at DESC";
$result = mysqli_query($conn, $sql);

// Duyệt hoặc từ chối
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == 'approve') {
        $update = "UPDATE booking_requests SET status='Approved', approved_by={$_SESSION['user_id']} WHERE booking_id=$id";
        $message = "Đã duyệt yêu cầu thành công!";
    } elseif ($action == 'reject') {
        $update = "UPDATE booking_requests SET status='Rejected', approved_by={$_SESSION['user_id']} WHERE booking_id=$id";
        $message = "Đã từ chối yêu cầu!";
    }

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('$message'); window.location='approve_booking.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật!');</script>";
    }
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white">📋 Quản lý Yêu cầu Mượn Phòng</h2>
        <div>
            <?php 
            $pending_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM booking_requests WHERE status='Pending'"))['total'];
            ?>
            <span class="badge bg-warning fs-6">
                <i class="bi bi-clock"></i> <?= $pending_count ?> chờ duyệt
            </span>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Người yêu cầu</th>
                        <th>Vai trò</th>
                        <th>Phòng</th>
                        <th>Mục đích</th>
                        <th>Thời gian</th>
                        <th>Ngày yêu cầu</th>
                        <th>Trạng thái</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr class="<?= $row['status'] == 'Pending' ? 'table-warning' : '' ?>">
                        <td><span class="badge bg-secondary"><?= $row['booking_id'] ?></span></td>
                        <td>
                            <strong><?= htmlspecialchars($row['full_name']) ?></strong>
                            <br><small class="text-muted">@<?= htmlspecialchars($row['username']) ?></small>
                        </td>
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
                            <strong><?= htmlspecialchars($row['room_code']) ?></strong>
                            <br><small class="text-muted"><?= htmlspecialchars($row['building']) ?> - Tầng <?= $row['floor'] ?></small>
                        </td>
                        <td>
                            <em><?= htmlspecialchars($row['purpose']) ?></em>
                        </td>
                        <td>
                            <strong><?= date("d/m/Y", strtotime($row['start_time'])) ?></strong>
                            <br><?= date("H:i", strtotime($row['start_time'])) ?> - <?= date("H:i", strtotime($row['end_time'])) ?>
                        </td>
                        <td>
                            <small class="text-muted"><?= date("d/m/Y H:i", strtotime($row['created_at'])) ?></small>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'Pending') { ?>
                                <span class="badge bg-warning">
                                    <i class="bi bi-clock"></i> Chờ duyệt
                                </span>
                            <?php } elseif ($row['status'] == 'Approved') { ?>
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle"></i> Đã duyệt
                                </span>
                            <?php } else { ?>
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle"></i> Từ chối
                                </span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'Pending') { ?>
                                <div class="btn-group" role="group">
                                    <a href="approve_booking.php?action=approve&id=<?= $row['booking_id'] ?>" 
                                       class="btn btn-success btn-sm"
                                       onclick="return confirm('Duyệt yêu cầu này?')">
                                        <i class="bi bi-check"></i>
                                    </a>
                                    <a href="approve_booking.php?action=reject&id=<?= $row['booking_id'] ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Từ chối yêu cầu này?')">
                                        <i class="bi bi-x"></i>
                                    </a>
                                </div>
                            <?php } else { ?>
                                <span class="text-muted">-</span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php if (mysqli_num_rows($result) == 0): ?>
    <div class="text-center py-5">
        <i class="bi bi-inbox display-1 text-muted"></i>
        <h3 class="text-white mt-3">Chưa có yêu cầu nào</h3>
        <p class="text-white-50">Các yêu cầu mượn phòng sẽ hiển thị ở đây</p>
    </div>
    <?php endif; ?>
</div>

<?php include("../includes/footer.php"); ?>