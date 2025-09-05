<h2 align="center"> <a href="https://dainam.edu.vn/vi/khoa-cong-nghe-thong-tin"> 🎓 Faculty of Information Technology (DaiNam University) </a> </h2> <h2 align="center"> STUDENT ROOM BOOKING MANAGEMENT SYSTEM </h2> <div align="center"> <p align="center"> <img src="docs/logo/fitdnu_logo.png" alt="FIT DNU Logo" width="180"/> <img src="docs/logo/dnu_logo.png" alt="DaiNam University Logo" width="200"/> </p>




</div>
📖 1. Giới thiệu

Hệ thống quản lý đặt phòng sinh viên được phát triển nhằm:

Quản lý thông tin phòng học, lớp học, và giảng viên.

Cho phép sinh viên và giảng viên gửi yêu cầu đặt phòng.

Cho phép admin duyệt, phê duyệt hoặc từ chối yêu cầu đặt phòng.

Theo dõi lịch sử các yêu cầu và tình trạng phòng học.

Hệ thống được phát triển bằng PHP, MySQL, Bootstrap và áp dụng mô hình MVC.

2. Công nghệ sử dụng

Ngôn ngữ và Framework:

PHP: Ngôn ngữ lập trình phía server.

Bootstrap: Framework CSS để xây dựng giao diện responsive.

Cơ sở dữ liệu:

MySQL: Lưu trữ thông tin người dùng, phòng học, lớp học và các yêu cầu đặt phòng.

Công cụ hỗ trợ:

XAMPP/WAMP: Môi trường chạy PHP và MySQL.

Visual Studio Code: Trình soạn thảo code.
</div>
🚀 3. Hình ảnh cách chức năng

Quản lý Users: Admin quản lý sinh viên, giảng viên và admin khác.

<img width="1912" height="750" alt="image" src="https://github.com/user-attachments/assets/360f8405-79df-4995-882e-86f5ae5fe7bd" />

Quản lý Rooms: Admin quản lý phòng học, trạng thái và thông tin chi tiết.
<img width="1884" height="573" alt="image" src="https://github.com/user-attachments/assets/e12555b4-7a81-4929-9025-2082c5ee3c0c" />


Quản lý Classes: Quản lý thông tin lớp học và giảng viên phụ trách.
<img width="1919" height="545" alt="image" src="https://github.com/user-attachments/assets/0e38d17b-6fa3-4063-9c80-549256cc9372" />

Requests: Sinh viên/giảng viên gửi yêu cầu đặt phòng, admin duyệt.

Schedules: Xem lịch sử và tình trạng các phòng.

History: Lịch sử các yêu cầu đặt phòng.

⚙️ 4. Cài đặt
4.1. Clone project
git clone https://github.com/username/student-room-booking.git
cd student-room-booking

4.2. Cài đặt môi trường

Cài đặt XAMPP/WAMP/LAMP để chạy PHP và MySQL.

Tạo database mới, ví dụ room_booking.

Import file database.sql để tạo bảng và dữ liệu mẫu.

4.3. Cấu hình kết nối database

Mở file config.php và cập nhật thông tin database:

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "room_booking";

4.4. Chạy hệ thống

Khởi động XAMPP/WAMP.

Truy cập địa chỉ: http://localhost/student-room-booking/

Đăng nhập với tài khoản admin mẫu:

Username: admin
Password: admin123

📝 5. License

© 2025 Faculty of Information Technology, DaiNam University. All rights reserved.
