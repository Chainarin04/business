<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดข้อมูลลูกค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 20px;
        }

        /* --- สไตล์เมนูนำทาง --- */
        .nav-menu {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        .nav-menu a {
            text-decoration: none;
            color: #555;
            font-weight: bold;
            padding: 10px 20px;
            margin: 0 5px;
            border-radius: 25px;
            transition: 0.3s;
            display: inline-block;
        }

        .nav-menu a:hover {
            background-color: #e0f2f1;
            color: #009688;
        }

        .nav-menu a.active {
            background-color: #3498db;
            color: white;
        }

        /* --- สไตล์การ์ดโปรไฟล์ --- */
        .profile-card {
            max-width: 550px;
            margin: 0 auto 50px auto;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 30px 40px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #3498db;
            padding-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px dashed #e0e0e0;
            padding: 15px 0;
            font-size: 16px;
        }

        .info-label {
            font-weight: bold;
            color: #555;
        }

        .info-value {
            color: #2c3e50;
            font-weight: 500;
            text-align: right;
        }

        .debt-badge {
            background-color: #e74c3c;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }

        .no-debt {
            background-color: #2ecc71;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="nav-menu">
            <a href="index.php">🏠 หน้าแรก</a>
            <a href="managecountry.php">🌎 จัดการข้อมูลประเทศ</a>
            <a href="addcustomer.php">👤 เพิ่มข้อมูลลูกค้า</a>
        </div>

        <div class="profile-card">
            <div class="profile-header">
                <h3 class="fw-bold text-primary mb-0">🔍 ข้อมูลลูกค้ารายบุคคล</h3>
            </div>

            <?php
            require 'connect.php';

            if (isset($_GET['CustomerID'])) {
                $id = $_GET['CustomerID'];

                // ดึงข้อมูลลูกค้า + ดึงชื่อประเทศมาแสดง
                $sql = "SELECT c.*, co.CountryName 
                        FROM customer c 
                        JOIN country co ON c.CountryCode = co.CountryCode 
                        WHERE c.CustomerID = :id";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $debtClass = ($result['OutstandingDebt'] > 0) ? 'debt-badge' : 'debt-badge no-debt';
            ?>
                    <div class="info-row">
                        <span class="info-label">รหัสลูกค้า:</span>
                        <span class="badge bg-primary text-white fs-6 px-3 py-2"><?= htmlspecialchars($result['CustomerID']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">ชื่อ-นามสกุล:</span>
                        <span class="info-value"><?= htmlspecialchars($result['Name']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">วันเดือนปีเกิด:</span>
                        <span class="info-value"><?= htmlspecialchars($result['Birthdate']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">อีเมล:</span>
                        <span class="info-value text-primary"><?= htmlspecialchars($result['Email']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">ประเทศ:</span>
                        <span class="info-value"><?= htmlspecialchars($result['CountryName']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">ยอดหนี้สะสม:</span>
                        <span class="<?= $debtClass ?>"><?= number_format($result['OutstandingDebt'], 2) ?> ฿</span>
                    </div>
            <?php
                } else {
                    echo "<div class='alert alert-danger text-center mt-3'>ไม่พบข้อมูลลูกค้ารายนี้ในระบบ</div>";
                }
            } else {
                echo "<div class='alert alert-warning text-center mt-3'>กรุณาเลือกลูกค้าที่ต้องการดูข้อมูล</div>";
            }
            ?>

            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-secondary btn-lg px-5 fw-bold rounded-pill">⬅️ กลับหน้าแรก</a>
            </div>
        </div>
    </div>

</body>

</html>