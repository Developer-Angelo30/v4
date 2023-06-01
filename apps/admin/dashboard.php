<?php
    session_start();
    require_once("../include/session/loggedSession.php");
    if(isset($_SESSION['email']) && isset($_SESSION['password']) && isset($_SESSION['role']) && isset($_SESSION['department'])){
        $session = new mySession($_SESSION['email'], $_SESSION['password'], $_SESSION['role'], $_SESSION['department']);
        $session->loggedSessionAdmin();
    }
    else{
        header("location: ../logout.php");
    }
    
?>