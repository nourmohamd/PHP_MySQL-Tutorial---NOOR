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
?>