<?php
require 'connect.php';


if (isset($_GET['CustomerID'])) {
    $id = $_GET['CustomerID'];

    try {

        $sql = "DELETE FROM customer WHERE CustomerID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {

            echo "<script>
                    alert('ลบข้อมูลลูกค้าสำเร็จแล้ว');
                    window.location.href = 'index.php';
                  </script>";
        }
    } catch (PDOException $e) {
        echo "<script>
                alert('ไม่สามารถลบข้อมูลได้: " . $e->getMessage() . "');
                window.location.href = 'index.php';
              </script>";
    }
} else {

    header("Location: index.php");
}
$conn = null;
