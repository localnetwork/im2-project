<?php
    session_start(); 
    require_once (__DIR__ . '/../../objects/assignment.php');  

    if($_SERVER["REQUEST_METHOD"] === 'POST') {

        var_dump($_POST); 
        $assignment = new Assignment();   

        $assignment_id = $_POST['assignment_id'];
        $assignmentExist = $assignment->getAssignment($assignment_id); 


        if($assignmentExist !== false) {
            $result = $assignment->deleteAssignment($assignment_id);
            if ($result === true) {
                echo 'Assignment deleted successfully';
                $_SESSION['messages']['success'][0] = 'Assignment deleted successfully';
                header("Location: /assignments");
            }else {
                echo 'You cannot delete an assignment that is associated with a score.';
                $_SESSION['messages']['errors'][0] = 'You cannot delete an assignment that is associated with a score.';
                header("Location: /assignments");
                
            }
        }else {
            echo 'Assignment not found!'; 
        } 
    }else {
        echo "Access denied."; 
    }
?> 