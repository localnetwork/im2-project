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
            <h2>Associate students for this subject</h2>
            <div>
                <a href="../subjects">Back to subjects</a>    
            </div> 

            <?php
               require_once '../templates/alerts/alerts.php';
            ?>
            

            <form action="../../core/handlers/student_subject_association/student_associate.php?id=<?php echo $_GET['id']; ?>"  method="POST">
                <div class="form-item checkboxes">
                  <label for="instructor_id">Add Students:</label>
                  <?php
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student.php');
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student_subject_association.php');
                        $student = new Student(); 
                        $students = $student->getStudents(); 

                       
                        $test = new studentSubjectAssociation();  
                        
                           $test = $test->getStudentsInSubject($_GET['id']);
                     

                        foreach ($students as $student) {
                           // $isChecked = in_array($student['id'], $ids) ? 'checked="checked"' : '';
                           $isChecked = ''; 
                           


                            echo "
                            <div class='item'>
                              <input type='checkbox' name='{$student['id']}' id='{$student['id']}' value='{$student['id']}' {$isChecked} />
                           ";
                            echo "<label for='{$student['id']}'>{$student['first_name']} {$student['last_name']}</label></div>";
                        }
                    ?>
                </div>

                
            
               <input class="btn" type="submit" value="Add students">
            </form>
         </div>
      </div>
   </body>
</html>