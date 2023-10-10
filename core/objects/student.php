<?php

class Student {
    private $first_name; 
    private $last_name;

    public function __construct() {
        // require_once '../config/db.php'; 
        require_once($_SERVER['DOCUMENT_ROOT'] . '/core/config/db.php');
        $dbcon = new Database(); 

        $this->db = $dbcon->getConnection(); 

    }

    public function createStudent($stud) {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/core/validators/studentValidator.php');
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

    public function editStudent($id, $first_name, $last_name) {
        try {
            $stmt = $this->db->prepare("call sp_editStudent(:id, :first_name, :last_name)");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_VARCHAR);
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_VARCHAR);
            
            if ($stmt->execute()) {
                return true; // Success
            } else {
                return false; // Error
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Error
        }
    }
}
?>