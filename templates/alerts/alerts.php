<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); 
    }
    require_once($_SERVER['DOCUMENT_ROOT'] . '/core/cache/disable-cache.php');
    $alert_type = ''; 

    if (isset($_SESSION['messages']['errors']) && is_array($_SESSION['messages']['errors'])) {
        $alert_type = 'errors'; 
    }else if(isset($_SESSION['messages']['success']) && is_array($_SESSION['messages']['success'])) {
        $alert_type = 'success'; 
    }else if(isset($_SESSION['messages']['warning']) && is_array($_SESSION['messages']['warning'])) {
        $alert_type = 'warning'; 
    }

    if(isset($_SESSION['messages'][$alert_type])) {
        echo "<div class='alert alert-{$alert_type}'>";
            foreach ($_SESSION['messages'][$alert_type] as $message) {
                echo '<div class="alert-item">' . $message . '</div>';
            }
        echo '<span class="close" onclick="closeAlert()"></span> </div>'; 
        // Clear the error messages from the session
        $_SESSION['messages'][$alert_type] = array();
        unset($_SESSION['messages']);
    }
?>


<script type="text/javascript">
    var element = document.querySelector('.alert');
    console.log(element); 
    function closeAlert() {
        console.log(element);
        if(element) {
            element.remove(); 
        }
    }
    
    function removeAlert() { 
        closeAlert(); 
    }

    setTimeout(removeAlert, 10000);
</script>