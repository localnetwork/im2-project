<?php
    session_start(); 

    require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/score.php');  

    if($_SERVER["REQUEST_METHOD"] === 'POST') {
        $score = new Score; 
        $score_value = $_POST['score']; 
        $assignment_id = $_GET['id']; 
        $student_id = $_POST['student_id']; 

        $scoreExist = $score->getScore($assignment_id, $student_id); 

        

        if($scoreExist == 1) {
            $_SESSION['messages']['errors'][0] = 'Score already exists.';
            header("Location: /scores/create.php?id=" . $_GET['id']);
        }

        $result = $score->createScore($score_value, $student_id, $assignment_id);  
        if($result === 1) {
            // echo 'student created';
            $_SESSION['messages']['success'][0] = 'Successfully created score';
            header("Location: /assignments/scores.php?id=" . $_GET['id']);
        }elseif($result === 0) {
            echo 'Score creation failed';
            $_SESSION['messages']['errors'][0] = 'Score creation failed';
            header("Location: /assignments/scores.php?id=" . $_GET['id']);
        }elseif($result === -2) {
            $_SESSION['messages']['errors'][0] = 'Score already exist.';
            header("Location: /assignments/scores.php?id=" . $_GET['id']);
        }else {
            echo 'error'; 
        }
    }
?>