<?php


    // DISABLE CACHE. 
    session_start(); 
    require_once(__DIR__ . '/../core/cache/disable-cache.php');
    echo '<meta charset="UTF-8">'; 
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<link rel="favicon" href="../favicon.ico" /> ';
    echo '<link rel="stylesheet" href="../styles/styles.css" />';
    echo '<link rel="stylesheet" href="../styles/welljade.css" />';

    echo '<script type="text/javascript" src="../scripts/main.js"></script>'; 


    require_once(__DIR__ . '/../core/objects/user.php');
    if($_SESSION && isset($_SESSION['user'])) {
        $user_email = $_SESSION['user']['email'];
        $user = new User();
        $userInfo = $user->getUserInfo($user_email);
    }else {
        unset($_SESSION['user']); // Clear user session. 
    }
?>   