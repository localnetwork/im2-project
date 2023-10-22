<!DOCTYPE html>
<html>
<head>
    <title>List of Subjects</title>
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
        <h1 class="page-header">Subjects</h1>

        <div class="head-actions">
            <div class="">
                
                <p>A list of all the subjects.</p>
            </div>
            <div class="">
                <a class="btn" href="./create.php">Add subject</a>
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
                        Title
                    </div>
                    <div class="table-column">
                        Description
                    </div>
                    <div class="table-column">
                        Instructor
                    </div>
                    <div class="table-column">
                        Actions
                    </div>
                </div>
                <div class="table-body columns-4">
                        <?php

                        try {
                            require_once(__DIR__ . '/../core/config/db.php');
                            require_once(__DIR__ . '/../core/objects/subject.php');
                            
                            
                            $dbcon = new Database();
                            $db = $dbcon->getConnection();
                            
                            $subjects = new Subject(); 
                            $subjects = $subjects->getSubjects(); 

                            if(!$subjects) {
                                echo "<div class='no-result'>There are no subjects to show. Please create a subject.</div>"; 
                            }
                            foreach($subjects as $row) {
                                if(isset($row['instructor'])) {
                                    require_once(__DIR__ . '/../core/objects/instructor.php'); 
                                    $instructor = new Instructor(); 
                                    $instructor = $instructor->getInstructor($row['instructor']); 
                                }
                                echo "<div class='item table-row'>";
                                echo "<div class='item-wrapper table-row-wrapper'>";
                                echo "<div class='table-column fname'>{$row['title']}</div>";
                                echo "<div class='table-column secondary description'>{$row['description']}</div>";
                                if(isset($row['instructor'])) {
                                echo "<div class='table-column secondary instructor'>{$instructor['first_name']} {$instructor['last_name']}</div>";
                                }
                                echo "<div class='table-column actions'><div class='edit'><a href='./edit.php?id={$row['subject_id']}'>Edit</a></div><div class='delete'><a href='/subjects/delete.php?id={$row['subject_id']}'>Delete</a></div><div class='delete'><a href='/subjects/view_students.php?id={$row['subject_id']}'>View Students</a></div><div class='delete'><a href='/assignments/view.php?id={$row['subject_id']}'>View Assignments</a></div><div class='delete'><a href='/subjects/students_grades.php?id={$row['subject_id']}'>Students Grades</a></div></div>";
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