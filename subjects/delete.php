<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
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
                require_once (__DIR__ . '/../core/objects/subject.php');  
                $subject = new Subject();  
                $subject = $subject->getSubject(intval($_GET['id']));
                if($subject !== false) {
                    // $subject = isset($_GET['id']) ? intval($_GET['id']) : '';
                    echo '<h1 class="page-header">Are you sure you want to delete subject' . ' ' . $subject['title'] . '?</h1>';  
                    echo '<form action="../../core/handlers/subject/delete_subject.php" method="POST" onsubmit="return validateForm()">'; 
                    echo '<div class="form-item" hidden>';
                    echo '<input hidden type="hidden" id="subject_id" name="subject_id" value="'.$subject['subject_id'].'" required>';
                    echo '</div>';    
                    echo '<input class="btn" type="submit" value="Yes, please delete record">'; 
                    echo '<a style="text-decoration: none; margin-left: 5px; " href="../subjects"> Cancel</a></div>';
                    echo '</form>'; 
                }else {
                    echo '<h2> Subject not found.</h2>';    
                }
                
            ?>
        </div>
    </div>       
</body>
</html>