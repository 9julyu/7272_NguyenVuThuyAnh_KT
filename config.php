<?php
$servername = "127.0.0.1:3307"; // Đúng cổng MySQL trong XAMPP
$username = "root";
$password = ""; 
$dbname = "qlns";

// Kết nối MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
} // <-- Kiểm tra dấu đóng
?>