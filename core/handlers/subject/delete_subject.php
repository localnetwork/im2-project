<?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/subject.php');  

    if($_SERVER["REQUEST_METHOD"] === 'POST') {
        $subject = new Subject();   

        var_dump($_POST); 

        $subject_id = $_POST['subject_id'];

        $subjectExist = $subject->getSubject($_POST['subject_id']); 

        if($subjectExist !== false) {
            $result = $subject->deleteSubject($subject_id);
            if ($result === true) {
                echo 'Subject deleted successfully';
                $_SESSION['messages']['success'][0] = 'Subject deleted successfully';
                header("Location: /subjects");
            }
        }else {
            echo 'Subject not found!'; 
        } 
    }else {
        echo "Access denied."; 
    }
?> 