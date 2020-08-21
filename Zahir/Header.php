<?php
require_once 'Session/CheckToken.php';

require_once '../Simran/Logout.php';
//SessionHelper::removeToken('logout');

if (!SessionHelper::check('userId')) {
    $action = "/Assignment/Simran/loginPage.php";
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
            }

            .header-panel button{
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

            .header-panel button:hover{
                background-color: white;
                color: black;
            }
        </style>
    </head>
    <body>
        <header>
            <form action="<?php echo $action ?>" method="POST">
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
                        <a href="/Assignment/Simran/Home.php">
                            <img src='../img/tgx-logo.png' alt="Logo" />
                        </a>
                    </div>
                    <div>
                        <button name="logout" style="float: right"><i class="fas fa-sign-out-alt"></i> <?php echo $button ?></button>
                    </div>
                </div>
            </form>
        </header>
    </body>
</html>
