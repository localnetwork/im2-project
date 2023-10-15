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
        }elseif($result === -2) {
            echo 'student already exists!'; 
        }else {
            echo 'error'; 
        }
    }

?>