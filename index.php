<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการข้อมูลลูกค้า (Customer Information)</title>
    <style>
        /* จัดรูปแบบพื้นหลังและฟอนต์ */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 40px 20px;
        }

        /* จัดรูปแบบกล่องเนื้อหาตรงกลาง */
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            display: inline-block;
        }

        .header-wrapper {
            text-align: center;
        }

        /* จัดรูปแบบตาราง */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eeeeee;
        }

        th {
            background-color: #3498db;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        /* เอฟเฟกต์ตอนชี้เมาส์ที่แถว */
        tr:hover {
            background-color: #f1f9ff;
            transition: background-color 0.3s ease;
        }

        /* จัดรูปแบบป้ายสถานะหนี้ */
        .debt-badge {
            background-color: #e74c3c;
            /* สีแดงสำหรับคนมีหนี้ */
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            display: inline-block;
        }

        .no-debt {
            background-color: #2ecc71;
            /* สีเขียวสำหรับคนไม่มีหนี้ */
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header-wrapper">
            <h2>📋 ข้อมูลลูกค้า (Customer Information)</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>รหัสลูกค้า</th>
                    <th>ชื่อ - นามสกุล</th>
                    <th>วันเกิด</th>
                    <th>อีเมล</th>
                    <th>ประเทศ</th>
                    <th>ยอดหนี้สะสม</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    // เรียกไฟล์เชื่อมต่อฐานข้อมูล
                    require 'connect.php';

                    // ใช้ JOIN ใน SQL เพื่อนำชื่อประเทศจากตาราง country มาแสดงแทน CountryCode
                    $sql = "SELECT c.CustomerID, c.Name, c.Birthdate, c.Email, co.CountryName, c.OutstandingDebt 
                            FROM customer c 
                            JOIN country co ON c.CountryCode = co.CountryCode";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    // ลูปข้อมูลมาแสดงแบบ PDO::FETCH_ASSOC
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // เช็คยอดหนี้เพื่อเปลี่ยนสีป้าย (Badge)
                        $debtClass = ($row['OutstandingDebt'] > 0) ? 'debt-badge' : 'debt-badge no-debt';

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['CustomerID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Birthdate']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['CountryName']) . "</td>";
                        // แปลงตัวเลขให้มีคอมม่าและทศนิยม 2 ตำแหน่ง
                        echo "<td><span class='$debtClass'>" . number_format($row['OutstandingDebt'], 2) . " ฿</span></td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='6' style='text-align:center; color:red;'>ไม่สามารถประมวลผลข้อมูลได้ : " . $e->getMessage() . "</td></tr>";
                }
                $conn = null;
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>