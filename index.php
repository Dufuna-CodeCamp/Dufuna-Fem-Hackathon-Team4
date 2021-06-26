<?php

    // include db_connect file
    require_once 'php_action/db_connect.php';

    session_start();

    // to prevent user from accessinng log in page when logged in
    if(isset($_SESSION['id'])) {
        header('location: dashboard/dashboard.php');
    }

    if($_POST) {
        $email = $_POST['email'];
        $password = $_POST['password'];
       

        if(empty($email) || empty($password)) {
            if($email == '') {
                $emailError = 'Email is required';
            }

            if($password == '') {
                $passwordError = 'Password is required';
            }
            echo $emailError;
            echo $passwordError;

        } else {
            $sql = "SELECT * FROM users WHERE email= '$email'";
            $result = $conn->query($sql);
            // print_r($result);
            // echo $result->num_rows;
           

            if($result->num_rows == 1) {
                $password = md5($password);
                // exists
                $mainSql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
                $mainResult = $conn->query($mainSql);
                
                if($mainResult->num_rows == 1) {
                    $value = $mainResult->fetch_assoc();
                    $user_id = $value['id'];
                    // echo $user_id;

                    //set session
                    $_SESSION['id'] = $user_id;

                    header('location: dashboard/dashboard.php');
                } else {
                    $error = 'Incorrect email/password combination';
                }


            } else {
                $error = 'Email does not exist';
            }
        }
    }
?>

<!DOCTYPE html>
<html>
 <head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Inventory management system</title>
    <link rel="stylesheet" href="index.css">
 </head>
 <body>
  <div class="inventory">
    <img src="Images/inventoryicon.png" >
    <p>
      <span class="hr3">Inventory management</span>     
      <span class="hr4">  made easy  </span>
    </p>
  </div>
  <div class="signupform">

    <p class="Signin">Sign In</p> 
    <span class= "error"><?php echo $error; ?></span>
    <form action='index.php' method='POST' id='loginForm'>
        <label for="email" class="Email"> Email </label> 
        <input type="Email" id="email" name="email" class="inputbox">
        <div class= "error">
            <?php
                if ($emailError) {
                    echo $emailError;
                } 
            ?>
        </div>
        <label for="password" class="password"> Password </label>
        <input type="password" id="password" name="password" class="inputbox">
        <div class= "error"><?php echo $passwordError; ?></div>
        <div class="sign-btn">
            <button type="submit"> Sign In </button>
        </div>  
        <div class="signup">
            <p  class="Signup"> Don't have an account? <a href="signup.php"> Sign up!</a> </p>
        </div>  
    </form>
    </div>
 </body>
</html>  
