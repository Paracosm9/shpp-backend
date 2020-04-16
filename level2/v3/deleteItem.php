<?php
require __DIR__.'/PdoProcess.php';
include "checkAuthorize.php";
$login = $_SESSION["login"];
$arr = json_decode(file_get_contents("php://input"), true);
$pdo = new PdoProcess();
echo $pdo->deleteItem($login, $arr);
