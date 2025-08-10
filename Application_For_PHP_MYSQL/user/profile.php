<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<title>Edit Profile</title>
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
<div class="container" style="width: 100%; border-bottom: 1px solid orange;padding-bottom: 10px;">
    <ul class="nav nav-pills p-2">
        <div class='d-flex'>
            <a class="nav-link text-warning" aria-current="page" href="index.php">Home</a>
            <a class="nav-link text-warning" aria-current="page" href="./create_todolist.php">Create Do Item</a>
            <a class="nav-link bg-dark active" aria-current="page" href="./profile.php">Profile</a>
        </div>
        <form method="POST" style="margin-bottom: 0 !important;">
            <button class="logout btn btn-outline-danger" type="submit" name="logout">Logout</button>
        </form>
    </ul>
</div>
<div class="container">
    <div class="container">
        <div class="shadow p-3 mb-2 bg-body-tertiary rounded text-center fw-bold">Welcome USER
            <?php
            echo "<span class='text-success'>".$_SESSION["user"]->username."</span>";
        ?>
        </div>
    </div>
    <?php
        echo "<form method='POST'>";
        echo "<div>";
        echo    "<label class='form-label' for='username'>Username :</label>";
        echo    "<input class='form-control' type='text' value=".$_SESSION["user"]->username." name='username' id='username' />";
        echo "</div>";
        echo "<div>";
        echo    "<label class='form-label' for='email'>Email :</label>";
        echo    "<input class='form-control' type='email' value=".$_SESSION["user"]->email." readonly name='email' id='email' />";
        echo "</div>";
        echo "<div>";
        echo    "<label class='form-label' for='password1'>Password :</label>";
        echo    "<input class='form-control' type='password' placeholder='New Password' minlength='8' maxlength='25' name='password1' id='password1' />";
        echo "</div>";
        echo "<div>";
        echo    "<label class='form-label' for='gender'>Gender :</label>";
        echo "<select name='gender' class='w-100 p-2 rounded' id='gender'>";
        if($_SESSION["user"]->gender == "1") {
            echo "<option selected value='1'>Male</option>";
            echo "<option value='0'>Female</option>";
        } else {
            echo "<option value='1'>Male</option>";
        echo "<option selected value='0'>Female</option>";
        }
        echo "</select>";
        echo "</div>";
        echo "<div>";
        echo "<button class='mt-2 btn btn-outline-warning submit w-100 p-2' type='submit' name='update_profile'>Update Data Profile</button>";
        echo "</form>";
    ?>
</div>
<?php
        if (isset($_POST["logout"])) {
            session_unset();
            session_destroy();
            header("Location: http://localhost/Application1/login.php", true);
        }
        if(isset($_POST["update_profile"])) {
            $username = "root";
            $password = "";
            $db = new PDO("mysql:host=localhost;dbname=app1;charset=utf8", $username, $password);
            $username_ = $_POST["username"];
            $password_ = sha1($_POST["password1"]);
            $gender_ = $_POST["gender"];
            $email_ = $_SESSION["user"]->email;
            $sql = $db->prepare("UPDATE `user` SET username = :Username, password = :Password, gender = :Gender WHERE email = :Email");
            $sql->bindParam("Username", $username_);
            $sql->bindParam("Password", $password_);
            $sql->bindParam("Gender", $gender_);
            $sql->bindParam("Email", $email_);
            if($sql->execute()) {
                echo "<div class='alert alert-success'>Updated Data Has Been Successfuly</div>";
                $sql = $db->prepare("SELECT * FROM `user` WHERE email = :Email");
                $sql->bindParam("Email", $email_);
                $sql->execute();
                $_SESSION["user"] = $sql->fetchObject();
                header("refresh: 2; url=profile.php", true);
            } else {
                echo "<div class='alert alert-danger'>Some Error Has Been Happened, Try Again</div>";
            }
        }
    ob_end_flush();
?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
</script>