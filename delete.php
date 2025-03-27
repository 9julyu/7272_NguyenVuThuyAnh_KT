<?php
include 'config.php';

$id = $_GET['id'];

$sql = "DELETE FROM nhanvien WHERE Ma_NV = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Xóa thành công!";
    header("Location: index.php");
} else {
    echo "Lỗi: " . $conn->error;
}

$conn->close();
?>
