

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <?php
    require_once(__DIR__ . '/../templates/head.php');
    ?>
</head>
<body class="page-user">
    <div class="main-wrapper">
        <?php
            require_once(__DIR__ . '/../templates/layout/header.php');
        ?>  
        <div class="">
            <?php
                require_once(__DIR__ . '/../core/objects/user.php');

                


                if (isset($_SESSION['user'])) {
                    $user_email = $_SESSION['user']['email'];
                    $user = new User();
                    $userInfo = $user->getUserInfo($user_email);
                    require_once '../templates/navigation/navigation.php';
                    if(isset($userInfo['email'])) {
                        // echo "
                        // <small>Date joined: {$userInfo['created']}</small>"; 
                        
                        echo " <div class='user-taskbar container'>";

                        require_once '../templates/alerts/alerts.php';

                        echo "<h2>What do you want to do?</h2>
                                
                                <div class='row'>
                                    <div class='task card'>
                                        <a href='../students'>
                                            <h3>Manage Students</h3>
                                            <img src='../assets/images/students.svg'>
                                        </a>
                                    </div>
                                    <div class='task card'>
                                        <a href='../subjects'>
                                            <h3>Manage Subjects</h3>
                                            <img src='../assets/images/subjects.svg'>
                                        </a>
                                    </div>

                                    <div class='task card'>
                                        <a href='../assignments'>
                                            <h3>Manage Assignments</h3>
                                            <img src='../assets/images/assignments.svg'>
                                        </a>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>";
                    }else {
                        // Callback if the user is muanually deleted in the database. 
                        unset($_SESSION['user']); // Clear user session. 
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