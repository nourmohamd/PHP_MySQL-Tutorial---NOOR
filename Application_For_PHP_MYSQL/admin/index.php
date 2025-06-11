<?php
    ob_start();
    session_start();

    if(isset($_SESSION["user"])) {
        if($_SESSION["user"]->role === "ADMIN") {
            echo "Welcome Admin ".$_SESSION["user"]->username;
        } else {
            header("Location: http://localhost/Application_for_php_mysql/login.php", true);
            die();
        }
    } else {
        header("Location: http://localhost/Application_for_php_mysql/login.php", true);
        die();
    }
?>
<?php
    ob_end_flush();
?>