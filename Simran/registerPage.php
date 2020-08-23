<?php
require_once '../Database/DatabaseConnection.php';
require_once '../Database/UserConnection.php';
require_once 'Authentication.php';

$name = $email = $number = $dob = $gender = $address = $username = $password = $cPassword = "";
$nameErr = $emailErr = $numberErr = $dobErr = $genderErr = $addressErr = $usernameErr = $passwordErr = $cPasswordErr = "";

//if($_SERVER["REQUEST_METHOD"] == "POST"){
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Customer Registration</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{ font: 14px sans-serif; align-content: center}
            .wrapper{ width: 350px; padding: 20px;}
        </style>
    </head>
    <body>
        <div class="wrapper">
             <h2>Customer Registration</h2>
             <p>Please enter your details to register.</p>
             <form action="registerPage.php" method="POST">
                 <div class="form-group, <?php echo (!empty($nameErr)) ? 'has_error' : '';?>">
                     <label>Name</label>
                     <input type="text" name="name" id="name" class="form-control" value="<?php echo $name;?>"/>
                     <span class="help-block"><?php echo $nameErr;?>                      
                     </span>
                 </div>
                 <div class="form-group <?php echo (!empty($emailErr)) ? 'has_error' : '';?>">
                     <label>Email</label>
                     <input type="text" name="email" id="email" class="form-control" value="<?php echo $email;?>"/>
                     <span class="help-block"><?php echo $emailErr;?>                      
                     </span>
                 </div>
                 <div class="form-group <?php echo (!empty($numberErr)) ? 'has_error' : '';?>">
                     <label>Name</label>
                     <input type="text" name="number" id="number" class="form-control" value="<?php echo $number;?>"/>
                     <span class="help-block"><?php echo $numberErr;?>                      
                     </span>
                 </div>
                 <div class="form-group <?php echo (!empty($dobErr)) ? 'has_error' : '';?>">
                     <label>Date Of Birth</label>
                     <input type="date" name="dob" id="dob" class="form-control" value="<?php echo $dob;?>"/>
                     <span class="help-block"><?php echo $dobErr;?>                      
                     </span>
                 </div>
                 <div class="form-group <?php echo (!empty($genderErr)) ? 'has_error' : '';?>">
                     <label>Gender</label><br/>
                     <input type="radio" name="gender" id="female" class="radio-line, radio-line" value="<?php echo $gender;?>"/>Female
                     <input type="radio" name="gender" id="male" class="radio-line" value="<?php echo $gender;?>"/>Male
                     <span class="help-block"><?php echo $genderErr;?>                      
                     </span>
                 </div>
                 <div class="form-group <?php echo (!empty($addressErr)) ? 'has_error' : '';?>">
                     <label>Address</label>
                     <input type="text" name="address" id="address" class="form-control" value="<?php echo $address;?>"/>
                     <span class="help-block"><?php echo $addressErr;?>                      
                     </span>
                 </div>
                 <div class="form-group <?php echo (!empty($usernameErr)) ? 'has_error' : '';?>">
                     <label>Username</label>
                     <input type="text" name="username" id="username" class="form-control" value="<?php echo $username;?>"/>
                     <span class="help-block"><?php echo $usernameErr;?>                      
                     </span>
                 </div>
                 <div class="form-group <?php echo (!empty($passwordErr)) ? 'has_error' : '';?>">
                     <label>Password</label>
                     <input type="password" name="password" id="password" class="form-control" value="<?php echo $password;?>"/>
                     <span class="help-block"><?php echo $passwordErr;?>                      
                     </span>
                 </div>
                 <div class="form-group <?php echo (!empty($cPasswordErr)) ? 'has_error' : '';?>">
                     <label>Confirm Password</label>
                     <input type="password" name="cpassword" id="cpassword" class="form-control" value="<?php echo $cPassword;?>"/>
                     <span class="help-block"><?php echo $cPasswordErr;?>                      
                     </span>
                 </div>
                 <div class="form-group">
                     <input type="submit" class="btn btn-primary" value="Submit">
                     <input type="reset" class="btn btn-default" value="Reset"> 
                 </div>
                 <p>Already have an account? <a href="loginPage.php">Login Here</a>.</p>
             </form>  
        </div>
        <?php
        //}
           // if(isset($_POST['submit']) || isset($_POST['gender'])){
          //  $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
          //  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING);
          //  $number = filter_var(trim($_POST['number']), FILTER_SANITIZE_STRING);
           // $dob = $_POST['dob'];
           // $gender = $_POST['gender'];
           // $address = filter_var(trim($_POST['address']), FILTER_SANITIZE_STRING);
           // $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
           // $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
            //$cPassword = trim($_POST['cPassword']);
                              
                
            //if($password == $cPassword){
            //    $password = $cPassword;
            //}else{
                    
            //}
                
          //  Authentication::validateRegister($name, $email, $number, $dob, $gender, $address, $username, $password);
                
            //$db = databaseConnection::getInstance();
            //$userDb = UserConnection::getInstance();
            //$userDb->addUser($name, $email, $number, $dob, $gender, $address, $username, $password);
            //echo "<p>Registration Successful</p>";
            //$db->closeConnection();
          //  }
        ?>
    </body>
</html>
