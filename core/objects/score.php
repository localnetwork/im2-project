<?php


class Score {
    private $assignment_title; 
    private $assignment_description;

    public function __construct() {
        // require_once '../config/db.php'; 
        require_once(__DIR__ . '/../config/db.php');
        $dbcon = new Database(); 

        $this->db = $dbcon->getConnection(); 

    }

    public function createScore($score, $student_id, $assignment_id) {
        $sql = "call sp_insertScore(:score_value, :stud_id, :ass_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':score_value', $score, PDO::PARAM_INT);
        $stmt->bindParam(':stud_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':ass_id', $assignment_id, PDO::PARAM_INT);

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

    public function getScore($assignment_id, $student_id) {
        
        try {
            $sql = "call sp_getScore(:ass_id, :stud_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':ass_id', $assignment_id, PDO::PARAM_INT);
            $stmt->bindParam(':stud_id', $student_id, PDO::PARAM_INT);
            $stmt->execute(); 
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                return 1; // Return the assignment_score record details
            } else {
                return null; // No records found
            } 
        }catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return -1; 
        }
        echo "New records created successfully";
        $stmt->close();
        $conn->close();
    } 
    
    public function getScoreById($score_id) {
        
        try {
            $sql = "call sp_getScoreById(:score_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':score_id', $score_id, PDO::PARAM_INT);
            $stmt->execute(); 
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                return $result; 
                // return 1; // Return the assignment_score record details
            } else {
                return null; // No records found
            } 
        }catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return -1; 
        }
        $stmt->close(); 
        $conn->close();
    }    


    public function updateScore($score_id, $score_value) {
        try {
            $stmt = $this->db->prepare("call sp_updateScore(:score_id, :score_value)");
            $stmt->bindParam(':score_id', $score_id, PDO::PARAM_INT);
            $stmt->bindParam(':score_value', $score_value, PDO::PARAM_INT);
            
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

    public function deleteScore($score_id) {
        try {
            $stmt = $this->db->prepare("call sp_deleteScore(:score_id)");
            $stmt->bindParam(':score_id', $score_id, PDO::PARAM_INT);
            
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