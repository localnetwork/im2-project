<!DOCTYPE html>
<html>
<head>
    <title>Delete Assignment?</title>
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
                require_once (__DIR__ . '/../core/objects/assignment.php');  
            $assignment = new Assignment();  
                $assignment = $assignment->getAssignment(intval($_GET['id']));
                if($assignment !== false) {
                    // $subject = isset($_GET['id']) ? intval($_GET['id']) : '';
                    echo '<h1 class="page-header">Are you sure you want to delete assignment' . ' ' . $assignment['title'] . '?</h1>';  
                    echo "<form action='../../core/handlers/assignment/delete_assignment.php' method='POST' onsubmit='return validateForm()'>"; 
                    echo '<div class="form-item" hidden>';
                    echo '<input hidden type="hidden" id="assignment_id" name="assignment_id" value="'.$assignment['assignment_id'].'" required>';
                    echo '</div>';    
                    echo '<input class="btn" type="submit" value="Yes, please delete record">'; 
                    echo '<a style="text-decoration: none; margin-left: 5px; " href="../assignments"> Cancel</a></div>';
                    echo '</form>'; 
                }else {
                    echo '<h2> Assignment not found.</h2>';    
                }
                
            ?>
        </div>
    </div>       
</body>
</html>