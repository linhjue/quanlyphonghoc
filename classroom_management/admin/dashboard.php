<?php
include("../includes/auth.php");
include("../db.php");
include("../includes/header.php");
include("../includes/navbar.php");

// Lấy số liệu thống kê
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
$room_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM rooms"))['total'];
$class_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM classes"))['total'];
$booking_pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM booking_requests WHERE status='pending'"))['total'];
?>

<div class="dashboard-wrapper">
    <div class="container-fluid py-2"> <!-- Giảm padding -->
        <!-- Header Section -->
        <div class="dashboard-header">
            <h1 class="dashboard-title">Admin</h1> <!-- Chỉ giữ "Admin" -->
            <p class="dashboard-subtitle">Quản lý hệ thống một cách hiệu quả</p>
        </div>

        <!-- Stats Cards -->
        <div class="row g-1 mb-2"> <!-- Giảm gutter và margin -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="stats-card">
                    <div class="card-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="card-info">
                        <h3 class="card-title">Người dùng</h3>
                        <div class="card-number"><?php echo number_format($user_count); ?></div>
                        <p class="card-description">Tổng số người dùng</p>
                    </div>
                    <div class="card-action">
                        <a href="users.php" class="btn btn-primary btn-sm">Quản lý</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="stats-card">
                    <div class="card-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <div class="card-info">
                        <h3 class="card-title">Phòng học</h3>
                        <div class="card-number"><?php echo number_format($room_count); ?></div>
                        <p class="card-description">Tổng số phòng</p>
                    </div>
                    <div class="card-action">
                        <a href="rooms.php" class="btn btn-primary btn-sm">Quản lý</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="stats-card">
                    <div class="card-icon">
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </div>
                    <div class="card-info">
                        <h3 class="card-title">Lớp học</h3>
                        <div class="card-number"><?php echo number_format($class_count); ?></div>
                        <p class="card-description">Tổng số lớp</p>
                    </div>
                    <div class="card-action">
                        <a href="classes.php" class="btn btn-primary btn-sm">Quản lý</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="stats-card">
                    <div class="card-icon">
                        <i class="bi bi-calendar-check-fill"></i>
                        <?php if($booking_pending > 0): ?>
                            <span class="badge bg-danger"><?php echo $booking_pending; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="card-info">
                        <h3 class="card-title">Yêu cầu mượn</h3>
                        <div class="card-number"><?php echo number_format($booking_pending); ?></div>
                        <p class="card-description">Yêu cầu chờ duyệt</p>
                    </div>
                    <div class="card-action">
                        <a href="approve_booking.php" class="btn btn-primary btn-sm">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="quick-actions-section">
            <h2 class="section-title">
                <i class="bi bi-lightning-fill me-1"></i> <!-- Giảm margin -->
                Thao tác nhanh
            </h2>
            <div class="row g-1"> <!-- Giảm gutter -->
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="users.php" class="quick-action-card">
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Thêm người dùng</span>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="rooms.php" class="quick-action-card">
                        <i class="bi bi-plus-square-fill"></i>
                        <span>Thêm phòng</span>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="classes.php" class="quick-action-card">
                        <i class="bi bi-journal-plus"></i>
                        <span>Tạo lớp</span>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <a href="approve_booking.php" class="quick-action-card">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Duyệt yêu cầu</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>