<?php

    require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/user.php');  

    if($_SERVER["REQUEST_METHOD"] === 'POST') {
        $user = new User(); 
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userInfo = array(
            'email' => $_POST['email'],
            'password' => $hashedPassword, 
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
        );

        $result = $user->createUser($userInfo); 

        
        if($result === 1) {
            echo 'User created.';
        }elseif($result === 0) {
            echo 'User creation failed.';
        }elseif($result === -2) {
            echo 'User already exists!'; 
        }
    }

?>