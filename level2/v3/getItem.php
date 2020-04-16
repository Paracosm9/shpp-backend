<?php
require __DIR__.'/PdoProcess.php';
include "checkAuthorize.php";
$login = $_SESSION["login"];
$pdo = new PdoProcess();
$newResult = $pdo->getItems($login);
$result = [];
foreach ($newResult as $item) {
    $temp = $item;
    $temp["checked"] = ($item["checked"] == "0") ? false : true;
    array_push($result, $temp);
}
echo json_encode(["items" => $result]);




