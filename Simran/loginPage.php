<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
        <form action="login.php" method="POST">
            <p>Username : 
            <input type="text" name="username" id="username" size="15" /></p>
            
            <p>Password : 
            <input type="password" name="password" id="password" size="15" /></p>
            
            <button type="submit" name="login">Login</button>
        </form>
        <?php
        } else{
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
        }
        ?>
    </body>
</html>
