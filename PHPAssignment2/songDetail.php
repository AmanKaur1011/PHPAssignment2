<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Song Details</title>
    <link href="css/styles.css" rel ="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>

<body>
    <?php
    session_start();
    //fetching  selected song information from the database
    include('reusable/connect.php');
    $id = $_GET['songId'];
    $query = "SELECT * FROM songs JOIN movies ON songs.movieId = movies.movieId WHERE songId = '$id'";
    $song = mysqli_query($connect, $query);
    $result = $song->fetch_assoc();
    ?>
<!-- Displaying the song details on the webpage -->
    <div class="container-fluid">
        <div class="container">
            <h1 class="display-4 mt-5 mb-5 pb-2 border-bottom border-white">Song Details <i class="fa-solid fa-music text-warning"></i></h1>
            <div class="row align-items-center p-2  justify-content-between">
                <?php
                echo '<div  class=" col-md-7 rounded video-container" >
                        <iframe  class="object-fit-contain" src="https://www.youtube.com/embed/'.$result['videoId'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                      </div>
                      
                        <!-- <div class="col">
                          <img src="' . $result['imagePath'] . '" class="object-fit-fill" height="400" alt="song cover">
                          
                        </div> -->
                        <div class="col-md-auto">
                          <h2 class="display-5 mb-3">' . $result['songName'] . '</h2>
                          <div class="fs-5 mb-3">
                            <i class="fa-solid fa-film"></i>
                            <a href="movieDetail.php?movieId=' . $result['movieId'] . '" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover text-bg-danger-subtle">' . $result['movieName'] . '</a>
                          </div>
                          <div><span class="badge bg-secondary fs-6 mb-3 fw-normal"> Release Date :  </span>  ' . '&nbsp; ' . $result['releaseDate'] . '</div>
                          <div><span class="badge bg-secondary fs-6 mb-3 fw-normal"> Singer :  </span>' . '&nbsp; ' . $result['singer'] . '</div>
                          <div><span class="badge bg-secondary fs-6 fw-normal"> Genre :  </span>' . '&nbsp; ' . $result['songGenre'] . '</div>
                          <div class="mt-3"><span class="badge bg-secondary fs-6 fw-normal "> User Rating :  </span>' . '&nbsp; ' . $result['userRating'] .   '&nbsp; ' .'<span><i class="fa-solid fa-star text-warning"></i></span> </div>';
                          //Add Edit and Delete buttons 
                        // Only show Edit and Delete buttons if admin is logged in
                if (isset($_SESSION['admin_id'])) {
                          
                          echo '<div class="mt-4">
                            <a href="inc/songs/edit_song.php?songId=' . $result['songId'] . '" class="btn btn-outline-warning me-2">Edit Song</a>
                            <!--  <a href="delete_song.php?songId=' . $result['songId'] . '" class="btn btn-outline-danger" onclick="return confirm(\'Are you sure you want to delete this song?\')">Delete Song</a> -->
                            <a href="inc/songs/song_delete_confirm.php?songId=' . $result['songId'] . '" class="btn btn-outline-danger">Delete Song</a>';}
                          echo ' </div>
                        </div>
                     
                      ';
                ?>
            </div>
        </div>
    </div>
<!-- CDN link for the js file  of Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
    <!--CDN link for fontawesone icons  -->
    <script src="https://kit.fontawesome.com/db1e295bdd.js" crossorigin="anonymous"></script>
</body>

</html>