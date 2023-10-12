<?php

    class User {
        public function __construct() {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/config/db.php');
            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/validators/userValidator.php');
            $dbcon = new Database(); 
    
            $this->db = $dbcon->getConnection(); 
    
        } 


        public function createUser($user) {
            $sql = "call sp_insertUser(:email, :password, :role)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $user['email']); 
            $stmt->bindParam(':password', $user['password']); 
            $stmt->bindParam(':role', $user['role']); 
            

            if(userEmailValid($user['email'])) {
                if(userExists($user['email'])) {
                    return -2; 
                } else {
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
    
                    echo "Created user successfully."; 
                }
                $stmt->close();
                $conn->close();
            }else{
                echo 'Please provide a valid email.'; 
            }
        }

        public function userLogin($email, $password) {
            $sql = "call sp_userLoginPost(:email, :password)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email); 
            $stmt->bindParam(':password', $password); 

            try {
                $stmt->execute(); 
                if(isset($stmt)) {
                    return 1; 
                    echo '1'; 
                }else {
                    return 0; 
                    echo '0'; 
                }
            }catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                return -1; 
            } 
        }
    } 
?>