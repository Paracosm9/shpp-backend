<?php

/*Getting some data from program enter.*/

$data = json_decode(file_get_contents('php://input'), true);
$base = new PDO('mysql:host=localhost;dbname=MyCuteBase', 'root', 'Lol123');
/*Taking data from base.*/
$query = 'SELECT * FROM users WHERE login = "' . $data["login"] . '" AND password = "' . $data["pass"] . '"';
$user = $base->query($query);
$arr = $user->fetchAll(PDO::FETCH_ASSOC);
/*If we have such user in base - starting session. */
if (count($arr) !== 0) {
    session_start();
    $_SESSION["login"] = $data["login"];
    $hash = makeHash($data["login"], $data["pass"]);
    $_SESSION["hash"] = $hash;
    setcookie("login", $data["login"], time() + 30);
    setcookie("hash", $hash, time() + 30);
    setUserHash($base, $hash, $data["login"]);
    echo json_encode(["ok" => "true"]);
}
else {
    header("HTTP1.1 403 Forbidden");
    echo json_encode(["false" => false]);
    exit();
}
/** hashing for pass.
 * @param $login
 * @param $password
 * @return string
 */
function makeHash($login, $password)
{
    return md5($login . $password . session_id(), "123214");
}

function setUserHash($base, $hash, $user)
{
    $base->query('UPDATE users SET hash = "'.$hash.'" WHERE login = "'.$user.'"');
}
