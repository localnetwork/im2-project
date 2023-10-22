<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Register</title>
      <?php
         require_once(__DIR__ . '/../templates/head.php');
      ?>
      <?php
         require_once(__DIR__ . '/../core/redirects/dashboard-redirect.php');
      ?>
   </head>
   <body class="page-login">
      <div class="main-wrapper">
         <div class="login-container">

         <img src="../assets/images/fb.svg" style="max-width: 100%;" />
            <div class="login-wrapper">
            <h2>Create an account.</h2>
            <?php
               require_once '../templates/alerts/alerts.php';
            ?>
            
            <form action="../../core/handlers/user/insert_user.php" method="POST" enctype="multipart/form-data">
               <div class="form-item" hidden>
                  <label for="user_role_id">Role:</label>
                  <input hidden type="hidden" id="user_role_id" name="user_role_id" value="2" required>
               </div>
               <div class="form-item">
                  <!-- <label for="first_name">First Name:</label> -->
                  <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
               </div>
               <div class="form-item">
                  <!-- <label for="last_name">Last Name:</label> -->
                  <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
               </div>
               <div class="form-item">
                  <!-- <label for="email">Email:</label> -->
                  <input type="email" id="email" name="email" placeholder="Email" required>
               </div>
               <div class="form-item">
                  <!-- <label for="password">Password:</label> -->
                  <input type="password" id="password" name="password" placeholder="Password" required>
               </div>
               <div class="form-item">
                  <label for="profile_picture">Profile Picture:</label>
                  <input type="file" id="profile_picture" name="profile_picture" required>
               </div>
               <input class="btn" type="submit" value="Create account">
            </form>
            <div class="form-links">
            <a href="./login.php">Back to login</a>
            </div>
            </div>
         </div>
      </div>
   </body>
</html>