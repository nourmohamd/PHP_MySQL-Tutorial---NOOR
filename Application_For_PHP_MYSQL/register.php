<title>Register | إنشاء حساب</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<style>
.container {
    max-width: 100%;
    width: 1000px;
    margin: 20px auto;
}

.submit {
    margin-top: 10px;
}
</style>
<div class="container">
    <h1 align="center">Register | إنشاء حساب</h1>
    <form method="POST">
        <div>
            <label class="form-label" for="username">Username <span style="color:red;">*</span>:</label>
            <input class="form-control" type="text" name="username" id="username" required />
        </div>
        <div>
            <label class="form-label" for="email">Email <span style="color:red;">*</span>:</label>
            <input class="form-control" type="email" name="email" id="email" required />
        </div>
        <div>
            <label class="form-label" for="password1">Password <span style="color:red;">*</span>:</label>
            <input class="form-control" type="password" minlength="8" maxlength="25" name="password1" id="password1"
                required />
        </div>
        <div>
            <label class="form-label" for="password2">Confirm password <span style="color:red;">*</span>:</label>
            <input class="form-control" type="password" minlength="8" maxlength="25" name="password2" id="password2"
                required />
        </div>
        <div>
            <p class="form-label">Gender <span style="color:red;">*</span>:</p>
            <input type="radio" name="gender" value="0" id="female">
            <label for="female">Female</label>
            <br>
            <input type="radio" name="gender" value="1" id="male">
            <label for="male">Male</label>
        </div>
        <button class="btn btn-primary submit" type="submit" name="register">Register</button>
    </form>
    <?php
        $username = "root";
        $password = "";
        $db = new PDO("mysql:host=localhost;dbname=app1;charset=utf8", $username, $password);
        if(isset($_POST["register"])) {
            $email_ = $_POST["email"];
            $password_1 = $_POST["password1"];
            $password_2 = $_POST["password2"];
            $gender_ = $_POST["gender"];
            $username_ = $_POST["username"];
            $password_after_encoding = sha1($_POST["password1"]);
            if($password_1 === $password_2) {
                $sql_search = $db->prepare("SELECT * FROM `user` WHERE email = :Email AND password = :Password");
                $sql_search->bindParam("Email", $email_);
                $sql_search->bindParam("Password", $password_after_encoding);
                $sql_search->execute();
                if($sql_search->rowCount() === 0) {
                    $sql_add = $db->prepare("INSERT INTO `user` (username, email, password, gender) VALUES (:Username, :Email, :Password, :Gender)");
                    $sql_add->bindParam("Username", $username_);
                    $sql_add->bindParam("Email", $email_);
                    $sql_add->bindParam("Password", $password_after_encoding);
                    $sql_add->bindParam("Gender", $gender_);
                    if($sql_add->execute()) {
                        echo "<div class='alert alert-success' role='alert'>Successfuly To Add Your Account</div>";
                        header("Location: login.php");
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Some Error Happend 😒😒😒</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger' role='alert'>This Email Used In Our Website</div>";
                }
            } else {
                echo "<div class='alert alert-danger' role='alert'>Wrong In Password And Confirm Password</div>";
            }
        }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
</script>