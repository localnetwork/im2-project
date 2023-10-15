

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/templates/head.php');
    ?>
</head>
<body>
    <div class="main-wrapper">
        <div class="box">
            <?php
                require_once($_SERVER['DOCUMENT_ROOT'] . '/core/objects/user.php');
                session_start();

                require_once '../templates/alerts/alerts.php';

                if (isset($_SESSION['user_email'])) {
                    $user_email = $_SESSION['user_email'];
                    $user = new User();
                    $userInfo = $user->getUserInfo($_SESSION['user_email']);

                    echo "<div>
                            <div class='' style='display: flex; justify-content: space-between;'>
                                <h2>Dashboard</h2>
                                <a href='./logout.php'>Logout</a>
                            </div>
                            <h3>Howdy, {$userInfo['first_name']} </h3>

                            <div class='test'>
                                <h2>What do you want to do?</h2>
                                
                                <a href='../students'>Manage Students</a>
                            </div>
                        </div>";
                }else {
                    // Redirect to login page if not logged in.
                    header("Location: /users/login.php");
                    exit();
                } 
            ?>
        </div>
    </div>
</body>
</html>