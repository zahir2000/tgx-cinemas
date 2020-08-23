<?php
require_once 'Server.php';
require_once 'ThrottlingMiddleware.php';
require_once 'UserExistsMiddleware.php';
require_once 'RoleCheckMiddleware.php';
require_once 'Service.php';

$status = "";
$message = "";
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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <title>Administrator Login</title>
    </head>
    <body>
        <?php
        /**
         * The client code.
         */
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $success = $server->logIn($email, $password);

            if ($success) {
                $message = "Authorization has been successful!\n";
                $status = "success";
                session_start();
                $_SESSION["email"] = $email;
                $_SESSION["password"] = $password;

                if (isset($_SESSION["email"])) {
                    header('Location:AdminDashboard.php?status=' . $status);
                }
            } else {
                $message = "Login Failed! Authorized Personnel Only!";
                $status = "failed";
                //header('Location:AdminDashboard.php?status=' . $status);
            }
        }
        ?>

        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">Admin Login Page</h1>
                <p class="lead">Welcome to the admin login page. Please enter your login details to gain access.</p>
            </div>
        </div>

        <div class="container">
            <form method="POST" name="form">
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-lg" placeholder="e.g. someone@example.com" name="email" id="email" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-7">
                        <input placeholder="Enter Password" class="form-control form-control-lg" type="password" name="password" id="password" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-9">
                        <button type="submit" name='login' class="btn btn-dark btn-block">Login</button>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-9">
                        <?php if ($status == "failed") { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </form>
        </div>
    </body>
</html>
