<?php

include "checkAuthorize.php";
$login = $_SESSION["login"];
$arr = json_decode(file_get_contents('php://input'), true);
$dbh = new PDO('mysql:host=localhost;dbname=MyCuteBase', 'root', 'Lol123');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$checked = false;

$prep = $dbh->prepare('INSERT INTO ToDo (text, checked , `user`) VALUES (:text, 0, :user)');
$prep->execute([":text" => $arr["text"], ":user" => $login]);
$query = $dbh->query('SELECT * FROM ToDo WHERE id = ( SELECT MAX( id ) FROM ToDo )');

echo json_encode(crResponse($query->fetchAll(2)));

function crResponse($arr)
{
    return array(
        "id" => $arr[0]["id"]
    );
}
