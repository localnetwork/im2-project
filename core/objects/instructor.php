<?php

class Instructor {
    private $instructor_id; 

    public function __construct() {
        // require_once '../config/db.php'; 
        require_once($_SERVER['DOCUMENT_ROOT'] . '/core/config/db.php');
        $dbcon = new Database(); 

        $this->db = $dbcon->getConnection(); 

    }

    // public function createSubject($sub) {
    //     $sql = "call sp_insertSubject(:title, :description, author, instructor)";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->bindParam(':title', $sub['subject_title']); 
    //     $stmt->bindParam(':description', $sub['subject_description']); 
    //     $stmt->bindParam(':author', $sub['subject_author']); 
    //     $stmt->bindParam(':instructor', $sub['subject_instructor']); 
        
    //     try {
    //         $stmt->execute(); 
    //         if(isset($stmt)) {
    //             return 1; 
    //         }else {
    //             return 0; 
    //         }
    //     }catch(PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //         return -1; 
    //     }
    //     echo "New records created successfully";
    //     $stmt->close();
    //     $conn->close();
    // }

    public function getInstructors() {
        $sql = "call sp_getInstructors()";
        $stmt = $this->db->prepare($sql);
    
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return array(); // Return an empty array on error
        } 
    } 

    // public function getInstructor($user_id) {
    //     $sql = "call sp_getInstructors(:id)";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    
    //     try {
    //         $stmt->execute();
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //         return array(); // Return an empty array on error
    //     } 
    // }

    public function getInstructor($user_id) {
        try {
            $sql = "call sp_getInstructor(:id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            $instructor = $stmt->fetch(PDO::FETCH_ASSOC);
            return $instructor;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Error
        } 
    }

    // public function getSubject($subject_id) {
    //     try {
    //         $stmt = $this->db->prepare("CALL sp_getSubject(:sub_id)");
    //         $stmt->bindParam(':sub_id', $subject_id, PDO::PARAM_INT);
    //         $stmt->execute();
    //         $subject = $stmt->fetch(PDO::FETCH_ASSOC);
    //         return $subject;
    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //         return false; // Error
    //     } 
    // } 

    // public function updateSubject($subject_id, $title, $description) {
    //     try {
    //         $stmt = $this->db->prepare("call sp_updateSubject(:sub_id, :title, :description)");
    //         $stmt->bindParam(':sub_id', $subject_id, PDO::PARAM_INT);
    //         $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    //         $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            
    //         if ($stmt->execute()) {
    //             if ($stmt->rowCount() > 0) {
    //                 return true; // Success, at least one row was updated
    //             } else {
    //                 return false; // No rows were updated
    //             }
    //         } else {
    //             return false; // Error during execution
    //         } 
    //     } catch (PDOException $e) { 
    //         echo "Error: " . $e->getMessage();
    //         return false; // Error
    //     }
    // }

    // public function deleteSubject($subject_id) {
    //     try {
    //         $stmt = $this->db->prepare("call sp_deleteSubject(:subject_id)");
    //         $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
            
    //         if ($stmt->execute()) {
    //             if ($stmt->rowCount() > 0) {
    //                 return true; // Success, at least one row was updated
    //             } else {
    //                 return false; // No rows were updated
    //             }
    //         } else {
    //             return false; // Error during execution
    //         } 
    //     } catch (PDOException $e) { 
    //         echo "Error: " . $e->getMessage();
    //         return false; // Error
    //     }
    // } 
}
?>