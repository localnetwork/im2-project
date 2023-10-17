<?php
    if (isset($_SESSION['user'])) {
        // redirect to dashboard if logged-in. 
        header("Location: /users/dashboard.php");
        exit();
    }
?>


