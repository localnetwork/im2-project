<?php

require_once '../config/db.php'; 

function studentExists($firstName, $lastName) {
    $dbcon = new Database(); 

    $db = $dbcon->getConnection();  

    $sql = "SELECT COUNT(*) FROM students WHERE first_name = :fname AND last_name = :lname";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':fname', $firstName);
    $stmt->bindParam(':lname', $lastName);

    try {
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        echo 'Student already exists!'; 
        return true; // Assume an error occurred
    }
} 
?>