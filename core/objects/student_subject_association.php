<?php

    class studentSubjectAssociation {

        public function __construct() {
            // require_once '../config/db.php'; 
            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/config/db.php');
            $dbcon = new Database(); 
    
            $this->db = $dbcon->getConnection(); 
    
        }


        public function insertStudentsToSub($subject_id, $student_ids) {
            try {
                var_dump($subject_id); 
                $stmt = $this->db->prepare("CALL sp_deleteStudentsToSubject(:sub_id)");
                $stmt->bindParam(':sub_id', $subject_id, PDO::PARAM_INT);
                $stmt->execute(); 

                $stmt = $this->db->prepare("call sp_insertStudentsToSubject(:sub_id, :student_ids)");
                $stmt->bindParam(':sub_id', $subject_id, PDO::PARAM_INT);
                $stmt->bindParam(':student_ids', $student_ids, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->errorCode() == 0) {
                    return 1; // Success
                    echo '1'; 
                } else { 
                    $errorInfo = $stmt->errorInfo();
                    return $errorInfo; // Return error information
                }
            } catch (PDOException $e) {
                echo "Error calling stored procedure: " . $e->getMessage();
                return $e; 
            } 
        }

        public function getStudentsInSubject($subject_id) {
            try {
                $stmt = $this->db->prepare("CALL sp_getStudentsInSubject(:sub_id)");
                $stmt->bindParam(':sub_id', $subject_id, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->errorCode() == 0) {
                    $students = $stmt->fetch(PDO::FETCH_ASSOC);
                    return $students;
                } else { 
                    return 0; 
                } 
                
            } catch (PDOException $e) {
                echo "Error calling stored procedure: " . $e->getMessage();
                return $e; 
            } 
        }


    }
?>