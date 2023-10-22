<!DOCTYPE html>
<html>
<head>
    <title>Delete Score?</title>
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
            <?php 
                require_once (__DIR__ . '/../core/objects/score.php');  
            $score = new Score();  
                $assignment = $score->deleteScore(intval($_GET['id']));
                if($assignment !== false) {
                    echo '<h1 class="page-header">Are you sure you want to delete this score?</h1>';  
                    echo "<form action='../../core/handlers/score/delete_score.php' method='POST' onsubmit='return validateForm()'>"; 
                    echo '<div class="form-item" hidden>';
                    echo '<input hidden type="hidden" id="score_id" name="score_id" value="'. $_GET['id'] .'" required>';
                    echo '</div>';    
                    echo '<input class="btn" type="submit" value="Yes, please delete record">'; 
                    echo '<a style="text-decoration: none; margin-left: 5px; " href="../assignments"> Cancel</a></div>';
                    echo '</form>'; 
                }else {
                    echo '<h2> Score not found.</h2>';    
                }
                
            ?>
        </div>
    </div>       
</body>
</html>