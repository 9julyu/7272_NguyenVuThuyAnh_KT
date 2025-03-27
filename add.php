<?php
include 'config.php';

// Lấy danh sách phòng ban để chọn
$phong_query = "SELECT * FROM phongban";
$phong_result = $conn->query($phong_query);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Nhân Viên</title>
</head>
<body>
    <h2>Thêm Nhân Viên</h2>
    <form action="process_add.php" method="post">
        <label>Tên Nhân Viên:</label>
        <input type="text" name="Ten_NV" required><br>

        <label>Giới tính:</label>
        <select name="Phai">
            <option value="Nam">Nam</option>
            <option value="Nu">Nữ</option>
        </select><br>

        <label>Nơi Sinh:</label>
        <input type="text" name="Noi_Sinh"><br>

        <label>Phòng Ban:</label>
        <select name="Ma_Phong">
            <?php while ($row = $phong_result->fetch_assoc()) { ?>
                <option value="<?= $row['Ma_Phong'] ?>"><?= $row['Ten_Phong'] ?></option>
            <?php } ?>
        </select><br>

        <label>Lương:</label>
        <input type="number" name="Luong"><br>

        <button type="submit">Thêm Nhân Viên</button>
    </form>
</body>
</html>
