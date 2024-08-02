<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>

<body>
    <?php
    session_start();
    include('reusable/connect.php');
    $id = $_GET['movieId'];
    $query = "SELECT * FROM movies WHERE movieId = '$id'";
    $movie = mysqli_query($connect, $query);
    $result = $movie->fetch_assoc();
    ?>

    <div class="container-fluid">
        <div class="container">
            <h1 class="display-4 mt-5 mb-5 pb-2 border-bottom border-white">Movie Details <i class="fa-solid fa-film"></i></h1>
            <div class="row align-items-center gap-5">
                <?php
                echo '<div class="col-md-auto  " >
                        <img src="' . $result['imagepath'] . '" class="object-fit-fill w-100 rounded-4" height="400" alt="movie cover">
                      </div>
                      <div class="col-md-7">
                        <h2 class="display-5 mb-5">' . $result['movieName'] . ' (' . $result['year'] . ')</h2>
                        <p>' . $result['overview'] . '</p>
                        <p><span class="badge bg-secondary fs-6 mb-3 fw-normal"> Director :  </span> '.'&nbsp; ' . $result['director'] . '</p>
                        <p><span class="badge bg-secondary fs-6 mb-3 fw-normal"> Cast :  </span>' .'&nbsp; '. $result['cast'] . '</p>
                        <p><span class="badge bg-secondary fs-6 mb-3 fw-normal"> Genre :  </span> ' .'&nbsp; '. $result['genre'] . '</p>';
                        
                        //Add Edit and Delete buttons 
                        // Only show Edit and Delete buttons if admin is logged in
                      if (isset($_SESSION['admin_id'])) {
                        echo '<div class="mt-4">
                          <a href="inc/movies/edit_movie.php?movieId=' . $result['movieId'] . '" class="btn btn-outline-warning me-2">Edit Movie</a>
                          <a href="inc/movies/delete_movie.php?movieId=' . $result['movieId'] . '" class="btn btn-outline-danger" onclick="return confirm(\'Are you sure you want to delete this movie? This will also delete all associated songs.\')">Delete Movie</a>';}
                       echo ' </div>
                      </div>';
                ?>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
     <!-- Font Awesome JS -->
    <script src="https://kit.fontawesome.com/db1e295bdd.js" crossorigin="anonymous"></script>
</body>

</html>