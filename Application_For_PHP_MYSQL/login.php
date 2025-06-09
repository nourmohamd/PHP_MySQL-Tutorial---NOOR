<?php
ob_start();
?>
<title>Login | تسجيل الدخول</title>
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

h1 {
    margin-top: 50px;
}

p {
    margin-top: 10px;
}
</style>
<div class="container">
    <h1 align="center">Login | تسجيل الدخول</h1>
    <form method="POST">
        <div><label class="form-label" for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" required />
        </div>
        <div>
            <label class="form-label" for="password">Password</label>
            <input class="form-control" type="password" name="password" id="password" required />

        </div>
        <div>
            <button class="btn btn-primary submit" type="submit" name="login">Login | تسجيل الدخول</button>
            <a class="btn btn-warning submit" href="./register.php">Register | إنشاء حساب</a>
        </div>
        <?php
            if(isset($_POST["login"])) {
                $username = "root";
                $password = "";
                $db = new PDO("mysql:host=localhost;dbname=app1;charset=utf8;", $username, $password);
                $email_ = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
                $password_ = trim(sha1($_POST["password"]));
                $sql1 = $db->prepare("SELECT * FROM `user` WHERE email = :Email AND password = :Password");
                $sql1->bindParam("Email", $email_);
                $sql1->bindParam("Password", $password_);
                $sql1->execute();
                if($sql1->rowCount() === 1) {
                    $sql1 = $sql1->fetchObject();
                    if($sql1->activited === "1") {
                        echo "<p class='alert alert-success'>Successfuly To Sign In my Website</p>";
                        session_start();
                        $_SESSION["email"] = $email_;
                        $_SESSION["password"] = $password_;
                        header("refresh: 3;url=main.php");
                    } else {
                        echo "<p class='alert alert-danger'>We will sent a code to your gmail please got it and verify your email then try again.</p>";
                    }
                } else {
                    echo "<p class='alert alert-danger'>Incorrect email or password. Try again.</p>";
                }
            }
            ob_end_flush();
        ?>
    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
</script>