<?php

    // include db_connect file
    require_once 'php_action/db_connect.php';

    session_start();

    // to prevent user from accessinng log in page when logged in
    if(isset($_SESSION['id'])) {
        header('location: dashboard.php');
    }

    if($_POST) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
       

        if(empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
            if($firstname == '') {
                $firstnameError = 'Firstname is required';
            }
            if($lastname == '') {
                $lastnameError = 'Lastname is required';
            }
            if($email == '') {
                $emailError = 'Email is required';
            }
            if($password == '') {
                $passwordError = 'Password is required';
            }

        } else {
            $password = md5($password);
            $checkSql = "SELECT * FROM users WHERE email = '$email'";
            $result = $conn->query($checkSql);
            // print_r($result);
            // echo $result->num_rows;

            if($result->num_rows == 0) {
                $sql = "INSERT INTO users(firstname, lastname, email, password) VALUES('$firstname', '$lastname', '$email', '$password')";
                if($conn->query($sql) === TRUE) {
                    
                    header('location: index.php');
                } else {
                    $error = "There was error creating user, please try again."; 
                } 
                
            }else {
                $error = "This user already exists, please login.";
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
      <span class="hr4">made easy</span>
    </p>
  </div>
  <div class="signupform">

    <p class="Signin">Sign Up</p> 
    <span class= "error"><?php echo $error; ?></span>
    <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST' id='loginForm'>
        <label for="firstname" class="firstname"> First Name </label> 
        <input type="text" id="firstname" name="firstname" class="inputbox">
        <span class= "error"><?php echo $firstnameError; ?></span>
        <label for="lastname" class="lastname"> Last Name </label> 
        <input type="text" id="lastname" name="lastname" class="inputbox">
        <span class= "error"><?php echo $lastnameError; ?></span>
        <label for="email" class="email"> Email </label> 
        <input type="Email" id="email" name="email" class="inputbox">
        <span class= "error"><?php echo $emailError; ?></span>
        <label for="password" class="password"> Password </label>
        <input type="password" id="password" name="password" class="inputbox">
        <span class= "error"><?php echo $passwordError; ?></span>
        <div class="sign-btn">
            <button type="submit"> Sign Up </button>
        </div>  
        <div class="signup">
            <p  class="Signup"> Already have an account? <a href="index.php"> Sign in!</a> </p>
        </div>  
    </form>
    </div>
 </body>
</html>  
