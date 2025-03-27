<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';

// Kiểm tra và làm sạch ID
$id = isset($_GET['id']) ? $conn->real_escape_string($_GET['id']) : '';

if (empty($id)) {
    die("ID không hợp lệ.");
}

// Truy vấn nhân viên
$sql = "SELECT * FROM nhanvien WHERE Ma_NV = '$id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Không tìm thấy nhân viên với mã ID: " . htmlspecialchars($id));
}

$nhanvien = $result->fetch_assoc();

// Lấy danh sách phòng ban
$phong_query = "SELECT * FROM phongban";
$phong_result = $conn->query($phong_query);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Nhân Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #007BFF;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #007BFF;
        }
    </style>
    <script>
        function confirmUpdate(event) {
            if (!confirm("Bạn có chắc chắn muốn cập nhật thông tin nhân viên này?")) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Sửa Nhân Viên</h2>
        <form action="process_edit.php" method="post" onsubmit="confirmUpdate(event)">
            <input type="hidden" name="Ma_NV" value="<?= htmlspecialchars($nhanvien['Ma_NV']) ?>">

            <label>Tên Nhân Viên:</label>
            <input type="text" name="Ten_NV" value="<?= htmlspecialchars($nhanvien['Ten_NV']) ?>" required>

            <label>Giới tính:</label>
            <select name="Phai">
                <option value="Nam" <?= ($nhanvien['Phai'] == 'Nam') ? 'selected' : '' ?>>Nam</option>
                <option value="Nu" <?= ($nhanvien['Phai'] == 'Nu') ? 'selected' : '' ?>>Nữ</option>
            </select>

            <label>Nơi Sinh:</label>
            <input type="text" name="Noi_Sinh" value="<?= htmlspecialchars($nhanvien['Noi_Sinh']) ?>">

            <label>Phòng Ban:</label>
            <select name="Ma_Phong">
                <?php while ($row = $phong_result->fetch_assoc()) { ?>
                    <option value="<?= htmlspecialchars($row['Ma_Phong']) ?>" <?= ($row['Ma_Phong'] == $nhanvien['Ma_Phong']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['Ten_Phong']) ?>
                    </option>
                <?php } ?>
            </select>

            <label>Lương:</label>
            <input type="number" name="Luong" value="<?= htmlspecialchars($nhanvien['Luong']) ?>">

            <button type="submit">Cập Nhật</button>
        </form>
        <a href="index.php" class="back-link">← Quay lại danh sách nhân viên</a>
    </div>
</body>
</html>
