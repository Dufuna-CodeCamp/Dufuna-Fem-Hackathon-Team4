<?php
    session_start();

    require_once 'db_connect.php';

    // echo $_SESSION['id'];

    if(!$_SESSION['id']) {
        header('location: index.php');
    }
?>