<?php
    ob_start();
?>
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
        <p>If You Hava An Account Please Login In Here? <a href="login.php">here</a></p>
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
            $activited_ = 0;
            $security_code_ = md5(date("h:m:i"));
            if($password_1 === $password_2) {
                $sql_search = $db->prepare("SELECT * FROM `user` WHERE email = :Email");
                $sql_search->bindParam("Email", $email_);
                $sql_search->execute();
                if($sql_search->rowCount() === 0) {
                    $sql_add = $db->prepare("INSERT INTO `user` (username, email, password, gender, activited, security, role) VALUES (:Username, :Email, :Password, :Gender, :Activited, :Security_Code, 'USER')");
                    $sql_add->bindParam("Username", $username_);
                    $sql_add->bindParam("Email", $email_);
                    $sql_add->bindParam("Password", $password_after_encoding);
                    $sql_add->bindParam("Gender", $gender_);
                    $sql_add->bindParam("Activited", $activited_);
                    $sql_add->bindParam("Security_Code", $security_code_);
                    if($sql_add->execute()) {
                        echo "<div class='alert alert-success' role='alert'>The verification code has been sent to your email. Return To Your Gmail</div>";
                        require_once "./server.php";
                        $mail->setFrom('abdonoor684@gmail.com', 'SP Managment');
                        $mail->addAddress($email_);
                        $mail->Subject = "Verify Your Email";
                        $mail->Body = "<div align='center' >" . "<h1>Thank You For Your Signning In Our Website</h1>"
                        . "<p>URL For Verify Your Email, Please Click On URL Down:</p>"
                        . "<a href='http://localhost/Application1/active.php?code=".$security_code_."'>"."http://localhost/Application_for_php_mysql/active.php?code=".$security_code_."</a>".
                        "</div>";
                        $mail->send();
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
        ob_end_flush();
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
</script>