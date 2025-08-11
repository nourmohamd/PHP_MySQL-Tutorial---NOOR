<?php
    $username = "root";
    $password = "";
    $db = new PDO("mysql:host=localhost;dbname=app1;charset=utf8;", $username, $password);
    $search_ = $_POST["search_value"];
    $id_user_ = $_POST["id_user"];

    $sql = $db->prepare("SELECT * FROM `user` WHERE role = 'USER'");
    $sql->execute();
        echo "<table class='table table-hover' width='100%'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th style='font-size: 18px;'>Username</th>";
        echo "<th style='font-size: 18px;'>Email</th>";
        echo "<th style='font-size: 18px;'>Remove</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        if($sql->rowCount() == 0) {
                echo "<tr>";
                echo "<td colspan='3'>Not Found Any Result</td>";
                echo "</tr>";
        } else {
            $sql = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach($sql as $s) {
                echo "<tr>";
                echo "<td>".$s["username"]."</td>";
                echo "<td>".$s["email"]."</td>";
                echo "<td><form class='m-0' method='GET'><button type='submit' class='btn btn-danger' value='".$s["id"]."' name='remove_do_item'>Remove</button></form></td>";
                echo "</tr>";
        }
        }
        echo "</tbody>";
        echo "</table>";
    
    
?>