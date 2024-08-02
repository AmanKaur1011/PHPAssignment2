<?php
include('../../reusable/connect.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $movieId = mysqli_real_escape_string($connect, $_POST['movieId']);
    $movieName = mysqli_real_escape_string($connect, $_POST['movieName']);
    $year = mysqli_real_escape_string($connect, $_POST['year']);
    $genre = mysqli_real_escape_string($connect, $_POST['genre']);
    $overview = mysqli_real_escape_string($connect, $_POST['overview']);
    $director = mysqli_real_escape_string($connect, $_POST['director']);
    $cast = mysqli_real_escape_string($connect, $_POST['cast']);


    // Handle file upload for imagePath
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imagePath = 'images/' . basename($_FILES['image']['name']);
        $actualImagePath= '../../images/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $actualImagePath);
    }

    // Insert new song into database
    $query = "INSERT INTO movies (movieId, movieName, year, genre, overview, director, cast, imagePath) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "ssssssss", $movieId, $movieName, $year, $genre, $overview, $director, $cast, $imagePath);

    if (mysqli_stmt_execute($stmt)) {
        echo "<div class=' mt-3 alert alert-success' role='alert' >New Movie added successfully </div>";
    } else {
        echo "<div class=' mt-3 alert alert-danger' role='alert' >An Error occured". mysqli_error($connect)."</div>" ;
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
    <div class="container">
        <h1 class="mt-5 mb-4">Add New Movie</h1>
        <a href="../../index.php"class=" mb-3 btn btn-outline-primary">Back To Home Page</a>
        <form action="add_movie.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="movieId" class="form-label">Movie Id</label>
                <input type="text" class="form-control" id="movieId" name="movieId" required>
            </div>    
            <div class="mb-3">
                <label for="movieName" class="form-label">Movie Name</label>
                <input type="text" class="form-control" id="movieName" name="movieName" required>
            </div>
            
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Year of Release</label>
                <input type="text" class="form-control" id="year" name="year" required>
            </div>
            <div class="mb-3">
                <label for="overview" class="form-label">Overview</label>
                <input type="text" class="form-control" id="overview" name="overview" required>
            </div>
            <div class="mb-3">
                <label for="director" class="form-label">Director</label>
                <input type="text" class="form-control" id="director" name="director" required>
            </div>
            <div class="mb-3">
                <label for="cast" class="form-label">Cast</label>
                <input type="text" class="form-control" id="cast" name="cast" required>
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">Movie Cover Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-success mb-3">Add Movie</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>