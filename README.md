# Quản Lý Phòng Học & Lớp Học

## 1. Giới thiệu
Ứng dụng quản lý phòng học, lớp học và yêu cầu đặt phòng. Hệ thống cho phép:
- Quản lý **Users**: thêm/sửa/xóa người dùng theo vai trò `admin`, `lecturer`, `student`.
- Quản lý **Classes**: thêm/sửa/xóa lớp học và liên kết giảng viên.
- Quản lý **Rooms**: thêm/sửa/xóa phòng học, trạng thái và loại phòng.
- Quản lý **Requests**: giảng viên gửi yêu cầu đặt phòng.
- Xem **Schedules**: hiển thị lịch học theo phòng/lớp/giảng viên.
- Xem **History Requests**: theo dõi các yêu cầu đã được duyệt hoặc từ chối.

Mục tiêu: Hỗ trợ admin quản lý tài nguyên và lịch học hiệu quả, trực quan và dễ sử dụng.

---

## 2. Mô tả công nghệ
- **Ngôn ngữ lập trình:** PHP 8.x
- **Database:** MySQL / MariaDB
- **Web server:** Apache (XAMPP)
- **Front-end:** HTML, CSS, Bootstrap 5
- **Các công nghệ khác:**  
  - Prepared statements (`mysqli`) để bảo mật SQL Injection  
  - ENUM trong MySQL cho các giá trị hợp lệ của phòng học và trạng thái  
  - Session PHP để quản lý đăng nhập theo role

---

## 3. Hình ảnh minh họa chức năng
1. **Quản lý Users**
   ![Manage Users](images/manage_users.png)

2. **Quản lý Classes**
   ![Manage Classes](images/manage_classes.png)

3. **Quản lý Rooms**
   ![Manage Rooms](images/manage_rooms.png)

4. **Yêu cầu đặt phòng (Requests)**
   ![Requests](images/requests.png)

5. **Lịch học (Schedules)**
   ![Schedules](images/schedules.png)

6. **Lịch sử Requests**
   ![History Requests](images/history_requests.png)

---

## 4. Các bước cài đặt và chạy dự án

### Bước 1: Cài đặt môi trường
1. Cài đặt **XAMPP** hoặc LAMP/WAMP.
2. Bật Apache và MySQL.

### Bước 2: Tạo database
1. Tạo database `school_management`.
2. Tạo các bảng:

```sql
-- Users
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','lecturer','student') NOT NULL
);

-- Rooms
CREATE TABLE rooms (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    room_code VARCHAR(45) NOT NULL UNIQUE,
    building VARCHAR(45) NOT NULL,
    floor INT NOT NULL,
    capacity INT UNSIGNED NOT NULL,
    room_type ENUM('Lecture','Lab','Seminar','Other') NOT NULL,
    status ENUM('Available','Maintenance','Inactive') NOT NULL,
    note VARCHAR(255) NOT NULL
);

-- Classes
CREATE TABLE classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    class_code VARCHAR(20) NOT NULL UNIQUE,
    lecturer_id INT,
    size INT NOT NULL,
    department VARCHAR(50) NOT NULL,
    FOREIGN KEY (lecturer_id) REFERENCES users(user_id)
);

-- Requests
CREATE TABLE requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    room_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    status ENUM('Pending','Approved','Rejected') NOT NULL,
    FOREIGN KEY (class_id) REFERENCES classes(class_id),
    FOREIGN KEY (room_id) REFERENCES rooms(room_id)
);
