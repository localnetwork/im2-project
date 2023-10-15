

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
                    
                    if(isset($userInfo['profile_picture'])) {
                        $media_id = $userInfo['profile_picture']; 
                        $media = $user->getMediaInfo($media_id); 
                        $media_image = $media['uri']; 
                    }else {
                        $media_image = ''; 
                    }

                 
                    
                    if(isset($userInfo['email'])) {
                        echo "<div>
                            <div class='' style='display: flex; justify-content: space-between;'>
                                <h2>Dashboard</h2>
                                <a href='./logout.php'>Logout</a>
                            </div>
                            
                        ";

                        if($media_image) {
                            echo "
                                <div class='user-data'>
                                    <div>
                                    <h3 style='margin-bottom: 5px;'>Howdy, {$userInfo['first_name']} </h3>
                                    <small>Date joined: {$userInfo['created']}</small>
                                    </div>
                                    <img class='user-img' width='100' height='100' src='{$media_image}' />
                                </div>
                            ";
                        }
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