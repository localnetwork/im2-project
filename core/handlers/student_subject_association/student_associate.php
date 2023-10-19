<?php


    session_start(); 

    require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student_subject_association.php');  

    if($_SERVER["REQUEST_METHOD"] === 'POST') {

        $subject_id = $_GET['id']; 
        $student_ids_array = $_POST; 

        $student_ids = implode(',', $student_ids_array);

        $studentSubjectAssociation = new studentSubjectAssociation(); 


        $result = $studentSubjectAssociation->insertStudentsToSub($subject_id, $student_ids); 

        if($result === 1) {
            echo 'student created';
            $_SESSION['messages']['success'][0] = 'Successfully associated the students ' . $subInfo['subject_title'];
            header("Location: /subjects/view_students.php?id=" . $subject_id);
        }elseif($result === 0) {
            echo 'subject creation failed';
        }elseif($result === -2) {
            echo 'subject already exists!'; 
        }else {
            echo 'error'; 
        }
    }

?>