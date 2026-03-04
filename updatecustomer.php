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
                        <h4 class="mb-0">✏️ แก้ไขข้อมูลลูกค้า</h4>
                    </div>
                    <div class="card-body p-4">

                        <?php
                        require 'connect.php';

                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customerID'])) {
                            $sql_update = "UPDATE customer 
                                       SET Name = :Name, Birthdate = :birthdate, Email = :email, CountryCode = :countryCode, OutstandingDebt = :outstandingDebt 
                                       WHERE CustomerID = :customerID";

                            $stmt = $conn->prepare($sql_update);
                            $stmt->bindParam(':customerID', $_POST['customerID']);
                            $stmt->bindParam(':Name', $_POST['Name']);
                            $stmt->bindParam(':birthdate', $_POST['birthdate']);
                            $stmt->bindParam(':email', $_POST['email']);
                            $stmt->bindParam(':countryCode', $_POST['countryCode']);
                            $stmt->bindParam(':outstandingDebt', $_POST['outstandingDebt']);

                            try {
                                if ($stmt->execute()) {
                                    echo "<script>
                                        alert('อัปเดตข้อมูลลูกค้าสำเร็จ!');
                                        window.location.href = 'index.php';
                                      </script>";
                                    exit();
                                }
                            } catch (PDOException $e) {
                                echo '<div class="alert alert-danger">แก้ไขล้มเหลว: ' . $e->getMessage() . '</div>';
                            }
                        }

                        if (isset($_GET['CustomerID'])) {
                            $id = $_GET['CustomerID'];
                            $sql = "SELECT * FROM customer WHERE CustomerID = :id";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':id', $id);
                            $stmt->execute();
                            $customer = $stmt->fetch(PDO::FETCH_ASSOC);

                            if (!$customer) {
                                echo "<script>alert('ไม่พบข้อมูลลูกค้ารายนี้'); window.location.href='index.php';</script>";
                                exit();
                            }

                            // ดึงรายชื่อประเทศมาทำ Dropdown
                            $sql_countries = "SELECT CountryCode, CountryName FROM country ORDER BY CountryName ASC";
                            $stmt_countries = $conn->prepare($sql_countries);
                            $stmt_countries->execute();
                            $countries = $stmt_countries->fetchAll();
                        ?>

                            <form action="updatecustomer.php" method="POST">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">รหัสลูกค้า (อ่านอย่างเดียว)</label>
                                        <input type="text" class="form-control bg-light" name="customerID" value="<?= htmlspecialchars($customer['CustomerID']) ?>" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">ชื่อ-นามสกุล</label>
                                        <input type="text" class="form-control" name="Name" value="<?= htmlspecialchars($customer['Name']) ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">วันเดือนปีเกิด</label>
                                        <input type="date" class="form-control" name="birthdate" value="<?= $customer['Birthdate'] ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">อีเมล</label>
                                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($customer['Email']) ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">เลือกประเทศ</label>
                                        <select class="form-select" name="countryCode" required>
                                            <?php foreach ($countries as $c) {

                                                $selected = ($c['CountryCode'] == $customer['CountryCode']) ? 'selected' : '';
                                            ?>
                                                <option value="<?= $c['CountryCode'] ?>" <?= $selected ?>>
                                                    <?= htmlspecialchars($c['CountryName']) ?> (<?= $c['CountryCode'] ?>)
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">ยอดหนี้คงค้าง</label>
                                        <input type="number" step="0.01" class="form-control" name="outstandingDebt" value="<?= $customer['OutstandingDebt'] ?>" required>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="index.php" class="btn btn-secondary btn-lg">ยกเลิก</a>
                                    <button type="submit" class="btn btn-warning btn-lg">บันทึกการแก้ไข</button>
                                </div>
                            </form>

                        <?php
                        } else {
                            echo "<p class='text-center text-danger'>กรุณาเลือกลูกค้าที่ต้องการแก้ไขจากหน้าแรก</p>";
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>