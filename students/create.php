<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Add a student</title>
      <?php
         require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/head.php');
      ?>
   </head>
   <body>
      <div class="main-wrapper">
         <div class="box">
            <h2>Add a student</h2>
            <div>
                <a href="../students">Back to students</a>    
            </div> 

            <?php
               session_start(); 
               require_once '../templates/alerts/alerts.php';
            ?>
            <form action="../../core/handlers/student/insert_student.php" method="POST">
               <div class="form-item">
                  <label for="first_name">First Name:</label>
                  <input type="text" id="first_name" name="first_name" required>
               </div>
               <div class="form-item">
                  <label for="last_name">Last Name:</label>
                  <input type="text" id="last_name" name="last_name" required>
               </div>
               <input class="btn" type="submit" value="Add record">
            </form>
         </div>
      </div>
   </body>
</html>