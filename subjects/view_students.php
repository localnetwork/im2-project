<!DOCTYPE html>
<html>
<head>
    <title>Students in <?php
            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/subject.php');
            $subject = new Subject(); 
            $subject = $subject->getSubject($_GET['id']);
            echo $subject['title']; 
        ?> </title>
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
        <h1 class="page-header">
        <?php
            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/subject.php');
            $subject = new Subject(); 
            $subject = $subject->getSubject($_GET['id']);
            echo $subject['title']; 
        ?>    

        </h1>

        
        <div class="head-actions">
            <div class="">
                
                <p>A list of students in this subject.</p>
            </div>
            <div class="">
                <a class="btn" href="./associate_students.php?id=<?php echo $_GET['id']; ?>">Associate students</a>
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
                        Last Name
                    </div>
                    
                </div>
                <div class="table-body">
                        <?php

                        try {
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student.php');
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/student_subject_association.php');
                            $student = new Student(); 
                            $students = $student->getStudents();  

                            $studentsInSubject = new studentSubjectAssociation();  
                            $studentsInSubject = $studentsInSubject->getStudentsInSubject($_GET['id']);
                            $SidsinSubjects = array_column($studentsInSubject, 'student_id');
                            
                            if(!$SidsinSubjects) {
                                echo "<div class='no-result'>There are no subjects to show. Please create a subject.</div>"; 
                            }
                            foreach($students as $student) {
                                
                                if(in_array($student['id'], $SidsinSubjects)) {
                                    echo "
                                    <div class='item table-row'>
                                        <div class='item-wrapper table-row-wrapper'>
                                            <div class='table-column fname'>
                                                {$student['first_name']}
                                            </div>
                                            <div class='table-column secondary lname'>
                                                {$student['last_name']}
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