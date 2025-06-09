<?php
    ob_start();
    session_start();
    if(isset($_SESSION["email"]) && isset($_SESSION["password"])) {
        echo $_SESSION["email"];
    }
?>