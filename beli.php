<?php
session_start();
require_once "config/database.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

if(!isset($_GET['produk_id'])){
    header("Location: index.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();

// Ambil data produk
$query = "SELECT p.*, g.nama_game FROM produk p JOIN games g ON p.game_id = g.id WHERE p.id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$_GET['produk_id']]);
$produk = $stmt->fetch(PDO::FETCH_ASSOC);

// Ambil data user
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($_POST){
    $jumlah = $_POST['jumlah'];
    $total_harga = $produk['harga'] * $jumlah;
    
    // Cek saldo
    if($user['saldo'] >= $total_harga){
        // Kurangi saldo
        $query = "UPDATE users SET saldo = saldo - ? WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$total_harga, $_SESSION['user_id']]);
        
        // Buat transaksi
        $query = "INSERT INTO transaksi (user_id, produk_id, jumlah, total_harga, status) VALUES (?, ?, ?, ?, 'success')";
        $stmt = $db->prepare($query);
        $stmt->execute([$_SESSION['user_id'], $_GET['produk_id'], $jumlah, $total_harga]);
        
        $_SESSION['success'] = "Pembelian berhasil!";
        header("Location: dashboard.php");
    } else {
        $_SESSION['error'] = "Saldo tidak cukup!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beli <?php echo $produk['nama_produk']; ?> - TopUp Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">TopUp Game</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Konfirmasi Pembelian</h3>
                    </div>
                    <div class="card-body">
                        <?php if(isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <strong>Game:</strong> <?php echo $produk['nama_game']; ?>
                        </div>
                        <div class="mb-3">
                            <strong>Produk:</strong> <?php echo $produk['nama_produk']; ?>
                        </div>
                        <div class="mb-3">
                            <strong>Harga Satuan:</strong> Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
                        </div>
                        <div class="mb-3">
                            <strong>Saldo Anda:</strong> Rp <?php echo number_format($user['saldo'], 0, ',', '.'); ?>
                        </div>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" value="1" min="1" required>
                            </div>
                            <div class="mb-3">
                                <strong>Total Harga: </strong><span id="total_harga">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></span>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Beli Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('jumlah').addEventListener('input', function() {
            var harga = <?php echo $produk['harga']; ?>;
            var jumlah = this.value;
            var total = harga * jumlah;
            document.getElementById('total_harga').textContent = 'Rp ' + total.toLocaleString('id-ID');
        });
    </script>
</body>
</html>