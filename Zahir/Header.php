<?php
SessionHelper::login_session();

require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Session/CheckToken.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Logout.php';

if (!SessionHelper::check('userId')) {
    $action = "/tgx-cinemas/Simran/loginPage.php";
} else {
    $action = "?a=submit";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" crossorigin="anonymous"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script>

        <style>
            *{
                font-family: "Verdana", sans-serif;
            }

            .header-panel {
                display: grid;
                grid-gap: 25px;
                grid-template-columns: 3fr 1fr;
                background-color: #000;
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

            .header-panel .button{
                border: 1px solid #ccc;
                padding: 3vh;
                margin-right: 2vh;
                text-align: center;
                background-color: black;
                color: #ccc;
                transition: all 0.7s ease;
                cursor: pointer;
                font-size: 15px;
                -webkit-appearance: button;
                -moz-appearance: button;
                appearance: button;
                text-decoration: none;
                transition: all 0.7s ease;
            }

            .header-panel .button:hover{
                background-color: white;
                color: black;
            }
        </style>
    </head>
    <body>
        <header>
            <form action="<?php echo $action ?>" method="POST" style="box-sizing: content-box">
                <?php
                if (SessionHelper::check('userId')) {
                    echo "<input type='hidden' value=" . SessionHelper::generateToken('logout') . " id='csrf_token' name='csrf_token' />";
                    $button = "Logout";
                } else {
                    $button = "Login";
                }
                ?>

                <div class='header-panel'>
                    <div>
                        <a href="/tgx-cinemas/Home.php">
                            <img src='/tgx-cinemas/img/tgx-logo.png' alt="Logo" />
                        </a>
                    </div>
                    <div>
                        <button name="logout" class="button" style="float: right"><i class="fas fa-sign-out-alt"></i> <?php echo $button ?></button>
                        <a href="/tgx-cinemas/Simran/Profile.php" class="button" name="profile" style="float: right"><i class="far fa-user"></i></a>
                    </div>
                </div>
            </form>
        </header>
    </body>
</html>
