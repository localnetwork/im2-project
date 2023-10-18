<?php
    session_start(); 

    require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/assignment.php');  

    if($_SERVER["REQUEST_METHOD"] === 'POST') {
        $assignment = new Assignment(); 
        
        var_dump($_POST); 
        $assignmentInfo = array(
            'author_id' => $_SESSION['user']['id'],
            'subject_id' => $_POST['subject'],
            'assignment_title' => $_POST['assignment_title'],
            'ass_description' => $_POST['assignment_description'],
            'total_score' => !empty($_POST['score']) ? $_POST['score'] : null
        );

        $result = $assignment->createAssignment($assignmentInfo); 

        if($result === 1) {
            // echo 'student created';
            $_SESSION['messages']['success'][0] = 'Successfully created assignment ' . $assignmentInfo['subject_title'];
            header("Location: /assignments");
        }elseif($result === 0) {
            echo 'Assignment creation failed';
        }elseif($result === -2) {
            echo 'Assignment already exists!'; 
        }else {
            echo 'error'; 
        }
    }
?>