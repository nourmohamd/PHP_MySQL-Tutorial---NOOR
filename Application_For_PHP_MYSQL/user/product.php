<?php
// Some Advice Or Tip To Make Results Show In More One Page
// ========================================================
/*
1- Connect To DataBase - إتصال بقاعدة البيانات لجلب المنتجات منها

2- Define Variable For Save Number Of Products In Every Page You Want To Show - تعريف متغير لحفظ عدد المنتجات التي تريد عرضها في كل صفحة

3- Get Number Of Product (Total) - جلب عدد البيانات الكلي

4- Select Number Of Page Customer Work By It Now - تحديد رقم الصفحة التي يعمل عليها الزائر الآن

5- Select Number Of Page (Total) - تحديد عدد الصفحات الإجمالي

*/
// 1
require "./../connect_to_database.php";

// 2
$results_number = 50;

// 3
$data = $db->prepare("SELECT * FROM `product`");
$data->execute();
$number_product = $data->rowCount(); // Number Of Products

// 4
if(!isset($_GET["page"])) {
    $page = 1;
} else {
    $page = $_GET["page"];
}

// 5
$number_page = ceil($number_product / $results_number);
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<title>Products Page <?php echo $page; ?></title>
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
            <a class="nav-link bg-dark active" aria-current="page" href="./create_todolist.php">Our Product</a>
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
    <h1 class="mt-5 mb-5 text-center">Page <?php echo $page; ?></h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
            $sql = $db->prepare("SELECT * FROM `product` LIMIT ".$results_number." OFFSET ". ($page-1)*$results_number);
            $sql->execute();
            foreach($sql as $s) {
                echo '<div class="col">
                        <div class="card">
                        <img height="250px" src="'.$s["img_link"].'" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">'.$s["name_product"].'</h5>
                            <p class="card-text">'.$s["category"].'</p>
                        </div>
                    </div>
        </div>';
            }
        ?>
    </div>
    <div class="btn-toolbar mt-5" role="toolbar" aria-label="Toolbar with button groups">
        <div class="btn-group me-2" role="group" aria-label="First group">
            <?php
                for($i=1;$i<=$number_page;$i++) {
                    if($page == $i) {
                        echo '<a type="button" href="http://localhost/Application1/user/product.php?page='.$i.'" class="btn btn-dark bg-dark">'.$i.'</a>';
                    } else {
                        echo '<a type="button" href="http://localhost/Application1/user/product.php?page='.$i.'" class="btn btn-warning">'.$i.'</a>';
                    }
                }
            ?>
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