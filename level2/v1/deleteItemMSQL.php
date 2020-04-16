<?php

$arr = get();
$dbh = new PDO('mysql:host=localhost;dbname=MyCuteBase', 'root','Lol123');
$dbh->query('DELETE FROM ToDo WHERE id="'.intval($arr["id"]).'"');
echo json_encode(['ok' => true]);



function get(){
    return json_decode( file_get_contents("php://input"), true);
}
