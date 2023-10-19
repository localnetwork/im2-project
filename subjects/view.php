<!DOCTYPE html>
<html>
<head>
    <title><?php
            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/subject.php');
            $subject = new Subject(); 
            $subject = $subject->getSubject($_GET['id']);
            echo $subject['title']; 
        ?>   </title>
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
       

        
        <?php
            require_once '../templates/alerts/alerts.php';
        ?>

        <?php
            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/subject.php');
            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/instructor.php');
            $subject = new Subject(); 
            $subject = $subject->getSubject($_GET['id']);


            $instructor = new Instructor(); 
            $instructor = $instructor->getInstructor($subject['instructor']); 


            var_dump($subject['instructor']); 
            echo "<h1 class='page-header'>{$subject['title']}</h1>
            <div>
                <a href='../subjects'>Back to subjects</a>
            </div>
            "; 


            echo "
                <div class='node-info'>
                    <div class='nf-item'>
                        <div class='label'>
                            Instructor
                        </div>

                        <div class='value'>
                            {$instructor['first_name']} {$instructor['last_name']}    
                        </div>
                    </div>
                </div>
            ";
        ?>
      
        </div>
        </div>
    </div>        
</body>
</html>