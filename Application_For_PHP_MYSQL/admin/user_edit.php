<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<title>User Management</title>
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

@media only screen and (max-width: 500px) {
    .nav {
        flex-direction: column;
    }
}
</style>
<?php
        ob_start();
        session_start();

        if(isset($_SESSION["user"])) {
            if($_SESSION["user"]->role === "ADMIN") {
                if(isset($_GET["id_user"])) {
                    // Yes, You are in a correct place
                } else {
                    header("Location: http://localhost/Application1/admin/index.php", true);
                    die();
                }
            } else {
                header("Location: http://localhost/Application1/login.php", true);
                die();
            }
        } else {
            header("Location: http://localhost/Application1/login.php", true);
            die();
        }
        
    ?>
<div class="container" style="width: 100%; border-bottom: 1px solid orange;padding-bottom: 10px;">
    <ul class="nav nav-pills p-2">
        <div class='d-flex'>
            <a class="nav-link bg-dark active" aria-current="page" href="index.php">Home</a>
            <a class="nav-link text-warning" aria-current="page" href="./create_todolist.php">Create Do Item</a>
            <a class="nav-link text-warning" aria-current="page" href="./profile.php">Profile</a>
        </div>
        <form method="POST" style="margin-bottom: 0 !important;">
            <button class="logout btn btn-outline-danger" type="submit" name="logout">Logout</button>
        </form>
    </ul>
</div>
<div class="container">
    <div class="shadow p-3 mb-2 bg-body-tertiary rounded text-center fw-bold">Welcome ADMIN
        <?php
            echo "<span class='text-success'>".$_SESSION["user"]->username."</span>";
        ?>
    </div>
    <?php
            $username = "root";
            $password = "";
            $db = new PDO("mysql:host=localhost;dbname=app1;charset=utf8;", $username, $password);
            $id_user_ = $_GET["id_user"];
            $sql = $db->prepare("SELECT * FROM `user` WHERE id = :ID");
            $sql->bindParam("ID", $id_user_);
            $sql->execute();
            $sql = $sql->fetch(PDO::FETCH_ASSOC);
            if(isset($_POST["update"])) {
                $username_ = $_POST["username"];
                $password_ = sha1($_POST["newpassword"]);
                $gender_ = $_POST["gender"];
                $activited_ = $_POST["activited"];
                $sql_update = $db->prepare("UPDATE `user` SET username = :Username, password = :Password, gender = :Gender, activited = :Activited WHERE id = :Iduser");
                $sql_update->bindParam("Username", $username_);
                $sql_update->bindParam("Password", $password_);
                $sql_update->bindParam("Gender", $gender_);
                $sql_update->bindParam("Activited", $activited_);
                $sql_update->bindParam("Iduser", $id_user_);
                if($sql_update->execute()) {
                    echo '<div class="alert alert-success">Update Successfuly!</div>';
                    header("refresh: 1");
                } else {
                    echo '<div class="alert alert-danger">Update Failure!</div>';
                }
            }
            echo '
            <form method="POST">
        <label for="email" class="mt-3 mb-2">Email</label>
        <input class="form-control" type="email" name="email" value='.$sql["email"].' id="email" readonly />
        <label for="username" class="mt-3 mb-2">Username</label>
        <input class="form-control" type="text" name="username" value='.$sql["username"].' id="username" />
        <label for="newpassword" class="mt-3 mb-2">New Password</label>
        <input class="form-control" type="text" name="newpassword" required minlength="8" id="newpassword" />
        <label for="gender" class="mt-3 mb-2">Gender</label>';
        if($sql["gender"] == "1") {
            echo '<select name="gender" id="gender" class="form-control">
            <option value="0">Female</option>
            <option selected value="1">Male</option>
        </select>';
        } else {
            echo '<select name="gender" id="gender" class="form-control">
            <option selected value="0">Female</option>
            <option value="1">Male</option>
        </select>';
        }
        echo '<label for="active" class="mt-3 mb-2">Activiation</label>';
        if($sql["activited"] == "1") {
            echo '        <select name="activited" id="active" class="form-control">
            <option value="0">Not Activited</option>
            <option selected value="1">Activited</option>
        </select>';
        } else {
            echo '        <select name="activited" id="active" class="form-control">
            <option selected value="0">Not Activited</option>
            <option value="1">Activited</option>
        </select>';
        }
        echo '
        <button class="btn btn-dark mt-3" type="submit" name="update">Update</button>
    </form>
            ';
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