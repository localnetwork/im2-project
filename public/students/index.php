<!DOCTYPE html>
<html>
<head>
    <title>List of Students</title>
    <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/public/templates/head.php');
    ?>
</head>
<body class="page-students">
    <div class="main-wrapper">
        <div class="container">
        <div class="head-actions">
            <div class="">
                <h2>Students</h2>
                <p>A list of all the students.</p>
            </div>
            <div class="">
                <a class="btn" href="./create.php">Add student</a>
            </div>
        </div>
        <div class="student-list">
            <div class="table">
                <div class="table-header w-full">
                    <div class="table-column">
                        First Name
                    </div>
                    <div class="table-column">
                        Last Name
                    </div>
                    <div class="table-column">
                        Actions
                    </div>
                </div>
                <div class="table-body">
                        <?php

                        try {
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/config/db.php');
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student.php');
                            
                            $dbcon = new Database();
                            $db = $dbcon->getConnection();
                            $student = new Student(); 
                            $students = $student->getStudents(); 

                            foreach($students as $row) {
                                echo "<div class='item table-row'>";
                                echo "<div class='item-wrapper table-row-wrapper'>";
                                echo "<div class='table-column fname'>{$row['first_name']}</div>";
                                echo "<div class='table-column secondary lname'>{$row['last_name']}</div>";
                                echo "<div class='table-column actions'><div class='edit'><a href='/public/students/edit.php?id={$row['id']}'>Edit</a></div><div class='delete'><a href='/public/students/delete.php?id={$row['id']}'>Delete</a></div></div>";
                                echo "</div>";
                                echo "</div>";
                            }

                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                        
                </div>
            </div>
        </div>
        </div>
    </div>        
</body>
</html>