
<?php
    session_start();  
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/score.php');  

    if($_SERVER["REQUEST_METHOD"] === 'POST') {

        $score = new Score(); 


        $score_id = $_POST['score_id'];
        $score_value = $_POST['score_value']; 


        // Check if subject exists in the database.
        $scoreExist = $score->getScoreById($score_id); 

        
        if(isset($scoreExist)) {
            $result = $score->updateScore($score_id, $score_value);

            if ($result === true) {
                echo 'Score updated successfully';
                $_SESSION['messages']['success'][0] = "Score updated successfully";
                header("Location: /assignments/scores.php?id=" . $scoreExist['assignment_id']);
            }else {
                echo "Can't update score with the same value";
                $_SESSION['messages']['errors'][0] = "Can't update score with the same value";
                header("Location: /scores/edit.php?id=" . $_POST['score_id']);
            } 
        }else {
            echo 'Score not found!'; 
        }
    }else {
        echo "Access denied."; 
    }
?>