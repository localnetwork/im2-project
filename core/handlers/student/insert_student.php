<?php
    session_start(); 

    require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student.php');  

    if($_SERVER["REQUEST_METHOD"] === 'POST') {
        $student = new Student(); 
        
        $studInfo = array(
            'fname' => $_POST['first_name'],
            'lname' => $_POST['last_name']
        );

        $result = $student->createStudent($studInfo); 

        if($result === 1) {
            // echo 'student created';
            $_SESSION['messages']['success'][0] = 'Successfully created student ' . $studInfo['fname'] . ' ' . $studInfo['lname'];
            header("Location: /students");
        }elseif($result === 0) {
            echo 'student failed';
            $_SESSION['messages']['errors'][0] = 'Error: Student Creation failed.';
            header("Location: /students/create.php");
        }elseif($result === -2) {
            echo 'student already exists!'; 
            $_SESSION['messages']['errors'][0] = 'Student already exists';
            header("Location: /students/create.php");
        }else {
            $_SESSION['messages']['errors'][0] = 'Error: There is a problem creating this student. Please try again later.';
            header("Location: /students/create.php");
            echo 'error'; 
        }
    }

?>