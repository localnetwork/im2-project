<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Register</title>
      <?php
         require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/head.php');
      ?>
   </head>
   <body>
      <div class="main-wrapper">
        <?php
            require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/layout/header.php');
        ?>
         <div class="box">
            <h2>Update.</h2>
            <?php
                require_once '../templates/alerts/alerts.php';

                $user = new User();

               
                
                if(isset($userInfo['profile_picture'])) {
                    $media_img = $user->getMediaInfo($userInfo['profile_picture']);
                }


                $userInfo = $user->getUserInfo($_SESSION['user']['email']);
                echo "
                    <form action='../../core/handlers/user/update_user.php' method='POST' enctype='multipart/form-data'>
                    <div class='form-item'>
                    <label for='first_name'>First Name:</label>
                        <input type='text' id='first_name' name='first_name' value='{$userInfo['first_name']}' required>
                    </div>
                    <div class='form-item'>
                    <label for='last_name'>Last Name:</label>
                        <input type='text' id='last_name' name='last_name' value='{$userInfo['last_name']}' required>
                    </div>
                    <div class='form-item'>
                    <label for='email'>Email:</label>
                        <input type='email' id='email' name='email' value='{$userInfo['email']}' required>
                    </div>
                    <div class='form-item'>
                        <label for='current_password'>Current Password:</label>
                        <input type='password' id='current_password' name='current_password' value='' required>
                    </div>
                    <div class='form-item'>
                        <label for='password'>Password:</label>
                        <input type='password' id='password' name='password' required>
                    </div>
                    <div class='form-item'>
                    <label for='profile_picture'>Profile Picture:</label>
                        
                        <input type='file' id='profile_picture' name='profile_picture'>
                    </div>
                    <input class='btn bg-secondary' type='submit' value='Update Account'>
                </form>
                ";

                // <div class='' style='margin: 10px 0;'>
                        //     <img src='{$media_img['uri']}' width='50' height='50' />
                        // </div>
            ?>
         </div>
      </div>
   </body>
</html>