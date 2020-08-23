<?php
require_once 'Server.php';
require_once 'ThrottlingMiddleware.php';
require_once 'UserExistsMiddleware.php';
require_once 'Service.php';

$status = "";
$message = "";

session_start();
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
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"/>
        <title>Administrator Login</title>
    </head>
    <body>
        <?php
        /**
         * The client code.
         */
        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $success = $server->logIn($username, $password);

            if ($success) {
                $message = "Authorization has been successful!\n";
                $status = "success";

                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;

                if (isset($_SESSION["username"])) {
                    header('Location:AdminDashboard.php?status=' . $status);
                }else{
                    header('Location:Client.php');
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
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control form-control-lg" placeholder="e.g. someone@example.com" name="username" id="username" required>
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
