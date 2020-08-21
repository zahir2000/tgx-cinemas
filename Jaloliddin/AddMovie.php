<?php
require_once '../lib/nusoap.php';
$error = "";
$response = "";
$wsdl = "http://localhost/tgx-cinemas/Jaloliddin/service.php?wsdl";

// Add new movie
if (isset($_POST['addbtn'])) {
    $name = trim($_POST['name']);
    $poster = trim($_POST['poster']);
    $length = trim($_POST['length']);
    $status = trim($_POST['status']);
    $genre = trim($_POST['genre']);
    $language = trim($_POST['language']);
    $subtitle = trim($_POST['subtitle']);
    $ageRestriction = trim($_POST['ageRestriction']);
    $releaseDate = trim($_POST['releaseDate']);
    $cast = trim($_POST['cast']);
    $director = trim($_POST['director']);
    $distribution = trim($_POST['distributor']);
    $synopsis = trim($_POST['synopsis']);

    //Perform all required validations here
    if (!$isbn || !$title || !$author || !$category || !$price) {
        $error = 'All fields are required.';
    }

    if (!$error) {
        //create client object
        $client = new nusoap_client($wsdl, true);
        $err = $client->getError();
        if ($err) {
            echo '<h2>Constructor error</h2>' . $err;
            // At this point, you know the call that follows will fail
            exit();
        }
        try {
            /** Call insert book method */
            $response = $client->call('insertBook', array($title, $author, $price, $isbn, $category));
            $response = json_decode($response);
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Book Store Web Service</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>


        <div class='row'>
            <h1 class="display-4">Add New Movie</h1>
            <?php
            if (isset($$response->status)) {

                if ($response->status == 200) {
                    ?>
                    <div class="alert alert-success fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Success!</strong>&nbsp; Movie added successfully. 
                    </div>
                <?php } elseif (isset($response) && $response->status != 200) { ?>
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong>&nbsp; Cannot add the movie. Please try again. 
                    </div>
                    <?php
                }
            }
            ?>
            <form class="form-inline" method = 'post' name='form1'>
                <?php if ($error) { ?> 
                    <div class="alert alert-danger fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong>&nbsp;<?php echo $error; ?> 
                    </div>
                <?php } ?>
                <div class="form-group">
                    <label for="email"></label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" required>
                    <input type="text" class="form-control" name="author" id="author" placeholder="Enter Author" required>
                    <input type="text" class="form-control" name="price" id="price" placeholder="Enter Price" required>
                    <input type="text" class="form-control" name="isbn" id="isbn" placeholder="Enter ISBN" required>
                    <input type="text" class="form-control" name="category" id="category" placeholder="Enter Category" required>
                </div>
                <button type="submit" name='addbtn' class="btn btn-dark">Add New Movie</button>
            </form>
        </div>
    </div>

</body>
</html>