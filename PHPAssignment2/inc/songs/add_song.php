<?php
include('../../reusable/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $songId = mysqli_real_escape_string($connect, $_POST['songId']);
    $songName = mysqli_real_escape_string($connect, $_POST['songName']);
    $singer = mysqli_real_escape_string($connect, $_POST['singer']);
    $songGenre = mysqli_real_escape_string($connect, $_POST['songGenre']);
    $movie = mysqli_real_escape_string($connect, $_POST['movie']);
    $userRating = mysqli_real_escape_string($connect, $_POST['userRating']);
    $movieId = mysqli_real_escape_string($connect, $_POST['movieId']);
    $releaseDate = mysqli_real_escape_string($connect, $_POST['releaseDate']);
    $videoId = mysqli_real_escape_string($connect, $_POST['video']);

    // Handle file upload for imagePath
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imagePath = 'images/' . basename($_FILES['image']['name']);
        $actualImagePath= '../../images/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'],$actualImagePath);
    }

    // Insert new song into database
    $query = "INSERT INTO songs (songId,songName, singer, songGenre, movie, userRating, movieId, releaseDate, imagePath, videoId) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "ssssssssss", $songId,$songName, $singer, $songGenre, $movie, $userRating, $movieId, $releaseDate, $imagePath, $videoId);

    if (mysqli_stmt_execute($stmt)) {
        echo "<div class=' mt-3 alert alert-success' role='alert' >New  Song added successfully </div>";
    } else {
        echo "<div class='mt-3 alert alert-danger' role='alert' >An Error occured". mysqli_error($connect)."</div>" ;
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Song</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container ">
        <h1 class="mt-5 mb-4">Add New Song</h1>
        <a href="../../index.php"class=" mb-3 btn btn-outline-primary">Back To Home Page</a>
        <form action="add_song.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="songId" class="form-label">Song Id</label>
                <input type="number" class="form-control" id="songId" name="songId" required>
            </div>
            <div class="mb-3">
                <label for="songName" class="form-label">Song Name</label>
                <input type="text" class="form-control" id="songName" name="songName" required>
            </div>
            <div class="mb-3">
                <label for="singer" class="form-label">Singer</label>
                <input type="text" class="form-control" id="singer" name="singer" required>
            </div>
            <div class="mb-3">
                <label for="songGenre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="songGenre" name="songGenre" required>
            </div>
            <div class="mb-3">
                <label for="movie" class="form-label">Movie</label>
                <input type="text" class="form-control" id="movie" name="movie" required>
            </div>
            <div class="mb-3">
                <label for="userRating" class="form-label">User Rating</label>
                <input type="text" class="form-control" id="userRating" name="userRating" required>
            </div>
            <div class="mb-3">
                <label for="movieId" class="form-label">Movie ID</label>
                <input type="text" class="form-control" id="movieId" name="movieId" required>
            </div>
            <div class="mb-3">
                <label for="releaseDate" class="form-label">Release Date</label>
                <input type="date" class="form-control" id="releaseDate" name="releaseDate" required>
            </div>
            <div class="mb-3">
                <label for="video" class="form-label">Song Youtube Video Id</label>
                <input type="text" class="form-control" id="video" name="video">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Song Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-success mb-3">Add Song</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>