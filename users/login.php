<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Login</title>
      <?php
         require_once(__DIR__ . '/../templates/head.php');
      ?>

      <?php
         require_once(__DIR__ . '/../core/redirects/dashboard-redirect.php');
      ?>
   </head>
   <body class='page-login'>
      <div class="main-wrapper">
         <div class="login-container">
            <div class="site-logo">
               <img src="../assets/images/fb.svg" style="max-width: 100%;" />

            </div>
            <div class="login-wrapper">
               <h2>Login your account</h2>
               <?php
                  require_once '../templates/alerts/alerts.php';
               ?>
               <form action="../../core/handlers/user/login_user.php" method="POST">
                  <div class="form-item">
                     <!-- <label for="p_email">Email:</label> -->
                     <input type="email" id="p_email" placeholder="Email" name="p_email" required>
                  </div>
                  <div class="form-item">
                     <!-- <label for="password">Password:</label> -->
                     <input type="password" id="password" placeholder="Password" name="password" required>
                  </div>
                  <input class="btn" type="submit" value="Login">
               </form>

               <div class="form-links">
                  <a href="./register.php">Don't have an account? Register now.</a>
               </div>

            </div>
            
         </div>
      </div>
   </body>
</html>