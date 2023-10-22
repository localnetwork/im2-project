
<?php
    session_start(); 
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/subject.php');  

    if($_SERVER["REQUEST_METHOD"] === 'POST') {

        $subject = new Subject(); 

        $subject_id = $_POST['subject_id'];
        $title = $_POST['subject_title']; 
        $description = $_POST['subject_description']; 
        $instructor_id = intval($_POST['instructor_id']); 

        var_dump($instructor_id); 
        
        // Check if subject exists in the database.
        $subjectExist = $subject->getSubject($subject_id); 
        
        if(isset($subjectExist)) {
            $result = $subject->updateSubject($instructor_id, $subject_id, $title, $description);

            if ($result === true) {
                echo 'Subject updated successfully';
                $_SESSION['messages']['success'][0] = "Subject updated successfully";
                header("Location: /subjects");
            }else {
                echo "Can't update subject with the same value."; 

                // $_SESSION['messages']['errors'][0] = "Can't update subject with the same value";
                // header("Location: /subjects/edit.php?id=" . $subject_id);
            } 
        }else {
            echo 'Subject not found!'; 
        }
    }else {
        echo "Access denied."; 
    }
?>