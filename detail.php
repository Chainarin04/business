<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Customer Detail</title>
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        .card h2 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #3498db;
            display: inline-block;
            padding-bottom: 10px;
        }

        .info-row {
            text-align: left;
            margin: 15px 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 100px;
        }

        .value {
            color: #333;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: 0.3s;
        }

        .back-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>

    <div class="card">
        <?php
        require 'connect.php';


        if (isset($_GET['CustomerID'])) {
            $id = $_GET['CustomerID'];


            $sql = "SELECT * FROM customer WHERE CustomerID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
        ?>
                <h2>ข้อมูลลูกค้า</h2>
                <div class="info-row">
                    <span class="label">รหัสลูกค้า:</span>
                    <span class="value"><?php echo $result['CustomerID']; ?></span>
                </div>
                <div class="info-row">
                    <span class="label">ชื่อ-สกุล:</span>
                    <span class="value"><?php echo $result['Name']; ?></span>
                </div>
                <div class="info-row">
                    <span class="label">วันเกิด:</span>
                    <span class="value"><?php echo $result['Birthdate']; ?></span>
                </div>
                <div class="info-row">
                    <span class="label">อีเมล:</span>
                    <span class="value"><?php echo $result['Email']; ?></span>
                </div>
                <div class="info-row">
                    <span class="label">ประเทศ:</span>
                    <span class="value"><?php echo $result['CountryCode']; ?></span>
                </div>
                <div class="info-row">
                    <span class="label">ยอดหนี้:</span>
                    <span class="value"><?php echo number_format($result['OutstandingDebt'], 2); ?></span>
                </div>
        <?php
            } else {
                echo "<p style='color:red;'>ไม่พบข้อมูลลูกค้ารายนี้</p>";
            }
        }
        ?>

        <a href="select1.php" class="back-btn">กลับหน้าหลัก</a>
    </div>

</body>

</html>