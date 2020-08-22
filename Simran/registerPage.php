<?php
require_once '../Database/DatabaseConnection.php';
require_once '../Database/UserConnection.php';
require_once 'Authentication.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Customer Registration</title>
    </head>
    <body>
        <?php
            
        ?>
        <h1>Customer Registration</h1>
        <form action="registerPage.php" method="POST">
            <p>Name: 
                <input type="text" name="name" id="name" size="15" /></p>
            
            <p>Email: 
                <input type="text" name="email" id="email" size="15" /></p>
            
            <p>Contact Number: 
                <input type="text" name="number" id="number" size="15" /></p>
            
            <p>Date Of Birth: 
                <input type="date" name="dob" id="dob" size="15" /></p>
            
            <p>Gender: <br/>
                <input type="radio" name="gender" id="female" value="female" />Female<br/>
                <input type="radio" name="gender" id="male" value="male"/>Male</p>
                     
            <p>Address: 
                <input type="text" name="address" id="address" size="80" /></p>
            
            <p>Username: 
            <input type="text" name="username" id="username" size="15" /></p>
            
            <p>Password: 
                <input type="password" name="password" id="password" size="15" /></p>
            
         
            <button type="submit" name="submit">Register</button>
            
        </form>
        <?php
            if(isset($_POST['submit']) || isset($_POST['gender'])){
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $number = trim($_POST['number']);
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $address = trim($_POST['address']);
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            //$cPassword = trim($_POST['cPassword']);
                              
                
            //if($password == $cPassword){
            //    $password = $cPassword;
            //}else{
                    
            //}
                
            Authentication::validateRegister($name, $email, $number, $dob, $gender, $address, $username, $password);
                
            //$db = databaseConnection::getInstance();
            //$userDb = UserConnection::getInstance();
            //$userDb->addUser($name, $email, $number, $dob, $gender, $address, $username, $password);
            //echo "<p>Registration Successful</p>";
            //$db->closeConnection();
            }
        ?>
    </body>
</html>
