<?php
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
        echo '</div>'; 
        // Clear the error messages from the session
        $_SESSION['messages'][$alert_type] = array();
        unset($_SESSION['messages']);
    }
?>