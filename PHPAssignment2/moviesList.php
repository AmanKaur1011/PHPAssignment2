<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link  href="css/styles.css" rel="stylesheet">
    
</head>

<body>
    <?php
    include('reusable/connect.php');
    
    try {
        // SQL query to fetch all movies with their  song details
        $query = 'SELECT * FROM movies';
        $result = $connect->query($query);

        // Check if the query was successful
        if ($result === false) {
          throw new Exception("Query failed: " . $connect->error);
        }

        $totalRows = $result->num_rows;
        

        if ($totalRows == 0) {
          echo "<div class='alert alert-warning'>No movies found in the database.</div>";
        } else {
          $movies= $result;
        }}
        catch (Exception $e) {
            // Display any errors that occur during the process
            echo '<div class="alert alert-danger" role="alert">';
            echo 'An error occurred: ' . htmlspecialchars($e->getMessage());
            echo '</div>';
          }
    
    ?>

    <div class="container-fluid">
        <div class="container">
            <?php 
        echo "<h2 class='display-5 mt-5 mb-5 pb-2 text-white border-bottom border-white'>Bollywood Movies <i class='fa-solid fa-film'></i></h2>
        <a href='index.php' class=' mb-3 btn btn-outline-primary'>Back To Home Page</a>";
        if (empty($movies)) {
            echo "<div class='alert alert-warning'>No movies found .</div>";
        } else {
            echo '<div class="row mb-3">';
        foreach ($movies as $movie) {
            // Display each movie in a Bootstrap card
        echo '<div class="col-md-4 g-5 ">
                    <div class="card movies"  >
                      <img src="' . htmlspecialchars($movie['imagepath']) . '" class="card-img-top" alt="song cover picture" style="height:370px">
                      <div class="card-body">
                        <h5 class="card-title fs-4 fw-normal">' . htmlspecialchars($movie['movieName']) . ' <i class="bi bi-music-note text-warning"></i></h5>
                        <!-- <div class="card-text">
                           <i class="fa-solid fa-file-video"></i> <a href="movieDetail.php?movieId=' . htmlspecialchars($movie['movieId']) . '" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover text-bg-danger-subtle">' . htmlspecialchars($movie['movieName']) . '</a>
                        </div> -->
                        <div class="card-text mt-3 d-flex justify-content-between">
                          <a href="movieDetail.php?movieId=' . htmlspecialchars($movie['movieId']) . '" class="btn btn-outline-primary ">Details</a>
                          <a href="inc/movies/edit_movie.php?movieId=' . htmlspecialchars($movie['movieId']) . '" class="btn btn-outline-warning " data-bs-toggle="tooltip"  data-bs-title="Edit the Movie "><i class="fa-solid fa-pen-to-square"></i></a>
                          <a href="inc/movies/movie_delete_confirm.php?movieId=' . htmlspecialchars($movie['movieId']) . '" class="btn btn-outline-danger " ><i class="fa-solid fa-trash"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>';
    }
    echo '</div>';
  }?>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
     <!-- Font Awesome JS -->
    <script src="https://kit.fontawesome.com/db1e295bdd.js" crossorigin="anonymous"></script>
</body>

</html>