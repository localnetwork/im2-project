<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/head.php');
    ?>
</head>
<body class="page-students">
    <div class="main-wrapper">
        <div class="container">
            <div class="test">
            <?php 
                require_once '../core/objects/student.php'; 

                if (isset($_GET['id'])) {
                    $studentId = intval($_GET['id']); 
                    $student = new Student($studentId); 
                    $student = $student->getStudent($studentId); 
                    if($student !== false) {
                        echo "
                            <h2>Edit student {$student['first_name']} {$student['last_name']}</h2>
                            <a href='/students/'>Go back to students.</a>
                            <form action='../core/handlers/student/update_student.php' method='POST' onsubmit='return validateForm()'>
                                <div class='form-item' hidden>
                                    <input hidden type='hidden' id='studentId' name='studentId' value='{$studentId}' required>
                                </div>
                                <div class='form-item'>
                                    <label for='first_name'>First Name:</label>
                                    <input type='text' id='first_name' name='first_name'  required value='{$student['first_name']}'>
                                </div>
                                <div class='form-item'>
                                    <label for='last_name'>Last Name:</label>
                                    <input type='text' id='last_name' name='last_name'  required value='{$student['last_name']}'>
                                </div>
                                <input class='btn' type='submit' value='Update record'>
                            </form>
                        ";
                    }
                    
                }
            ?> 
            </div>
        </div>
    </div>       
    
    <script>
        function validateForm() {
            var studentId = <?php echo $studentId; ?>;
            var formStudentId = parseInt(document.getElementById('studentId').value);
            if (formStudentId !== studentId) {
                alert("You're not allowed to modify studentId");
                return false;
            }
            return true;
        }
    </script> 
</body>
</html>