<?php
// Enable error reporting for debugging
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Include the database connection file
require_once('reusable/connect.php');
session_start();

// Check if the database connection is established
if (!isset($connect) || !($connect instanceof mysqli)) {
  die("Error: Database connection not established. Check your connect.php file.");
}

/**
 * Function to display songs for a specific year
 * 
 * @param array $songs Array of song data
 * @param string $year The year for which songs are being displayed
 */
function displaySongs($songs, $year)
{
  echo "<h2 class='display-5 mt-5 mb-5 pb-2 text-white border-bottom border-white'>Bollywood hits of $year</h2>";
  if (empty($songs)) {
    echo "<div class='alert alert-warning'>No songs found for $year.</div>";
  } else {
    echo '<div class="row">';
    foreach ($songs as $song) {
      // Display each song in a Bootstrap card
      echo '<div class="col-md-4 g-5">
                    <div class="card songs " >
                      <img src="' . htmlspecialchars($song['imagePath']) . '" class="card-img-top " style="height:270px"  alt="song cover picture">
                      <div class="card-body">
                        <h5 class="card-title fs-4 fw-normal">' . htmlspecialchars($song['songName']) . ' <i class="bi bi-music-note text-warning"></i></h5>
                        <div class="card-text">
                          <i class="fa-solid fa-file-video"></i> <a href="movieDetail.php?movieId=' . htmlspecialchars($song['movieId']) . '" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover text-bg-danger-subtle">' . htmlspecialchars($song['movieName']) . '</a>
                        </div>
                        <div class="card-text mt-3 d-flex justify-content-between">
                          <a href="songDetail.php?songId=' . htmlspecialchars($song['songId']) . '" class="btn btn-outline-primary ">Details</a>';
                          // Only show Edit and Delete buttons if admin is logged in
                        if (isset($_SESSION['admin_id'])) {
                          echo '<a href="inc/songs/edit_song.php?songId=' . htmlspecialchars($song['songId']) . '" class="btn btn-outline-warning " data-bs-toggle="tooltip"  data-bs-title="Edit the Song "><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="inc/songs/song_delete_confirm.php?songId=' . htmlspecialchars($song['songId']) . '" class="btn btn-outline-danger " ><i class="fa-solid fa-trash"></i></a>';}
                  echo '</div>
                      </div>
                    </div>
                  </div>';
    }
    echo '</div>';
  }
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
  <link  href="css/styles.css" rel="stylesheet">
</head>

<body>
  <!-- Header Section -->
  <div class="container-fluid">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1 class="display-4 mt-5 mb-5 text-center">Bollywood Hit Songs(2017-2019) <i class="bi bi-fire text-warning"></i></h1>
        </div>
      </div>
      <!-- Navigation buttons -->
      <div class="row mb-4">
        <div class="col">
        <a href="moviesList.php" class="btn btn-secondary me-2">View all Movies <i class="fa-solid fa-film"></i></a> 
        <?php if (isset($_SESSION['admin_id'])): ?>
          <a href="inc/songs/add_song.php" class="btn btn-primary me-2">Add New Song</a>
          <a href="inc/movies/add_movie.php" class="btn btn-success me-2">Add New Movie</a>
          <a class="btn btn-danger" href="logout.php">Logout</a>
          <?php else: ?>
            <a  class="btn btn-danger" href="login.php">Admin Login</a>
          <?php endif; ?>
          
        
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content Section -->
  <div class="container-fluid">
    <div class="container">
      <div class="row">
        <?php
        try {
          // SQL query to fetch all songs with their movie details
          $query = 'SELECT * FROM songs JOIN movies ON songs.movieId = movies.movieId';
          $result = $connect->query($query);

          // Check if the query was successful
          if ($result === false) {
            throw new Exception("Query failed: " . $connect->error);
          }

          $totalRows = $result->num_rows;
          // echo "<div class='alert alert-info'>Total songs found: $totalRows</div>";

          if ($totalRows == 0) {
            echo "<div class='alert alert-warning'>No songs found in the database.</div>";
          } else {
            // Arrays to store songs by year
            $array2017 = array();
            $array2018 = array();
            $array2019 = array();

            // Categorize songs by year
            while ($song = $result->fetch_assoc()) {
              $releaseDate = $song['releaseDate'];
              $year = date('Y', strtotime($releaseDate));

              switch ($year) {
                case '2017':
                  $array2017[] = $song;
                  break;
                case '2018':
                  $array2018[] = $song;
                  break;
                case '2019':
                  $array2019[] = $song;
                  break;
              }
            }

            // Display songs for each year
            displaySongs($array2017, '2017');
            displaySongs($array2018, '2018');
            displaySongs($array2019, '2019');
          }
        } catch (Exception $e) {
          // Display any errors that occur during the process
          echo '<div class="alert alert-danger" role="alert">';
          echo 'An error occurred: ' . htmlspecialchars($e->getMessage());
          echo '</div>';
        }
        ?>
      </div>
    </div>
  </div>

  

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
  crossorigin="anonymous"></script>
  <!-- Font Awesome JS -->
  <script src="https://kit.fontawesome.com/db1e295bdd.js" crossorigin="anonymous"></script>
</body>

</html>