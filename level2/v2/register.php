<?php
$new_user = json_decode(file_get_contents('php://input'), true);
$name = $new_user["login"];
$pass = $new_user["pass"];
$base = new PDO('mysql:host=localhost;dbname=MyCuteBase', 'root', 'Lol123');

$query = $base->query('SELECT * FROM users');
$arr = $query->fetchAll(2);
if (checkForExist($name, $arr) || $name === null || $pass === null || $name === "" || $pass === "") {
    header('HTTP1.1 422 Unprocessable Entity');
    echo json_encode(["false" => "false"]);
    exit();
} else {
    $query = $base->query('INSERT INTO users (login, password) VALUES ("' . $name . '", "' . $pass . '")');
    echo json_encode(["ok" => "true"]);
}

function checkForExist($name, $arr)
{
    foreach ($arr as $row) {
        if ($name === $row['login']) {
            return true;
        }
    }
    return false;
}