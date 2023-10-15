<!DOCTYPE html>
<html>
<head>
    <title>Student <?php 
            require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student.php');  
            $student = new Student();  
            $studentExist = $student->getStudent($_POST['studentId']);
            echo $studentExist['first_name']; 
        ?> Deleted</title>
    <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/head.php');
    ?> 
</head>
<body class="page-students">
    <div class="main-wrapper">
        <div class="container">
            <?php
                session_start(); 
                require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student.php');  

                if($_SERVER["REQUEST_METHOD"] === 'POST') {
                    $student = new Student(); 
            
                    $studentId = $_POST['studentId'];
            
                    $studentExist = $student->getStudent($_POST['studentId']); 

                    if($studentExist !== false) {
                        $result = $student->deleteStudent($studentId);
                        if ($result === true) {
                            echo 'Student deleted successfully';
                            $_SESSION['messages']['success'][0] = 'Student deleted successfully';
                            header("Location: /students");
                        }
                    }else {
                        echo 'Student not found!'; 
                    } 
                }else {
                    echo "Access denied."; 
                }
            ?> 
        </div>
    </div>     
</body>
</html>