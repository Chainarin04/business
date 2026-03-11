<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>จัดการข้อมูลประเทศ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f7f6;
        }
    </style>
</head>

<body>

    <div class="container mt-5 mb-5">
        <ul class="nav nav-pills justify-content-center mb-4 shadow-sm bg-white p-3 rounded-pill">
            <li class="nav-item"><a class="nav-link text-dark" href="index.php">🏠 หน้าแรก</a></li>
            <li class="nav-item"><a class="nav-link active bg-warning text-dark fw-bold" href="managecountry.php">🌎 จัดการประเทศ</a></li>
            <li class="nav-item"><a class="nav-link text-dark" href="addcustomer.php">👤 เพิ่มข้อมูลลูกค้า</a></li>
        </ul>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center py-3">
                <h4 class="mb-0 fw-bold">รายชื่อประเทศในระบบ</h4>
                <a href="addcountry.php" class="btn btn-dark fw-bold">+ เพิ่มประเทศใหม่</a>
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="15%">รหัส (Code)</th>
                            <th>ชื่อประเทศ (Country Name)</th>
                            <th width="15%">ลูกค้าในประเทศนี้</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require 'connect.php';
                        // นับจำนวนลูกค้าในแต่ละประเทศด้วย (Subquery)
                        $sql = "SELECT co.CountryCode, co.CountryName, 
                            (SELECT COUNT(*) FROM customer WHERE CountryCode = co.CountryCode) as CusCount 
                            FROM country co ORDER BY co.CountryName ASC";
                        $stmt = $conn->query($sql);

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td><span class='badge bg-secondary fs-6'>{$row['CountryCode']}</span></td>";
                            echo "<td class='text-start'>{$row['CountryName']}</td>";
                            echo "<td><strong>{$row['CusCount']} คน</strong></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>