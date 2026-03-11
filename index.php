<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการข้อมูลลูกค้าแบบมืออาชีพ</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .nav-menu {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .nav-menu a {
            text-decoration: none;
            color: #555;
            font-weight: bold;
            padding: 10px 20px;
            margin: 0 5px;
            border-radius: 25px;
            transition: 0.3s;
            display: inline-block;
        }

        .nav-menu a:hover {
            background-color: #e0f2f1;
            color: #009688;
        }

        .nav-menu a.active {
            background-color: #3498db;
            color: white;
        }

        /* Dashboard สรุปภาพรวม */
        .dashboard {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }

        .card-stat {
            flex: 1;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border-bottom: 5px solid #3498db;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .card-stat h3 {
            margin: 0;
            font-size: 28px;
            color: #2c3e50;
        }

        .card-stat p {
            margin: 5px 0 0;
            color: #7f8c8d;
            font-weight: bold;
            font-size: 14px;
        }

        .card-debt {
            border-color: #e74c3c;
        }

        .card-cus {
            border-color: #2ecc71;
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .search-input {
            padding: 8px 15px;
            border: 1px solid #ccc;
            border-radius: 20px;
            outline: none;
            width: 250px;
        }

        .btn-search {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-clear {
            background-color: #95a5a6;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }

        /* ปุ่มต่างๆ */
        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            text-decoration: none;
            color: white;
            transition: 0.3s;
        }

        .btn-add {
            background-color: #2ecc71;
        }

        .btn-country {
            background-color: #f39c12;
        }

        .btn-export {
            background-color: #1abc9c;
        }

        /* สีเขียวมิ้นท์สำหรับ Export */
        .btn:hover {
            filter: brightness(0.9);
        }

        /* ตารางและ Pagination */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eeeeee;
        }

        th {
            background-color: #3498db;
            color: white;
            font-size: 14px;
        }

        tr:hover {
            background-color: #f1f9ff;
        }

        .debt-badge {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 13px;
        }

        .no-debt {
            background-color: #2ecc71;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 25px;
            gap: 5px;
        }

        .page-link {
            padding: 8px 15px;
            background: #ecf0f1;
            text-decoration: none;
            border-radius: 5px;
            color: #333;
            font-weight: bold;
            transition: 0.2s;
        }

        .page-link.active {
            background: #3498db;
            color: white;
        }

        .page-link:hover {
            background: #bdc3c7;
        }

        /* จัดการปุ่มในตาราง */
        .btn-sm {
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 13px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            margin: 0 2px;
            display: inline-block;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="nav-menu">
            <a href="index.php" class="active">🏠 หน้าแรก</a>
            <a href="managecountry.php">🌎 จัดการข้อมูลประเทศ</a>
            <a href="addcustomer.php">👤 เพิ่มข้อมูลลูกค้า</a>
        </div>

        <?php
        require 'connect.php';

        // 1. ดึงข้อมูล Dashboard สรุปภาพรวม
        $stat_sql = "SELECT COUNT(CustomerID) as total_cus, SUM(OutstandingDebt) as total_debt, SUM(CASE WHEN OutstandingDebt > 0 THEN 1 ELSE 0 END) as debt_cus FROM customer";
        $stat_stmt = $conn->query($stat_sql);
        $stats = $stat_stmt->fetch(PDO::FETCH_ASSOC);
        ?>

        <div class="dashboard">
            <div class="card-stat card-cus">
                <h3><?= number_format($stats['total_cus']) ?></h3>
                <p>👥 จำนวนลูกค้าทั้งหมด (คน)</p>
            </div>
            <div class="card-stat card-debt">
                <h3><?= number_format($stats['debt_cus']) ?></h3>
                <p>⚠️ ลูกค้าที่มีค้างชำระ (คน)</p>
            </div>
            <div class="card-stat">
                <h3><?= number_format($stats['total_debt'], 2) ?> ฿</h3>
                <p>💰 ยอดหนี้สะสมรวม</p>
            </div>
        </div>

        <div class="action-bar">
            <form class="search-form" action="index.php" method="GET" style="display:flex; gap:10px;">
                <?php $searchValue = isset($_GET['search']) ? trim($_GET['search']) : ''; ?>
                <input type="text" name="search" class="search-input" placeholder="ค้นหารหัส หรือ ชื่อลูกค้า..." value="<?= htmlspecialchars($searchValue) ?>">
                <button type="submit" class="btn-search">🔍 ค้นหา</button>
                <?php if (!empty($searchValue)): ?><a href="index.php" class="btn-clear">✖ เคลียร์</a><?php endif; ?>
            </form>

            <div class="action-buttons">
                <a href="export.php?search=<?= urlencode($searchValue) ?>" class="btn btn-export">🖨️ Export CSV</a>
                <a href="addcustomer.php" class="btn btn-add">➕ เพิ่มลูกค้าใหม่</a>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>รหัส</th>
                    <th>ชื่อ - นามสกุล</th>
                    <th>อีเมล</th>
                    <th>ประเทศ</th>
                    <th>ยอดหนี้สะสม</th>
                    <th style="text-align: center;">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 2. ระบบแบ่งหน้า (Pagination)
                $per_page = 10; // กำหนดว่าให้แสดงกี่คนต่อ 1 หน้า
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $start = ($page - 1) * $per_page;

                // สร้างคำสั่ง SQL เพื่อนับจำนวนข้อมูลทั้งหมด
                $count_sql = "SELECT COUNT(*) FROM customer WHERE 1=1";
                if (!empty($searchValue)) {
                    $count_sql .= " AND (CustomerID LIKE :search OR Name LIKE :search)";
                }

                $count_stmt = $conn->prepare($count_sql);
                if (!empty($searchValue)) {
                    $count_stmt->bindValue(':search', "%$searchValue%");
                }
                $count_stmt->execute();
                $total_records = $count_stmt->fetchColumn();
                $total_pages = ceil($total_records / $per_page);

                // 3. ดึงข้อมูลมาแสดงตามหน้า
                $sql = "SELECT c.CustomerID, c.Name, c.Email, co.CountryName, c.OutstandingDebt 
                        FROM customer c 
                        JOIN country co ON c.CountryCode = co.CountryCode WHERE 1=1";

                if (!empty($searchValue)) {
                    $sql .= " AND (c.CustomerID LIKE :search OR c.Name LIKE :search)";
                }
                $sql .= " ORDER BY c.CustomerID ASC LIMIT :start, :per_page";

                $stmt = $conn->prepare($sql);
                if (!empty($searchValue)) {
                    $stmt->bindValue(':search', "%$searchValue%");
                }

                // Binding แบบ INT สำหรับ LIMIT ของ PDO
                $stmt->bindValue(':start', $start, PDO::PARAM_INT);
                $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $debtClass = ($row['OutstandingDebt'] > 0) ? 'debt-badge' : 'debt-badge no-debt';
                        echo "<tr>";
                        echo "<td><strong>{$row['CustomerID']}</strong></td>";
                        echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['CountryName']) . "</td>";
                        echo "<td><span class='$debtClass'>" . number_format($row['OutstandingDebt'], 2) . " ฿</span></td>";
                        echo "<td style='text-align: center;'>
                                <a href='detail.php?CustomerID={$row['CustomerID']}' class='btn-sm' style='background:#3498db;'>🔍</a>
                                <a href='updatecustomer.php?CustomerID={$row['CustomerID']}' class='btn-sm' style='background:#f39c12;'>✏️</a>
                                <a href='deletecustomer.php?CustomerID={$row['CustomerID']}' class='btn-sm' style='background:#e74c3c;' onclick='return confirm(\"ลบข้อมูลนี้?\")'>🗑️</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center; padding:30px;'>ไม่พบข้อมูล</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="index.php?page=<?= $i ?>&search=<?= urlencode($searchValue) ?>" class="page-link <?= ($i == $page) ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

    </div>
</body>

</html>