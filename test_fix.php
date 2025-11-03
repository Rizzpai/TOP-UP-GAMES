<?php
echo "<h1>Test Database Fix</h1>";

try {
    $host = "localhost";
    $dbname = "topup_game";
    $username = "root";
    $password = "";
    
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✅ Database CONNECTED!</p>";
    
    // Test each table
    $tables = ['users', 'games', 'produk', 'transaksi'];
    
    foreach($tables as $table) {
        $stmt = $conn->query("SELECT COUNT(*) as total FROM $table");
        $result = $stmt->fetch();
        echo "<p>Table <strong>$table</strong>: {$result['total']} rows</p>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>❌ ERROR: " . $e->getMessage() . "</p>";
}
?>