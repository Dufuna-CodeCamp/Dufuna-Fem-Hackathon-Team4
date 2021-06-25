<?php

    // include db_connect file
    require_once 'php_action/db_connect.php';

    session_start();

    // to prevent user from accessinng log in page when logged in
    if(isset($_SESSION['id'])) {
        header('location: dashboard.php');
    }

    $errors = array();

    if($_POST) {
        $username = $_POST['username'];
        $password = $_POST['password'];
       

        if(empty($username) || empty($password)) {
            if($username == '') {
                $errors[] = 'Username is required';
            }

            if($password == '') {
                $errors[] = 'Password is required';
            }

        } else {
            $sql = "SELECT * FROM `users` WHERE username = '$username'";
            $result = $conn->query($sql);
            // print_r($result);
            // echo $result->num_rows;

            if($result->num_rows == 1) {
                $password = md5($password);
                // exists
                $mainSql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
                $mainResult = $conn->query($mainSql);
                
                if($mainResult->num_rows == 1) {
                    $value = $mainResult->fetch_assoc();
                    $user_id = $value['id'];
                    // echo $user_id;

                    //set session
                    $_SESSION['id'] = $user_id;

                    header('location: dashboard.php');
                } else {
                    $errors[] = 'Incorrect username/password combination';
                }


            } else {
                $errors[] = 'Username does not exist';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
</head>
<body>
    

    <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST' id='loginForm'>
        <div>
            <?php if($errors) {
                foreach ($errors as $key => $value) {
                    echo $value;
                }
            } ?>        
        </div>
        <input type='username' name='username' placeholder='Username' >
        <br />
        <br />
        <!-- <input type='email' name='email' placeholder='Email' >
        <br />
        <br /> -->
        <input type='password' name='password' placeholder='Password' >
        <br />
        <br />
        <button type='submit'>Sign In</button>
    </form>
    
</body>
</html>