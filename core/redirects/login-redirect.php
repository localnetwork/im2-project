<?php
    session_start();
    if (!isset($_SESSION['user_email'])) {
        // redirect to dashboard if logged-in. 
        header("Location: /users/login.php");
        exit();
    }else {
        header("Location: /users/dashboard.php");
        exit();
    }
?>