<?php

include "checkAuthorize.php";
$login = $_SESSION["login"];
$arr = get();
$dbh = new PDO('mysql:host=localhost;dbname=MyCuteBase', 'root', 'Lol123');
$check = ($arr["checked"]) ? 1 : 0;
$dbh->query('UPDATE ToDo
    SET text = "' . $arr["text"] . '",
    checked = "' . $check . '" WHERE id = "' . intval($arr["id"]) . '" AND `user` = "' . $login . '"');
echo json_encode(['ok' => true]);


function get()
{
    return json_decode(file_get_contents('php://input'), true);
}
