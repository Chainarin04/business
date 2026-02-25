<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Customer List (Select0)</title>
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 800px;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #009879;
            color: #ffffff;
            text-transform: uppercase;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        tr:nth-child(even) {
            background-color: #fcfcfc;
        }
    </style>
</head>

<body>
    <h1>รายชื่อลูกค้า (Select 0)</h1>
    <?php
    require 'connect.php';
    $sql = "SELECT * FROM customer";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    ?>

    <table border="1">
        <thead>
            <tr>
                <th width="90">รหัสผู้ใช้</th>
                <th width="140">ชื่อ</th>
                <th width="120">วันเกิด</th>
                <th width="100">อีเมล์</th>
                <th width="50">ประเทศ</th>
                <th width="70">ยอดหนี้</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // ใช้ while ตามที่คุณขอมา
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <tr>
                    <td><?php echo $result["CustomerID"]; ?></td>
                    <td><?php echo $result["Name"]; ?></td>
                    <td><?php echo $result["Birthdate"]; ?></td>
                    <td><?php echo $result["Email"]; ?></td>
                    <td><?php echo $result["CountryCode"]; ?></td>
                    <td><?php echo $result["OutstandingDebt"]; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>