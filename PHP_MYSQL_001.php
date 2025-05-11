<?php
// Start Lessons

// Lesson 1 ===> Connect To SQL MYSQL DataBase
$username = "root";// UserName For DataBase
$password = "";// Password For DataBase
$database = new PDO("mysql:host=localhost;dbname=database_name;charset=utf8;", $username, $password);// Connect
// $database ===> Return True If Connected Or False If Don't Connected
if($database) {
    echo "Connected";
} else {
    echo "Not Connected";
}
// Open PhpMyAdming ===> DataBase ===> Privillages ===> Edit ===> Login Information

// Lesson 2 ===> Execute Rules On DataBase By SQL Language
// 1 - connect with database such as up
// 2 - write this :
// $sql = $database->prepare("SQL Language Statement");
// $sql->execute(); ===> For Execute SQL Statement
// Date Or Time Must be In "" | '' | `` in SQL Statements
// Example:
$sql = $database->prepare("SELECT * FROM aa");
$sql->execute();

// Lesson 3 ===> Insert Data To Table
$sql1 = $database->prepare("INSERT INTO aa (id, name) VALUES (123312, 'Mohamed Nour')");
if($sql1->execute()) {
    echo "Yes";
} else {
    echo "No";
}
?>
<!-- Example -->
<form method="GET">
    <input type="email" name="email" placeholder="Please Enter You Email" />
    <input type="password" name="password" placeholder="Please Enter You Password" />
    <input type="submit" value="Login" name="login">
</form>
<?php
    if(isset($_GET["login"])) {
        $email = $_GET[email];
        $password = $_GET[password];
        $sql2 = $database->prepare("INSERT INTO aa (email, password) VALUES ('$email', '$password' )");
        if($sql2->execute()) {
            echo "Yes";
        } else {
            echo "No";
        }
    }
?>
<?php
// Lesson 4 ===> Get Data From DataBase And Show It in WebSite
// 1 - connect with database such as up
// 2 - write this :
$sql3 = $database->prepare("SELECT * FROM `aa`");
if($sql3->execute()) {
    foreach($sql3 as $a) {
        echo "<h1>".$a["id"]."</h1>";
        echo "<h1>".$a["email"]."</h1>";
        echo "<h1>".$a["password"]."</h1>";
    }
}
// You Can Style The Result Then Show It In Website

// Lesson 5 ===> Convert Data To Array | Object
// Convert Data From DataBase To Array
// 1 - connect with database such as up
// 2 - write this :
$sql4 = $database->prepare("SELECT * FROM `aa` WHERE id = 10");
if($sql4->execute()) {
    $sql4 = $sql4->fetch(PDO::FETCH_ASSOC);
    echo $sql4["email"].$sql4["password"];
}
// Conver Data From DataBase To Object
$sql5 = $database->prepare("SELECT * FROM `aa` WHERE id = 10");
if($sql5->execute()) {
    $sql5 = $sql->fetchObject();
    echo $sql5->email;
}

// Lesson 6 ===> Know Number Of Records Data | Columns Data
$sql6 = $database->prepare("SELECT * FROM `aa`");
if($sql6->execute()) {
    $num = $sql6->rowCount();// Number Of Records Data
    $numColumn = $sql6->columnCount();// Number Of Columns Data
}

// Lesson 7 ===> bindParam For Top Level Security Data
// Example:
// 1 - connect with database such as up
// 2 - write this :
if(isset($_POST["Login"])) {
    $Title = $_POST["title"];
    $Content = $_POST["content"];
    $Email = $_POST["email"];
    $Password = $_POST["password"];
    $sql7 = $database->prepare("INSERT INTO `aa` (title, content, email, password) VALUES ('$Title', '$Content', '$Email', '$Password')");// Method 1 To Insert New Record
    $sql7->execute();
    $sql8 = $database->prepare("INSERT INTO `aa` (title, content, email, password) VALUES (:Title, :Content, :Email, :Password)");// Method 2 To Insert New Record
    $sql8->bindParam("Title", $Title);
    $sql8->bindParam("Content", $Content);
    $sql8->bindParam("Email", $Email);
    $sql8->bindParam("Password", $Password);
    $sql8->execute();
}
?>
<form method="POST">
    <input type="text" name="title" />
    <input type="text" name="content" />
    <input type="email" name="email" />
    <input type="password" name="password" />
    <input type="submit" value="Login" />
    <input type="reset" value="Reset" />
</form>

<?php
// Lesson 8 ===> How can you Find Errors In PHP_MySQL During Get Data
// For Know What is Error In Your Code When Get Error After Executes
$sql9 = $database->prepare("SELECT * FROM `aa`");
var_dump($sql9->errorInfo());// After Solve Error You Can Remove This Line Or Comment It
// If There Is Error Get <Message> Or <Nothing> If There Is Not Found Error
// بعد ما تحل المشكلة يمكنك حذف سطر الفحص أو تعليقه أنت الحر بالأختيار
if($sql9->execute()) {
    echo "Yes";
}

?>