<!DOCTYPE html>
<html>
<head>
    <title>Edit Assignment</title>
    <?php
        require_once(__DIR__ . '/../templates/head.php');
    ?>
</head>
<body class="page-students">
<?php
            require_once(__DIR__ . '/../templates/layout/header.php');
        ?> 
    <div class="main-wrapper">
        <div class="container">
            <div class="test">
            <?php 
                require_once '../core/objects/assignment.php'; 
                require_once '../templates/alerts/alerts.php'; 
                require_once(__DIR__ . '/../core/objects/subject.php');

                
                if (isset($_GET['id'])) {
                    $assignment_id = intval($_GET['id']); 
                    $assignment = new Assignment($assignment_id); 
                    $assignment = $assignment->getAssignment($assignment_id); 
                    $subjects = new Subject(); 
                    $subjects = $subjects->getSubjects(); 

                    if($assignment !== false) { 
                        echo "
                            <h1 class='page-header'> Edit assignment {$assignment['title']}</h1>
                            <a href='/assignments/'>Go back to assignments.</a>
                            <form action='../core/handlers/assignment/update_assignment.php' method='POST' onsubmit='return validateForm()'>
                                <div class='form-item' hidden>
                                    <input hidden type='hidden' id='assignment_id' name='assignment_id' value='{$assignment_id}' required>
                                </div>
                            ";

                            echo '<div class="form-item">
                            <label for="subject">Subject:</label>
                            <select type="textarea" id="subject" name="subject" required>';

                            foreach ($subjects as $subject) {
                                $selected = ($assignment['subject_id'] == $subject['subject_id']) ? 'selected' : '';
                                echo '<option value="' . $subject['subject_id'] . '" ' . $selected . '>' . $subject['title'] . '</option>';
                            }
                                    
                            echo '</select>
                            </div>'; 
                            echo "
                                <div class='form-item'>
                                    <label for='assignment_title'>Title:</label>
                                    <input type='text' id='assignment_title' name='assignment_title'  required value='{$assignment['title']}'>
                                </div>
                                
                                <div class='form-item'>
                                    <label for='assignment_description'>Subject Description:</label>
                                    <textarea type='text' id='assignment_description' name='assignment_description' required>{$assignment['assignment_description']}</textarea>
                                </div>
                                <div class='form-item'>
                                    <label for='score'>Total Score:</label>
                                    <input type='text' id='score' name='score'  required value='{$assignment['total_score']}'>
                                </div> 
                                <input class='btn' type='submit' value='Update subject'>
                            </form>
                        ";
                    }else {
                        // Redirect if subject not found.
                        echo 'Subject not found.'; 
                        // header("Location: /subjects");
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