<?php
    $username = "root";
    $password = "";
    $db = new PDO("mysql:host=localhost;dbname=app1;charset=utf8;", $username, $password);
    $search_ = $_POST["search_value"];
    $id_user_ = $_POST["id_user"];

    $sql = $db->prepare("SELECT * FROM `todolist` WHERE id_user = '$id_user_' AND text LIKE '%$search_%'");
    $sql->execute();
        echo "<table class='table table-hover' width='100%'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th style='font-size: 18px;'>Subject</th>";
        echo "<th style='font-size: 18px;'>Status</th>";
        echo "<th style='font-size: 18px;'>Remove</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        if($sql->rowCount() == 0) {
                echo "<tr>";
                echo "<td colspan='3'>Not Found Any Result</td>";
                echo "</tr>";
        } else {
            foreach($sql as $s) {
            $sql = $sql->fetchAll(PDO::FETCH_ASSOC);
            if($s["status"] == "" || $s["status"] === "no_execute") {
                echo "<tr>";
                echo "<td>".$s["text"]."</td>";
                echo "<td><form class='m-0' method='GET'><button type='submit' class='btn btn-success' value='".$s["id"]."' name='process_do_item_to_true'>Execute</button></form></td>";
                echo "<td><form class='m-0' method='GET'><button type='submit' class='btn btn-danger' value='".$s["id"]."' name='remove_do_item'>Remove</button></form></td>";
                echo "</tr>";
            } else {
                echo "<tr>";
                echo "<td>".$s["text"]."</td>";
                echo "<td><form class='m-0' method='GET'><button type='submit' class='btn btn-dark' value='".$s["id"]."' name='process_do_item_to_false'>Cancel Execute Mode</button></form></td>";
                echo "<td><form class='m-0' method='GET'><button type='submit' class='btn btn-danger' value='".$s["id"]."' name='remove_do_item'>Remove</button></form></td>";
                echo "</tr>";
            }
        }
        }
        echo "</tbody>";
        echo "</table>";
    
    
?>