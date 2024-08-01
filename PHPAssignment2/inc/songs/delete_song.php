<?php
include('../../reusable/connect.php');

if (isset($_GET['songId'])) {
    $id = $_GET['songId'];

    // Fetch the song details to get the image path
    $query = "SELECT imagePath FROM songs WHERE songId = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $song = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    // Delete the song from the database
    $query = "DELETE FROM songs WHERE songId = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        // $song['imagePath'] is the image  path relative to the web root (e.g., 'images/song.jpg')
        $relativeImagePath = $song['imagePath'];
        // Construct the absolute path from the script's location
        // __DIR__  returns the directory of the current path 
        $actualImagePath = __DIR__ . "/../../" . $relativeImagePath;
        // If deletion is successful, delete the image file
        if (file_exists($actualImagePath)) {
            unlink($actualImagePath);
            echo "<script>alert('Song deleted successfully'); window.location.href='../../index.php';</script>";
        }
        
    } else {
        echo "Error deleting record: " . mysqli_error($connect);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "No song ID provided for deletion.";
}

mysqli_close($connect);
