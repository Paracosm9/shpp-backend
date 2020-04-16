<?php

$arr = get();
$dbh = new PDO('mysql:host=localhost;dbname=MyCuteBase', 'root', 'Lol123');
$checked = true;
$dbh->query('INSERT INTO ToDo (text, checked) VALUES ("' .$arr["text"].'", "' . $checked. '")');
$query = $dbh->query('SELECT * FROM ToDo');
print_r($query->fetchAll(2));
$query = $dbh->query('SELECT * FROM ToDo WHERE id = ( SELECT MAX( id ) FROM ToDo )');

echo json_encode(crResponse($query->fetchAll(2)));

function crResponse($arr)
{
    return array(
        "id" => $arr[0]["id"]
    );
}