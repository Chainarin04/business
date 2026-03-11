<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลลูกค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
        }
    </style>
</head>

<body>

    <div class="container mt-5 mb-5">
        <ul class="nav nav-pills justify-content-center mb-4 shadow-sm bg-white p-3 rounded-pill">
            <li class="nav-item"><a class="nav-link text-dark" href="index.php">🏠 หน้าแรก</a></li>
            <li class="nav-item"><a class="nav-link text-dark" href="managecountry.php">🌎 จัดการข้อมูลประเทศ</a></li>
            <li class="nav-item"><a class="nav-link active bg-success text-white fw-bold" href="addcustomer.php">👤 เพิ่มข้อมูลลูกค้า</a></li>
        </ul>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h4 class="mb-0 fw-bold">➕ เพิ่มข้อมูลลูกค้าใหม่</h4>
                    </div>
                    <div class="card-body p-4">

                        <?php
                        require 'connect.php';

                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $customerID = $_POST['customerID'];
                            $name = $_POST['name'];
                            $birthdate = $_POST['birthdate'];
                            $email = $_POST['email'];
                            $countryCode = $_POST['countryCode'];
                            $outstandingDebt = $_POST['outstandingDebt'];

                            try {
                                $sql = "INSERT INTO customer (CustomerID, Name, Birthdate, Email, CountryCode, OutstandingDebt) 
                                        VALUES (:customerID, :name, :birthdate, :email, :countryCode, :outstandingDebt)";
                                $stmt = $conn->prepare($sql);
                                $stmt->bindParam(':customerID', $customerID);
                                $stmt->bindParam(':name', $name);
                                $stmt->bindParam(':birthdate', $birthdate);
                                $stmt->bindParam(':email', $email);
                                $stmt->bindParam(':countryCode', $countryCode);
                                $stmt->bindParam(':outstandingDebt', $outstandingDebt);

                                if ($stmt->execute()) {
                                    echo "<div class='alert alert-success text-center'>✅ เพิ่มข้อมูลลูกค้าสำเร็จ! <a href='index.php' class='alert-link'>กลับสู่หน้าแรก</a></div>";
                                }
                            } catch (PDOException $e) {
                                // เช็ค Error กรณีรหัสลูกค้าซ้ำ (Duplicate Entry)
                                if ($e->errorInfo[1] == 1062) {
                                    echo "<div class='alert alert-danger text-center'>❌ ข้อผิดพลาด: รหัสลูกค้า '<b>$customerID</b>' มีอยู่ในระบบแล้ว กรุณาใช้รหัสอื่น</div>";
                                } else {
                                    echo "<div class='alert alert-danger text-center'>❌ ไม่สามารถเพิ่มข้อมูลได้: " . $e->getMessage() . "</div>";
                                }
                            }
                        }

                        // ดึงข้อมูลประเทศมาแสดงใน Dropdown
                        $countries = [];
                        try {
                            $stmt = $conn->query("SELECT CountryCode, CountryName FROM country ORDER BY CountryName ASC");
                            $countries = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "<div class='alert alert-warning'>ไม่สามารถดึงรายชื่อประเทศได้</div>";
                        }
                        $conn = null;
                        ?>

                        <form action="addcustomer.php" method="POST" class="mt-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">รหัสลูกค้า</label>
                                    <input type="text" class="form-control" placeholder="เช่น C001" name="customerID" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">ชื่อ-นามสกุล</label>
                                    <input type="text" class="form-control" placeholder="ระบุชื่อและนามสกุล" name="name" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">วันเกิด</label>
                                    <input type="date" class="form-control" name="birthdate" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">อีเมล</label>
                                    <input type="email" class="form-control" placeholder="example@email.com" name="email" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">เลือกประเทศ</label>
                                    <select class="form-select" name="countryCode" required>
                                        <option value="" selected disabled>-- กรุณาเลือกประเทศ --</option>
                                        <?php foreach ($countries as $country) { ?>
                                            <option value="<?= $country['CountryCode'] ?>">
                                                <?= htmlspecialchars($country['CountryName']) ?> (<?= $country['CountryCode'] ?>)
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">ยอดหนี้คงค้าง (บาท)</label>
                                    <input type="number" step="0.01" class="form-control" placeholder="0.00" name="outstandingDebt" required>
                                </div>
                            </div>

                            <div class="d-grid mt-2">
                                <button type="submit" class="btn btn-success btn-lg fw-bold">💾 บันทึกข้อมูลลูกค้า</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>