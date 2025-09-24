<?php
// includes/navbar.php
// Nếu chưa login thì chỉ hiển thị nút Đăng nhập
if (!isset($_SESSION)) session_start();
?>

<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay d-lg-none" id="sidebarOverlay"></div>

<!-- Sidebar Navigation -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-content">
        <!-- Logo Section -->
        <div class="sidebar-header">
            <div class="logo">
                <i class="bi bi-mortarboard-fill"></i>
                <span class="logo-text">EduRoom</span>
            </div>
            <button class="sidebar-close d-lg-none" id="sidebarClose">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <!-- User Info Section -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-info">
                <div class="user-avatar">
                    <i class="bi bi-person-circle"></i>
                </div>
                <div class="user-details">
                    <div class="user-name"><?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?></div>
                    <div class="user-role"><?php echo htmlspecialchars($_SESSION['role'] ?? 'Role'); ?></div>
                </div>
                <div class="user-status">
                    <div class="status-indicator active"></div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Navigation Menu -->
        <div class="sidebar-menu">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <!-- Guest Menu -->
                <div class="menu-section">
                    <div class="menu-title">Menu chính</div>
                    <ul class="menu-list">
                        <li class="menu-item">
                            <a href="/classroom_management/index.php" class="menu-link">
                                <div class="menu-icon">
                                    <i class="bi bi-house-door-fill"></i>
                                </div>
                                <span class="menu-text">Trang chủ</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="/classroom_management/login.php" class="menu-link">
                                <div class="menu-icon">
                                    <i class="bi bi-box-arrow-in-right"></i>
                                </div>
                                <span class="menu-text">Đăng nhập</span>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <?php if ($_SESSION['role'] == 'Admin'): ?>
                    <!-- Admin Menu -->
                    <div class="menu-section">
                        <div class="menu-title">Quản trị</div>
                        <ul class="menu-list">
                            <li class="menu-item">
                                <a href="/classroom_management/admin/dashboard.php" class="menu-link">
                                    <div class="menu-icon">
                                        <i class="bi bi-speedometer2"></i>
                                    </div>
                                    <span class="menu-text">Dashboard</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="/classroom_management/admin/users.php" class="menu-link">
                                    <div class="menu-icon">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <span class="menu-text">Quản lý Người dùng</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="/classroom_management/admin/rooms.php" class="menu-link">
                                    <div class="menu-icon">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <span class="menu-text">Quản lý Phòng</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="/classroom_management/admin/classes.php" class="menu-link">
                                    <div class="menu-icon">
                                        <i class="bi bi-journal-bookmark-fill"></i>
                                    </div>
                                    <span class="menu-text">Quản lý Lớp</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="/classroom_management/admin/schedules.php" class="menu-link">
                                    <div class="menu-icon">
                                        <i class="bi bi-calendar3"></i>
                                    </div>
                                    <span class="menu-text">Quản lý Lịch</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="/classroom_management/admin/approve_booking.php" class="menu-link">
                                    <div class="menu-icon">
                                        <i class="bi bi-calendar-check-fill"></i>
                                    </div>
                                    <span class="menu-text">Duyệt đăng ký</span>
                                    <?php
                                    // Hiển thị badge số lượng pending nếu có
                                    if (isset($conn)) {
                                        $pending_count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM booking_requests WHERE status='pending'");
                                        if ($pending_count_query) {
                                            $pending_count = mysqli_fetch_assoc($pending_count_query)['total'];
                                            if ($pending_count > 0) {
                                                echo '<span class="menu-badge">' . $pending_count . '</span>';
                                            }
                                        }
                                    }
                                    ?>
                                </a>
                            </li>
                        </ul>
                    </div>

                <?php elseif ($_SESSION['role'] == 'Lecturer'): ?>
                    <!-- Lecturer Menu -->
                    <div class="menu-section">
                        <div class="menu-title">Giảng viên</div>
                        <ul class="menu-list">
                            <li class="menu-item">
                                <a href="/classroom_management/lecturer/dashboard.php" class="menu-link">
                                    <div class="menu-icon">
                                        <i class="bi bi-speedometer2"></i>
                                    </div>
                                    <span class="menu-text">Dashboard</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="/classroom_management/lecturer/schedules.php" class="menu-link">
                                    <div class="menu-icon">
                                        <i class="bi bi-calendar3"></i>
                                    </div>
                                    <span class="menu-text">Xem lịch dạy</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="/classroom_management/lecturer/booking.php" class="menu-link">
                                    <div class="menu-icon">
                                        <i class="bi bi-calendar-plus"></i>
                                    </div>
                                    <span class="menu-text">Đăng ký phòng</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                <?php elseif ($_SESSION['role'] == 'Student'): ?>
                    <!-- Student Menu -->
                    <div class="menu-section">
                        <div class="menu-title">Sinh viên</div>
                        <ul class="menu-list">
                            <li class="menu-item">
                                <a href="/classroom_management/student/dashboard.php" class="menu-link">
                                    <div class="menu-icon">
                                        <i class="bi bi-speedometer2"></i>
                                    </div>
                                    <span class="menu-text">Dashboard</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="/classroom_management/student/view_schedule.php" class="menu-link">
                                    <div class="menu-icon">
                                        <i class="bi bi-calendar-week"></i>
                                    </div>
                                    <span class="menu-text">Xem lịch học</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Logout Section - Fixed at Bottom -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="logout-section">
                <ul class="menu-list">
                    <li class="menu-item">
                        <a href="/classroom_management/logout.php" class="menu-link logout-link">
                            <div class="menu-icon">
                                <i class="bi bi-box-arrow-right"></i>
                            </div>
                            <span class="menu-text">Đăng xuất</span>
                        </a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</nav>

<style>
/* Sidebar Styles */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 280px;
    height: 100vh;
    background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
    z-index: 1000;
    transition: all 0.3s ease;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    overflow-y: auto;
    overflow-x: hidden;
}

.sidebar::-webkit-scrollbar {
    width: 4px;
}

.sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
}

.sidebar-content {
    padding: 0;
    height: 100%;
    display: flex;
    flex-direction: column;
}

/* Sidebar Header */
.sidebar-header {
    padding: 1.5rem 1.5rem 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #fff;
    text-decoration: none;
}

.logo i {
    font-size: 2rem;
    background: linear-gradient(135deg, #3498db, #2ecc71);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.logo-text {
    font-size: 1.5rem;
    font-weight: 700;
    background: linear-gradient(135deg, #fff, #ecf0f1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.sidebar-close {
    background: none;
    border: none;
    color: #fff;
    font-size: 1.2rem;
    padding: 0.25rem;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.sidebar-close:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

/* User Info */
.user-info {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar {
    position: relative;
}

.user-avatar i {
    font-size: 2.5rem;
    color: #3498db;
}

.user-details {
    flex: 1;
}

.user-name {
    color: #fff;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0.25rem;
}

.user-role {
    color: #bdc3c7;
    font-size: 0.85rem;
    text-transform: capitalize;
}

.user-status {
    position: relative;
}

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: #2ecc71;
    position: relative;
}

.status-indicator.active::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: #2ecc71;
    animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
}

/* Sidebar Menu */
.sidebar-menu {
    flex: 1;
    padding: 1rem 0;
    display: flex;
    flex-direction: column;
}

.menu-section {
    margin-bottom: 2rem;
}

.menu-title {
    color: #7f8c8d;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0 1.5rem;
    margin-bottom: 0.75rem;
}

.menu-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu-item {
    margin: 0.25rem 0;
}

.menu-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.875rem 1.5rem;
    color: #ecf0f1;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    border-radius: 0;
}

.menu-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(135deg, #3498db, #2ecc71);
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.menu-link:hover {
    background-color: rgba(255, 255, 255, 0.05);
    color: #fff;
    transform: translateX(5px);
}

.menu-link:hover::before {
    transform: scaleY(1);
}

.menu-link.active {
    background-color: rgba(52, 152, 219, 0.2);
    color: #3498db;
}

.menu-link.active::before {
    transform: scaleY(1);
}

.menu-icon {
    width: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.menu-icon i {
    font-size: 1.1rem;
    transition: transform 0.3s ease;
}

.menu-link:hover .menu-icon i {
    transform: scale(1.1);
}

.menu-text {
    font-weight: 500;
    font-size: 0.9rem;
    white-space: nowrap;
}

.menu-badge {
    background: #e74c3c;
    color: #fff;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 0.2rem 0.5rem;
    border-radius: 10px;
    margin-left: auto;
    animation: pulse-badge 2s infinite;
}

/* Logout Section - Fixed at Bottom */
.logout-section {
    margin-top: auto;
    padding: 1rem 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.logout-link {
    color: #e74c3c !important;
}

.logout-link:hover {
    background-color: rgba(231, 76, 60, 0.1) !important;
}

/* Sidebar Overlay for Mobile */
.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.sidebar-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* Animations */
@keyframes pulse-ring {
    0% {
        transform: scale(0.33);
        opacity: 1;
    }
    80%, 100% {
        transform: scale(2.5);
        opacity: 0;
    }
}

@keyframes pulse-badge {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.7;
    }
}

/* Responsive Design */
@media (max-width: 991.98px) {
    .sidebar {
        transform: translateX(-100%);
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
}

@media (max-width: 576px) {
    .sidebar {
        width: 100%;
    }
    
    .logo-text {
        font-size: 1.3rem;
    }
    
    .user-name {
        font-size: 0.9rem;
    }
    
    .menu-text {
        font-size: 0.85rem;
    }
}

/* Active Page Highlighting */
body[data-page="dashboard"] .menu-link[href*="dashboard"],
body[data-page="users"] .menu-link[href*="users"],
body[data-page="rooms"] .menu-link[href*="rooms"],
body[data-page="classes"] .menu-link[href*="classes"],
body[data-page="schedules"] .menu-link[href*="schedules"],
body[data-page="approve_booking"] .menu-link[href*="approve_booking"],
body[data-page="booking"] .menu-link[href*="booking"],
body[data-page="view_schedule"] .menu-link[href*="view_schedule"] {
    background-color: rgba(52, 152, 219, 0.2);
    color: #3498db;
}

body[data-page="dashboard"] .menu-link[href*="dashboard"]::before,
body[data-page="users"] .menu-link[href*="users"]::before,
body[data-page="rooms"] .menu-link[href*="rooms"]::before,
body[data-page="classes"] .menu-link[href*="classes"]::before,
body[data-page="schedules"] .menu-link[href*="schedules"]::before,
body[data-page="approve_booking"] .menu-link[href*="approve_booking"]::before,
body[data-page="booking"] .menu-link[href*="booking"]::before,
body[data-page="view_schedule"] .menu-link[href*="view_schedule"]::before {
    transform: scaleY(1);
}
</style>

<script>
// Sidebar Toggle for Mobile
document.addEventListener('DOMContentLoaded', function() {
    const sidebarClose = document.getElementById('sidebarClose');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    // Close sidebar
    function closeSidebar() {
        sidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (sidebarClose) {
        sidebarClose.addEventListener('click', closeSidebar);
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }

    // Close sidebar on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            closeSidebar();
        }
    });

    // Active page highlighting
    const currentPath = window.location.pathname;
    const menuLinks = document.querySelectorAll('.menu-link');
    
    menuLinks.forEach(link => {
        if (currentPath.includes(link.getAttribute('href'))) {
            link.classList.add('active');
        }
    });
});
</script>