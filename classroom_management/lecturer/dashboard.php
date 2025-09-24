<?php
include("../includes/auth.php");
include("../includes/header.php");
include("../includes/navbar.php");
include("../db.php");

// Lấy ID giảng viên đang đăng nhập
$lecturer_id = $_SESSION['user_id'];

// Tổng số lớp mà giảng viên dạy
$sql_classes = "SELECT COUNT(*) as total_classes FROM classes WHERE lecturer_id = $lecturer_id";
$res_classes = mysqli_query($conn, $sql_classes);
$total_classes = mysqli_fetch_assoc($res_classes)['total_classes'];

// Tổng số lịch giảng dạy
$sql_schedules = "SELECT COUNT(*) as total_schedules FROM schedules WHERE lecturer_id = $lecturer_id";
$res_schedules = mysqli_query($conn, $sql_schedules);
$total_schedules = mysqli_fetch_assoc($res_schedules)['total_schedules'];

// Tổng số yêu cầu mượn phòng
$sql_bookings = "SELECT COUNT(*) as total_bookings FROM booking_requests WHERE user_id = $lecturer_id";
$res_bookings = mysqli_query($conn, $sql_bookings);
$total_bookings = mysqli_fetch_assoc($res_bookings)['total_bookings'];

// Lấy lịch dạy hôm nay
$today = date('l'); // Lấy tên thứ hôm nay bằng tiếng Anh
$day_map = [
    'Monday' => 'Mon',
    'Tuesday' => 'Tue', 
    'Wednesday' => 'Wed',
    'Thursday' => 'Thu',
    'Friday' => 'Fri',
    'Saturday' => 'Sat',
    'Sunday' => 'Sun'
];
$today_short = $day_map[$today];

$sql_today = "SELECT s.start_time, s.end_time, c.class_code, r.room_code, r.building, r.floor
              FROM schedules s
              JOIN classes c ON s.class_id = c.class_id
              JOIN rooms r ON s.room_id = r.room_id
              WHERE s.lecturer_id = $lecturer_id AND s.day_of_week = '$today_short'
              ORDER BY s.start_time";
$result_today = mysqli_query($conn, $sql_today);
?>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="text-white mb-3">
                 Xin chào, <strong><?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username']) ?>!</strong>
            </h2>
            <p class="text-white-50">Chào mừng bạn đến với bảng điều khiển giảng viên</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stats-card classes-card">
                <div class="card-overlay"></div>
                <div class="card-content">
                    <div class="card-icon">
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </div>
                    <div class="card-info">
                        <h3 class="card-title">Lớp đang dạy</h3>
                        <div class="card-number"><?= number_format($total_classes) ?></div>
                        <p class="card-description">Tổng số lớp được phân công</p>
                    </div>
                    <div class="card-action">
                        <a href="classes.php" class="action-btn">
                            <span>Xem chi tiết</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stats-card rooms-card">
                <div class="card-overlay"></div>
                <div class="card-content">
                    <div class="card-icon">
                        <i class="bi bi-calendar3"></i>
                    </div>
                    <div class="card-info">
                        <h3 class="card-title">Lịch giảng dạy</h3>
                        <div class="card-number"><?= number_format($total_schedules) ?></div>
                        <p class="card-description">Tổng số buổi học trong tuần</p>
                    </div>
                    <div class="card-action">
                        <a href="schedules.php" class="action-btn">
                            <span>Xem lịch</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stats-card bookings-card">
                <div class="card-overlay"></div>
                <div class="card-content">
                    <div class="card-icon">
                        <i class="bi bi-calendar-plus"></i>
                    </div>
                    <div class="card-info">
                        <h3 class="card-title">Yêu cầu mượn phòng</h3>
                        <div class="card-number"><?= number_format($total_bookings) ?></div>
                        <p class="card-description">Tổng số yêu cầu đã gửi</p>
                    </div>
                    <div class="card-action">
                        <a href="booking.php" class="action-btn">
                            <span>Đăng ký mượn</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Schedule -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-calendar-day"></i>
                Lịch dạy hôm nay - <?= date('d/m/Y') ?>
            </h5>
        </div>
        <div class="card-body">
            <?php if (mysqli_num_rows($result_today) > 0): ?>
                <div class="row">
                    <?php while ($row = mysqli_fetch_assoc($result_today)): ?>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card border-primary h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="bi bi-book"></i> <?= htmlspecialchars($row['class_code']) ?>
                                    </h6>
                                    <p class="card-text mb-2">
                                        <i class="bi bi-geo-alt"></i>
                                        <strong><?= htmlspecialchars($row['room_code']) ?></strong>
                                        <br><small class="text-muted"><?= htmlspecialchars($row['building']) ?> - Tầng <?= $row['floor'] ?></small>
                                    </p>
                                    <p class="card-text">
                                        <i class="bi bi-clock"></i>
                                        <?= date("H:i", strtotime($row['start_time'])) ?> - <?= date("H:i", strtotime($row['end_time'])) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="bi bi-calendar-x display-4 text-muted"></i>
                    <h5 class="text-muted mt-3">Hôm nay bạn không có lịch dạy</h5>
                    <p class="text-muted">Hãy nghỉ ngơi hoặc chuẩn bị bài giảng cho ngày mai!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions-section">
        <h3 class="section-title">
            <i class="bi bi-lightning-fill"></i>
            Thao tác nhanh
        </h3>
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <a href="schedules.php" class="quick-action-card">
                    <i class="bi bi-calendar-week"></i>
                    <span>Xem lịch dạy tuần</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="booking.php" class="quick-action-card">
                    <i class="bi bi-calendar-plus"></i>
                    <span>Đăng ký mượn phòng</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="quick-action-card" onclick="alert('Tính năng đang phát triển!')">
                    <i class="bi bi-file-text"></i>
                    <span>Tạo báo cáo</span>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="#" class="quick-action-card" onclick="alert('Tính năng đang phát triển!')">
                    <i class="bi bi-gear"></i>
                    <span>Cài đặt</span>
                </a>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>