<?php
require '../../lib/nusoap.php';

$client = new nusoap_client("http://localhost:8000/Assignment/Zahir/WebService/ShowtimeSOAPService.php?wsdl");

$msg = 'Select movie and submit to retrieve movie showtimes.';
$movies = $client->call('fetchMovies', array());
$cinemas = $client->call('fetchCinemas', array());
$exp = $client->call('fetchExperiences', array());
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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" crossorigin="anonymous"/>
    </head>
    <body>
        <div class="container pt-3">
            <h1>TGX Showtimes Web Service</h1>

            <form action="" method="POST">

                <div class="form-group pt-3">
                    <label for="movieName" class="font-weight-bold"><i class="fas fa-film"></i> Movie Name</label>
                    <select class="form-control" name="movieId" id="movieId">
                        <?php foreach ($movies as $movie): ?>
                            <option aria-describedby="movieNameHelp" value="<?= $movie['movieID']; ?>"><?= $movie['movieName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small id="movieNameHelp" class="form-text text-muted">Select the movie you want to see showtimes for.</small>
                </div>

                <div class="form-group">
                    <label for="date" class="font-weight-bold"><i class="far fa-clock"></i> Date</label>
                    <input type="date" aria-describedby="dateHelp" class="form-control" name="date" id="date">
                    <small id="dateHelp" class="form-text text-muted">Leave this empty to get for all dates.</small>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                    <label for="cinema" class="font-weight-bold"><i class="far fa-building"></i> Cinema</label>
                    <select class="form-control" name="cinemaId" id="cinemaId">
                        <option aria-describedby="cinemaNameHelp" class="text-secondary" disabled selected value>TGX Cinemas</option>
                        <?php foreach ($cinemas as $cinema): ?>
                            <option aria-describedby="cinemaNameHelp" value="<?= $cinema['cinemaID']; ?>"><?= $cinema['cinemaName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small id="cinemaNameHelp" class="form-text text-muted">Leave this empty to get for all dates.</small>
                </div>

                <div class="col-md-6 mb-3 pb-3">
                    <label for="experience" class="font-weight-bold"><i class="fas fa-glasses"></i> Experience</label>
                    <select class="form-control" name="experience" id="experience">
                        <option aria-describedby="experienceHelp" class="text-secondary" disabled selected value>TGX Experience</option>
                        <?php foreach ($exp as $e): ?>
                            <option aria-describedby="experienceHelp" value="<?= $e['experience']; ?>"><?= $e['experience']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small id="experienceHelp" class="form-text text-muted">Leave this empty to get for all dates.</small>
                </div>
                </div>

                <p>
                    <input type="submit" class="btn btn-primary btn-block" name="submit" value="Submit" />
                </p>
            </form>
        </div>

        <?php
        if (isset($_POST['movieId'])) {
            $movieId = filter_input(INPUT_POST, 'movieId');

            if (isset($_POST['date']) && !empty($_POST['date'])) {
                $date = filter_input(INPUT_POST, 'date');

                if ($date < date('Y-m-d')) {
                    $msg = "Date selected must be today and onwards!";
                }

                if (isset($_POST['cinemaId'])) {
                    $cinemaId = filter_input(INPUT_POST, 'cinemaId');

                    if (isset($_POST['experience'])) {
                        $exper = filter_input(INPUT_POST, 'experience');
                        $response = $client->call('fetchShowTime', array('movieID' => $movieId, 'date' => $date, 'cinemaID' => $cinemaId, 'experience' => $exper));
                    } else {
                        $response = $client->call('fetchShowTime', array('movieID' => $movieId, 'date' => $date, 'cinemaID' => $cinemaId, 'experience' => ''));
                    }
                } else {
                    $response = $client->call('fetchShowTime', array('movieID' => $movieId, 'date' => $date, 'cinemaID' => '', 'experience' => ''));
                }
            } else {
                $response = $client->call('fetchShowTime', array('movieID' => $movieId, 'date' => '', 'cinemaID' => '', 'experience' => ''));
            }

            //$response = json_decode($response);
            //print_r($response);
        }
        ?>
        <div class="container pt-5"><h2>Results</h2>
            <table style="width: 100%; text-align: center" class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th class="pt-2 pb-2">Time</th>
                        <th class="pt-2 pb-2">Date</th>
                        <th class="pt-2 pb-2">Cinema Name</th>
                        <th class="pt-2 pb-2">Hall ID</th>
                        <th class="pt-2 pb-2">Experience</th>
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
                                    $hour = (int) ($item['showTime'] / 60);
                                    $min = $item['showTime'] % 60;
                                    echo str_pad($hour, 2, "0", STR_PAD_LEFT) . ":" . str_pad($min, 2, "0", STR_PAD_RIGHT);
                                    ?>
                                </td>
                                <td><?php echo date('d M Y', strtotime($item['showDate'])); ?></td>
                                <td><?php echo $item['cinemaName']; ?></td>
                                <td><?php echo $item['hallID']; ?></td>
                                <td><?php
                                    $exps = explode(',', $item['experience']);
                                    foreach ($exps as $e) {
                                        echo $e . " ";
                                    }
                                    ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan='6' class="text-info font-weight-bold pt-3 pb-3"><?php echo $msg ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table></div>
    </body>
</html>
