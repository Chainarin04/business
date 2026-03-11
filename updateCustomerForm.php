<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลลูกค้า</title>
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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-dark text-center py-3">
                        <h4 class="mb-0">✏️ ฟอร์มแก้ไขข้อมูลลูกค้า</h4>
                    </div>
                    <div class="card-body p-4">

                        <?php
                        require 'connect.php';

                        // ตรวจสอบว่ามีการส่งค่า CustomerID มาหรือไม่
                        if (isset($_GET['CustomerID'])) {
                            $customerID = $_GET['CustomerID'];

                            // ดึงข้อมูลลูกค้าจากฐานข้อมูล
                            $sql = "SELECT * FROM customer WHERE CustomerID = :customerID";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':customerID', $customerID);
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);

                            if (!$result) {
                                echo "<div class='alert alert-danger'>ไม่พบข้อมูลลูกค้า</div>";
                                exit();
                            }
                        ?>

                            <form action="updateCustomer.php" method="POST">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">รหัสลูกค้า</label>
                                        <input type="text" class="form-control bg-light" name="CustomerID" value="<?= htmlspecialchars($result['CustomerID']); ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">ชื่อ - นามสกุล</label>
                                        <input type="text" class="form-control" name="Name" value="<?= htmlspecialchars($result['Name']); ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">วันเดือนปีเกิด</label>
                                        <input type="date" class="form-control" name="Birthdate" value="<?= $result['Birthdate']; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">อีเมล</label>
                                        <input type="email" class="form-control" name="Email" value="<?= htmlspecialchars($result['Email']); ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">รหัสประเทศ</label>
                                        <input type="text" class="form-control" name="CountryCode" value="<?= htmlspecialchars($result['CountryCode']); ?>" required maxlength="2">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">ยอดหนี้สะสม</label>
                                        <input type="number" step="0.01" class="form-control" name="OutstandingDebt" value="<?= $result['OutstandingDebt']; ?>" required>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="index.php" class="btn btn-secondary">ยกเลิก</a>
                                    <button type="submit" class="btn btn-warning fw-bold">บันทึกการแก้ไข</button>
                                </div>
                            </form>

                        <?php
                        } else {
                            echo "<div class='alert alert-danger'>กรุณาระบุรหัสลูกค้าที่ต้องการแก้ไข</div>";
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>