<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Register</title>
      <?php
         require_once($_SERVER['DOCUMENT_ROOT'] . '/public/templates/head.php');
      ?>
   </head>
   <body>
      <div class="main-wrapper">
         <div class="box">
            <h2>Create an account.</h2>
            
            <form action="../../core/handlers/user/insert_user.php" method="POST">
               <div class="form-item">
                  <label for="email">Email:</label>
                  <input type="email" id="email" name="email" required>
               </div>
               <div class="form-item">
                  <label for="password">Password:</label>
                  <input type="password" id="password" name="password" required>
               </div>
               <div class="form-item" hidden>
                  <label for="role"> Role:</label>
                  <input hidden type="hidden" id="role" name="role" value="1" required>
               </div>
               <input class="btn" type="submit" value="Create account">
            </form>
         </div>
      </div>

      <script>
         function validateForm() {
               var roleId = 1; // Get studentId from PHP
               var formRoleId = parseInt(document.getElementById('role').value);
               if (roleId !== formRoleId) {
                  alert("You're not allowed to modify role ID");
                  return false; // Prevent form submission
               }
               return true; // Allow form submission
         }
      </script>  
   </body>
</html>