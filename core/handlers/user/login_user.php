<?php
session_start(); // Start or resume the session

require_once ($_SERVER['DOCUMENT_ROOT'] . '/core/objects/user.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/core/config/db.php');

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $conn = new Database();
    $user = new User();

    $conn = $conn->getConnection();
    $email = $_POST['p_email'];
    $password = $_POST['password'];

    // Query the database to retrieve the hashed password for a specific user
    $query = "SELECT password FROM users WHERE email = :email";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result !== false) {
        $hashedPassword = $result['password'];
        // Check if the provided password matches the hashed password
        if (password_verify($password, $hashedPassword)) {
            echo "Password matches.";
            // Set a session variable to indicate the user is logged in
            $_SESSION['user_email'] = $email;
            header("Location: /public/users/dashboard.php"); // Replace with the actual dashboard URL
            exit(); // Make sure to exit to prevent further code execution
        } else {
            echo "Password does not match.";
        }
    } else {
        echo 'User not found!';
    }
} else {
    echo "Access denied.";
}
?>