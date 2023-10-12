<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/core/config/db.php');

    function userExists($email) {
        $dbcon = new Database(); 

        $db = $dbcon->getConnection();  

        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email);

        try {
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {
            return true;
        }
    } 

    function userEmailValid($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true; 
        } else {
            return false; 
        }
    }

?>