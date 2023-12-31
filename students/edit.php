<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
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
                require_once '../core/objects/student.php'; 
                require_once '../templates/alerts/alerts.php'; 

                if (isset($_GET['id'])) {
                    $studentId = intval($_GET['id']); 
                    $student = new Student($studentId); 
                    $student = $student->getStudent($studentId); 
                    if($student !== false) {
                        echo "
                            <h1 class='page-header'> Edit student {$student['first_name']} {$student['last_name']}</h1>
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
                    }else {
                        // Redirect if student not found.
                        header("Location: ./index.php");
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