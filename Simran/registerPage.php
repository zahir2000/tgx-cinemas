<?php
require_once '../Database/DatabaseConnection.php';
require_once '../Database/UserConnection.php';
require_once 'Authentication.php';

$error = '';

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Customer Registration</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{ font: 14px sans-serif;}
            .wrapper{ width: 350px; padding: 20px;}
        </style>
    </head>
    <body>
        <div class="wrapper container">
             <h2>Customer Registration</h2>
             <p>Please enter your details to register.</p>
             <form action="registerPage.php" method="POST">
                 <div class="form-group">
                     <label>Name</label>
                     <input type="text" name="name" id="name" class="form-control" required/>                      
                 </div>
                 <div class="form-group">
                     <label>Email</label>
                     <input type="text" name="email" id="email" class="form-control" required/>
                 </div>
                 <div class="form-group">
                     <label>Number</label>
                     <input type="text" name="number" id="number" class="form-control" required/>
                 </div>
                 <div class="form-group">
                     <label>Date Of Birth</label>
                     <input type="date" name="dob" id="dob" class="form-control" required/>
                 </div>
                 <div class="form-group">
                     <label>Gender</label><br/>
                     <input type="radio" name="gender" id="female" class="radio-line, radio-line" required/>Female
                     <input type="radio" name="gender" id="male" class="radio-line" required/>Male
                 </div>
                 <div class="form-group">
                     <label>Address</label>
                     <input type="text" name="address" id="address" class="form-control" required/>
                 </div>
                 <div class="form-group">
                     <label>Username</label>
                     <input type="text" name="username" id="username" class="form-control" required/>
                 </div>
                 <div class="form-group">
                     <label>Password</label>
                     <input type="password" name="password" id="password" class="form-control" required/>
                 </div>
                 <div class="form-group">
                     <label>Confirm Password</label>
                     <input type="password" name="cPassword" id="cPassword" class="form-control" required/>
                 </div>
                 <div class="form-group">
                     <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Submit">
                     <input type="reset" class="btn btn-default" value="Reset"> 
                 </div>
                 <p>Already have an account? <a href="loginPage.php">Login Here</a>.</p>

             </form>  
        </div>
        
        <?php
           //do this later if you have time <p style="color:red">php(put the thingy later) echo $error;</p>
           if(isset($_POST['submit']) || isset($_POST['gender'])){
           $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
           $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING);
           $number = filter_var(trim($_POST['number']), FILTER_SANITIZE_STRING);
           $dob = $_POST['dob'];
           $gender = $_POST['gender'];
           $address = filter_var(trim($_POST['address']), FILTER_SANITIZE_STRING);
           $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
           $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
           $cPassword = filter_var(trim($_POST['cPassword']), FILTER_SANITIZE_STRING);
           
           if($password != $cPassword){
               $error = "Password Did Not Match!";
           }else{
               $password = $cPassword;
           }
           
           Authentication::validatePassword($name, $email, $number, $dob, $gender, $address, $username, $password);
                
            //$db = databaseConnection::getInstance();
            //$userDb = UserConnection::getInstance();
            //$userDb->addUser($name, $email, $number, $dob, $gender, $address, $username, $password);
            //echo "<p>Registration Successful</p>";
            //$db->closeConnection();
        }
        ?>
    </body>
</html>
