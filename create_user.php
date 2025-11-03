<?php
// Create new user with correct password
require_once "config/database.php";

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    die("Database connection failed");
}

$username = "admin";
$email = "admin@example.com";
$password = password_hash("123456", PASSWORD_DEFAULT); // Password: 123456

try {
    $query = "INSERT INTO users (username, email, password, saldo) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$username, $email, $password, 500000]);
    
    echo "<h1>User Created Successfully!</h1>";
    echo "<p><strong>Username:</strong> $username</p>";
    echo "<p><strong>Password:</strong> 123456</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo '<a href="login.php" class="btn btn-success">Go to Login</a>';
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>