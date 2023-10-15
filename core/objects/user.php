<?php

    class User {
        public function __construct() {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/config/db.php');
            require_once($_SERVER['DOCUMENT_ROOT'] . '/core/validators/userValidator.php');
            $dbcon = new Database(); 
    
            $this->db = $dbcon->getConnection(); 
    
        } 


        public function createUser($user) {

            $getLastMedia = "call sp_getLastMedia()";
            $getLastMedia = $this->db->prepare($getLastMedia); 
            $getLastMedia->execute(); 
            
            $getLastMedia = $getLastMedia->fetchAll(PDO::FETCH_ASSOC);


            $formatted_now = str_replace(' ', '#', strtolower(date('Y-m-d H:i:s')));
            $sql = "call sp_insertUser(:first_name, :last_name, :email, :password, :profile_picture)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':first_name', $user['first_name']); 
            $stmt->bindParam(':last_name', $user['last_name']); 
            $stmt->bindParam(':email', $user['email']); 
            $stmt->bindParam(':password', $user['password']); 
            $media_id = $getLastMedia[0]['mid'];
            
            $stmt->bindValue(':profile_picture', $media_id); 

            if(userEmailValid($user['email'])) {
                if(userExists($user['email'])) {
                    return -2; 
                } else {
                    try {
                        $stmt->execute();
                        if(isset($stmt)) {
                            $sql = "call sp_insertMedia(:filename, :uri,:filemime)";
                            $stmt = $this->db->prepare($sql);
                            $filename = $_SERVER['REQUEST_TIME'] . '-' . $_FILES['profile_picture']['name']; 
                            $fileFormat = pathinfo($filename, PATHINFO_EXTENSION);
                            $path = "/storage/images/{$filename}";
                            $stmt->bindParam(':filename', $filename);
                            $stmt->bindParam(':filemime', $fileFormat);
                            $stmt->bindParam(':uri', $path); 

                            $uri = $_SERVER['DOCUMENT_ROOT'] . "/storage/images/{$filename}";

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
            $stmt->execute();

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
        
    } 
?>