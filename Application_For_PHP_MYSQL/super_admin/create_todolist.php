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
            if($_SESSION["user"]->role === "SUPER-ADMIN") {
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
            <a class="nav-link bg-dark active" aria-current="page" href="./create_todolist.php">Create Do Item</a>
            <a class="nav-link text-warning" aria-current="page" href="./profile.php">Profile</a>
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
    <div class="todolist">
        <form method="GET">
            <div class="mb-3 mt-3">
                <label for="exampleFormControlInput1" class="form-label">New Box :</label>
                <input type="text" class="form-control" name="text_list" id="exampleFormControlInput1"
                    placeholder="name@example.com">
            </div>
            <button class="btn btn-danger" type="submit" name="add_new_box_in_list">Add</button>
        </form>
    </div>
    <?php
        if (isset($_POST["logout"])) {
            session_unset();
            session_destroy();
            header("Location: http://localhost/Application1/login.php", true);
        }
        if (isset($_GET["add_new_box_in_list"])) {
            require "./../connect_to_database.php";
            $text_ = $_GET["text_list"];
            $email_ = $_SESSION["user"]->email;
            $sql2 = $db->prepare("SELECT * FROM `user` WHERE email = :Email");
            $sql2->bindParam("Email", $email_);
            $sql2->execute();
            $sql2 = $sql2->fetch(PDO::FETCH_ASSOC);
            $id_ = $sql2["id"];
            $sql = $db->prepare("INSERT INTO `todolist` (text, id_user, status) VALUES ('$text_', '$id_', 'no_execute')");
            if ($sql->execute()) {
                echo "<div class='alert alert-success' role='alert'>Successfuly Add New Box ToDoList</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Doesn't Add New Box ToDoList</div>";
            }
            header("Location: http://localhost/Application1/super_admin/create_todolist.php");
        }
        if(isset($_GET["remove_do_item"])) {
            $id_do_ = $_GET["remove_do_item"];
            $id_user_ = $_SESSION["user"]->id;
            require "./../connect_to_database.php";
            $sql = $db->prepare("DELETE FROM `todolist` WHERE id = :ID AND id_user = :IU");
            $sql->bindParam("ID", $id_do_);
            $sql->bindParam("IU", $id_user_);
            if($sql->execute()) {
                echo "<div class='alert alert-success' role='alert'>Successfuly Remove Box ToDoList</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Doesn't Remove Box ToDoLis</div>";
            }
            header("refresh:2;url=http://localhost/Application1/super_admin/create_todolist.php");
        }
        if(isset($_GET["process_do_item_to_true"])) {
            $id_do_ = $_GET["process_do_item_to_true"];
            $id_user_ = $_SESSION["user"]->id;
            require "./../connect_to_database.php";
            $sql = $db->prepare("UPDATE `todolist` SET status = 'execute' WHERE id = :ID AND id_user = :IU");
            $sql->bindParam("ID", $id_do_);
            $sql->bindParam("IU", $id_user_);
            $sql->execute();
            header("refresh:1;url=http://localhost/Application1/super_admin/create_todolist.php");
        }
        if(isset($_GET["process_do_item_to_false"])) {
            $id_do_ = $_GET["process_do_item_to_false"];
            $id_user_ = $_SESSION["user"]->id;
            require "./../connect_to_database.php";
            $sql = $db->prepare("UPDATE `todolist` SET status = 'no_execute' WHERE id = :ID AND id_user = :IU");
            $sql->bindParam("ID", $id_do_);
            $sql->bindParam("IU", $id_user_);
            $sql->execute();
            header("refresh:1;url=http://localhost/Application1/super_admin/create_todolist.php");
        }
        $username = "root";
        $password = "";
        $db = new PDO("mysql:host=localhost;dbname=app1;charset=utf8;", $username, $password);
        $email_ = $_SESSION["user"]->email;
        $id_ = $_SESSION["user"]->id;
        $sql3 = $db->prepare("SELECT * FROM `todolist` WHERE id_user = '$id_' ORDER BY `id` DESC");
        $sql3->execute();

        echo "<table class='table table-hover' width='100%'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th style='font-size: 18px;'>Subject</th>";
        echo "<th style='font-size: 18px;'>Status</th>";
        echo "<th style='font-size: 18px;'>Remove</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        if($sql3->rowCount() == 0) {
                echo "<tr>";
                echo "<td colspan='3'>Not Found Any Result</td>";
                echo "</tr>";
        } else {
            $sql3 = $sql3->fetchAll(PDO::FETCH_ASSOC);
            foreach($sql3 as $s) {
            if($s["status"] == "" || $s["status"] === "no_execute") {
                echo "<tr>";
                echo "<td>".$s["text"]."</td>";
                echo "<td><form class='m-0' method='GET'><button type='submit' class='btn btn-success' value='".$s["id"]."' name='process_do_item_to_true'>Execute</button></form></td>";
                echo "<td><form class='m-0' method='GET'><button type='submit' class='btn btn-danger' value='".$s["id"]."' name='remove_do_item'>Remove</button></form></td>";
                echo "</tr>";
            } else {
                echo "<tr>";
                echo "<td>".$s["text"]."</td>";
                echo "<td><form class='m-0' method='GET'><button type='submit' class='btn btn-dark' value='".$s["id"]."' name='process_do_item_to_false'>Cancel Execute Mode</button></form></td>";
                echo "<td><form class='m-0' method='GET'><button type='submit' class='btn btn-danger' value='".$s["id"]."' name='remove_do_item'>Remove</button></form></td>";
                echo "</tr>";
            }
        }
        }
        echo "</tbody>";
        echo "</table>";


    ob_end_flush();
?>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
</script>