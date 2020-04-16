<?php

include "checkAuthorize.php";
$login = $_SESSION["login"];

$dbh = new PDO('mysql:host=localhost;dbname=MyCuteBase', 'root', 'Lol123');
$query = $dbh->query('SELECT id, text, checked FROM ToDo WHERE `user` = "'.$login.'"');
$newResult = $query->fetchAll(PDO::FETCH_ASSOC);

$result = [];
foreach ($newResult as $item) {
    $temp = $item;
    $temp["checked"] = ($item["checked"] == "0") ? false : true;
    array_push($result, $temp);
}
echo json_encode(["items" => $result]);




