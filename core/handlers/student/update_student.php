<?php
    session_start(); 
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student.php');  

    if($_SERVER["REQUEST_METHOD"] === 'POST') {
        $student = new Student(); 

        $studentId = $_POST['studentId'];
        $first_name = $_POST['first_name']; 
        $last_name = $_POST['last_name']; 

        $studentExist = $student->getStudent($_POST['studentId']); 

        if($studentExist !== false) {
            $result = $student->updateStudent($studentId, $first_name, $last_name);
            if ($result === true) {
                echo 'Student updated successfully';
                $_SESSION['messages']['success'][0] = "Student updated successfully";
                header("Location: /students");
            }else {
                echo "Can't update student with the same value."; 

                $_SESSION['messages']['errors'][0] = "Can't update student with the same value";
                header("Location: /students/edit.php?id=" . $studentId);
            } 
        }else {
            echo 'Student not found!'; 
        }
    }else {
        echo "Access denied."; 
    }
?>