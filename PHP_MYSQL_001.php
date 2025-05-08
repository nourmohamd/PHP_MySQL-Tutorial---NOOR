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
?>