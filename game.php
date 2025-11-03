<?php
session_start();
require_once "config/database.php";

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();

// Ambil data game
$query = "SELECT * FROM games WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$_GET['id']]);
$game = $stmt->fetch(PDO::FETCH_ASSOC);

// Ambil produk game
$query = "SELECT * FROM produk WHERE game_id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$_GET['id']]);
$produk = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $game['nama_game']; ?> - TopUp Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">TopUp Game</a>
            <div class="navbar-nav">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                    <a class="nav-link" href="logout.php">Logout</a>
                <?php else: ?>
                    <a class="nav-link" href="login.php">Login</a>
                    <a class="nav-link" href="register.php">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <img src="images/<?php echo $game['gambar']; ?>" class="img-fluid" alt="<?php echo $game['nama_game']; ?>">
            </div>
            <div class="col-md-8">
                <h1><?php echo $game['nama_game']; ?></h1>
                <p class="lead"><?php echo $game['developer']; ?></p>
                
                <h3>Pilih Produk Top Up</h3>
                <div class="row">
                    <?php foreach($produk as $item): ?>
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $item['nama_produk']; ?></h5>
                                <p class="card-text"><?php echo $item['deskripsi']; ?></p>
                                <h6 class="text-primary">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></h6>
                                <?php if(isset($_SESSION['user_id'])): ?>
                                    <a href="beli.php?produk_id=<?php echo $item['id']; ?>" class="btn btn-success">Beli Sekarang</a>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-warning">Login untuk Beli</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>