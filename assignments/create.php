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
            <h2>Add a subject</h2>
            <div>
                <a href="../assignments">Back to assignments</a>    
            </div> 

            <?php
               require_once '../templates/alerts/alerts.php';
            ?>
            
            
            <form action="../../core/handlers/assignment/insert_assignment.php" method="POST">
            <div class="form-item">
                  <label for="subject">Subject:</label>
                  <select type="textarea" id="subject" name="subject" required>
                  <?php
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/subject.php');
                        $subjects = new Subject(); 
                        $subjects = $subjects->getSubjects(); 

                        foreach ($subjects as $subject) {
                            echo '<option value="' . $subject['subject_id'] . '">' . $subject['title'] .'</option>';
                        }
                    ?>
                  </select>
                </div>

                <div class="form-item">
                  <label for="assignment_title">Title:</label>
                  <input type="text" id="assignment_title" name="assignment_title" required>
                </div>
                <div class="form-item">
                  <label for="assignment_description">Description:</label>
                  <textarea type="textarea" id="assignment_description" name="assignment_description" required></textarea>
                </div>

                <div class="form-item">
                  <label for="score">Total Score:</label>
                  <input type="number" id="score" name="score" required>
                </div>

               <input class="btn" type="submit" value="Add assignment">
            </form>
         </div>
      </div>
   </body>
</html>