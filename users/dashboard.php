

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
                    
                    require_once '../templates/navigation/navigation.php';
                    if(isset($userInfo['email'])) {

                        echo "<a href='./logout.php'>Logout</a>"; 
                        echo "
                        <small>Date joined: {$userInfo['created']}</small>"; 
                        
                        echo " <div class='test'>
                                <h2>What do you want to do?</h2>
                                
                                <a href='../students'>Manage Students</a>
                            </div>
                        </div>";
                    }else {
                        // Callback if the user is muanually deleted in the database. 
                        unset($_SESSION['user_email']); // Clear user session. 
                    } 
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