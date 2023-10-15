<?php

    class User {
        public function __construct() {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/config/db.php');
            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/validators/userValidator.php');
            $dbcon = new Database(); 
    
            $this->db = $dbcon->getConnection(); 
    
        } 


        public function createUser($user) {
            $sql = "call sp_insertUser(:first_name, :last_name, :email, :password)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':first_name', $user['first_name']); 
            $stmt->bindParam(':last_name', $user['last_name']); 
            $stmt->bindParam(':email', $user['email']); 
            $stmt->bindParam(':password', $user['password']); 

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
            $sql = "call sp_userLoginPost(:p_email, :p_password)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':p_email', $email); 
            $stmt->bindParam(':p_password', $password); 

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
        
        public function getUserInfo($email) {
            try {
                $stmt = $this->db->prepare("CALL sp_getUserInfo(:email)");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                return $user;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false; // Error 
            } 
        }
    } 
?>