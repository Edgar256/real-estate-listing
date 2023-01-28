<?php 
if(session_status() == PHP_SESSION_ACTIVE) {
    // session is active
    echo "Session is active";
} else {
    // session_start();
    // echo "Session is not active";
}

// require_once('./utils/start_session.php');
// echo  $_SESSION['email'];
// session_unset(); // unset $_SESSION variable for this page 
?>