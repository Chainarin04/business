<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Customer List (Select2)</title>
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            background-color: #fff8f0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #e67e22;
        }

        table {
            width: 850px;
            margin: 0 auto;
            border-collapse: collapse;
            background: white;
            border: 1px solid #f39c12;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #e67e22;
            color: white;
            padding: 12px;
            border: 1px solid #d35400;
        }

        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #fad7a0;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #fef5e7;
        }

        tr:hover {
            background-color: #f8c471;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .center {
            text-align: center;
        }

        .money {
            text-align: right;
            color: #c0392b;
        }
    </style>
</head>

<body>
    <h1>รายชื่อลูกค้า (Select 2 - While Loop)</h1>
    <?php
    require 'connect.php';
    $sql = "SELECT * FROM customer";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    ?>

    <table>
        <thead>
            <tr>
                <th width="10%">รหัส</th>
                <th width="25%">ชื่อ</th>
                <th width="15%">วันเกิด</th>
                <th width="25%">อีเมล์</th>
                <th width="10%">ประเทศ</th>
                <th width="15%">ยอดหนี้</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // ส่วนที่คุณส่งมา ผมเติม code ให้สมบูรณ์ตรงนี้
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <tr>
                    <td class="center"><?php echo $result["CustomerID"]; ?></td>
                    <td><?php echo $result["Name"]; ?></td>
                    <td class="center"><?php echo $result["Birthdate"]; ?></td>
                    <td><?php echo $result["Email"]; ?></td>
                    <td class="center"><?php echo $result["CountryCode"]; ?></td>
                    <td class="money"><?php echo number_format($result["OutstandingDebt"], 2); ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</body>

</html>