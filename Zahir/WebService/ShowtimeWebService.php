<?php
require '../../lib/nusoap.php';

$client = new nusoap_client("http://localhost:8000/Assignment/Zahir/WebService/ShowtimeSOAPService.php?wsdl");

$movies = $client->call('fetchMovies', array());
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TGX Showtimes Web Service</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container pt-3">
            <h1>Showtime Web Service</h1>

            <form action="" method="POST">

                <div class="form-group pt-3 pb-3">
                    <label for="movieName">Movie Name</label>
                    <select class="form-control" name="movieId" id="movieId">
                        <?php foreach ($movies as $movie): ?>
                            <option value="<?= $movie['movieID']; ?>"><?= $movie['movieName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!--<div class="form-group pt-3 pb-3">
                    <label for="movieName">Movie Name</label>
                    <input type="movieName" class="form-control" id="movieName" name="movieName" aria-describedby="movieNameHelp">
                    <small id="movieNameHelp" class="form-text text-muted">Enter the movie name you want the showtimes for.</small>
                </div>-->

                <p>
                    <input type="submit" class="btn btn-primary btn-block" name="submit" value="Submit" />
                </p>
            </form>
        </div>

        <?php
        if (isset($_POST['movieId'])) {
           
            $movieId = filter_input(INPUT_POST, 'movieId');
            $response = $client->call('fetchShowtimeDetails', array('movieID' => $movieId));

            //$response = json_decode($response);
            //print_r($response);
        }
        ?>
        <div class="container pt-5"><h2>Results</h2>
            <table style="width: 100%; text-align: center" class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Date</th>
                        <th>Cinema Name</th>
                        <th>Hall ID</th>
                        <th>Experience</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($response)) {

                        foreach ($response as $item) {
                            ?>

                            <tr>
                                <td>
                                    <?php 
                                    $hour = (int)($item['showTime'] / 60);
                                    $min = $item['showTime'] % 60;
                                    echo str_pad($hour, 2, "0", STR_PAD_LEFT) . ":" . str_pad($min, 2, "0", STR_PAD_RIGHT); 
                                    ?>
                                </td>
                                <td><?php echo date('d M Y', strtotime($item['showDate'])); ?></td>
                                <td><?php echo $item['cinemaName']; ?></td>
                                <td><?php echo $item['hallID']; ?></td>
                                <td><?php $exps = explode(',', $item['experience']); foreach ($exps as $e){ echo $e . " "; } ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan='6'>Enter Movie Name and submit to retrieve movie showtimes.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table></div>
    </body>
</html>
