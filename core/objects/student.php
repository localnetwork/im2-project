<?php

class Student {
    private $first_name; 
    private $last_name;

    public function __construct() {
        require_once(__DIR__ . '/../config/db.php');
        $dbcon = new Database(); 

        $this->db = $dbcon->getConnection(); 

    }

    public function createStudent($stud) {
        require_once(__DIR__ . '/../validators/studentValidator.php');
        $sql = "call sp_insertStudent(:first_name, :last_name)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':first_name', $stud['fname']); 
        $stmt->bindParam(':last_name', $stud['lname']); 

        if(studentExists($stud['fname'], $stud['lname'])) {
            return -2; 
        }
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

    public function getStudents() {
        $sql = "call sp_getStudents()";
        $stmt = $this->db->prepare($sql);
    
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return array(); // Return an empty array on error
        }
    } 

    public function getStudent($studentId) {
        try {
            $stmt = $this->db->prepare("CALL sp_getStudent(:studentId)");
            $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
            $stmt->execute();
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            return $student;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Error
        } 
    }

    public function updateStudent($studentId, $first_name, $last_name) {
        try {
            $stmt = $this->db->prepare("call sp_updateStudent(:studentId, :first_name, :last_name)");
            $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            
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

    public function deleteStudent($studentId) {
        try {
            $stmt = $this->db->prepare("call sp_deleteStudent(:studentId)");
            $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
            
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

    public function getStudentGradeBySubject($subject_id, $student_id) {
        try {
            $stmt = $this->db->prepare("call sp_getStudentGradeBySubject(:sub_id, :stud_id)");
            $stmt->bindParam(':sub_id', $subject_id, PDO::PARAM_INT);
            $stmt->bindParam(':stud_id', $student_id, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch the first row of the result set
            $grade = $stmt->fetch(PDO::FETCH_ASSOC);

            return $grade; 

            var_dump($grade); 
    
            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Error
        } 
    } 
}
?>