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
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['messages']['success'][] = "You've successfully logged-in.";
            $_SESSION['user_email'] = $email;
            header("Location: /users/dashboard.php");
            exit();
        } else {
            $_SESSION['messages']['errors'][] = 'Unrecognized email or password. Please try again';
            header("Location: /users/login.php");
        }
    } else {
        $_SESSION['messages']['errors'][] = 'Unrecognized email or password. Please try again.';
        header("Location: /users/login.php");
    }
} else {
    $_SESSION['messages']['errors'][] = 'You are not allowed to access.';
    header("Location: /users/login.php");
}
?>