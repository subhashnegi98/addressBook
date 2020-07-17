<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header('Location: ../login.php');
    }
    if($_SESSION['role_name']!='admin'){
        header('Location: ../login.php');
    }
?>