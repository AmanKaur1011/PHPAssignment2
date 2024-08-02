<?php
include('../../reusable/connect.php');
session_start();
$id = $_GET['movieId'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $movieName = mysqli_real_escape_string($connect, $_POST['movieName']);
    $genre = mysqli_real_escape_string($connect, $_POST['genre']);
    $overview = mysqli_real_escape_string($connect, $_POST['overview']);
    $cast = mysqli_real_escape_string($connect, $_POST['cast']);
    $director = mysqli_real_escape_string($connect, $_POST['director']);
    $year = mysqli_real_escape_string($connect, $_POST['year']);
    

     // Handle file upload for imagePath
     $imagepath = $_POST['currentImage'];
     if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
         $newImagePath = 'images/' . basename($_FILES['image']['name']);
         $actualImagePath = '../../' . $newImagePath;
         if (move_uploaded_file($_FILES['image']['tmp_name'], $actualImagePath)) {
             $imagepath = $newImagePath;
         } else {
             echo "Error: Unable to upload image.";
             exit();
         }
     }

    // Update song in database
    $query = "UPDATE movies SET movieName=?, genre=?, overview=?, cast=?, director=?, year=?,  imagepath=? WHERE movieId=?";

    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "ssssssss", $movieName, $genre, $overview, $cast, $director, $year, $imagepath, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Movie updated successfully'); window.location.href='../../moviesList.php';</script>";
    } else {
        echo "Error: " . mysqli_error($connect);
    }

    mysqli_stmt_close($stmt);
} else {
    // Fetch current song data
    $query = "SELECT * FROM movies WHERE movieId = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $movie = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Song</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="mt-5 mb-4">Edit  Movie</h1>
        <form action="edit_movie.php?movieId=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="movieName" class="form-label">Movie Name</label>
                <input type="text" class="form-control" id="movieName" name="movieName" value="<?php echo $movie['movieName']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?php echo $movie['genre']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="overview" class="form-label">Overview</label>
                <input type="text" class="form-control" id="overview" name="overview" value="<?php echo $movie['overview']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Year of Release</label>
                <input type="text" class="form-control" id="year" name="year" value="<?php echo $movie['year']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="cast" class="form-label">Cast</label>
                <input type="text" class="form-control" id="cast" name="cast" value="<?php echo $movie['cast']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="director" class="form-label">Director</label>
                <input type="text" class="form-control" id="director" name="director" value="<?php echo $movie['director']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Movie Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <input type="hidden" name="currentImage" value="<?php echo $movie['imagepath']; ?>">
                <img src="../../<?php echo $movie['imagepath']; ?>" alt="Current Image" class="mt-2" style="max-width: 200px;">
            </div>
            <button type="submit" class="btn btn-primary">Update Movie</button>
            <a href="../../moviesList.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>