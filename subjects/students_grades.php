<!DOCTYPE html>
<html>
<head>
    <title>Students in <?php
            require_once(__DIR__ . '/../core/objects/subject.php');
            $subject = new Subject(); 
            $subject = $subject->getSubject($_GET['id']);
            echo $subject['title']; 
        ?> </title>
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
        <h1 class="page-header">
        <?php
            require_once(__DIR__ . '/../core/objects/subject.php');
            $subject = new Subject(); 
            $subject = $subject->getSubject($_GET['id']);
            echo $subject['title']; 
        ?>    

        </h1>

        
        <div class="head-actions">
            <div class="">
                
                <p>The grades of students in this subject.</p>
            </div>
        </div>
        <div>
            <a href="/subjects">Back to subjects</a>
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
                        Grade
                    </div>
                    <div class="table-column">
                        Status
                    </div>
                    
                </div>
                <div class="table-body">
                        <?php

                        try {
                            require_once(__DIR__ . '/../core/objects/student.php');
                            require_once(__DIR__ . '/../core/objects/student_subject_association.php');
                            $student = new Student(); 
                            $students = $student->getStudents();  

                            $studentsInSubject = new studentSubjectAssociation();  
                            $studentsInSubject = $studentsInSubject->getStudentsInSubject($_GET['id']);
                            $SidsinSubjects = array_column($studentsInSubject, 'student_id');

                            if(!$SidsinSubjects) {
                                echo "<div class='no-result'>There are no students to show. Please associate a student.</div>"; 
                            }

                            // $SidsinSubjects = array_flip($SidsinSubjects); 


                            foreach($students as $row) {
                              
                                if(in_array($row['id'], $SidsinSubjects)) {
                                    $grade = $student->getStudentGradeBySubject($_GET['id'], $row['id']);

                                    if($grade['total_grade']) {
                                        $grade = $grade['total_grade'];

                                        if($grade >= 75) {
                                            $status = 'passed'; 
                                            $statusM = 'PASSED';
                                        }else {
                                            $statusM = 'FAILED'; 
                                            $status = 'failed'; 
                                        }
                                    }else {
                                        $grade = 'No Grade'; 
                                        $status = 'no-grade'; 
                                        $statusM = 'No Grade'; 
                                    }
                            
                                    echo "
                                    <div class='item table-row'>
                                        <div class='item-wrapper table-row-wrapper'>
                                            <div class='table-column fullname'>
                                                {$row['first_name']} {$row['last_name']}
                                            </div>
                                            <div class='table-column grade'>
                                                {$grade}
                                            </div>
                                            <div class='table-column'>
                                                <span class='status {$status}'>{$statusM}</span>
                                            </div>
                                        </div>
                                    </div>
                                    ";
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