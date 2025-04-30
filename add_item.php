<?php
require_once 'db.php';
require_once 'session.php';
redirectIfNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $song_name = $_POST['song_name'] ?? '';
    $artist = $_POST['artist'] ?? '';
    $genre = $_POST['genre'] ?? '';
    

    if (isset($_FILES['album_cover']) && $_FILES['album_cover']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['album_cover']['name']);
        $target_path = $upload_dir . $file_name;
        
  
        if (move_uploaded_file($_FILES['album_cover']['tmp_name'], $target_path)) {
            // Insert into database
            $stmt = $pdo->prepare("INSERT INTO songs (song_name, artist, genre, album_cover) VALUES (?, ?, ?, ?)");
            $stmt->execute([$song_name, $artist, $genre, $file_name]);
            
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Failed to upload file";
        }
    } else {
        $error = "Please select an album cover";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Song - Music Playlist</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Add New Song</h1>
            <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
        </header>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data" class="add-song-form">
            <div class="form-group">
                <label for="song_name">Song Name:</label>
                <input type="text" id="song_name" name="song_name" required>
            </div>
            
            <div class="form-group">
                <label for="artist">Artist:</label>
                <input type="text" id="artist" name="artist" required>
            </div>
            
            <div class="form-group">
                <label for="genre">Genre:</label>
                <input type="text" id="genre" name="genre" required>
            </div>
            
            <div class="form-group">
                <label for="album_cover">Album Cover:</label>
                <input type="file" id="album_cover" name="album_cover" accept="image/*" required>
            </div>
            
            <button type="submit" class="btn">Add Song</button>
        </form>
    </div>
</body>
</html> 