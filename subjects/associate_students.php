<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Add a subject</title>
      <?php
         require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/head.php');
      ?>
   </head>
   <body>
   <?php
            require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/layout/header.php');
        ?> 
      <div class="main-wrapper">
         <div class="box">
            <h2>Associate Students</h2>
            <div>
                <a href="../subjects">Back to subjects</a>    
            </div> 

            <?php
               require_once '../templates/alerts/alerts.php';
            ?>
            
            
            <form action="../../core/handlers/subject/insert_subject.php" method="POST">
                <div class="form-item">
                  <label for="subject_title">Subject Title:</label>
                  <input type="text" id="subject_title" name="subject_title" required>
                </div>
                <div class="form-item">
                  <label for="subject_description">Description:</label>
                  <textarea type="textarea" id="subject_description" name="subject_description" required></textarea>
                </div>

                <div class="form-item">
                  <label for="instructor_id">Instructor:</label>
                  <select type="textarea" id="instructor_id" name="instructor_id" required>
                  <?php
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/instructor.php');
                        $instructors = new Instructor(); 
                        $instructors = $instructors->getInstructors(); 

                        foreach ($instructors as $instructor) {
                            echo '<option value="' . $instructor['id'] . '">' . $instructor['first_name'] . ' ' . $instructor['last_name'] .'</option>';
                        }
                    ?>
                  </select>
                </div>

                
            
               <input class="btn" type="submit" value="Add record">
            </form>
         </div>
      </div>
   </body>
</html>