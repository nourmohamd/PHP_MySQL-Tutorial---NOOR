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
    <div class="shadow p-3 mb-2 bg-body-tertiary rounded text-center fw-bold">Welcome USER
        <?php
            echo "<span class='text-success'>".$_SESSION["user"]->username."</span>";
        ?>
    </div>
    <div class="search">
        <input style="border-radius: 25px;border-color: transparent;border-bottom: 1px solid orange;" type="search"
            id="inputPassword5" name="search_input" class="form-control p-3 mt-5" aria-describedby="passwordHelpBlock"
            placeholder="Type Anything To Search ...">
        <?php
            if(isset($_GET["remove_do_item"])) {
            $id_do_ = $_GET["remove_do_item"];
            $id_user_ = $_SESSION["user"]->id;
            $username = "root";
            $password = "";
            $db = new PDO("mysql:host=localhost;dbname=app1;charset=utf8;", $username, $password);
            $sql = $db->prepare("DELETE FROM `todolist` WHERE id = :ID AND id_user = :IU");
            $sql->bindParam("ID", $id_do_);
            $sql->bindParam("IU", $id_user_);
            if($sql->execute()) {
                echo "<div class='alert alert-success' role='alert'>Successfuly Remove Box ToDoList</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Doesn't Remove Box ToDoLis</div>";
            }
            header("refresh:2;url=http://localhost/Application1/admin/index.php");
        }
        if(isset($_GET["process_do_item_to_true"])) {
            $id_do_ = $_GET["process_do_item_to_true"];
            $id_user_ = $_SESSION["user"]->id;
            $username = "root";
            $password = "";
            $db = new PDO("mysql:host=localhost;dbname=app1;charset=utf8;", $username, $password);
            $sql = $db->prepare("UPDATE `todolist` SET status = 'execute' WHERE id = :ID AND id_user = :IU");
            $sql->bindParam("ID", $id_do_);
            $sql->bindParam("IU", $id_user_);
            $sql->execute();
            header("refresh:1;url=http://localhost/Application1/admin/index.php");
        }
        if(isset($_GET["process_do_item_to_false"])) {
            $id_do_ = $_GET["process_do_item_to_false"];
            $id_user_ = $_SESSION["user"]->id;
            $username = "root";
            $password = "";
            $db = new PDO("mysql:host=localhost;dbname=app1;charset=utf8;", $username, $password);
            $sql = $db->prepare("UPDATE `todolist` SET status = 'no_execute' WHERE id = :ID AND id_user = :IU");
            $sql->bindParam("ID", $id_do_);
            $sql->bindParam("IU", $id_user_);
            $sql->execute();
            header("refresh:1;url=http://localhost/Application1/admin/index.php");
        }
        ?>
        <div class="search-content p-5">
        </div>
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
<script>
let search_input = document.getElementById("inputPassword5");
search_input.addEventListener("input", function(event) {
    let value_ = search_input.value;
    if (value_ !== "") {
        const data = {
            search_value: value_,
            id_user: <?php echo json_encode($_SESSION["user"]->id); ?>,
        };

        const body = Object.entries(data)
            .map(([key, value]) => `${encodeURIComponent(key)}=${encodeURIComponent(value)}`)
            .join("&");

        fetch("http://localhost/application1/user/search.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: body
            })
            .then(response => response.text())
            .then(data => {
                document.querySelector(".search-content").innerHTML = data;
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Something went wrong. Please try again.");
            });
    }
})
</script>