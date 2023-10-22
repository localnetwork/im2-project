<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Update Account</title>
      <?php
         require_once(__DIR__ . '/../templates/head.php');
      ?>
   </head>
   <body>
      <div class="main-wrapper">
        <?php
            require_once(__DIR__ . '/../templates/layout/header.php');
        ?>
         <div class="box">
            <h1 class="page-header">Update your account</h1>
            <?php
                require_once '../templates/alerts/alerts.php';

                // $user = new User();

               
                
                if(isset($userInfo['profile_picture'])) {
                    $media_img = $user->getMediaInfo($userInfo['profile_picture']);
                }


                // $userInfo = $user->getUserInfo($_SESSION['user']['email']);

                $user_email = $_SESSION['user']['email'];
                $user = new User();
                $userInfo = $user->getUserInfo($user_email);
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
                    <div class='form-item' hidden style='display: none;'>
                        <label for='current_password'>Current Password:</label>
                        <input type='password' id='current_password' name='current_password' value=''>
                    </div>
                    <div class='form-item' hidden style='display: none;'>
                        <label for='password'>Password:</label>
                        <input type='password' id='password' name='password'>
                    </div>
                    <div class='form-item'>
                    <label for='profile_picture'>Profile Picture:</label>
                    <div class='' style='margin: 10px 0;'>
                        <img src='{$media_img['uri']}' width='50' height='50' />
                    </div>
                        <input type='file' id='profile_picture' name='profile_picture'>
                    </div>
                    <input class='btn bg-secondary' type='submit' value='Update Account'>
                </form>
                ";
            ?>
         </div>
      </div>
   </body>
</html>