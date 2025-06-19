<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<title>Main Super-Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<style>
body {
    background-color: #efdbdb;
}

.container {
    max-width: 100%;
    width: 1000px;
    margin: 20px auto;
}

.container form {
    margin: 0;
}
</style>
<div class="container">
    <?php
    ob_start();
    session_start();

    if(isset($_SESSION["user"])) {
        if($_SESSION["user"]->role === "SUPER-ADMIN") {
            echo "<nav class='navbar'>".
                    "<div class='container-fluid'>".
                        "<a class='navbar-brand'>Welcome ".$_SESSION["user"]->username."</a>".
                        "<form method='GET' class='d-flex'>".
                            "<button class='btn btn-outline-danger' type='submit' name='logout'>Logout</button>".
                        "</form>".
                    "</div>".
                "</nav>";
        } else {
            header("Location: http://localhost/Application1/user/index.php", true);
            die();
        }
    } else {
        header("Location: http://localhost/Application1/user/index.php", true);
        die();
    }
    if (isset($_GET["logout"])) {
        session_unset();
        session_destroy();
        header("Location: http://localhost/Application1/login.php", true);
    }
?>
    <?php
    ob_end_flush();
?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
</script>