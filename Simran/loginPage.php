<?php
require_once '../Database/UserConnection.php';
require_once 'Authentication.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Customer Login</title>
    </head>
    <body>
        <?php
        
        ?>
        <h1>Customer Login</h1>
        <form action="loginPage.php" method="POST">
            <p>Username : 
            <input type="text" name="username" id="username" size="15" /></p>
            
            <p>Password : 
            <input type="password" name="password" id="password" size="15" /></p>
            
            <button type="submit" name="submit">Login</button>
        </form>
        <?php
        //} else{
        if (isset($_POST['submit']) || isset($_POST['username']) || isset($_POST['password'])){
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            
            //$db = DatabaseConnection::getInstance();
            //$getUser = UserConnection::getInstance();
            //$getUser->getUserAccount($username, $password);
            
            //echo "Welcome $username";
            
            //$db->closeConnection();
            if(Authentication::authenticateLogin($username, $password)){
                header('Location:/tgx-cinemas/Home.php');
            }
        }
        ?>
    </body>
</html>
