<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        // redirect to dashboard if logged-in. 
        header("Location: /users/login.php");
        exit();
    }else {
        header("Location: /users/dashboard.php");
        exit();
    }
?>