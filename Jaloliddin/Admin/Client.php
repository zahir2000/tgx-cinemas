<?php
require_once 'Server.php';
require_once 'ThrottlingMiddleware.php';
require_once 'UserExistsMiddleware.php';
require_once 'RoleCheckMiddleware.php';
require_once 'Service.php';
//require_once 'DatabaseConnection.php';

//$connect = DatabaseConnection::getInstance();

$status = "";
$message = "";

//echo password_hash('admin', PASSWORD_BCRYPT);
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Login</title>
    </head>
    <body>
        <?php
        /**
         * The client code.
         */
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            //$email= strip_tags(mysql_real_escape_string($connect, trim($email)));
            //$password = strip_tags(mysql_real_escape_string($connect, trim($password)));

            $success = $server->logIn($email, $password);

            if ($success) {
                $message = "Authorization has been successful!\n";
                $status = "success";
                header('Location:AdminDashboard.php?status=' . $status);
            } else {
                $message = "Login Failed! Authorized Personnel Only!";
                $status = "failed";
                //header('Location:AdminDashboard.php?status=' . $status);
            }
        }
        ?>
        <form method="POST" name="form" action="">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" required>
            <input type="password" name="password" id="password" required>
            <button type="submit" name='login' class="btn btn-dark">Login</button>
        </form>
        <p><?php echo $message ?></p>
    </body>
</html>
