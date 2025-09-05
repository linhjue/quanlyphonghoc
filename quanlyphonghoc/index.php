<?php
include("session.php"); 
include("config.php"); 

$role = strtolower($_SESSION['role']);
$username = htmlspecialchars($_SESSION['login_user']);

// Xử lý tìm kiếm
$search = '';
$sql = "SELECT * FROM rooms";
if(isset($_GET['search']) && !empty(trim($_GET['search']))){
    $search = trim($_GET['search']);
    $search_safe = $conn->real_escape_string($search);
    $sql .= " WHERE room_code LIKE '%$search_safe%' 
              OR building LIKE '%$search_safe%' 
              OR room_type LIKE '%$search_safe%'";
}
$sql .= " ORDER BY building, floor, room_code";
$rooms = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Quản lý phòng học</title>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; display: flex; }
        #sidebar { width: 220px; background: #343a40; color: #fff; flex-shrink: 0; }
        #sidebar .nav-link { color: #fff; }
        #sidebar .nav-link:hover { background: #495057; color: #fff; }
        #topbar { height: 60px; background: #f8f9fa; border-bottom: 1px solid #dee2e6;
                 display: flex; align-items: center; justify-content: space-between; padding: 0 20px; }
        #content { flex-grow: 1; padding: 20px; }
    </style>
</head>
<body>
    <div id="sidebar" class="d-flex flex-column p-3">
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4">LOGO</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <?php if($role === 'admin'): ?>
                <li class="nav-item"><a href="manage_users.php" class="nav-link text-white">Quản lý Users</a></li>
                <li class="nav-item"><a href="manage_rooms.php" class="nav-link text-white">Quản lý Rooms</a></li>
            <?php endif; ?>
            <li><a href="manage_classes.php" class="nav-link text-white">Quản lý Classes</a></li>
            <li><a href="requests.php" class="nav-link text-white">Duyệt Requests</a></li>
            <li><a href="schedules.php" class="nav-link text-white">Xem Schedules</a></li>
            <li><a href="history.php" class="nav-link text-white">Lịch sử Requests</a></li>
        </ul>
    </div>

    <div class="flex-grow-1 d-flex flex-column">
        <div id="topbar">
            <div><strong>Xin chào, <?php echo $username; ?></strong></div>
            <div><i class='bx bx-user'></i> 
                <a href="logout.php" class="btn btn-danger btn-sm">Đăng xuất</a>
            </div>
        </div>

        <div id="content">
            <h3>Dashboard</h3>

            <h4>Danh sách phòng học</h4>

            <!-- Form tìm kiếm -->
            <form method="get" class="mb-3 d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Tìm theo RoomCode, Building, Type" value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                <?php if($search !== ''): ?>
                    <a href="index.php" class="btn btn-secondary ms-2">Xóa</a>
                <?php endif; ?>
            </form>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>RoomCode</th>
                        <th>Building</th>
                        <th>Floor</th>
                        <th>Capacity</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($rooms->num_rows > 0): ?>
                        <?php while($room = $rooms->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($room['room_code']) ?></td>
                            <td><?= htmlspecialchars($room['building']) ?></td>
                            <td><?= htmlspecialchars($room['floor']) ?></td>
                            <td><?= htmlspecialchars($room['capacity']) ?></td>
                            <td><?= htmlspecialchars($room['room_type']) ?></td>
                            <td><?= htmlspecialchars($room['status']) ?></td>
                            <td><?= htmlspecialchars($room['note']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center">Không tìm thấy phòng học nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Yêu cầu đặt phòng (Pending) -->
            <h4>Yêu cầu đặt phòng (Pending)</h4>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>RequestId</th>
                        <th>Lecturer</th>
                        <th>Class</th>
                        <th>Room</th>
                        <th>StartTime</th>
                        <th>EndTime</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Nguyen Van A</td>
                        <td>CS101</td>
                        <td>R101</td>
                        <td>08:00 05/09/2025</td>
                        <td>10:00 05/09/2025</td>
                        <td>Pending</td>
                        <td>
                            <button class="btn btn-success btn-sm">Approve</button>
                            <button class="btn btn-danger btn-sm">Reject</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Tran Thi B</td>
                        <td>CS102</td>
                        <td>R202</td>
                        <td>10:00 05/09/2025</td>
                        <td>12:00 05/09/2025</td>
                        <td>Pending</td>
                        <td>
                            <button class="btn btn-success btn-sm">Approve</button>
                            <button class="btn btn-danger btn-sm">Reject</button>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
