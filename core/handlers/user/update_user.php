<?php

    session_start(); 
    
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/user.php'); 

    $user = new User();

    $userInfo = $user->getUserInfo($_SESSION['user']['email']);


    $password = $_POST['password']; 

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $result = $user->updateUser($_POST['email'], $_POST['first_name'], $_POST['last_name'], $_FILES['profile_picture'], $_SESSION['user']['id']);
    if($result === 1) {
        $_SESSION['messages']['success'][0] = 'Your account has successfully updated.';
        header("Location: /users/update.php");
    }else {
        $_SESSION['messages']['errors'][0] = "There's a problem updating your account. Please try again.";
        header("Location: /users/update.php");
    }

?>