<!DOCTYPE html>
<html>
<head>
    <title>View Students for this subject</title>
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
                
                <p>A list of all the students in this subject.</p>
            </div>
            <div class="">
                <a class="btn" href="./create.php">Associate students</a>
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
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/config/db.php');
                            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/subject.php');
                            
                            $dbcon = new Database();
                            $db = $dbcon->getConnection();
                            $subjects = new Subject(); 
                            $subjects = $subjects->getSubjects(); 


                            foreach($subjects as $row) {
                                echo "<div class='item table-row'>";
                                echo "<div class='item-wrapper table-row-wrapper'>";
                                echo "<div class='table-column fname'>{$row['title']}</div>";
                                echo "<div class='table-column secondary lname'>{$row['description']}</div>";
                               
                                echo "<div class='table-column actions'><div class='delete'><a href='/subjects/ddd.php?id={$row['subject_id']}'>Remove</a></div></div>";
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