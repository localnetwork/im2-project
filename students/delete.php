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
                require_once (__DIR__ . '/../core/objects/student.php');  
                $student = new Student();  
                $studentExist = $student->getStudent(intval($_GET['id']));

                if($studentExist !== false) {
                    $studentId = isset($_GET['id']) ? intval($_GET['id']) : '';
                    echo '<h1 class="page-header">Are you sure you want to delete student' . ' ' . $studentExist['first_name'] . " " . $studentExist['last_name'] . '?</h1>';  
                    echo '<form action="../../core/handlers/student/delete_student.php" method="POST" onsubmit="return validateForm()">'; 
                    echo '<div class="form-item" hidden>';
                    echo '<input hidden type="hidden" id="studentId" name="studentId" value="' . $studentId . '" required>';
                    echo '</div>';    
                    echo '<input class="btn" type="submit" value="Yes, please delete record">'; 
                    echo '<a style="text-decoration: none; margin-left: 5px; " href="../students"> Cancel</a></div>';
                    echo '</form>';
                }else {
                    echo '<h2> Student not found.</h2>';    
                }
                
            ?>
        </div>
    </div>       
    
</body>
</html>