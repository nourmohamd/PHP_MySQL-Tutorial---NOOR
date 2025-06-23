<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<title>Main User</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<style>
.container {
    max-width: 100%;
    width: 1000px;
    margin: 20px auto;
}

.nav {
    align-items: center !important;
    justify-content: space-between;
}

.nav p {
    margin-left: 20px;
    font-weight: 500;
    font-size: 20px;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
}

@media only screen and (max-width: 767px) {
    .nav {
        flex-direction: column;
        gap: 25px;
    }
}
</style>
<?php
        ob_start();
        session_start();

        if(isset($_SESSION["user"])) {
            if($_SESSION["user"]->role === "USER") {
            } else {
                header("Location: http://localhost/Application1/login.php", true);
                die();
            }
        } else {
            header("Location: http://localhost/Application1/login.php", true);
            die();
        }
        
    ?>
<div class="container" style="border-bottom: 1px solid blue;padding-bottom: 10px;">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <p>Welcome in Our Website</p>
        <form method="POST" style="margin-bottom: 0 !important;">
            <button class="logout btn btn-outline-danger" type="submit" name="logout">Logout</button>
        </form>
    </ul>
</div>
<div class="container">
    <div class="shadow p-3 mb-5 bg-body-tertiary rounded text-center">Welcome
        <?php
            echo $_SESSION["user"]->username;
        ?>
    </div>
</div>
<?php
        if (isset($_POST["logout"])) {
            session_unset();
            session_destroy();
            header("Location: http://localhost/Application1/login.php", true);
        }
    ob_end_flush();
?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
</script>