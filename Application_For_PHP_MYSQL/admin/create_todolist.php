<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<title>Create To Do List</title>
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
            if($_SESSION["user"]->role === "ADMIN") {
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
            <a class="nav-link active" aria-current="page" href="./create_todolist.php">Do List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php">Home</a>
        </li>

        <form method="POST" style="margin-bottom: 0 !important;">
            <button class="logout btn btn-outline-danger" type="submit" name="logout">Logout</button>
        </form>
    </ul>
</div>
<div class="container">
    <div class="shadow p-3 mb-2 bg-body-tertiary rounded text-center">Welcome
        <?php
            echo $_SESSION["user"]->username;
        ?>
    </div>
    <a class="btn btn-primary w-100" href="./profile.php">Edit profile</a>
    <div class="todolist">
        <form method="GET">
            <div class="mb-3 mt-3">
                <label for="exampleFormControlInput1" class="form-label">New Box :</label>
                <input type="text" class="form-control" name="text_list" id="exampleFormControlInput1"
                    placeholder="name@example.com">
            </div>
            <button class="btn btn-success" type="submit" name="add_new_box_in_list">Add</button>
        </form>
    </div>
    <?php
        if (isset($_POST["logout"])) {
            session_unset();
            session_destroy();
            header("Location: http://localhost/Application1/login.php", true);
        }
        if (isset($_GET["add_new_box_in_list"])) {
            $username = "root";
            $password = "";
            $db = new PDO("mysql:host=localhost;dbname=app1;charset=utf8;", $username, $password);
            $text_ = $_GET["text_list"];
            $email_ = $_SESSION["user"]->email;
            $sql2 = $db->prepare("SELECT * FROM `user` WHERE email = :Email");
            $sql2->bindParam("Email", $email_);
            $sql2->execute();
            $sql2 = $sql2->fetch(PDO::FETCH_ASSOC);
            $id_ = $sql2["id"];
            $sql = $db->prepare("INSERT INTO `todolist` (text, id_user) VALUES ('$text_', '$id_')");
            if ($sql->execute()) {
                echo "<div class='alert alert-success' role='alert'>Successfuly Add New Box ToDoList</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Doesn't Add New Box ToDoList</div>";
            }
            header("Location: http://localhost/Application1/user/create_todolist.php");
        }
        $username = "root";
        $password = "";
        $db = new PDO("mysql:host=localhost;dbname=app1;charset=utf8;", $username, $password);
        $email_ = $_SESSION["user"]->email;
        $sql2 = $db->prepare("SELECT * FROM `user` WHERE email = :Email");
        $sql2->bindParam("Email", $email_);
        $sql2->execute();
        $sql2 = $sql2->fetch(PDO::FETCH_ASSOC);
        $id_ = $sql2["id"];
        $sql3 = $db->prepare("SELECT * FROM `todolist` WHERE id_user = '$id_' ORDER BY `id` DESC");
        $sql3->execute();
        $sql3 = $sql3->fetchAll(PDO::FETCH_ASSOC);
        foreach($sql3 as $s) {
            echo "<div class='alert alert-warning' role='alert'>".$s["text"]."</div>";
        }
    ob_end_flush();
?>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
</script>