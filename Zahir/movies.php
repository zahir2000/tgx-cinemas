<?php
require_once '../Database/DatabaseConnection.php';
?>

<!DOCTYPE html>

<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $db = DatabaseConnection::getInstance();
    $result = $db->getMovieDetails($id);

    if (!isset($result)) {
        echo "TODO: The ID does not exist";
    } else {
        //echo $result['name'];
    }
} else {
    echo "No ID entered!";
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>TGX Cinemas - <?php echo $result['name'] ?></title>
        <link rel="stylesheet" href="movies.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" crossorigin="anonymous">
    </head>
    <body>
        <div class="booking-panel">

            <div class="booking-panel-section booking-panel-title">
                <h1>RESERVE YOUR TICKET</h1>
            </div>
            <div class="booking-panel-section booking-panel-close" onclick="window.history.go(-1); return false;">
                <i class="fas fa-2x fa-times"></i>
            </div>

            <div class="booking-panel-section booking-panel-poster">
                <div class="movie-box">
                    <?php echo '<img src="/Assignment/' . $result['poster'] . '" alt="">'; ?>
                </div>
            </div>

            <div class="booking-panel-section booking-panel-details">
                <div class="title"><?php echo $result['name'];
                    echo " (" . $result['ageRestriction'] . ")"; ?></div>
                <div class="movie-information">
                    <table>
                        <tr>
                            <td>Genre</td>
                            <td><?php echo $result['genre']; ?></td>
                        </tr>
                        <tr>
                            <td>Duration</td>
                            <td><?php echo $result['length'] . " minutes"; ?></td>
                        </tr>
                        <tr>
                            <td>Language</td>
                            <td><?php echo $result['language']; ?></td>
                        </tr>
                        <tr>
                            <td>Subtitle</td>
                            <td><?php echo $result['subtitle']; ?></td>
                        </tr>
                        <tr>
                            <td>Release Date</td>
                            <td>
                                <?php echo $newDate = date("d F Y", strtotime($result['releaseDate'])); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Actors</td>
                            <td><?php echo $result['cast']; ?></td>
                        </tr>
                        <tr>
                            <td>Director</td>
                            <td><?php echo $result['director']; ?></td>
                        </tr>
                        <tr>
                            <td>Distributor</td>
                            <td><?php echo $result['distributor']; ?></td>
                        </tr>
                        <tr>
                            <td>Synopsis</td>
                            <td><?php echo $result['synopsis']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </body>
</html>
