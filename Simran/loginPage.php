<?php
require_once '../Database/DatabaseConnection.php';
require_once '../Database/UserConnection.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Customer Login</title>
    </head>
    <body>
        <?php
        if ((!isset($_POST['username'])) || !isset($_POST['password'])){
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
        } else{
            $username = trim($_POST['username']);
            $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
            
            $db = DatabaseConnection::getInstance();
            $getUser = new UserConnection();
            $getUser->getUserAccount($username, $password);
            
            echo "Welcome $username";
            
            $db->closeConnection();
            
        }
        ?>
    </body>
</html>
