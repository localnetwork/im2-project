<!DOCTYPE html>
<html>
<head>
    <title>Edit Assignment</title>
    <?php
        require_once(__DIR__ . '/../templates/head.php');
    ?>
</head>
<body class="page-students">
<?php
            require_once(__DIR__ . '/../templates/layout/header.php');
        ?> 
    <div class="main-wrapper">
        <div class="container">
            <div class="test">
            <?php 
                require_once '../templates/alerts/alerts.php'; 
                require_once(__DIR__ . '/../core/objects/score.php');
                require_once(__DIR__ . '/../core/objects/assignment.php');

                
                if (isset($_GET['id'])) {
                    $score = new Score(); 
                    $assignment = new Assignment();
                    $score = $score->getScoreById($_GET['id']); 
                     
                    $assignment = $assignment->getAssignment($score['assignment_id']); 

        

                    
           

                    if($score !== false) { 
                        echo "
                            <h1 class='page-header'> Edit score {$_GET['id']}</h1>
                            <a href='/assignments/'>Go back to assignments.</a>
                            <form style='margin-top: 15px;' action='../core/handlers/score/update_score.php' method='POST' onsubmit='return validateForm()'>
                                <div class='form-item' hidden>
                                    <input hidden type='hidden' id='score_id' name='score_id' value='{$_GET['id']}' required>
                                </div>
                                <div class='form-item'>
                                    <input hidden type='number' id='score_value' name='score_value' value='{$score['score']}' maxlength='{$assignment['total_score']}' max='{$assignment['total_score']}' required>
                                </div>
                                <input class='btn' type='submit' value='Update assignment'>
                            </form>
                        ";
                    }else {
                        // Redirect if subject not found.
                        echo 'Assignment not found.'; 
                        header("Location: /assignments");
                    }
                    
                }
            ?> 
            </div>
        </div>
    </div>       
    
    <script>
        function validateForm() {
            var subject_id = <?php echo $subject_id; ?>;
            var formSubjectId = parseInt(document.getElementById('subject_id').value);
            if (formSubjectId !== subject_id) {
                alert("You're not allowed to modify studentId");
                return false;
            }
            return true;
        }
    </script> 
</body>
</html>