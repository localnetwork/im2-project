<?php
    session_start(); 
    require_once (__DIR__ . '/../../objects/score.php');  

    if($_SERVER["REQUEST_METHOD"] === 'POST') {

        var_dump($_POST); 
        $score = new Score();   

        $score_id = $_POST['score_id'];
        $scoreExist = $score->getScoreById($score_id); 



        if($scoreExist !== false) {
            $result = $score->deleteScore($score_id);
            if ($result === true) {
                echo 'Score deleted successfully';
                $_SESSION['messages']['success'][0] = 'Score deleted successfully';
                header("Location: /assignments");
            }else {
                echo 'You cannot delete an score that is associated with a score.';
                $_SESSION['messages']['errors'][0] = 'You cannot delete this score.';
                header("Location: /assignments");
                
            }
        }else {
            echo 'Score not found!'; 
        } 
    }else {
        echo "Access denied."; 
    }
?> 