<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Register</title>
      <?php
         require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/head.php');
      ?>
      <?php
         require_once($_SERVER['DOCUMENT_ROOT'] . '/core/redirects/dashboard-redirect.php');
      ?>
   </head>
   <body>
      <div class="main-wrapper">
         <div class="box">
            <h2>Create an account.</h2>
            <?php
               require_once '../templates/alerts/alerts.php';
            ?>
            <a href="./login.php">Back to login</a>
            <form action="../../core/handlers/user/insert_user.php" method="POST" enctype="multipart/form-data">
               <div class="form-item">
                  <label for="first_name">First Name:</label>
                  <input type="text" id="first_name" name="first_name" required>
               </div>
               <div class="form-item">
                  <label for="last_name">Last Name:</label>
                  <input type="text" id="last_name" name="last_name" required>
               </div>
               <div class="form-item">
                  <label for="email">Email:</label>
                  <input type="email" id="email" name="email" required>
               </div>
               <div class="form-item">
                  <label for="password">Password:</label>
                  <input type="password" id="password" name="password" required>
               </div>
               <div class="form-item">
                  <label for="profile_picture">Profile Picture:</label>
                  <input type="file" id="profile_picture" name="profile_picture" required>
               </div>
               <input class="btn" type="submit" value="Create account">
            </form>
         </div>
      </div>
   </body>
</html>