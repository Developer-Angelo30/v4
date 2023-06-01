<?php
    include_once("../include/session/loggedSession.php");
    $session = new mySession($_SESSION['email'], $_SESSION['password'], $_SESSION['role'], $_SESSION['department']);
    $session->loggedSessionSuperAdmin();

?>