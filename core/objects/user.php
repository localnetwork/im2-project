<?php
    class User {
        public function __construct() {
            require_once(__DIR__ . '/../config/db.php');
            require_once(__DIR__ . '/../validators/userValidator.php');
            require_once(__DIR__ . '/../service/media.php');
            $dbcon = new Database(); 
    
            $this->db = $dbcon->getConnection(); 
    
        } 

        

        public function createUser($user) {

            $sql = "call sp_insertMedia(:filename, :uri,:filemime)";
            $stmt = $this->db->prepare($sql);
            $filename = $_SERVER['REQUEST_TIME'] . '-' . $_FILES['profile_picture']['name']; 
            $fileFormat = pathinfo($filename, PATHINFO_EXTENSION);
            $path = "/storage/images/{$filename}";
            $stmt->bindParam(':filename', $filename);
            $stmt->bindParam(':filemime', $fileFormat);
            $stmt->bindParam(':uri', $path); 

            $uri = __DIR__ . "/../../storage/images/{$filename}";

            $uploadOk = 1; 

            if(isset($_POST)) {
                $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
                if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
                } else {
                echo "File is not an image.";
                $uploadOk = 0;
                }
            }
            
            // Check if file already exists
            if (file_exists($uri)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            // if ($_FILES["profile_picture"]["size"] > 500000) {
            //     echo "Sorry, your file is too large.";
            //     $uploadOk = 0;
            // }
            // Allow certain file formats
            if($fileFormat != "jpg" && $fileFormat != "png" && $fileFormat != "jpeg" && $fileFormat != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $uri)) {
                echo "The file ". htmlspecialchars( basename($_FILES["profile_picture"]["name"])). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }

            $stmt->execute(); 
            

            $getLastMedia = "call sp_getLastMedia()";
            $getLastMedia = $this->db->prepare($getLastMedia); 
            $getLastMedia->execute(); 
            
            $getLastMedia = $getLastMedia->fetchAll(PDO::FETCH_ASSOC);

            $formatted_now = str_replace(' ', '#', strtolower(date('Y-m-d H:i:s')));
            $sql = "call sp_insertUser(:user_role_id, :first_name, :last_name, :email, :password, :profile_picture)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_role_id', $user['user_role_id']); 
            $stmt->bindParam(':first_name', $user['first_name']); 
            $stmt->bindParam(':last_name', $user['last_name']); 
            $stmt->bindParam(':email', $user['email']); 
            $stmt->bindParam(':password', $user['password']); 
            $media_id = $getLastMedia[0]['mid'];
            
            $stmt->bindValue(':profile_picture', $media_id); 

            try {
                if(userEmailValid($user['email'])) {
                    if(userExists($user['email'])) {
                        throw new Exception(-2);
                    } else {
                        try {
                            $stmt->execute();
                            if(isset($stmt)) {  
                                return 1; 
                            }else {
                                throw new Exception(0);
                            }
                        }catch(Exception $e) {
                            echo "Error: " . $e->getMessage();
                            throw new Exception(-1);
                        }
                    }
                    $stmt->close();
                    $conn->close();
                }else{
                    throw new Exception(-3);
                }
            }catch(Exception $e) {
                $stmt = $this->db->prepare("call sp_deleteMediaById(:mid)");
                $stmt->bindParam(':mid', $media_id, PDO::PARAM_INT);
                $stmt->execute();  

                return intval($e->getMessage()); 
            }

            
        }

        public function userLogin($email, $password) {
            $sql = "call sp_userLoginPost(:p_email, :p_password)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':p_email', $email); 
            $stmt->bindParam(':p_password', $password); 
            $stmt->execute();

            try {
                $stmt->execute(); 
                if(isset($stmt)) {
                    return 1; 
                }else {
                    return 0; 
                }
            }catch(PDOException $e) {
                $this->db->rollback();
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

        public function getMediaInfo($media_id) {
            try {
                $stmt = $this->db->prepare("call sp_getMediaById(:mid)");
                $stmt->bindParam(':mid', $media_id, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                return $user;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false; // Error 
            } 
        }

        public function getRole($user_role_id) {
            try {
                $stmt = $this->db->prepare("call sp_getRole(:role_id)");
                $stmt->bindParam(':role_id', $user_role_id, PDO::PARAM_STR);
                $stmt->execute();
                $role = $stmt->fetch(PDO::FETCH_ASSOC);
                return $role;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                return false; // Error 
            } 
        }


        public function updateUser($email, $first_name, $last_name, $profile_picture) {
            try {              
                $stmt = $this->db->prepare("call sp_userUpdate(:email, :first_name, :last_name, :profile_picture)");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
                $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);

                if(isset($profile_picture['name']) && strlen($profile_picture['name']) > 0) {

                    

                    $media_id = insertMedia($profile_picture, $this->db); 
 
                    $stmt->bindParam(':profile_picture', $media_id, PDO::PARAM_STR); 
                    unset($_SESSION['user']['profile_picture']);  
                    $_SESSION['user']['profile_picture'] = $media_id; 
                    $stmt->execute(); 

                    // if($_SESSION['user']['profile_picture']) {
                    //     deleteMedia($_SESSION['user']['profile_picture'], $this->db);
                    // } 
                    
                }else {
                    $stmt->bindParam(':profile_picture', $_SESSION['user']['profile_picture'], PDO::PARAM_STR);
                    $stmt->execute(); 
                } 
                $user = $stmt->fetch(PDO::FETCH_ASSOC); 

                var_dump($_SESSION['user']['profile_picture']); 
                return 1; 
                
            } catch (PDOException $e) { 
                echo "Error: " . $e->getMessage();
                return false; // Error
            }

            // $stmt->close();
            // $conn->close();
        }
        
    } 
?>