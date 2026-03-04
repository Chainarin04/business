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
            <li class="nav-item"><a class="nav-link text-dark" href="select1.php">🔍 รายชื่อลูกค้า</a></li>
            <li class="nav-item"><a class="nav-link text-dark" href="addcountry.php">🌎 เพิ่มข้อมูลประเทศ</a></li>
            <li class="nav-item"><a class="nav-link active bg-success" href="addcustomer.php">👤 เพิ่มข้อมูลลูกค้า</a></li>
        </ul>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h4 class="mb-0">ลงทะเบียนลูกค้าใหม่</h4>
                    </div>
                    <div class="card-body p-4">

                        <?php
                        require 'connect.php'; // เชื่อมต่อฐานข้อมูล

                        // ส่วนประมวลผลเมื่อกดปุ่มบันทึก
                        if (!empty($_POST['customerID']) && !empty($_POST['Name'])) {
                            $sql_insert = "INSERT INTO customer (CustomerID, Name, Birthdate, Email, CountryCode, OutstandingDebt) 
                                       VALUES (:customerID, :Name, :birthdate, :email, :countryCode, :outstandingDebt)";

                            $stmt = $conn->prepare($sql_insert);
                            $stmt->bindParam(':customerID', $_POST['customerID']);
                            $stmt->bindParam(':Name', $_POST['Name']);
                            $stmt->bindParam(':birthdate', $_POST['birthdate']);
                            $stmt->bindParam(':email', $_POST['email']);
                            $stmt->bindParam(':countryCode', $_POST['countryCode']);
                            $stmt->bindParam(':outstandingDebt', $_POST['outstandingDebt']);

                            try {
                                if ($stmt->execute()) {
                                    echo '<div class="alert alert-success fw-bold">บันทึกข้อมูลลูกค้าสำเร็จ!</div>';
                                }
                            } catch (PDOException $e) {
                                if ($e->errorInfo[1] == 1062) {
                                    echo '<div class="alert alert-danger">รหัสลูกค้านี้มีอยู่ในระบบแล้ว</div>';
                                } else {
                                    echo '<div class="alert alert-danger">บันทึกล้มเหลว: ' . $e->getMessage() . '</div>';
                                }
                            }
                        }

                        // ดึงรายชื่อประเทศจากฐานข้อมูลมาทำ Dropdown
                        $sql_countries = "SELECT CountryCode, CountryName FROM country ORDER BY CountryName ASC";
                        $stmt_countries = $conn->prepare($sql_countries);
                        $stmt_countries->execute();
                        $countries = $stmt_countries->fetchAll();
                        ?>

                        <form action="addcustomer.php" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">รหัสลูกค้า</label>
                                    <input type="text" class="form-control" placeholder="เช่น Cus006" name="customerID" required maxlength="6">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">ชื่อ-นามสกุล</label>
                                    <input type="text" class="form-control" placeholder="กรอกชื่อและนามสกุล" name="Name" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">วันเดือนปีเกิด</label>
                                    <input type="date" class="form-control" name="birthdate" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">อีเมล</label>
                                    <input type="email" class="form-control" placeholder="example@email.com" name="email" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
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
                                    <label class="form-label fw-bold">ยอดหนี้คงค้าง</label>
                                    <input type="number" step="0.01" class="form-control" placeholder="0.00" name="outstandingDebt" required>
                                </div>
                            </div>

                            <div class="d-grid mt-2">
                                <button type="submit" class="btn btn-success btn-lg">บันทึกข้อมูลลูกค้า</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>