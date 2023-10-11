<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css" /> 
</head>
<body class="page-students">
    <div class="main-wrapper">
        <div class="container">
            <div class="test">
            <?php if (isset($_GET['id'])) {$studentId = intval($_GET['id']); echo $studentId; }?> 

            <form action="../../core/handlers/update_student.php" method="POST" onsubmit="return validateForm()">
                <div class="form-item" hidden>
                    <input hidden type="hidden" id="studentId" name="studentId" value="<?php if (isset($_GET['id'])) {$studentId = intval($_GET['id']); echo $studentId; }?>" required>
                </div>
                <div class="form-item">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                <div class="form-item">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
                <input class="btn" type="submit" value="Update record">
            </form>
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