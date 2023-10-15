
<!DOCTYPE html>
<html>
<head>
    <title>Update Student <?php 
            require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student.php');  
            $student = new Student();  
            $studentExist = $student->getStudent($_POST['studentId']);
            echo $studentExist['first_name']; 
        ?></title>
    <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/head.php');
    ?>
</head>
<body class="page-students">
    <div class="main-wrapper">
        <div class="container">
            <?php
                require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student.php');  

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
                        }else {
                            echo "Can't update student with the same value."; 
                        }
                    }else {
                        echo 'Student not found!'; 
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