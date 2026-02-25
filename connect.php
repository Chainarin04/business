<?php
$serverName = 'localhost';
$userName = 'root';
$userPassword = ''; // ถ้าคอมที่แล็บมีรหัสผ่าน (เช่น 12345678) ให้เปลี่ยนตรงนี้ครับ
$dbname = 'business';

try {

    $conn = new PDO("mysql:host=$serverName;dbname=$dbname;charset=UTF8", $userName, $userPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Sorry! You cannot connect to database: ' . $e->getMessage();
}
