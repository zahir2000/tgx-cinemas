<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment/Zahir/Session/SessionHelper.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment/Database/BookingConnection.php';

if(isset($_GET['booking'])){
    echo "Session Expired!";
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/Assignment/Zahir/Header.php';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>TGX Cinemas - Home</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <style>
            .movies-panel{
                background-color: #FFF;
                padding: 40px;
                box-shadow: 1px 0px 23px 3px rgba(0, 0, 0, 0.45);
                -webkit-box-shadow: 1px 0px 23px 3px rgba(0, 0, 0, 0.45);
                -moz-box-shadow: 1px 0px 23px 3px rgba(0, 0, 0, 0.45);
                transition: all 0.7s ease;
                width: 90%;
                /* height: 100vh; */
                margin: 0 auto;
                margin-top: 3vh;
                box-sizing: content-box
            }

            .movies-panel-img{
                height: 421px;
            }
        </style>
    </head>
    <body>
        <?php
        $con = BookingConnection::getInstance();
        $movies = $con->getMovies();
        ?>
        <div>
            <div class="movies-panel">
                <div class="row">
                    <?php foreach ($movies as $movie) { ?>

                        <div class="col-md-3 pt-5">
                            <div class="card" style="width: 18rem;">
                                <a href="/Assignment/Zahir/Movies.php?id=<?php echo $movie['movieID'] ?>">
                                    <img class="card-img-top movies-panel-img" src="<?php echo "/Assignment/" . $movie['poster'] ?>" alt="Card image cap">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $movie['movieName'] ?></h5>
                                    <p class="card-text"><?php echo substr($movie['synopsis'], 0, 75) . "..." ?></p>
                                    <a href="/Assignment/Zahir/Movies.php?id=<?php echo $movie['movieID'] ?>" class="btn btn-dark btn-block">Book Now</a>
                                </div>
                            </div>
                        </div>


                    <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>
