<?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/user.php');  
    require_once($_SERVER['DOCUMENT_ROOT'] . '/core/config/db.php');
    if($_SERVER["REQUEST_METHOD"] === 'POST') {
        $conn = new Database(); 
        $user = new User(); 

    
        $conn = $conn->getConnection(); 

        $email = $_POST['email'];
        $password = $_POST['password']; 
        // var_dump($password); 
        // $user = $user->userLogin($email, $password); 

        // Query the database to retrieve the hashed password for a specific user
        $email = 'diome.halcyonwebdesign@gmail.com'; // Replace with the user's email
        $query = "SELECT password FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(":email", $email);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        $stmt->fetch(); 


        // if (password_verify($password, $pwd_hashed)) {
        //     echo "Password matches.";
        // } 


        // if($studentExist !== false) {
        //     $result = $student->updateStudent($studentId, $first_name, $last_name);
        //     if ($result === true) {
        //         echo 'Student updated successfully';
        //     }else {
        //         echo "Can't update student with the same value."; 
        //     }
        // }else {
        //     echo 'Student not found!'; 
        // }
    }else {
        echo "Access denied."; 
    }

?>