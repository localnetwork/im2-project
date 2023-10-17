<?php
    session_start(); 

    require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/user.php'); 


    $user = new User();

    $userInfo = $user->getUserInfo($_SESSION['user']);


    $password = $_POST['password']; 

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // var_dump($userInfo); 

    $result = $user->updateUser($_POST['email'], $_POST['first_name'], $_POST['last_name'], $_FILES['profile_picture']);

    var_dump($result); 

?>