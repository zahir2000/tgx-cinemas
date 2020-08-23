<?php
require_once 'MovieConnection.php';
require_once 'Classes/Movie.php';
require_once 'XML/MovieXML.php';

$movieConn = new MovieConnection();
$movieFullList = $movieConn->getAllMovie();
$movieList = $movieConn->getAllMovie();

$movieXML = new MovieXML();

// check the movieName whether is POST
if (filter_input(INPUT_POST, 'movieName')) {
    $movieName = trim(filter_input(INPUT_POST, 'movieName'));
    $movieList = $movieConn->getSearchedMovie($movieName);
}
?>

<!DOCTYPE html>
<!--
    @author: Venessa Choo Wei Ling
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- JavaScript -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <title>Search Movie</title>
    </head>
    <body>
        <div class='container'>
            <form id="searchForm" name="searchForm" action="searchMovie.php" method="POST">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <input id="movieName" name="movieName" class="form-control" type="text" placeholder="Search Movie Name" />
                        <div class="input-group-append">
                            <button id="btnSearch" name="btnSearch" class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </div>
            </form>

            <br />

            <h1>TGX Cinemas Movies From DB</h1>

            <br />

            <div class = "row">
                <?php
                if (is_array($movieList) || is_object($movieList)) {
                    foreach ($movieList as $movie) {
                        ?>
                        <div class="col-3">
                            <div class = "card">
                                <img class="card-img-top" src="../<?php echo $movie['poster'] ?>" alt="">
                                <div class = "card-body">
                                    <h5 class = "card-title"><?php echo $movie['name'] ?></h5>
                                    <p class = "card-text text-truncate"><?php echo $movie['synopsis'] ?></p>
<!--                                    <a href = "#" class = "btn btn-secondary">View</a>-->
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo 'Sorry... Not record found for ' . $movieName;
                }
                ?>
            </div>

            <hr />

            <!-- create xml file -->
            <?php
            if (is_array($movieList) || is_object($movieList)) {
                $movieXML->createXMLFile($movieList);
            }
            ?>

            <!-- read from xml -->
            <?php
            // check the movieName whether is POST
//            if (filter_input(INPUT_POST, 'movieName')) {
//                $movieName = trim(filter_input(INPUT_POST, 'movieName'));
//                $movieXML->readFromXMLByName($movieName);
//            }
            $movieXML->readFromXML();
            ?>
        </div>
    </body>
</html>
