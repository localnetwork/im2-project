<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/core/config/db.php');

    require_once ($_SERVER['DOCUMENT_ROOT'] . '/objects/student.php'); 


    $dbcon = new Database();
    $db = $dbcon->getConnection();

    
?>