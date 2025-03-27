<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';

// Số nhân viên trên mỗi trang
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Truy vấn dữ liệu nhân viên + phòng ban
$sql = "SELECT nhanvien.*, phongban.Ten_Phong FROM nhanvien 
        INNER JOIN phongban ON nhanvien.Ma_Phong = phongban.Ma_Phong
        LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $start, $limit);
$stmt->execute();
$result = $stmt->get_result();

// Truy vấn tổng số nhân viên
$total_sql = "SELECT COUNT(*) as total FROM nhanvien";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $limit);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Nhân Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        img {
            width: 30px;
            height: 30px;
        }

        a {
            text-decoration: none;
            font-weight: bold;
        }

        .add-btn {
            display: inline-block;
            padding: 10px 15px;
            background: green;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .add-btn:hover {
            background: darkgreen;
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 5px;
            border: 1px solid #007BFF;
            color: #007BFF;
        }

        .pagination a.active, .pagination a:hover {
            background-color: #007BFF;
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            th {
                display: none;
            }

            td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: bold;
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>THÔNG TIN NHÂN VIÊN</h2>
        <a href="add.php" class="add-btn">➕ Thêm Nhân Viên</a>
        <br><br>
        <table>
            <tr>
                <th>Mã NV</th>
                <th>Tên Nhân Viên</th>
                <th>Giới tính</th>
                <th>Nơi Sinh</th>
                <th>Tên Phòng</th>
                <th>Lương</th>
                <th>Hành động</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['Ma_NV']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Ten_NV']) . "</td>";
                    echo "<td>" . ($row['Phai'] == 'Nu' ? '<img src=\'images/woman.png\' alt=\'Nữ\'>' : '<img src=\'images/man.png\' alt=\'Nam\'>') . "</td>";
                    echo "<td>" . htmlspecialchars($row['Noi_Sinh']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Ten_Phong']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Luong']) . "</td>";
                    echo "<td>
                            <a href='edit.php?id=" . urlencode($row['Ma_NV']) . "' style='color: blue;'>✏️</a> |
                            <a href='delete.php?id=" . urlencode($row['Ma_NV']) . "' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")' style='color: red;'>🗑️</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Không có nhân viên nào</td></tr>";
            }
            ?>
        </table>

        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <a href="index.php?page=<?= $i ?>" class="<?= ($page == $i) ? 'active' : '' ?>"><?= $i ?></a>
            <?php } ?>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
