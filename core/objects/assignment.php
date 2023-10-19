<?php

class Assignment {
    private $assignment_title; 
    private $assignment_description;

    public function __construct() {
        // require_once '../config/db.php'; 
        require_once($_SERVER['DOCUMENT_ROOT'] . '/core/config/db.php');
        $dbcon = new Database(); 

        $this->db = $dbcon->getConnection(); 

    }

    public function createAssignment($assignment) {
        $sql = "call sp_insertAssignment(:author_id, :subject_id, :assignment_title, :ass_description, :score)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':author_id', $assignment['author_id']); 
        $stmt->bindParam(':subject_id', $assignment['subject_id']); 
        $stmt->bindParam(':assignment_title', $assignment['assignment_title']); 
        $stmt->bindParam(':ass_description', $assignment['ass_description']); 
        $stmt->bindParam(':score', $assignment['total_score']); 
        
        try {
            $stmt->execute(); 
            if(isset($stmt)) {
                return 1; 
            }else {
                return 0; 
            }
        }catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return -1; 
        }
        echo "New records created successfully";
        $stmt->close();
        $conn->close();
    }

    public function getAssignments() {
        $sql = "call sp_getAssignments()";
        $stmt = $this->db->prepare($sql);
    
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return array(); // Return an empty array on error
        } 
    } 

    public function getAssignment($assignment_id) {
        try {
            $stmt = $this->db->prepare("CALL sp_getAssignment(:ass_id)");
            $stmt->bindParam(':ass_id', $assignment_id, PDO::PARAM_INT);
            $stmt->execute();
            $subject = $stmt->fetch(PDO::FETCH_ASSOC);
            return $subject;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Error
        } 
    } 

    public function updateAssignment($subject_id, $assignment_id, $title, $description, $score) {
        try {
            $stmt = $this->db->prepare("call sp_updateAssignment(:subject_id, :ass_id, :assignment_title, :ass_description, :score)");
            $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
            $stmt->bindParam(':ass_id', $assignment_id, PDO::PARAM_INT);
            $stmt->bindParam(':assignment_title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':ass_description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':score', $score, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    return true; // Success, at least one row was updated
                } else {
                    return false; // No rows were updated
                }
            } else {
                return false; // Error during execution
            } 
        } catch (PDOException $e) { 
            echo "Error: " . $e->getMessage();
            return false; // Error
        }
    }

    public function deleteSubject($subject_id) {
        try {
            $stmt = $this->db->prepare("call sp_deleteSubject(:subject_id)");
            $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    return true; // Success, at least one row was updated
                } else {
                    return false; // No rows were updated
                }
            } else {
                return false; // Error during execution
            } 
        } catch (PDOException $e) { 
            echo "Error: " . $e->getMessage();
            return false; // Error
        }
    } 
}
?>