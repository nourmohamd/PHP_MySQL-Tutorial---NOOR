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
/*
    There Are Two Ways To Conver Data To Array
    ==========================================
    1- $sql4 = $sql4->fetch(PDO::FETCH_ASSOC); ===> This For One Row
    2- $sql4 = $sql4->fetchAll(PDO::FETCH_ASSOC); ===> This For Multi-rows
*/
// 1 - connect with database such as up
// 2 - write this :
$sql4 = $database->prepare("SELECT * FROM `aa` WHERE id = 10");
if($sql4->execute()) {
    $sql4 = $sql4->fetch(PDO::FETCH_ASSOC);// Or $sql4 = $sql4->fetchAll(PDO::FETCH_ASSOC); ===> For Multi-rows
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

// Lesson 9 ===> Upload Files To DataBase
// Note: Always Use AUTO_INCREMENT To Every id In Any Table
// Way1:
// Way: We Save The File On Server And Save Path And Name And Type In DB 
// Path = "Path/".$_FILES["file1"]["name"];
// Example:
/*
Upload Files To Server
======================
PHP
===
    $username = "root";
    $password = "";
    $db = new PDO("mysql:host=localhost;dbname=my_db;charset=utf8", $username, $password);

    if(isset($_POST["n"])) {
        $file_name = $_FILES["file1"]["name"];
        $file_type = $_FILES["file1"]["type"];
        $file = $_FILES["file1"]["tmp_name"];// Move File To Server
        move_uploaded_file($file, "path"/$file_name);
        $sql = $db->prepare("INSERT INTO file (name, type, path) VALUES (:Name, :Type, :Path)");
        $sql->bindParam("Name", $file_name);
        $sql->bindParam("Type", $file_type);
        $sql->bindParam("Path", "path//".$file_name);
        $sql->execute();
    }
HTML
====
<form enctype="multipart/form-data" method="POST" >
    <input type="file" name="file1" accept="image/*,video/*,audio/*"/>
    <input type="submit" value="Send" name="s"/>
</form>

For Get Files From Server
=========================
$sql = $db->prepare("SELECT * FROM file");
$sql->execute();
foreach($sql as $a) {
    echo "<a href='". "http://localhost/name_project/" . $a["path"] . "' download>".$a["name"]."</a>";
}
*/

// Way2:
/*
Upload Files To Server
======================

PHP
===
    $username = "root";
    $password = "";
    $db = new PDO("mysql:host=localhost;dbname=my_db;charset=utf8", $username, $password);

    if(isset($_POST["s"])) {
        $file_name = $_FILES["file1"]["name"];
        $file_type = $_FILES["file1"]["type"];
        $file = file_get_contents($_FILES["file1"]["tmp_name"]);
        $sql = $db->prepare("INSERT INTO file (name, type, file) VALUES (:Name, :Type, :File)");
        $sql->bindParam("Name", $file_name);
        $sql->bindParam("Type", $file_type);
        $sql->bindParam("File", $file);
        $sql->execute();
    }
HTML
====
<form enctype="multipart/form-data" method="POST" >
    <input type="file" name="file1" accept="image/*,video/*,audio/*"/>
    <input type="submit" value="Send" name="s"/>
</form>

For Get Files From Server
=========================
$sql = $db->prepare("SELECT * FROM file");
$sql->execute();
foreach($sql as $a) {
    $getFile = "data:".$a["name_file"].";base64,".base64_encode($a["file"]);
    echo "<a href='".$getFile."' download >".$a["name_file"]."</a>";
    ech "<br/>";
    echo "<img src=".$getFile." /><br/>";
}

Note:
1 - In Way1 ===> Save File In Server And [name, type, path] in Database
2 - In Way2 ===> Save [name, type, file] in Database
*/

// Lesson 10 ===> How Remove Record In SQL-MySQL
/*
يوجد طريقتين لحذف سجل عبر لغة بي اتش بي
1 - عبر حذف السجل وذلك بتحديد الشرط مباشرةً
2 - الطريقة الثانية هي عمل حلقة وبجانب كل سجل كبسة حذف لحذف السجل
Example1:
=========
$username = "root";
$password = "";
$db = new PDO("mysql:host=localhost;dbname=my_db;charset=utf8", $username, $password);
$sql = $db->prepare("DELETE FROM user WHERE email = a@gmail.com");
$sql->execute();

Example2:
=========
$username = "root";
$password = "";
$db = new PDO("mysql:host=localhost;dbname=my_db;charset=utf8", $username, $password);

$sql = $db->execute("SELECT * FROM user);
$sql->execute();
foreach($sql as $a) {
    echo "<p>" . $a["email"] ."</p>";
    echo "<form method='POST' enctype='multipart/form-data' >";
    echo "<input type='hidden' name='id' value='" . $a["id"] . "' />";
    echo "<input type='submit' name='remove' value='Rremove' />";
    echo "</form>";
}
if(isset($_POST["remove"])) {
    $sql2 = $db->prepare("DELETE FROM user WHERE id = :Id");
    $sql2->bindParam("Id", $_POST["id"]);
    if($sql2->execute()) {
        echo "Removed Element Successufly";
    } else {
        echo "There Is An Error";
    }
    header("location: This.php");
    // For Reload Page
}

Full Example For Remove Elements (I Tried This Code In My Envirmoment)
======================================================================
<?php
$username = "root";
$password = "";
$db = new PDO("mysql:host=localhost;dbname=try;charset=utf8", $username, $password);

$sql = $db->prepare("SELECT * FROM `aa`");
if($sql->execute()) {
    foreach($sql as $a) {
        echo "<div>";
        echo "<h1> The User Is ".$a["id"]."</h1>";
        echo "<h2> Name Is ".$a["name"]."</h2>";
        echo "<form method='POST' ><input type='hidden' name='id' value='".$a["id"]."' /><input type='submit' name='del' value='Delete'/></form>";
        echo "</div>";
    }
}
if(isset($_POST["del"])) {
        $sql2 = $db->prepare("DELETE FROM `aa` WHERE id = :Id");
        $sql2->bindParam("Id", $_POST["id"]);
        if($sql2->execute()) {
            echo "<h3>Successfuly In Delete Element</h3>";
            header("Location: index.php");
        } else {
            echo "<h3>Failur In Delete</h3>";
        }
    }
?>

// Lesson 11 ===> For Update Data In SQL-MYSQL
// Way1:
الطريقة الأولى هي انك تحدد مباشرة السجل الذي تريد تعديله مع القيم الجديدة
// Way2:
نفس فكرة الحذف الثانية
// Full Example
الفكرة أنك بجانب كل عنصر تضع كبسة للحذف و عنصر اي له الرابط التالي
http://localhost/edit.php?edit=id
وعند الضغط عليه يحول المستخدم للصفحة الخاصة بالتعديل وتقوم بعمل شرط لوجود المتغير
if(isset($_GET["edit"])) { Here }
Here ===> تضع فيها كل الحقول التي تريد السماح للمستخدم بالتعديل عليها
Form In {} Must Be POST Not GET

Full Example For Edit And Update Data In SQL-MYSQL
==================================================
index.php
=========
<?php
$username = "root";
$password = "";
$db = new PDO("mysql:host=localhost;dbname=try;charset=utf8", $username, $password);

$sql = $db->prepare("SELECT * FROM `aa`");
if($sql->execute()) {
    foreach($sql as $a) {
        echo "<div>";
        echo "<h1> The User Is ".$a["id"]."</h1>";
        echo "<h2> Name Is ".$a["name"]."</h2>";
        echo "<a href='http://localhost/try/edit.php?edit=".$a["id"]."'>Edit - تعديل</a>";
        echo "</div>";
    }
}
?>

edit.php
========
if(isset($_GET["edit"])) {
$username = "root";
$password = "";
$db = new PDO("mysql:host=localhost;dbname=try;charset=utf8", $username, $password);
$sql = $db->prepare("SELECT * FROM `aa` WHERE id = :Id");
$sql->bindParam("Id", $_GET["edit"]);
$sql->execute();
if($sql->rowCount() === 1) {
$sql = $sql->fetch(PDO::FETCH_ASSOC);
echo "<form method='POST'>";
    echo "<input type='id' name='id' value='".$_GET["edit"]."' readonly />";
    echo "<br />";
    echo "<input type='id' name='name' value='".$sql["name"]."' placeholder='Please Enter Name Of Emplyee' />";
    echo "<input type='submit' name='update' value='Edit - تعديل' />";
    echo "</form>";

}

if(isset($_POST["update"])) {
$sql2 = $db->prepare("UPDATE `aa` SET name = :Name WHERE id = :Id");
$sql2->bindParam("Name", $_POST["name"]);
$sql2->bindParam("Id", $_GET["edit"]);
if($sql2->execute()) {
echo "Successfuly In Update Data";
header("Location: index.php");
} else {
echo "Failure In Update Data";
}
}
}

// Lesson 12 ===> For Create A Search Box
// The Idea Is Make Form And Field Input And Submit And SQL Query For Execute SELECT And Show Data In Page
// About Value Of Input
Full Example
============
<form method="GET">
    <input type="text" placeholder="Search" name="search" />
    <input type="submit" value="Search" name="se" />
</form>
<?php
    $username = "root";
    $password = "";
    $db = new PDO("mysql:host=localhost;dbname=try;charset=utf8", $username, $password);
    if(isset($_GET["se"])) {
        $searchText = trim($_GET["search"]);
        if(empty($searchText)) {
            echo "Not Found Any Results";
        } else {
            $sql = $db->prepare("SELECT * FROM `aa` WHERE title Like :Value");
            $sql->bindParam("Value", "%".$searchText."%");
            if($sql->execute()) {
                if($sql->rowCount() > 0) {
                    foreach($sql as $a) {
                        echo "Results";
                        // أطبع النتائج
                    }
                } else {
                    echo "Not Found Anything About Your Entering Values
                }
            } else {
                echo "There is an error";
            }
        }
    }
?>
*/
?>