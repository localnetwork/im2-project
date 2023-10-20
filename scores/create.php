<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Add a score</title>
      <?php
         require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/head.php');
      ?>
   </head>
   <body>

    <?php
                require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student.php');
                require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student_subject_association.php');
                require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/assignment.php');
                    
                $assignment = new Assignment();  
                
                $assignment = $assignment->getAssignment($_GET['id']); 

                

                $student = new Student(); 
                $students = $student->getStudents();  

                $studentsInSubject = new studentSubjectAssociation();  
                $studentsInSubject = $studentsInSubject->getStudentsInSubject($assignment['subject_id']);
                $SidsinSubjects = array_column($studentsInSubject, 'student_id');

                if(!$SidsinSubjects) {
                    // $_SESSION['messages']['errors'][0] = "Please associate a student in subject before you can add a score.";
                    // header("Location: /subjects/view_students.php?id=" . $assignment['subject_id']);
                }

    ?>
   <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/layout/header.php');
    ?> 
      <div class="main-wrapper">
         <div class="box">
            <h2>Add a score</h2>
            <div>
                <a href="../assignments/scores.php?id=<?php echo $_GET['id']; ?>">Back to scores</a>    
            </div> 

            
            <form action="../../core/handlers/score/insert_score.php?id=<?php echo $_GET['id']; ?>" method="POST">
               <div class="form-item">
                  <label for="subject">Student:</label>
                
                    
                  <!-- <select type="textarea" id="subject" name="subject" required> -->
                  <?php
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student.php');
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student_subject_association.php');
                        require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/assignment.php');
                            
                        $assignment = new Assignment();  
                        
                        $assignment = $assignment->getAssignment($_GET['id']); 


                        $student = new Student(); 
                        $students = $student->getStudents();  

                        $studentsInSubject = new studentSubjectAssociation();  
                        $studentsInSubject = $studentsInSubject->getStudentsInSubject($assignment['subject_id']);
                        $SidsinSubjects = array_column($studentsInSubject, 'student_id');
                        echo '<select type="textarea" id="student_id" name="student_id" required>';
                        foreach($students as $student) {
                            if(in_array($student['id'], $SidsinSubjects)) {
                                echo "
                                
                                    <option value='{$student['id']}'> {$student['first_name']}
                                    {$student['last_name']}</option>
                                ";
                            }
                        }

                        echo '</select>'; 

                        echo "<div class='form-item'>
                        <label for='score'>Score:</label>
                        <input type='number' id='score' name='score' max='{$assignment['total_score']}' maxlength='{$assignment['total_score']}' required>
                      </div>";
                        
                    ?>

                    
                  <!-- </select> -->
                </div>

                

               <input class="btn" type="submit" value="Add score">
            </form>
         </div>
      </div>
   </body>
</html>