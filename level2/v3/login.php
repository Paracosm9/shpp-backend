<?php
require __DIR__.'/PdoProcess.php';
/*Getting some data from program enter.*/

$data = json_decode(file_get_contents('php://input'), true);
$pdo = new PdoProcess();
$arr_from_pdo = $pdo->login($data);
/*If we have such user in base - starting session. */


if (count($arr_from_pdo) !== 0) {
    session_start();
    $_SESSION["login"] = $data["login"];
    $hash = makeHash($data["login"], $data["pass"]);
    $_SESSION["hash"] = $hash;
    setcookie("login", $data["login"], time() + 30);
    setcookie("hash", $hash, time() + 30);
    $pdo->setUserHash($hash, $data["login"]);
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
    return md5($login . $password . session_id(), "1234567890abcdef");
}


