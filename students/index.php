<!DOCTYPE html>
<html>
<head>
    <title>List of Students</title>
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
        <h1 class="page-header">Students</h1>

        <div class="head-actions">
            <div class="">
                
                <p>A list of all the students.</p>
            </div>
            <div class="">
                <a class="btn" href="./create.php">Add student</a>
            </div>
        </div>
        <div>
            <a href="../users/dashboard.php">Back to dashboard</a>
        </div>
        <?php
            require_once '../templates/alerts/alerts.php';
        ?>
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
                            require_once(__DIR__ . '/../core/config/db.php');
                            require_once(__DIR__ . '/../core/objects/student.php');
                            
                            $dbcon = new Database();
                            $db = $dbcon->getConnection();
                            $student = new Student(); 
                            $students = $student->getStudents(); 

                            foreach($students as $row) {
                                echo "<div class='item table-row'>";
                                echo "<div class='item-wrapper table-row-wrapper'>";
                                echo "<div class='table-column fname'>{$row['first_name']}</div>";
                                echo "<div class='table-column secondary lname'>{$row['last_name']}</div>";
                                echo "<div class='table-column actions'><div class='edit'><a href='/students/edit.php?id={$row['id']}'>Edit</a></div><div class='delete'><a href='/students/delete.php?id={$row['id']}'>Delete</a></div></div>";
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