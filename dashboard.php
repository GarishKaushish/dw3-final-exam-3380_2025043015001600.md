<?php
require_once 'db.php';
require_once 'session.php';
redirectIfNotLoggedIn();

#retrive all songs from the database    
$stmt = $pdo->query("SELECT * FROM songs ORDER BY created_at DESC");
$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard - Music Playlist</title>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
    <div class="container">
        <header>
            <h1>🎶 Music Playlist Dashboard</h1>
            <div class="user-info">
                <span>Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</span>
                <a href="logout.php" class="btn logout-btn">Logout</a>
            </div>
        </header>

        <section class="add-song" aria-label="Add a new song">
            <a href="add_item.php" class="btn">➕ Add New Song</a>
        </section>

        <section class="songs-grid" aria-label="Your Songs">
            <?php if (!empty($songs)): ?>
                <?php foreach ($songs as $song): ?>
                    <div class="song-card">
                        <img src="uploads/<?php echo htmlspecialchars($song['album_cover']); ?>" alt="Album cover for <?php echo htmlspecialchars($song['song_name']); ?>">
                        <h3><?php echo htmlspecialchars($song['song_name']); ?></h3>
                        <p><strong>Artist:</strong> <?php echo htmlspecialchars($song['artist']); ?></p>
                        <p><strong>Genre:</strong> <?php echo htmlspecialchars($song['genre']); ?></p>
                        <a 
                            href="delete_item.php?id=<?php echo $song['id']; ?>" 
                            class="delete-btn"
                            onclick="return confirm('Are you sure you want to delete this song?')"
                        >
                            🗑️ Delete
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No songs found. Start by adding one!</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
