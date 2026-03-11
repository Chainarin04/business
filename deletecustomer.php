<?php
require 'connect.php';

// ตรวจสอบว่ามีค่า CustomerID ส่งมาเพื่อทำการลบหรือไม่
if (isset($_GET['CustomerID']) && !empty($_GET['CustomerID'])) {
    $id = $_GET['CustomerID'];

    try {
        // เตรียมคำสั่งลบข้อมูล
        $sql = "DELETE FROM customer WHERE CustomerID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);

        // ดำเนินการลบและแจ้งผล
        if ($stmt->execute()) {
            echo "<script>
                    alert('ลบข้อมูลลูกค้าสำเร็จแล้ว!');
                    window.location.href = 'index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('เกิดข้อผิดพลาด: ไม่สามารถลบข้อมูลได้');
                    window.location.href = 'index.php';
                  </script>";
        }
    } catch (PDOException $e) {
        // ดักจับ Error เผื่อติดเรื่อง Foreign Key
        echo "<script>
                alert('ไม่สามารถลบข้อมูลได้เนื่องจากระบบฐานข้อมูลขัดข้อง: " . addslashes($e->getMessage()) . "');
                window.location.href = 'index.php';
              </script>";
    }
} else {
    // หากเข้าหน้านี้โดยไม่มีรหัสลูกค้าให้เด้งกลับหน้าแรกทันที
    header("Location: index.php");
    exit();
}

$conn = null;
