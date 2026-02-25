<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Customer List (Select1)</title>
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            background-color: #eef2f3;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        table {
            width: 800px;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background-color: #3498db;
            color: white;
            padding: 15px;
        }

        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            color: #555;
        }

        tr:hover {
            background-color: #d6eaf8;
            transition: 0.3s;
        }

        /* สไตล์สำหรับลิงก์รหัสลูกค้า (ธีมสีฟ้า) */
        .link-id {
            text-decoration: none;
            color: #2980b9;
            font-weight: bold;
            padding: 5px 10px;
            border: 1px solid #3498db;
            border-radius: 15px;
            transition: 0.3s;
        }

        .link-id:hover {
            background-color: #3498db;
            color: white;
        }
    </style>
</head>

<body>
    <h1>รายชื่อลูกค้า (Select 1 - Foreach Loop)</h1>
    <?php
    require 'connect.php';
    // ดึงข้อมูลพร้อมชื่อประเทศภาษาไทย
    $sql = "SELECT customer.*, country.CountryName 
            FROM customer 
            JOIN country ON customer.CountryCode = country.CountryCode";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    ?>

    <table>
        <tr>
            <th>รหัสลูกค้า</th>
            <th>ชื่อ - นามสกุล</th>
            <th>วันเกิด</th>
            <th>อีเมล</th>
            <th>ประเทศ</th>
            <th>ยอดหนี้</th>
        </tr>

        <?php foreach ($result as $r) { ?>
            <tr>
                <td>
                    <a href="detail.php?CustomerID=<?= $r['CustomerID'] ?>" class="link-id">
                        <?= $r['CustomerID'] ?>
                    </a>
                </td>
                <td><?= $r['Name'] ?></td>
                <td><?= $r['Birthdate'] ?></td>
                <td><?= $r['Email'] ?></td>
                <td><?= $r['CountryName'] ?></td>
                <td><?= number_format($r['OutstandingDebt'], 2) ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>