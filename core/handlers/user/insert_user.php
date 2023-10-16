<?php
    

    session_start(); 

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
        // $filename = $_SERVER['REQUEST_TIME'] . '-' . $_FILES['profile_picture']['name']; 
        // $fileFormat = pathinfo($filename, PATHINFO_EXTENSION);

        // $uri = "../../../storage/images/{$filename}";
        // $uploadOk = 1; 

        // if(isset($_POST)) {
        //     $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        //     if($check !== false) {
        //       echo "File is an image - " . $check["mime"] . ".";
        //       $uploadOk = 1;
        //     } else {
        //       echo "File is not an image.";
        //       $uploadOk = 0;
        //     }
        // }
        
        // // Check if file already exists
        // if (file_exists($uri)) {
        //     echo "Sorry, file already exists.";
        //     $uploadOk = 0;
        // }
        // // Check file size
        // if ($_FILES["profile_picture"]["size"] > 500000) {
        //     echo "Sorry, your file is too large.";
        //     $uploadOk = 0;
        // }
        // // Allow certain file formats
        // if($fileFormat != "jpg" && $fileFormat != "png" && $fileFormat != "jpeg" && $fileFormat != "gif" ) {
        //     echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        //     $uploadOk = 0;
        // }

        // // Check if $uploadOk is set to 0 by an error
        // if ($uploadOk == 0) {
        //     echo "Sorry, your file was not uploaded.";
        // // if everything is ok, try to upload file
        // } else {
        //     if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $uri)) {
        //     echo "The file ". htmlspecialchars( basename($_FILES["profile_picture"]["name"])). " has been uploaded.";
        //     } else {
        //         echo "Sorry, there was an error uploading your file.";
        //     }
        // }



        $result = $user->createUser($userInfo); 
        
        
        if($result === 1) {
            $_SESSION['messages']['success'][0] = 'Your account has been created. Please login.';
            header("Location: /users/login.php");
        }elseif($result === 0) {
            echo 'User creation failed.';
        }elseif($result === -2) {
            $_SESSION['messages']['errors'][0] = 'This email already exists!';
            header("Location: /users/register.php");
        }elseif($result === -3) {
            $_SESSION['messages']['errors'][0] = 'Please provide a valid email.';
            header("Location: /users/register.php");
        }


        if($result !== 1) {
            $_SESSION['form_values']['first_name'] = $_POST['first_name'];
            $_SESSION['form_values']['last_name'] = $_POST['last_name'];
            $_SESSION['form_values']['email'] = $_POST['email'];
        }
    }

?>