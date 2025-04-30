<?php
require_once 'db.php';
require_once 'session.php';
redirectIfNotLoggedIn();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
        // Get the album cover filename
    $stmt = $pdo->prepare("SELECT album_cover FROM songs WHERE id = ?");
    $stmt->execute([$id]);
    $song = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($song) {
        # delete the album cover file
        $file_path = 'uploads/' . $song['album_cover'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        
       #delete the song from the database
        $stmt = $pdo->prepare("DELETE FROM songs WHERE id = ?");
        $stmt->execute([$id]);
    }
}

header("Location: dashboard.php");
exit();
?>
