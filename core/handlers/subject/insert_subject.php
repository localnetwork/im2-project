<?php
    session_start(); 

    require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/subject.php');  

    if($_SERVER["REQUEST_METHOD"] === 'POST') {
        $subject = new Subject(); 

        
        $subInfo = array(
            'author_id' => $_SESSION['user']['id'],
            'subject_title' => $_POST['subject_title'],
            'subject_description' => $_POST['subject_description'],
            'instructor_id' => !empty($_POST['instructor_id']) ? $_POST['instructor_id'] : null
        );

        $result = $subject->createSubject($subInfo); 

        if($result === 1) {
            // echo 'student created';
            $_SESSION['messages']['success'][0] = 'Successfully created subject ' . $subInfo['subject_title'];
            header("Location: /subjects");
        }elseif($result === 0) {
            echo 'subject creation failed';
        }elseif($result === -2) {
            echo 'subject already exists!'; 
        }else {
            echo 'error'; 
        }
    }

?>