<?php
require 'connect.php';

// ตั้งค่าให้เบราว์เซอร์รู้ว่านี่คือไฟล์ดาวน์โหลดแบบ CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Customer_Report_' . date('Y-m-d') . '.csv');

// สร้าง output
$output = fopen('php://output', 'w');

// เพิ่ม BOM (Byte Order Mark) เพื่อให้ Excel อ่านภาษาไทยได้ไม่เพี้ยน
fputs($output, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

// พิมพ์หัวตาราง
fputcsv($output, array('รหัสลูกค้า', 'ชื่อ-นามสกุล', 'วันเกิด', 'อีเมล', 'รหัสประเทศ', 'ชื่อประเทศ', 'ยอดหนี้สะสม'));

// ดึงข้อมูล (รองรับการค้นหาด้วย ถ้าส่งมาจากหน้าแรก)
$searchValue = isset($_GET['search']) ? trim($_GET['search']) : '';
$sql = "SELECT c.CustomerID, c.Name, c.Birthdate, c.Email, c.CountryCode, co.CountryName, c.OutstandingDebt 
        FROM customer c 
        JOIN country co ON c.CountryCode = co.CountryCode";

if (!empty($searchValue)) {
    $sql .= " WHERE c.CustomerID LIKE :search OR c.Name LIKE :search";
}
$sql .= " ORDER BY c.CustomerID ASC";

$stmt = $conn->prepare($sql);
if (!empty($searchValue)) {
    $stmt->bindValue(':search', "%$searchValue%");
}
$stmt->execute();

// วนลูปนำข้อมูลใส่ CSV
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, array(
        $row['CustomerID'],
        $row['Name'],
        $row['Birthdate'],
        $row['Email'],
        $row['CountryCode'],
        $row['CountryName'],
        $row['OutstandingDebt']
    ));
}
fclose($output);
exit();
