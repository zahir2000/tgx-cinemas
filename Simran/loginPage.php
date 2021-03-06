<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Simran/SecureCodingPrac/Authentication.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/lib/nusoap.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Session/SessionHelper.php';
$client = new nusoap_client("http://localhost/tgx-cinemas/Simran/WebService/service.php?wsdl");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Customer Login</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"/>
        <style type="text/css">
            body{ font: 14px sans-serif; }
            .wrapper{ width: 350px; padding: 20px; }
        </style>
    </head>
    <body>
        <div class="wrapper container">
            <h2>Customer Login</h2>
            <p>Please fill in your credentials to login.</p>
            <form action="loginPage.php" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" id="username" class="form-control" required/>
                </div>     
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="form-control" required/>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Login"/>
                </div>
                <p>Do Not Have An Account? <a href="registerPage.php">Register Here</a>!</p>
            </form>
        </div>
        <?php
        if (isset($_POST['submit']) || isset($_POST['username']) || isset($_POST['password'])){
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            
            //SecureCodingPrac
            //if(Authentication::authenticateLogin($username, $password)){
            //    header('Location:/tgx-cinemas/Home.php');
            //}else{
            //    echo "Username or password are invalid!";
            //}
            
            //WebServices
            $result = $client->call("authenticateLoginService", array("username" => $username, "password" => $password));
            print_r($result);
            
            if($result != 0){
                echo "Successful login!";
                SessionHelper::login($username, $result);
                header('Location:/tgx-cinemas/Home.php');
            }else{
                echo "Unsuccessful login! Invalid username or password!";
            }
        }
        ?>
    </body>
</html>
