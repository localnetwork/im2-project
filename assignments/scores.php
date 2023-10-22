<!DOCTYPE html>
<html>
<head>
    <title>List of Assignments</title>
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
        <h1 class="page-header">Scores in
            
            <?php
                require_once(__DIR__ . '/../core/objects/assignment.php');
                $assignment = new Assignment(); 
                $assignment = $assignment->getAssignment($_GET['id']); 
                echo $assignment['title']; 
                if($assignment === false) {
                    require_once(__DIR__ . '/../core/objects/assignment.php');
                }
            ?>
        </h1>

        <div class="head-actions">
            <div class="">
                
                <p>A list of scores in this assignment.</p>
            </div>
            <div class="">
                <a class="btn" href="../scores/create.php?id=<?php echo $_GET['id'];?>">Add score</a>
            </div>
        </div>
        <div>
            <a href="../assignments">Back to assignments</a>
        </div>
        <?php
            require_once '../templates/alerts/alerts.php';
        ?>
        <div class="student-list">
            <div class="table">
                <div class="table-header w-full">
                    <div class="table-column">
                        Student
                    </div>
                    <div class="table-column">
                        Score
                    </div>
                    <!-- <div class="table-column">
                        Actions
                    </div> -->
                </div>
                <div class="table-body columns-4">
                        <?php

                        try {
                        require_once(__DIR__ . '/../core/objects/student.php');
                        require_once(__DIR__ . '/../core/objects/student_subject_association.php');
                        require_once(__DIR__ . '/../core/objects/assignment.php');
                            
                        $assignment = new Assignment();  
                        
                        $ass = $assignment->getAssignment($_GET['id']); 

                        

                        $student = new Student(); 
                        $students = $student->getStudents();  

                        $studentsInSubject = new studentSubjectAssociation();  
                        $studentsInSubject = $studentsInSubject->getStudentsInSubject($ass['subject_id']);
                        $SidsinSubjects = array_column($studentsInSubject, 'student_id');
                        
                        
                        

                        foreach($students as $student) {
                            if(in_array($student['id'], $SidsinSubjects)) {
                                $id = new Assignment();
                                // $score = $assignment->getStudentAssignmentRecord($student['id'], $_GET['id']);
                          
                                $score = $id->getStudentAssignmentScore($student['id'], $_GET['id']);

                                if(isset($score)) {
                                    $score = $score[0]['score']; 
                                }else {
                                    $score = 'No score';
                                }
                               
                                echo "
                                    <div class='item table-row'> 
                                        <div class='item-wrapper table-row-wrapper'>
                                            <div class='table-column'>
                                            {$student['first_name']}
                                            {$student['last_name']}
                                            </div>
                                            <div class='table-column'>
                                            {$score}
                                            </div>
                                           
                                        </div>
                                    </div>
                                ";

                                 // <div class='table-column actions'>
                                // <div class='edit'><a href='./edit.php?id=7'>Edit</a></div>
                                // </div>
                            }
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