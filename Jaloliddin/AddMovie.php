<?php
require_once '../lib/nusoap.php';
require_once '../Jaloliddin/Validation.php';
require_once '../Database/DatabaseConnection.php';
$errorMsg = "";
$response = "";
$wsdl = "http://localhost/tgx-cinemas/Jaloliddin/service.php?wsdl";

session_start();
if (!isset($_SESSION["username"])) {
    header('Location:/tgx-cinemas/Jaloliddin/Admin/Client.php');
    exit();
}
?>

<?php
// Add new movie
if (isset($_POST['addbtn'])) {
    //print_r($_FILES);
    $poster = $_FILES['poster']['name'];
    //echo $poster;
    $targetDir = "img/" . $poster;
    $target_file = $targetDir . basename($_FILES["poster"]["name"]);
    $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
    $file_extension = strtolower($file_extension);

    $valid_extension = array("png", "jpeg", "jpg");


    $name = ($_POST['movieName']);
    $length = ($_POST['length']);
    $status = ($_POST['status']);
    $genre = ($_POST['genre']);
    $language = ($_POST['language']);
    $subtitle = ($_POST['subtitle']);
    $ageRestriction = ($_POST['ageRestriction']);
    $releaseDate = ($_POST['releaseDate']);
    $cast = ($_POST['cast']);
    $director = ($_POST['director']);
    $distributor = ($_POST['distributor']);
    $synopsis = ($_POST['synopsis']);

    $connect = DatabaseConnection::getInstance();
    $query = "INSERT INTO movie (name, poster, length, status, genre, language, subtitle, ageRestriction, releaseDate, cast, director, distributor, synopsis) "
            . "VALUES ('$name','$poster','$length','$status','$genre','$language','$subtitle','$ageRestriction','$releaseDate','$cast','$director','$distributor','$synopsis')";
    $stmt = $connect->getDb()->prepare($query);

    if (in_array($file_extension, $valid_extension)) {
        // Upload file
        if (move_uploaded_file($_FILES['poster']['tmp_name'], $targetDir)) {
            $stmt->execute();
            echo "SUCCESS!";
        }
        echo "FAILED!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Book Store Web Service</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"/>
    </head>
    <body>
        <?php include ('Utilities/navigation.php'); ?>
        <div class='container' style="margin-top: 10vh !important; padding-bottom: 10vh !important">
            <h1 class="display-4">Add New Movie</h1>
            <div class="container-fluid">
                <form method = 'post' name='form' enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name: </label>
                        <input type="text" class="form-control" name="movieName" id="movieName" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="name">Poster: </label>
                        <input type="file" class="form-control" name="poster" id="poster">
                    </div>
                    <div class="form-group">
                        <label for="name">Length: </label>
                        <input type="text" class="form-control" name="length" id="length" placeholder="Enter Length">
                    </div>
                    <div class="form-group">
                        <label for="name">Status: </label>
                        <input type="text" class="form-control" name="status" id="status" placeholder="Enter Status">
                    </div>
                    <div class="form-group">
                        <label for="name">Genre: </label>
                        <input type="text" class="form-control" name="genre" id="genre" placeholder="Enter Genre">
                    </div>
                    <div class="form-group">
                        <label for="name">Language: </label>
                        <input type="text" class="form-control" name="language" id="language" placeholder="Enter Language">
                    </div>
                    <div class="form-group">
                        <label for="name">Subtitle: </label>
                        <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="Enter Subtitle">
                    </div>
                    <div class="form-group">
                        <label for="name">Age Restriction: </label>
                        <input type="text" class="form-control" name="ageRestriction" id="ageRestriction" placeholder="Enter Age Restriction">
                    </div>
                    <div class="form-group">
                        <label for="name">Release Date: </label>
                        <input type="date" class="form-control" name="releaseDate" id="releaseDate" placeholder="Enter Release Date">
                    </div>
                    <div class="form-group">
                        <label for="name">Cast Members: </label>
                        <input type="text" class="form-control" name="cast" id="cast" placeholder="Enter Cast Members">
                    </div>
                    <div class="form-group">
                        <label for="name">Director: </label>
                        <input type="text" class="form-control" name="director" id="director" placeholder="Enter Director's Name">
                    </div>
                    <div class="form-group">
                        <label for="name">Distributor: </label>
                        <input type="text" class="form-control" name="distributor" id="distributor" placeholder="Enter Distributor's Name">
                    </div>
                    <div class="form-group">
                        <label for="name">Synopsis: </label>
                        <input type="text" class="form-control" name="synopsis" id="synopsis" placeholder="Enter Synopsis">
                    </div>
                    <button type="submit" name='addbtn' class="btn btn-dark btn-block">Add New Movie</button>

                    <div class="form-group">
                        <?php if (!empty($errorMsg)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $errorMsg; ?>
                            </div>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>