

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/public/templates/head.php');
    ?>
</head>
<body>
    <div class="main-wrapper">
        <div class="box">
            <?php
            session_start();
            if (isset($_SESSION['user_email'])) {
                echo "<h2>Dashboard</h2>"; 
                $user_email = $_SESSION['user_email'];
                echo $user_email; 
            }else {
                echo('tesstasdasdasd'); 
                http_response_code(403);
            }
            ?>
        </div>
    </div>
</body>
</html>