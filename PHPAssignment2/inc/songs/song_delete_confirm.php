<?php 
include('../../reusable/connect.php');
if (isset($_GET['songId'])) {
    $id = $_GET['songId'];



    // Fetch the song details 
    $query = "SELECT * FROM songs JOIN movies ON songs.movieId = movies.movieId WHERE songId = ? ";
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
  <title>Bollywood Hit Songs (2017-2019)</title>
  <!-- Bootstrap Icons CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
echo '<h1 class="text-center  mt-5 px-3 fw-light"> Are you sure you want to Delete this Song <i class="bi bi-music-note text-warning"></i></h1>
<div class="container d-flex justify-content-center align-items-center "><div>
<div class="col d-inline-block mt-5 g-3 ">
<div class=" row-md-auto fs-5"><span class="  badge bg-secondary fs-5 mb-3 fw-normal"> Song Name :  </span>  ' . '&nbsp; &nbsp; ' . $song['songName'] . '</div>
<div class="  row-md-auto fs-5"><span class="  badge bg-secondary fs-5 mb-3 fw-normal"> Release Date:  </span>' . '&nbsp; &nbsp;  ' . $song['releaseDate'] . '</div>
<div class="  row-md-auto fs-5"><span class="  badge bg-secondary fs-5 mb-3 fw-normal"> Movie Name :  </span>' . '&nbsp; &nbsp;  ' . $song['movieName'] . '</div>
</div>
<div class="text-center mt-5">
<a  href="delete_song.php?songId='. $song['songId'].'" class="  btn btn-danger btn-md"> Delete Song</a>
</div>'
?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
  crossorigin="anonymous"></script>
  <!-- Font Awesome JS -->
  <script src="https://kit.fontawesome.com/db1e295bdd.js" crossorigin="anonymous"></script>
</body>
</html>