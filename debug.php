<?php
echo "<h1>Debug Koneksi Database</h1>";

require_once "config/database.php";

$database = new Database();
$db = $database->getConnection();

if($db) {
    echo "✅ Koneksi BERHASIL<br>";
    
    // Test query
    $stmt = $db->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Tables in database: " . implode(", ", $tables);
} else {
    echo "❌ Koneksi GAGAL";
}
?>