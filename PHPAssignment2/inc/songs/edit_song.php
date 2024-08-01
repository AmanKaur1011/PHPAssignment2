<?php
include('../../reusable/connect.php');

$id = $_GET['songId'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $songName = mysqli_real_escape_string($connect, $_POST['songName']);
    $singer = mysqli_real_escape_string($connect, $_POST['singer']);
    $songGenre = mysqli_real_escape_string($connect, $_POST['songGenre']);
    $movie = mysqli_real_escape_string($connect, $_POST['movie']);
    $userRating = mysqli_real_escape_string($connect, $_POST['userRating']);
    $movieId = mysqli_real_escape_string($connect, $_POST['movieId']);
    $releaseDate = mysqli_real_escape_string($connect, $_POST['releaseDate']);

    // Handle file upload for imagePath
    $imagePath = $_POST['currentImage'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $newImagePath = 'images/' . basename($_FILES['image']['name']);
        $actualImagePath = '../../' . $newImagePath;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $actualImagePath)) {
            $imagePath = $newImagePath;
        } else {
            echo "Error: Unable to upload image.";
            exit();
        }
    }

    // Update song in database
    $query = "UPDATE songs SET songName=?, singer=?, songGenre=?, movie=?, userRating=?, movieId=?, releaseDate=?, imagePath=? WHERE songId=?";

    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "ssssssssi", $songName, $singer, $songGenre, $movie, $userRating, $movieId, $releaseDate, $imagePath, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Song updated successfully'); window.location.href='../../index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($connect);
    }

    mysqli_stmt_close($stmt);
} else {
    // Fetch current song data
    $query = "SELECT * FROM songs WHERE songId = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $song = mysqli_fetch_assoc($result);
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
        <h1 class="mt-5 mb-4">Edit Song</h1>
        <form action="edit_song.php?songId=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="songName" class="form-label">Song Name</label>
                <input type="text" class="form-control" id="songName" name="songName" value="<?php echo $song['songName']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="singer" class="form-label">Singer</label>
                <input type="text" class="form-control" id="singer" name="singer" value="<?php echo $song['singer']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="songGenre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="songGenre" name="songGenre" value="<?php echo $song['songGenre']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="movie" class="form-label">Movie</label>
                <input type="text" class="form-control" id="movie" name="movie" value="<?php echo $song['movie']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="userRating" class="form-label">User Rating</label>
                <input type="text" class="form-control" id="userRating" name="userRating" value="<?php echo $song['userRating']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="movieId" class="form-label">Movie ID</label>
                <input type="text" class="form-control" id="movieId" name="movieId" value="<?php echo $song['movieId']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="releaseDate" class="form-label">Release Date</label>
                <input type="date" class="form-control" id="releaseDate" name="releaseDate" value="<?php echo $song['releaseDate']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Song Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <input type="hidden" name="currentImage" value="<?php echo $song['imagePath']; ?>">
                <img src="../../<?php echo $song['imagePath']; ?>" alt="Current Image" class="mt-2" style="max-width: 200px;">
            </div>
            <button type="submit" class="btn btn-primary">Update Song</button>
            <a href="../../index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>