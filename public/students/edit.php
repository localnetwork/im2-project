<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/public/templates/head.php');
    ?>
</head>
<body class="page-students">
    <div class="main-wrapper">
        <div class="container">
            <div class="test">
            <?php 
                require_once '../../core/objects/student.php'; 

                if (isset($_GET['id'])) {
                    $studentId = intval($_GET['id']); 
                    $student = new Student($studentId); 
                    $student = $student->getStudent($studentId); 
                    if($student !== false) {
                        echo '<h2> Edit student ' . $student['first_name'] . ' ' . $student['last_name'] . '</h2>';   
                        echo '<a href="/public/students/">Go back to students.</a>';   
                        echo '<form action="../../core/handlers/update_student.php" method="POST" onsubmit="return validateForm()">'; 
                        
                        
                            echo '<div class="form-item" hidden>'; 
                                echo '<input hidden type="hidden" id="studentId" name="studentId" value="' .  $studentId .'" required>'; 
                            echo '</div>'; 

                            echo '<div class="form-item">'; 
                                echo '<label for="first_name">First Name:</label>'; 
                                echo '<input type="text" id="first_name" name="first_name"  required value="' .  $student['first_name'] .'">'; 
                            echo '</div>'; 

                            echo '<div class="form-item">'; 
                                echo '<label for="last_name">Last Name:</label>'; 
                                echo '<input type="text" id="last_name" name="last_name"  required value="' .  $student['last_name'] .'">'; 
                            echo '</div>'; 
                        
                            echo '<input class="btn" type="submit" value="Update record">'; 
                        echo '</form>'; 
                    }
                    
                }
            ?> 
            </div>
        </div>
    </div>       
    
    <script>
        function validateForm() {
            var studentId = <?php echo $studentId; ?>; // Get studentId from PHP
            var formStudentId = parseInt(document.getElementById('studentId').value);
            if (formStudentId !== studentId) {
                alert("You're not allowed to modify studentId");
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script> 
</body>
</html>