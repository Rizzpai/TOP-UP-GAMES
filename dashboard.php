<?php
session_start();
require_once "config/database.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();

// Ambil data user
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Ambri riwayat transaksi
$query = "SELECT t.*, p.nama_produk, g.nama_game 
          FROM transaksi t 
          JOIN produk p ON t.produk_id = p.id 
          JOIN games g ON p.game_id = g.id 
          WHERE t.user_id = ? 
          ORDER BY t.created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$transaksi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TopUp Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">TopUp Game</a>
            <div class="navbar-nav">
                <a class="nav-link" href="index.php">Home</a>
                <a class="nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Dashboard</h2>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Saldo</div>
                    <div class="card-body">
                        <h4 class="card-title">Rp <?php echo number_format($user['saldo'], 0, ',', '.'); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <h3>Riwayat Transaksi</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Game</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($transaksi as $trx): ?>
                <tr>
                    <td><?php echo $trx['nama_game']; ?></td>
                    <td><?php echo $trx['nama_produk']; ?></td>
                    <td><?php echo $trx['jumlah']; ?></td>
                    <td>Rp <?php echo number_format($trx['total_harga'], 0, ',', '.'); ?></td>
                    <td>
                        <span class="badge bg-<?php echo $trx['status'] == 'success' ? 'success' : ($trx['status'] == 'pending' ? 'warning' : 'danger'); ?>">
                            <?php echo ucfirst($trx['status']); ?>
                        </span>
                    </td>
                    <td><?php echo date('d/m/Y H:i', strtotime($trx['created_at'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>