<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Customer Registration</title>
    </head>
    <body>
        <?php
            if((!isset($_POST['name'])) || !isset($_POST['email']) || !isset($_POST['number']) || !isset($_POST['dob']) || !isset($_POST['gender']) || !isset($_POST['address']) || !isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['cPassword'])){
        ?>
        <h1>Customer Registration</h1>
        <form action="registration.php" method="POST">
            <p>Name: 
            <input type="text" name="name" id="name" size="15" /></p>
            
            <p>Email: 
            <input type="text" name="email" id="email" size="15" /></p>
            
            <p>Contact Number: 
            <input type="text" name="number" id="number" size="15" /></p>
            
            <p>Date Of Birth: 
            <input type="date" name="dob" id="dob" size="15" /></p>
            
            <p>Gender: <br/>
            <input type="radio" name="gender" id="female" />Female<br/>
            <input type="radio" name="gender" id="male"/>Male</p>
                     
            <p>Address: 
            <input type="text" name="address" id="address" size="80" /></p>
            
            <p>Username: 
            <input type="text" name="username" id="username" size="15" /></p>
            
            <p>Password: 
            <input type="password" name="password" id="password" size="15" /></p>
            
            <p>Confirm Password:
            <input type="password" name="cPassword" id="cPassword" size="15"/></p>
            
            <button type="submit" name="register">Register</button>
            
        </form>
        <?php
            } else{
                $name = trim($_POST['name']);
                $email = trim($_POST['email']);
                $number = trim($_POST['number']);
                $dob = $_POST['dob'];
                $gender = $_POST['gender'];
                $address = trim($_POST['address']);
                $username = trim($_POST['name']);
                $password = trim($_POST['password']);
                $cPassword = trim($_POST['cPassword']);
                
                //if($password == $cPassword){
                //    $password = $cPassword;
                //}else{
                    
                //}
                
                $db = databaseConnection::getInstance();
                $db->addUser($name, $email, $number, $dob, $gender, $address, $username, $password);
                        
            }
        ?>
    </body>
</html>