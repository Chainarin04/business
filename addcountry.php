<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลประเทศ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <ul class="nav nav-pills justify-content-center mb-4 shadow-sm bg-white p-3 rounded-pill">
            <li class="nav-item">
                <a class="nav-link text-dark" href="index.php">🏠 หน้าแรก</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="select1.php">🔍 รายชื่อลูกค้า</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active bg-primary" href="addcountry.php">🌎 เพิ่มข้อมูลประเทศ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark" href="addcustomer.php">👤 เพิ่มข้อมูลลูกค้า</a>
            </li>
        </ul>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0">เพิ่มข้อมูลประเทศใหม่</h4>
                    </div>
                    <div class="card-body p-4">

                        <?php
                        // ส่วนประมวลผล PHP
                        if (!empty($_POST['CountryCode']) && !empty($_POST['CountryName'])) {
                            require 'connect.php';

                            $sql_insert = "INSERT INTO country (CountryCode, CountryName) VALUES (:CountryCode, :CountryName)";
                            $stmt = $conn->prepare($sql_insert);
                            $stmt->bindParam(':CountryCode', $_POST['CountryCode']);
                            $stmt->bindParam(':CountryName', $_POST['CountryName']);

                            try {
                                if ($stmt->execute()) {
                                    echo '<div class="alert alert-success fw-bold">บันทึกข้อมูลประเทศสำเร็จ!</div>';
                                }
                            } catch (PDOException $e) {
                                // ดักจับ Error รหัสซ้ำ (1062)
                                if ($e->errorInfo[1] == 1062) {
                                    echo '<div class="alert alert-danger"><strong>เกิดข้อผิดพลาด:</strong> รหัสประเทศนี้มีอยู่ในระบบแล้ว กรุณาใช้รหัสอื่น</div>';
                                } else {
                                    echo '<div class="alert alert-danger"><strong>บันทึกล้มเหลว:</strong> ' . $e->getMessage() . '</div>';
                                }
                            }
                            $conn = null;
                        }
                        ?>

                        <form action="addcountry.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">รหัสประเทศ (Country Code)</label>
                                <input type="text" class="form-control" placeholder="เช่น TH, JP, US" name="CountryCode" required maxlength="2">
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">ชื่อประเทศ (Country Name)</label>
                                <input type="text" class="form-control" placeholder="เช่น ประเทศไทย, Japan" name="CountryName" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">บันทึกข้อมูลประเทศ</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>