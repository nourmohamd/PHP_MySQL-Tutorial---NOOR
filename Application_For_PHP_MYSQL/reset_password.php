<?php
ob_start();
?>
<title>Forget Password | Reset Password</title>
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
<?php
    require "./nav.php";
?>
<div class="container">
    <?php
        if(!isset($_GET["code"])) {
            echo '<h1 align="center">Login | تسجيل الدخول</h1>
    <form method="POST">
        <div><label class="form-label" for="email">Email</label>
            <input class="form-control" type="email" name="email" id="email" required />
        </div>
        <div>
            <button class="btn btn-primary w-100 submit" type="submit" name="forget_password">Forget Password</button>
        </div>';
        } else if(isset($_GET["code"]) && isset($_GET["email"])) {
            echo '<h1 align="center">Reset Password</h1>
    <form method="POST">
        <div><label class="form-label" for="password">New Password</label>
            <input class="form-control" type="password" name="password" id="password" required />
        </div>
        <div>
            <button class="btn btn-primary w-100 submit" type="submit" name="reset_password">Reset Password</button>
        </div>';
        }
    ?>

    <?php
            if(isset($_POST["forget_password"])) {
                $username = "root";
                $password = "";
                $db = new PDO("mysql:host=localhost;dbname=app1;charset=utf8;", $username, $password);
                $email_ = $_POST["email"];
                $check_email = $db->prepare("SELECT * FROM `user` WHERE email = :Email");
                $check_email->bindParam("Email", $email_);
                $check_email->execute();
                if($check_email->rowCount() >= 1) {
                    $check_email = $check_email->fetchObject();
                    echo "<div class='alert alert-success mt-2' role='alert'>A Verification Code For Reset Your Password has been Sent To Your Gmail! </div>";
                    require "./server.php";
                    $mail->setFrom('abdonoor684@gmail.com', 'Website`s Managment');
                    $mail->addAddress($email_);
                    $mail->Subject = "I Forget A Password";
                    $mail->Body = "<div align='center' >" . "<h1>Reset Password</h1>"
                    . "<p>URL For Reset Password, Please Click On URL Down:</p>"
                    . "<a href='http://localhost/Application1/reset_password.php?email=".$email_."&code=".$check_email->security."'>"."http://localhost/Application_for_php_mysql/reset_password.php?email=".$email_."&code=".$check_email->security."</a>".
                    "</div>";
                    $mail->send();
                } else {
                    echo "<div class='alert alert-danger mt-2' role='alert'>This Email Is Not Registered In Our Website</div>";
                }
            }
            if(isset($_POST["reset_password"])) {
                $username = "root";
                $password = "";
                $db = new PDO("mysql:host=localhost;dbname=app1;charset=utf8;", $username, $password);
                $password_ = sha1($_POST["password"]);
                $email_ = $_GET["email"];
                $sql = $db->prepare("UPDATE `user` SET password = :Password WHERE email = :Email");
                $sql->bindParam("Password",$password_);
                $sql->bindParam("Email",$email_);
                if($sql->execute()) {
                    echo "<div class='mt-2 alert alert-success'>A Password Has Been Reset Successfuly</div>";
                } else {
                    echo "<div class='mt-2 alert alert-danger'>There is some error please try again later</div>";
                }
            }
            ob_end_flush();
        ?>
    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
</script>