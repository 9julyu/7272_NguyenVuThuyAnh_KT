<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten_nv = $_POST['Ten_NV'];
    $phai = $_POST['Phai'];
    $noi_sinh = $_POST['Noi_Sinh'];
    $ma_phong = $_POST['Ma_Phong'];
    $luong = $_POST['Luong'];

    $sql = "INSERT INTO nhanvien (Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $ten_nv, $phai, $noi_sinh, $ma_phong, $luong);

    if ($stmt->execute()) {
        echo "Thêm nhân viên thành công!";
        header("Location: index.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>
