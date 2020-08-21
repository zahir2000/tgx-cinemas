<?php
require_once '../lib/nusoap.php';
$error = "";
$response = "";
$wsdl = "http://localhost/tgx-cinemas/Jaloliddin/service.php?wsdl";

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
        <title>Movie Search</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="Jaloliddin.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
</html>

<body>
    <div class="container-fluid">
        <h1 class="display-4">Movie Search Box</h1>
        <p>Enter <strong>name</strong> of movie and click <strong>Submit</strong> button.</p><br/>    
        <div class="row">
            <form class="form-inline" method="POST" name="form">
                <?php if ($error) { ?> 
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong>&nbsp;<?php echo $error; ?> 
                    </div>
                <?php } ?>
                <div class="form-group container-fluid">
                    <label for="Name">Name:</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required>
                    <button type="submit" name='submit' class="btn btn-dark">Submit</button>
                </div>

            </form>
        </div>
        <br/>
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
</body>



