<?php
session_start();

// Include database connection
require_once "config/database.php";

$database = new Database();
$db = $database->getConnection();

// Check if connection successful
if (!$db) {
    die("Cannot connect to database");
}

// Get games data
try {
    $query = "SELECT * FROM games";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error loading games: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopUp Game - Home</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .game-card {
            transition: transform 0.3s;
            height: 100%;
        }
        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-img-top {
            height: 200px;
            object-fit: contain;
            background: #f8f9fa;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">🎮 TopUp Game</a>
        <div class="navbar-nav ms-auto">
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
    <h1 class="text-center mb-3">🎯 Top Up Game Produk UCA</h1>
    <p class="text-center text-muted">Pilih game favorit Anda dan top up dengan mudah!</p>

    <div class="row mt-4">
        <?php if(count($games) > 0): ?>
            <?php foreach($games as $game): ?>
                <div class="col-md-4 mb-4">
                    <div class="card game-card text-center">

                        <!-- LOGO GAME -->
                         

                        <img 
    src="images/<?php echo htmlspecialchars($game['gambar'] ?? 'no-image.png'); ?>" 
    class="card-img-top p-3"
    alt="<?php echo htmlspecialchars($game['nama_game']); ?>"
    onerror="this.src='images/no-image.png';"
>

                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($game['nama_game']); ?>
                            </h5>

                            <p class="card-text text-muted">
                                <?php echo htmlspecialchars($game['developer']); ?>
                            </p>

                            <a href="game.php?id=<?php echo $game['id']; ?>" 
                               class="btn btn-primary">
                                Lihat Produk Top Up
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <div class="alert alert-warning">
                    <h4>No Games Found</h4>
                    <p>No games data available in database.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<footer class="bg-dark text-white mt-5 py-3">
    <div class="container text-center">
        <p class="mb-0">&copy; 2024 TopUp Game. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
