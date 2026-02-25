<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ดูข้อมูลselect1.php</title>
</head>

<body>
    <?php
    require 'connect.php';
    // ทดสอบเรียกดูข้อมูลจากฐานข้อมูล แบบ Loop พร้อมดึงชื่อประเทศ (Exercise)
    $sql = 'SELECT customer.*, country.CountryName 
            FROM customer 
            JOIN country ON customer.CountryCode = country.CountryCode';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo '<br/>';

    $result = $stmt->fetchAll();

    foreach ($result as $r) {
        // ปรับให้โชว์ รหัส--ชื่อ--ยอดหนี้--ชื่อประเทศ ตาม Exercise
        print $r['CustomerID'] . '--' . $r['Name'] . '--' . $r['OutstandingDebt'] . '--' . $r['CountryName'] . '<br>';
    }
    ?>
</body>

</html>