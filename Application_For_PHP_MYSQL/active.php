<title>Verify Your Email - تأكيد بريدك الإلكتروني</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<style>
.container {
    max-width: 100%;
    width: 1000px;
    margin: 20px auto;
}
</style>
<div class="container">
    <?php if($_GET["code"]) {
    $username="root";
    $password="";
    $db=new PDO("mysql:host=localhost;dbname=app1;charset=utf8;", $username, $password);
    // Check About Code
    $sql=$db->prepare("SELECT * FROM `user` WHERE security = :Security");
    $sql->bindParam("Security", $_GET["code"]);
    $sql->execute();
    if($sql->rowCount()===1) {
        $new_security_code=md5(date("h:m:i"));
        $sql2=$db->prepare("UPDATE `user` SET security = :NewSecurityCode, activited=true WHERE security = :Security");
        $sql2->bindParam("NewSecurityCode", $new_security_code);
        $sql2->bindParam("Security", $_GET["code"]);
        if($sql2->execute()) {
            echo "<div class='alert alert-success' role='alert'>Email verified Successfuly</div>";
            echo "<a href='login.php' class='btn btn-primary'>Login - تسجيل الدخول</a>";
        }
    }
    else {
        echo "<div class='alert alert-danger' role='alert'>This code no longer works - هذا الكود تم تأكيده سابقاً</div>";
    }
}
?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" </div>
integrity = "sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
crossorigin = "anonymous" >
</script>