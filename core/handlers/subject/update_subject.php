<!DOCTYPE html>
<html>
<head>
    <title>Update Student <?php 
            require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/subject.php');  
            $subject = new Subject();  
            $subject = $subject->getSubject($_POST['subject_id']);
            echo $subject['title']; 
        ?></title>
    <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/head.php');
    ?>
</head>
<body class="page-students">
    <div class="main-wrapper">
        <div class="container">
            <?php
                require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/subject.php');  

                if($_SERVER["REQUEST_METHOD"] === 'POST') {

                    $subject = new Subject(); 

                    $subject_id = $_POST['subject_id'];
                    $title = $_POST['subject_title']; 
                    $description = $_POST['subject_description']; 
                    
                    // Check if subject exists in the database.
                    $subjectExist = $subject->getSubject($subject_id); 
                    
                    if(isset($subjectExist)) {
                        $result = $subject->updateSubject($subject_id, $title, $description);

                        if ($result === true) {
                            echo 'Subject updated successfully';
                            $_SESSION['messages']['success'][0] = "Subject updated successfully";
                            header("Location: /subjects");
                        }else {
                            echo "Can't update subject with the same value."; 

                            $_SESSION['messages']['errors'][0] = "Can't update subject with the same value";
                            header("Location: /subjects/edit.php?id=" . $subject_id);
                        } 
                    }else {
                        echo 'Subject not found!'; 
                    }
                }else {
                    echo "Access denied."; 
                }
            ?>
        </div>
    </div>       
    
    <script>
        function validateForm() {
            var studentId = <?php echo $studentId; ?>; // Get studentId from PHP
            var formStudentId = parseInt(document.getElementById('studentId').value);
            if (formStudentId !== studentId) {
                alert("You're not allowed to change Student ID");
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script> 
</body>
</html>