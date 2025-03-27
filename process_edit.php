<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['Ma_NV'];
    $ten_nv = trim($_POST['Ten_NV']);
    $phai = $_POST['Phai'];
    $noi_sinh = trim($_POST['Noi_Sinh']);
    $ma_phong = trim($_POST['Ma_Phong']); // Xử lý chuỗi
    $luong = $_POST['Luong'];

    // Kiểm tra dữ liệu hợp lệ
    if (empty($ten_nv) || empty($phai) || empty($noi_sinh) || empty($ma_phong) || empty($luong)) {
        die("Vui lòng điền đầy đủ thông tin.");
    }

    // Kiểm tra Ma_Phong có tồn tại trong bảng phongban không
    $check_phong_query = "SELECT Ma_Phong FROM phongban WHERE Ma_Phong = ?";
    $check_stmt = $conn->prepare($check_phong_query);
    $check_stmt->bind_param("s", $ma_phong); // Sử dụng "s" nếu Ma_Phong là VARCHAR
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows == 0) {
        echo "<script>alert('Mã phòng không tồn tại. Vui lòng chọn lại!'); window.history.back();</script>";
        exit();
    }

    // Cập nhật thông tin nhân viên
    $sql = "UPDATE nhanvien SET Ten_NV=?, Phai=?, Noi_Sinh=?, Ma_Phong=?, Luong=? WHERE Ma_NV=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisi", $ten_nv, $phai, $noi_sinh, $ma_phong, $luong, $id); // "s" nếu Ma_Phong là VARCHAR

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href='index.php';</script>";
    } else {
        echo "Lỗi cập nhật: " . $conn->error;
    }
}

$conn->close();
?>
