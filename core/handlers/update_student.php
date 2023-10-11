
<!DOCTYPE html>
<html>
<head>
    <title>List of Students</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css" /> 
</head>
<body class="page-students">
    <div class="main-wrapper">
        <div class="container">
            
            <?php
                require_once '../objects/student.php'; 

                if($_SERVER["REQUEST_METHOD"] === 'POST') {
                    $student = new Student(); 
            
                    $studentId = $_POST['studentId'];
                    $first_name = $_POST['first_name']; 
                    $last_name = $_POST['last_name']; 
            
            
                    $studentExist = $student->getStudent($_POST['studentId']); 
            
                    if($studentExist !== false) {
                        $result = $student->updateStudent($studentId, $first_name, $last_name);
                        if ($result === true) {
                            echo 'Student updated successfully';
                        }
                    }else {
                        echo 'Student not found!'; 
                    }
                }
            ?>
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