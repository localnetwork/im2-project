<!DOCTYPE html>
<html>
<head>
    <title>List of Assignments</title>
    <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/head.php');
    ?>
</head>
<body class="page-students">
<?php
            require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/layout/header.php');
        ?> 
    <div class="main-wrapper">
        <div class="container">
        <h1 class="page-header">Assignments in
            <?php
                require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/subject.php');
                $subject = new Subject(); 
                $subject = $subject->getSubject($_GET['id']); 

                echo $subject['title']; 
            ?>

        </h1>

        <div class="head-actions">
            <div class="">
                
                <p>A list of all the assignments.</p>
            </div>
            <div class="">
                <a class="btn" href="./create.php?id=<?php echo $_GET['id']; ?>">Add assignment</a>
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
                        Score
                    </div>
                    <div class="table-column">
                        Actions
                    </div>
                </div>
                <div class="table-body columns-4">
                        <?php

                        try {
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/config/db.php');
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/subject.php');
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/instructor.php');
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/assignment.php');
                            
                            $dbcon = new Database();
                            $db = $dbcon->getConnection();
                            $instructor = new Instructor(); 
                            $subjects = new Subject(); 
                            $subjects = $subjects->getSubjects(); 
                            $assignment = new Assignment(); 
                            
                            $assignments = $assignment->getAssignmentsBySubject($_GET['id']); 


                            if(!$assignments) {
                                echo "<div class='no-result'>There are no assignments to show. Please add an assignment.</div>"; 
                            }
                            foreach($assignments as $row) {
                                echo "<div class='item table-row'>";
                                echo "<div class='item-wrapper table-row-wrapper'>";
                                echo "<div class='table-column fname'>{$row['title']}</div>";
                                echo "<div class='table-column secondary description'>{$row['assignment_description']}</div>";
                                echo "<div class='table-column secondary instructor'>{$row['total_score']}</div>";
                                echo "<div class='table-column actions'><div class='edit'><a href='./edit.php?id={$row['assignment_id']}'>Edit</a></div><div class='delete'><a href='/assignments/delete.php?id={$row['assignment_id']}'>Delete</a></div><div class='delete'><a href='/assignments/scores.php?id={$row['assignment_id']}'>View Scores</a></div></div>";
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