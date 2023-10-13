<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Login</title>
      <?php
         require_once($_SERVER['DOCUMENT_ROOT'] . '/public/templates/head.php');
      ?>
   </head>
   <body>
      <div class="main-wrapper">
         <div class="box">
            <h2>Login your account.</h2>
            
            <form action="../../core/handlers/user/login_user.php" method="POST">
               <div class="form-item">
                  <label for="p_email">Email:</label>
                  <input type="email" id="p_email" name="p_email" required>
               </div>
               <div class="form-item">
                  <label for="password">Password:</label>
                  <input type="password" id="password" name="password" required>
               </div>
               <input class="btn" type="submit" value="Login">
            </form>
         </div>
      </div>
   </body>
</html>