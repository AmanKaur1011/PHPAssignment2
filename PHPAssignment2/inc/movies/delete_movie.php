<?php
include('../../reusable/connect.php');

if (isset($_GET['movieId'])) {
    $id = $_GET['movieId'];

    // Fetch the movie details to delete it's image
    $query = "SELECT imagePath FROM  movies WHERE movieId = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $movie = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    // $moviesQuery = "SELECT imagePath FROM  movies WHERE movieId = ?";
    // $stmt = mysqli_prepare($connect, $moviesQuery);
    
    // if ($stmt) {
    //     mysqli_stmt_bind_param($stmt, "s", $id);
    //     mysqli_stmt_execute($stmt);
    //     $moviesResult = mysqli_stmt_get_result($stmt);

    //     while ($movie = mysqli_fetch_assoc($moviesResult)) {
    //         $relativeImagePath = $movie['imagePath'];
    //         $actualImagePath = __DIR__ . "/../../" . $relativeImagePath;
    //         if (file_exists($actualImagePath)) {
    //             if (!unlink($actualImagePath)) {
    //                 echo "Failed to delete image file: " . htmlspecialchars($actualImagePath);
    //             }
    //         }
    //     }
    //     mysqli_stmt_close($stmt);
    // } else {
    //     echo "Failed to prepare statement for fetching song images: " . mysqli_error($connect);
    // }

    // Delete related songs
    $deleteSongsQuery = "DELETE FROM songs WHERE movieId = ?";
    $stmt = mysqli_prepare($connect, $deleteSongsQuery);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $id);
        if (!mysqli_stmt_execute($stmt)) {
            echo "Error deleting songs: " . mysqli_error($connect);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Failed to prepare statement for deleting songs: " . mysqli_error($connect);
    }

    // Delete the movie from the database
    $deleteMovieQuery = "DELETE FROM movies WHERE movieId = ?";
    $stmt = mysqli_prepare($connect, $deleteMovieQuery);
    mysqli_stmt_bind_param($stmt, "s", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        // $movie['imagePath'] is the image  path relative to the web root (e.g., 'images/song.jpg')
        $relativeImagePath = $movie['imagePath'];
        // Construct the absolute path from the script's location
        // __DIR__  returns the directory of the current path 
        $actualImagePath = __DIR__ . "/../../" . $relativeImagePath;
        // If deletion is successful, delete the image file
        if (file_exists($actualImagePath)) {
            unlink($actualImagePath);
            echo "<script>alert('Movie deleted successfully'); window.location.href='../../index.php';</script>";
        }
        
    } else {
        echo "Error deleting record: " . mysqli_error($connect);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "No  Movie ID provided for deletion.";
}

mysqli_close($connect);
   

