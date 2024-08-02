<?php 
include('../../reusable/connect.php');
session_start();
if (isset($_GET['movieId'])) {
    $id = $_GET['movieId'];

    // Fetching the movie details and related songs
    $query = "SELECT movies.*, songs.songId, songs.imagePath 
              FROM movies 
              LEFT JOIN songs ON movies.movieId = songs.movieId 
              WHERE movies.movieId = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "s", $id); // using s for string 
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $movie = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

} else {
    echo "No movie ID provided for deletion.";
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirm Delete Movie</title>
  <!-- Bootstrap Icons CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
if (isset($movie)) {
    echo '<h1 class="text-center mt-5 px-3 fw-light"> Are you sure you want to Delete this Movie <i class="bi bi-film text-warning"></i></h1>
    <div class="container d-flex justify-content-center align-items-center">
        <div>
            <div class="col d-inline-block mt-5 g-3">
                <div class="row-md-auto fs-5"><span class="badge bg-secondary fs-5 mb-3 fw-normal"> Movie Title :  </span>' . '&nbsp; &nbsp; ' . htmlspecialchars($movie['movieName']) . '</div>
                <div class="row-md-auto fs-5"><span class="badge bg-secondary fs-5 mb-3 fw-normal"> Release Date:  </span>' . '&nbsp; &nbsp;  ' . htmlspecialchars($movie['year']) . '</div>
                <div class="row-md-auto fs-5"><span class="badge bg-secondary fs-5 mb-3 fw-normal"> Genre :  </span>' . '&nbsp; &nbsp;  ' . htmlspecialchars($movie['genre']) . '</div>
            </div>';

    // Fetching and displaying related songs
    $songsQuery = "SELECT songId, songName FROM songs WHERE movieId = ?";
    $stmt = mysqli_prepare($connect, $songsQuery);
    mysqli_stmt_bind_param($stmt, "s", $id); // Using "s" for string
    mysqli_stmt_execute($stmt);
    $songsResult = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($songsResult) > 0) {
        echo '<h2 class="mt-4">Related Songs</h2><ul>';
        while ($song = mysqli_fetch_assoc($songsResult)) {
            echo '<li>' . htmlspecialchars($song['songName']) . '</li>';
        }
        echo '</ul>';
    }
    else{
        echo '<h2 class="mt-4">No Related Songs for this Movie</h2><ul>';
    }

    mysqli_stmt_close($stmt);

    echo '<div class="text-center mt-5">
            <a href="delete_movie.php?movieId=' . urlencode($movie['movieId']) . '" class="btn btn-danger btn-md"> Delete Movie and Related Songs</a>
          </div>
        </div>
    </div>';
}
?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- Font Awesome JS -->
<script src="https://kit.fontawesome.com/db1e295bdd.js" crossorigin="anonymous"></script>
</body>
</html>
