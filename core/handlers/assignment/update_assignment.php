
<?php
    session_start();  
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/assignment.php');  

    if($_SERVER["REQUEST_METHOD"] === 'POST') {

        $assignment = new Assignment(); 

        $subject_id = $_POST['subject'];
        $assignment_id = $_POST['assignment_id'];
        $title = $_POST['assignment_title']; 
        $description = $_POST['assignment_description']; 
        $score = $_POST['score']; 

        // Check if subject exists in the database.
        $assignmentExist = $assignment->getAssignment($assignment_id); 
        
        if(isset($assignmentExist)) {
            $result = $assignment->updateAssignment($subject_id, $assignment_id, $title, $description, $score);

            if ($result === true) {
                echo 'Assignment updated successfully';
                $_SESSION['messages']['success'][0] = "Assignment updated successfully";
                header("Location: /assignments");
            }else {
                echo "Can't update assignment with the same value";
                $_SESSION['messages']['errors'][0] = "Can't update assignment with the same value";
                header("Location: /assignments/edit.php?id=" . $assignment_id);
            } 
        }else {
            echo 'Assignment not found!'; 
        }
    }else {
        echo "Access denied."; 
    }
?>