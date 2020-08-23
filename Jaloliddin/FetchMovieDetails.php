<?php
require_once '../lib/nusoap.php';
$error = "";
$response = "";
$wsdl = "http://localhost/tgx-cinemas/Jaloliddin/service.php?wsdl";

session_start();
if (!isset($_SESSION["username"])) {
    header('Location:/tgx-cinemas/Jaloliddin/Admin/Client.php');
    exit();
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];

    if (!$name) {
        $error = "Name cannot be empty!";
    }

    if (!$error) {
        //create client object
        $client = new nusoap_client($wsdl);
        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2>' . $err;
            exit();
        }
        try {
            $result = $client->call('GetMovieDetails', array($name));
            $result = json_decode($result);
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Movie Details</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="Jaloliddin.css">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"/>
    </head>
    <body>
        <?php include ('Utilities/navigation.php'); ?>
        <div class="container-fluid" style="padding-top: 7vh !important">
            <h1 class="display-4">Movie Search Box</h1>
            <p class="lead">Enter movie name and click search button!</p>    
        </div>
        <div class="container-fluid">
            <form method="POST" name="form" class="form-inline">
                <?php if ($error) { ?> 
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong>&nbsp;<?php echo $error; ?> 
                    </div>
                <?php } ?>

                <div class="form-group mb-2">
                    <label for="name" class="sr-only">Name</label>
                    <input type="text" class="form-control" placeholder="e.g. Joker" name="name" id="name" required>
                </div>
                <button type="submit" name='submit' class="btn btn-dark mb-2">Search</button>
            </form>
        </div>

        <div class="container-fluid" id="details">
            <h1 class="display-4">Movie Details</h1>
            <table class="table table-hover table-stripped">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Poster</th>
                        <th>Length</th>
                        <th>Status</th>
                        <th>Genre</th>
                        <th>Language</th>
                        <th>Subtitle</th>
                        <th>Age Restriction</th>
                        <th>Release Date</th>
                        <th>Cast</th>
                        <th>Director</th>
                        <th>Distributor</th>
                        <th>Synopsis</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($result)) { ?>
                        <tr>
                            <td><?php echo $result->name; ?></td>
                            <td>
                                <img class="sizeMod" src='http://localhost/tgx-cinemas/<?php echo $result->poster; ?>'/>
                            </td>
                            <td><?php echo $result->length; ?></td>
                            <td><?php echo $result->status; ?></td>
                            <td><?php echo $result->genre; ?></td>
                            <td><?php echo $result->language; ?></td>
                            <td><?php echo $result->subtitle; ?></td>
                            <td><?php echo $result->ageRestriction; ?></td>
                            <td><?php echo $result->releaseDate; ?></td>
                            <td><?php echo $result->cast; ?></td>
                            <td><?php echo $result->director; ?></td>
                            <td><?php echo $result->distributor; ?></td>
                            <td><?php echo $result->synopsis; ?></td>
                        </tr>
                    <?php } else {
                        ?>
                        <tr>
                            <td colspan="5">Enter Name of a Movie and click Submit button</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>


