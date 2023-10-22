<!DOCTYPE html>
<html>
<head>
    <title>Edit Subject</title>
    <?php
        require_once(__DIR__ . '/../templates/head.php');
    ?>
</head>
<body class="page-subjects">
<?php
            require_once(__DIR__ . '/../templates/layout/header.php');
        ?> 
    <div class="main-wrapper">
        <div class="container">
            <div class="test">
            <?php 
                require_once '../core/objects/subject.php'; 
                require_once '../core/objects/instructor.php'; 
                require_once '../templates/alerts/alerts.php'; 
                if (isset($_GET['id'])) {
                    $subject_id = intval($_GET['id']); 
                    $subject = new Subject($subject_id); 
                    $subject = $subject->getSubject($subject_id); 

                    $instructor = new Instructor();
                    $instructors = $instructor->getInstructors(); 

                    if($subject !== false) {
                        echo "
                            <h1 class='page-header'> Edit subject {$subject['title']}</h1>
                            <a href='/subjects/'>Go back to subject.</a>
                            <form action='../core/handlers/subject/update_subject.php' method='POST' onsubmit='return validateForm()'>
                                <div class='form-item' hidden>
                                    <input hidden type='hidden' id='subject_id' name='subject_id' value='{$subject_id}' required>
                                </div>
                                <div class='form-item'>
                                    <label for='subject_title'>Subject Title:</label>
                                    <input type='text' id='subject_title' name='subject_title'  required value='{$subject['title']}'>
                                </div>
                                
                            ";

                            // foreach ($subjects as $subject) {
                            //     if(isset( $_GET['id'])) {
                            //        $selected = ($subject['subject_id'] == $_GET['id']) ? 'selected' : '';
                            //     }else {
                            //        $selected = ''; 
                            //     }
                                
                            //     echo '<option ' . $selected . ' value="' . $subject['subject_id'] . '">' . $subject['title'] .'</option>';
                            //  }
                        echo '<div class="form-item">
                                <label for="instructor">Instructor</label>
                        <select name="instructor_id" id="instructor_id">';
                        foreach($instructors as $instructor) {
                            if(isset($subject['instructor'])) {
                                $selected = ($instructor['id'] == $subject['instructor']) ? 'selected' : '';
                             }else {
                                $selected = ''; 
                             }
                            echo "
                                <option {$selected} value='{$instructor['id']}'>{$instructor['first_name']} {$instructor['last_name']}</option>
                            ";
                        }
                        echo '</select></div>';
                        echo "<div class='form-item'>
                                    <label for='subject_description'>Subject Description:</label>
                                    <textarea type='text' id='subject_description' name='subject_description' required>{$subject['description']}</textarea>
                                </div>
                                <input class='btn' type='submit' value='Update subject'>
                            </form>
                        ";
                    }else {
                        // Redirect if subject not found.
                        echo 'Subject not found.'; 
                        header("Location: /subjects");
                    }
                    
                }
            ?> 
            </div>
        </div>
    </div>       
    
    <script>
        function validateForm() {
            var subject_id = <?php echo $subject_id; ?>;
            var formSubjectId = parseInt(document.getElementById('subject_id').value);
            if (formSubjectId !== subject_id) {
                alert("You're not allowed to modify studentId");
                return false;
            }
            return true;
        }
    </script> 
</body>
</html>