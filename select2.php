<html>

<head>
    <title>Show Customer Information</title>
</head>

<body>
    <?php
    try {
        require 'connect.php';
        // เติมคำสั่ง SQL ในช่องว่าง
        $sql = "SELECT * FROM customer";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        //แบบที่ 1
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<br>' .
                'รหัสลูกค้า : ' .
                $result['CustomerID'] .
                ' วันเกิด : ' .
                $result['Birthdate'] .
                ' ยอดหนี้ : ' .
                $result['OutstandingDebt'];
        }
    } catch (PDOException $e) {
        echo 'ไม่สามารถประมวลผลข้อมูลได้ : ' . $e->getMessage();
    }
    $conn = null;
    ?>
</body>

</html>