<!DOCTYPE html>
<html lang="en">
   <head>
      <title>TEST </title>
      <link rel="stylesheet" href="../styles/styles.css" />
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
   <body>
      <div class="main-wrapper">
         <div class="box">
            <h2>Create a student</h2>
            <div>
                <a href="../students">Back to students</a>    
            </div>
            <form action="../../core/handlers/insert_student.php" method="POST">
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