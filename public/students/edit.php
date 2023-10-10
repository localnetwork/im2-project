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
            <div class="test">
            <?php
                // Check if the student ID is provided in the URL
                if (isset($_GET['id'])) {
                    $studentId = intval($_GET['id']); // Sanitize and convert to integer
                    echo $studentId; 
                }
                ?> 
            </div>
        </div>
    </div>        
</body>
</html>