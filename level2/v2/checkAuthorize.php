<?php

//breaking the options method, that makes server to give response.
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit();
}
if (!isset($_SESSION)) {
    session_start();
}
if (isset ($_SESSION["hash"]) && isset($_COOKIE["hash"])) {

    if (checkUserHash() && $_SESSION["hash"] === $_COOKIE["hash"]) {
        header("HTTP1.1 200 OK");

    } else {
        header('HTTP/1.1 401 Unauthorized');
        header('Location: http://front13.com/LoginToDo/login.html');
        echo json_encode(["error" => "Unauthorized user"]);
        exit();
    }
} else {
    header('HTTP/1.1 401 Unauthorized');
    header('Location: http://front13.com/LoginToDo/login.html');
    echo json_encode(["error" => "Unauthorized user"]);
    exit();
}


function checkUserHash()
{
    $base = new PDO ('mysql:host=localhost;dbname=MyCuteBase', 'root', 'Lol123');
    $query = ('SELECT * FROM users WHERE login = "' . $_SESSION["login"] . '" AND hash = "' . $_COOKIE["hash"] . '"');
    $arr = $base->query($query);
    return $arr !== 0;
}